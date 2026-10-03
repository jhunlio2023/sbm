<?php
// Run with: php -n tests/monitoring_catalog_test.php
// Exercise the model with an isolated SQLite database; no application records are touched.
define('BASEPATH', __DIR__);
define('APPPATH', dirname(__DIR__) . '/application/');
class CI_Model { public $db; }
class CatalogTestDatabase
{
    private $pdo, $where = array(), $order = array();
    public function __construct()
    {
        $this->pdo = new PDO('sqlite::memory:');
        $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $this->pdo->exec('CREATE TABLE monitoring_sections (id INTEGER PRIMARY KEY AUTOINCREMENT, title TEXT, sort_order INTEGER, monitor_id INTEGER NULL)');
        $this->pdo->exec('CREATE TABLE monitoring_section_monitors (section_id INTEGER, monitor_id INTEGER, PRIMARY KEY (section_id, monitor_id))');
        $this->pdo->exec('CREATE TABLE monitoring_monitors (id INTEGER PRIMARY KEY AUTOINCREMENT, first_name TEXT)');
        $this->pdo->exec('CREATE TABLE monitoring_indicators (id INTEGER PRIMARY KEY AUTOINCREMENT, section_id INTEGER, description TEXT, sort_order INTEGER)');
        $this->pdo->exec('CREATE TABLE monitoring_catalog_state (id INTEGER PRIMARY KEY, seeded INTEGER)');
    }
    public function query($sql)
    {
        if (strpos($sql, 'CREATE TABLE') === 0) { return true; } // Equivalent test schemas above.
        $sql = str_replace(array('INSERT IGNORE', ' FOR UPDATE'), array('INSERT OR IGNORE', ''), $sql);
        return new CatalogTestResult($this->pdo->query($sql));
    }
    public function trans_begin() { $this->pdo->beginTransaction(); }
    public function field_exists($field, $table) {
        foreach ($this->pdo->query('PRAGMA table_info(' . $table . ')')->fetchAll(PDO::FETCH_ASSOC) as $column) {
            if ($column['name'] === $field) return true;
        }
        return false;
    }
    public function trans_commit() { $this->pdo->commit(); }
    public function trans_rollback() { $this->pdo->rollBack(); }
    public function trans_status() { return true; }
    public function where($key, $value) { $this->where[$key] = $value; return $this; }
    public function order_by($key) { $this->order[] = $key; return $this; }
    private function conditions(&$params)
    {
        $parts = array();
        foreach ($this->where as $key => $value) { $parts[] = $key . ' = ?'; $params[] = $value; }
        $this->where = array();
        return $parts ? ' WHERE ' . implode(' AND ', $parts) : '';
    }
    public function get($table)
    {
        $params = array(); $sql = 'SELECT * FROM ' . $table . $this->conditions($params);
        if ($this->order) { $sql .= ' ORDER BY ' . implode(', ', $this->order); }
        $this->order = array(); $stmt = $this->pdo->prepare($sql); $stmt->execute($params);
        return new CatalogTestResult($stmt);
    }
    public function get_where($table, $where) { $this->where = $where; return $this->get($table); }
    public function count_all_results($table) { return count($this->get($table)->result_array()); }
    public function insert($table, $data)
    {
        $stmt = $this->pdo->prepare('INSERT INTO ' . $table . ' (' . implode(',', array_keys($data)) . ') VALUES (' . implode(',', array_fill(0, count($data), '?')) . ')');
        return $stmt->execute(array_values($data));
    }
    public function insert_id() { return $this->pdo->lastInsertId(); }
    public function update($table, $data)
    {
        $params = array_values($data); $parts = array();
        foreach ($data as $key => $value) { $parts[] = $key . ' = ?'; }
        $stmt = $this->pdo->prepare('UPDATE ' . $table . ' SET ' . implode(',', $parts) . $this->conditions($params));
        return $stmt->execute($params);
    }
    public function delete($table)
    {
        $params = array(); $stmt = $this->pdo->prepare('DELETE FROM ' . $table . $this->conditions($params));
        return $stmt->execute($params);
    }
}
class CatalogTestResult
{
    private $stmt;
    public function __construct($stmt) { $this->stmt = $stmt; }
    public function row() { return $this->stmt->fetchObject(); }
    public function result_array() { return $this->stmt->fetchAll(PDO::FETCH_ASSOC); }
}
function check($condition, $message)
{
    if (!$condition) { throw new RuntimeException($message); }
    echo 'PASS ' . $message . PHP_EOL;
}
require APPPATH . 'models/Monitoring_model.php';
$model = new Monitoring_model(); $model->db = new CatalogTestDatabase(); $model->initialize();
$original = $model->original_definition();
check($model->definition() === $original, 'Seed preserves all six sections and 32 original indicators in order');
$model->initialize();
check(count($model->indicators()) === 32, 'Repeated initialization does not duplicate seed data');
check($model->change('section', 'create', 0, array('title' => 'New section', 'sort_order' => 0)) === null, 'Create section');
$sectionId = $model->db->insert_id();
$model->db->insert('monitoring_monitors', array('first_name' => 'Ana'));
$monitorId = $model->db->insert_id();
$model->db->insert('monitoring_monitors', array('first_name' => 'Ben'));
$secondMonitor = $model->db->insert_id();
$model->db->where('id', $sectionId)->update('monitoring_sections', array('monitor_id' => $monitorId));
$model->initialize();
check($model->sections()[0]['monitor_ids'] === array((int) $monitorId), 'Migrate legacy selection');
check($model->change('section', 'update', $sectionId, array('monitor_ids' => array($monitorId, $secondMonitor, $monitorId))) === null, 'Assign multiple monitors with deduplication');
check(count($model->sections()[0]['monitor_ids']) === 2, 'Retain both selections');
$model->initialize();
check(count($model->sections()[0]['monitor_ids']) === 2, 'Repeated migration preserves multiple selections');
check($model->change('section', 'update', $sectionId, array('monitor_ids' => array($monitorId, 99999))) !== null, 'Reject nonexistent monitor');
check(count($model->sections()[0]['monitor_ids']) === 2, 'Invalid selection preserves all assignments');
check($model->change('section', 'update', $sectionId, array('monitor_ids' => array(array('1')))) !== null, 'Reject malformed monitor');
$snapshot = array('sections' => array(array('id' => $sectionId)));
check($model->allows_definition($monitorId, $snapshot) && $model->allows_definition($secondMonitor, $snapshot), 'Both monitors have domain access');
check(!$model->allows_definition(99999, $snapshot), 'Unassigned monitor has no access');
check($model->change('section', 'update', $sectionId, array('monitor_ids' => array($secondMonitor))) === null, 'Remove one monitor');
check(!$model->allows_definition($monitorId, $snapshot) && $model->allows_definition($secondMonitor, $snapshot), 'Removal revokes only removed monitor access');
check($model->change('section', 'update', $sectionId, array('monitor_ids' => array())) === null, 'Clear all assignments');
$model->initialize();
check($model->sections()[0]['monitor_ids'] === array(), 'Cleared assignments stay cleared after initialization');
check($model->change('indicator', 'create', 0, array('section_id' => $sectionId, 'description' => 'New indicator?', 'sort_order' => 1)) === null, 'Create indicator');
$indicatorId = $model->db->insert_id();
check($model->definition()['sections'][0]['items'][0] === 'New indicator?', 'New form uses new indicator and section order');
check($model->change('section', 'delete', $sectionId, array()) !== null, 'Cannot delete a section containing indicators');
check($model->change('indicator', 'update', $indicatorId, array('section_id' => $sectionId, 'description' => 'Edited question?', 'sort_order' => 0)) === null, 'Edit indicator');
check($model->definition()['sections'][0]['items'][0] === 'Edited question?', 'Edited text is immediately available');
check($model->change('indicator', 'update', $indicatorId, array('section_id' => 99999, 'description' => 'Invalid', 'sort_order' => 0)) !== null, 'Reject nonexistent section');
check($model->change('indicator', 'update', $indicatorId, array('section_id' => 1, 'description' => 'Moved question?', 'sort_order' => 0)) === null, 'Move indicator to another section');
check($model->change('section', 'delete', $sectionId, array()) === null, 'Delete empty section');
check($model->change('indicator', 'delete', $indicatorId, array()) === null, 'Delete indicator');
check($model->change('indicator', 'delete', $indicatorId, array()) !== null, 'Reject stale deleted entry');
check($model->definition() === $original, 'Original indicators remain unchanged after CRUD');
foreach ($model->indicators() as $item) { $model->change('indicator', 'delete', $item['id'], array()); }
foreach ($model->sections() as $section) { $model->change('section', 'delete', $section['id'], array()); }
$model->initialize();
check($model->definition()['sections'] === array(), 'Deleting every entry does not reimport the original indicators');
