<?php
$division_total = count($data);
$is_division_report = $this->session->position === 'division';
$is_region_report = $this->session->position === 'region';
$dashboard_url = base_url();
$schools = isset($schools) ? $schools : array();
$sgc_labels = array(1 => 'Not Yet Organized', 2 => 'Organized (Not Functional)', 3 => 'Functional');
$sgc_colors = array(1 => 'danger', 2 => 'warning', 3 => 'success');
$summary_labels = $sgc_labels + array(0 => 'Not Yet Responded');
$status_counts = array(1 => 0, 2 => 0, 3 => 0, 0 => 0);
$district_groups = array();
if ($is_division_report) {
    foreach ($schools as $school) {
        $district = trim((string) $school->district_name);
        $district = $district !== '' ? $district : 'Unassigned District';
        $district_groups[$district][] = $school;
        $status = (int) $school->sgc;
        $status_counts[isset($sgc_labels[$status]) ? $status : 0]++;
    }
    ksort($district_groups, SORT_NATURAL | SORT_FLAG_CASE);
} else {
    foreach ($data as $row) {
        $status_counts[1] += (int) $row->not_yet_organized;
        $status_counts[2] += (int) $row->organized_not_functional;
        $status_counts[3] += (int) $row->functional;
        $status_counts[0] += (int) $row->not_yet_responded;
    }
}
$group_names = array();
if ($is_region_report) {
    foreach ($data as $division) {
        $district_groups[$division->id] = array();
        $group_names[$division->id] = $division->description;
    }
    foreach ($schools as $school) {
        if (isset($district_groups[$school->division_id])) {
            $district_groups[$school->division_id][] = $school;
        }
    }
}
?>

<style>
    .report-page {
        --report-primary: #8b1e3f;
        --report-primary-dark: #64142d;
        --report-border: #e8ecf4;
        --report-muted: #6b7280;
    }

    .report-hero {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 24px;
        margin: 18px 0 22px;
        padding: 28px;
        border-radius: 18px;
        color: #fff;
        background:
            radial-gradient(circle at 90% 15%, rgba(255, 255, 255, .2), transparent 25%),
            linear-gradient(135deg, #64142d 0%, #a83255 100%);
        box-shadow: 0 14px 34px rgba(139, 30, 63, .22);
    }

    .report-hero h2 {
        margin: 0 0 7px;
        color: #fff;
        font-size: 25px;
        font-weight: 700;
    }

    .report-hero p {
        max-width: 720px;
        margin: 0;
        color: rgba(255, 255, 255, .82);
    }

    .report-actions {
        display: flex;
        align-items: center;
        flex-wrap: wrap;
        gap: 10px;
    }

    .report-pill {
        display: inline-flex;
        align-items: center;
        gap: 7px;
        padding: 10px 14px;
        border: 1px solid rgba(255, 255, 255, .24);
        border-radius: 999px;
        color: #fff;
        background: rgba(255, 255, 255, .14);
        font-size: 12px;
        font-weight: 700;
        backdrop-filter: blur(5px);
    }

    .report-card {
        border: 1px solid var(--report-border);
        border-radius: 16px;
        background: #fff;
        box-shadow: 0 8px 28px rgba(31, 45, 75, .07);
        overflow: hidden;
    }

    .report-card .card-body {
        padding: 0;
    }

    .report-card-header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 16px;
        padding: 20px 24px;
        border-bottom: 1px solid var(--report-border);
    }

    .report-card-header h4 {
        margin: 0 0 3px;
        color: #27324a;
        font-size: 17px;
        font-weight: 700;
    }

    .report-card-header p {
        margin: 0;
        color: var(--report-muted);
        font-size: 12px;
    }

    .report-table-wrap {
        padding: 8px 24px 24px;
    }

    .report-page table.dataTable {
        margin-top: 12px !important;
        border-collapse: separate !important;
        border-spacing: 0 8px !important;
    }

    .report-page table.dataTable thead th {
        padding: 11px 14px;
        border: 0;
        color: #687086;
        font-size: 10px;
        font-weight: 700;
        letter-spacing: .06em;
        text-transform: uppercase;
        white-space: nowrap;
    }

    .report-page table.dataTable tbody td {
        padding: 14px;
        border-top: 1px solid var(--report-border);
        border-bottom: 1px solid var(--report-border);
        vertical-align: middle;
        background: #fff;
    }

    .report-page table.dataTable tbody td:first-child {
        border-left: 1px solid var(--report-border);
        border-radius: 11px 0 0 11px;
    }

    .report-page table.dataTable tbody td:last-child {
        border-right: 1px solid var(--report-border);
        border-radius: 0 11px 11px 0;
    }

    .report-page table.dataTable tbody tr:hover td {
        background: #fff7f9;
    }

    .stat-cell {
        min-width: 100px;
    }

    .stat-value {
        display: block;
        font-size: 13px;
        font-weight: 700;
        color: #27324a;
    }

    .stat-label {
        display: block;
        font-size: 11px;
        color: var(--report-muted);
    }

    .progress-wrapper {
        margin-top: 6px;
    }

    .progress {
        height: 8px;
        background: #e8ecf4;
        border-radius: 4px;
        overflow: hidden;
    }

    .progress-bar {
        height: 100%;
        border-radius: 4px;
        transition: width 0.3s ease;
    }

    .progress-bar-danger {
        background: linear-gradient(90deg, #dc3545, #c82333);
    }

    .progress-bar-warning {
        background: linear-gradient(90deg, #ffc107, #fd7e14);
    }

    .progress-bar-success {
        background: linear-gradient(90deg, #28a745, #20c997);
    }

    .percentage-text {
        display: block;
        margin-top: 4px;
        font-size: 11px;
        font-weight: 600;
        color: var(--report-muted);
    }

    .sgc-district { margin: 16px 24px; border: 1px solid var(--report-border); border-radius: 10px; }
    .sgc-district summary { padding: 16px; cursor: pointer; color: #27324a; font-weight: 700; background: #f8f9fc; }
    .sgc-district summary:focus-visible { outline: 2px solid var(--report-primary); }
    .sgc-district summary .badge { margin-left: 10px; }
    .sgc-district-actions { padding: 16px 24px 0; display: flex; gap: 8px; }
    .sgc-summary { margin-top: 24px; }
    .sgc-summary-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(180px, 1fr)); gap: 16px; padding: 24px; }
    .sgc-summary-item { padding: 18px; border: 1px solid var(--report-border); border-radius: 10px; }
    .sgc-summary-item strong { display: block; margin-top: 10px; font-size: 26px; color: #27324a; }
    @media print { .sgc-district-actions { display: none; } }

    .report-empty {
        padding: 48px 24px;
        color: var(--report-muted);
        text-align: center;
    }

    .report-empty i {
        display: block;
        margin-bottom: 10px;
        color: #aab2c3;
        font-size: 38px;
    }
</style>

<div class="report-page">
    <div class="row">
        <div class="col-12">
            <div class="report-hero">
                <div>
                    <h2><i class="mdi mdi-account-group mr-2"></i>School Governance Council Report</h2>
                    <p><?= $is_division_report ? 'View the SGC status for your division, including schools that have not yet submitted an SGC response.' : 'View the SGC status across divisions, including schools that have not yet submitted an SGC response.'; ?></p>
                </div>
                <div class="report-actions">
                    <span class="report-pill">
                        <i class="mdi mdi-office-building"></i>
                        <?= $is_division_report ? count($schools) : $division_total; ?> <?= $is_division_report ? (count($schools) === 1 ? 'school' : 'schools') : ($division_total === 1 ? 'division' : 'divisions'); ?>
                    </span>
                </div>
            </div>

            <?php if ($this->session->flashdata('success')) : ?>
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    <?= $this->session->flashdata('success'); ?>
                </div>
            <?php endif; ?>

            <?php if ($this->session->flashdata('danger')) : ?>
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    <?= $this->session->flashdata('danger'); ?>
                </div>
            <?php endif; ?>
        </div>
    </div>

    <div class="row">
        <div class="col-12">
            <div class="card report-card">
                <div class="card-body">
                    <div class="report-card-header">
                        <div>
                            <h4><?= html_escape($title); ?></h4>
                            <p><?= $is_division_report ? 'All schools in your division and their current School Governance Council status.' : ($is_region_report ? 'Expand a division to view its schools and SGC status summary. Division summaries count recorded schools; the overall summary uses configured division totals.' : 'SGC status breakdown per division, with schools that have not yet responded based on total encoded schools.'); ?></p>
                        </div>
                    </div>

                    <?php if ($is_division_report || $is_region_report) { ?>
                        <?php if ($district_groups) { ?>
                        <div class="sgc-district-actions">
                            <button type="button" class="btn btn-outline-secondary btn-sm" data-sgc-expand="true">Expand All</button>
                            <button type="button" class="btn btn-outline-secondary btn-sm" data-sgc-expand="false">Collapse All</button>
                        </div>
                        <?php foreach ($district_groups as $district => $district_schools) :
                            $district = $is_region_report ? $group_names[$district] : $district;
                            $district_status_counts = array(1 => 0, 2 => 0, 3 => 0, 0 => 0);
                            foreach ($district_schools as $district_school) {
                                $district_status = (int) $district_school->sgc;
                                $district_status_counts[isset($sgc_labels[$district_status]) ? $district_status : 0]++;
                            }
                        ?>
                        <details class="sgc-district">
                            <summary><?= html_escape($district); ?><span class="badge badge-light"><?= count($district_schools); ?> schools</span></summary>
                        <div class="report-table-wrap table-responsive">
                            <table class="table dt-responsive sgc-school-table" style="width:100%">
                                <thead><tr><th>No.</th><th>School ID</th><th>School Name</th><th>District</th><th>SGC Status</th></tr></thead>
                                <tbody>
                                <?php foreach ($district_schools as $index => $school) :
                                    $status = (int) $school->sgc;
                                ?>
                                    <tr>
                                        <td><?= $index + 1; ?></td>
                                        <td><?= html_escape($school->schoolID); ?></td>
                                        <td><?php if ($is_division_report) : ?><a class="stat-value" href="<?= base_url('Pages/school_profile_division/' . rawurlencode($school->schoolID)); ?>"><?= html_escape($school->schoolName); ?></a><?php else : ?><span class="stat-value"><?= html_escape($school->schoolName); ?></span><?php endif; ?></td>
                                        <td><?= html_escape(trim((string) $school->district_name) !== '' ? $school->district_name : 'Unassigned District'); ?></td>
                                        <td><span class="badge badge-<?= isset($sgc_colors[$status]) ? $sgc_colors[$status] : 'secondary'; ?>"><?= isset($sgc_labels[$status]) ? $sgc_labels[$status] : 'Not Yet Responded'; ?></span></td>
                                    </tr>
                                <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                            <section class="sgc-district-summary">
                                <div class="report-card-header">
                                    <div><h4>SGC Status Summary</h4><p>All recorded schools in <?= html_escape($district); ?>. Select a count to show matching schools above.</p></div>
                                    <button type="button" class="btn btn-outline-secondary btn-sm sgc-district-reset">Show All Schools</button>
                                </div>
                                <div class="sgc-summary-grid">
                                    <?php foreach ($summary_labels as $district_status => $district_label) : ?>
                                        <div class="sgc-summary-item">
                                            <span class="badge badge-<?= isset($sgc_colors[$district_status]) ? $sgc_colors[$district_status] : 'secondary'; ?>"><?= html_escape($district_label); ?></span>
                                            <button type="button" class="btn btn-link sgc-district-status p-0" data-status="<?= html_escape($district_label); ?>" aria-label="<?= html_escape('View ' . $district_label . ' schools in ' . $district); ?>">
                                                <strong><?= number_format($district_status_counts[$district_status]); ?></strong>
                                                <span>View details &rarr;</span>
                                            </button>
                                        </div>
                                    <?php endforeach; ?>
                                </div>
                            </section>
                        </details>
                        <?php endforeach; ?>
                        <?php } else { ?>
                            <div class="report-empty"><?= $is_region_report ? 'No divisions are available for your assigned region.' : 'No schools are available for your assigned division.'; ?></div>
                        <?php } ?>
                    <?php } elseif (!empty($data)) { ?>
                        <div class="report-table-wrap table-responsive">
                            <table id="sgc-report-table" class="table dt-responsive" style="width: 100%;">
                                <thead>
                                    <tr>
                                        <th>No.</th>
                                        <th>Division</th>
                                        <th>Total Schools</th>
                                        <th>Not Yet Organized</th>
                                        <th>Organized (Not Functional)</th>
                                        <th>Functional</th>
                                        <th>Total SGC</th>
                                        <th>Not Yet Responded</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($data as $index => $row) { ?>
                                        <tr>
                                            <td><?= $index + 1; ?></td>
                                            <td>
                                                <span class="stat-value"><?= html_escape($row->description); ?></span>
                                            </td>
                                            <td class="stat-cell">
                                                <span class="stat-value"><?= html_escape($row->total_schools); ?></span>
                                                <span class="stat-label">Total Schools</span>
                                            </td>
                                            <td class="stat-cell">
                                                <span class="stat-value"><?= html_escape($row->not_yet_organized); ?></span>
                                                <span class="stat-label">Not Yet Organized</span>
                                                <?php if ($row->total_sgc > 0) { ?>
                                                <div class="progress-wrapper">
                                                    <div class="progress">
                                                        <div class="progress-bar progress-bar-danger" style="width: <?= round(($row->not_yet_organized / $row->total_sgc) * 100, 1); ?>%;"></div>
                                                    </div>
                                                    <span class="percentage-text"><?= round(($row->not_yet_organized / $row->total_sgc) * 100, 1); ?>%</span>
                                                </div>
                                                <?php } ?>
                                            </td>
                                            <td class="stat-cell">
                                                <span class="stat-value"><?= html_escape($row->organized_not_functional); ?></span>
                                                <span class="stat-label">Organized (Not Functional)</span>
                                                <?php if ($row->total_sgc > 0) { ?>
                                                <div class="progress-wrapper">
                                                    <div class="progress">
                                                        <div class="progress-bar progress-bar-warning" style="width: <?= round(($row->organized_not_functional / $row->total_sgc) * 100, 1); ?>%;"></div>
                                                    </div>
                                                    <span class="percentage-text"><?= round(($row->organized_not_functional / $row->total_sgc) * 100, 1); ?>%</span>
                                                </div>
                                                <?php } ?>
                                            </td>
                                            <td class="stat-cell">
                                                <span class="stat-value"><?= html_escape($row->functional); ?></span>
                                                <span class="stat-label">Functional</span>
                                                <?php if ($row->total_sgc > 0) { ?>
                                                <div class="progress-wrapper">
                                                    <div class="progress">
                                                        <div class="progress-bar progress-bar-success" style="width: <?= round(($row->functional / $row->total_sgc) * 100, 1); ?>%;"></div>
                                                    </div>
                                                    <span class="percentage-text"><?= round(($row->functional / $row->total_sgc) * 100, 1); ?>%</span>
                                                </div>
                                                <?php } ?>
                                            </td>
                                            <td class="stat-cell">
                                                <span class="stat-value"><?= html_escape($row->total_sgc); ?></span>
                                                <span class="stat-label">Total SGC</span>
                                            </td>
                                            <td class="stat-cell">
                                                <span class="stat-value"><?= html_escape($row->not_yet_responded); ?></span>
                                                <span class="stat-label">Total Schools - Total SGC</span>
                                                <?php if ($row->total_schools > 0) { ?>
                                                <div class="progress-wrapper">
                                                    <div class="progress">
                                                        <div class="progress-bar progress-bar-danger" style="width: <?= round(($row->not_yet_responded / $row->total_schools) * 100, 1); ?>%;"></div>
                                                    </div>
                                                    <span class="percentage-text"><?= round(($row->not_yet_responded / $row->total_schools) * 100, 1); ?>%</span>
                                                </div>
                                                <?php } ?>
                                            </td>
                                        </tr>
                                    <?php } ?>
                                </tbody>
                            </table>
                        </div>
                    <?php } else { ?>
                        <div class="report-empty">
                            <i class="mdi mdi-office-building-remove-outline"></i>
                            <?= $is_division_report ? 'No division is assigned or available for your account.' : 'No divisions are available for the active region.'; ?>
                        </div>
                    <?php } ?>
                </div>
            </div>
            <div class="card report-card sgc-summary">
                <div class="report-card-header">
                    <div><h4>SGC Status Summary</h4><p>Counts for all schools in this report, regardless of table searches or collapsed districts.</p></div>
                </div>
                <div class="sgc-summary-grid">
                    <?php foreach ($summary_labels as $status => $label) : ?>
                        <div class="sgc-summary-item">
                            <span class="badge badge-<?= isset($sgc_colors[$status]) ? $sgc_colors[$status] : 'secondary'; ?>"><?= html_escape($label); ?></span>
                            <a href="<?= base_url('Pages/report_sgc_details/' . $status); ?>" aria-label="<?= html_escape('View ' . $label . ' school details'); ?>"><strong><?= number_format($status_counts[$status]); ?></strong><span>View details &rarr;</span></a>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
window.addEventListener('load', function() {
    document.querySelectorAll('[data-sgc-expand]').forEach(function (button) {
        button.addEventListener('click', function () {
            document.querySelectorAll('.sgc-district').forEach(function (district) {
                district.open = button.dataset.sgcExpand === 'true';
            });
        });
    });
    document.querySelectorAll('.sgc-district').forEach(function (district) {
        district.addEventListener('toggle', function () {
            if (district.open) {
                $(district).find('table').DataTable().columns.adjust().responsive.recalc();
            }
        });
    });
    $('.sgc-district-status, .sgc-district-reset').on('click', function () {
        var district = $(this).closest('.sgc-district');
        var table = district.find('.sgc-school-table').DataTable();
        var status = $(this).attr('data-status');
        table.search('').columns().search('');
        if (status) {
            table.column(4).search('^' + $.fn.dataTable.util.escapeRegex(status) + '$', true, false);
        }
        table.draw();
        district.find('.report-table-wrap')[0].scrollIntoView({ behavior: 'smooth', block: 'start' });
    });
    $('#sgc-report-table, .sgc-school-table').DataTable({
        pageLength: 20,
        lengthMenu: [[10, 20, 50, 100], [10, 20, 50, 100]],
        order: [[0, 'asc']],
        responsive: true,
        language: {
            search: "_INPUT_",
            searchPlaceholder: "<?= ($is_division_report || $is_region_report) ? 'Search schools...' : 'Search divisions...'; ?>"
        }
    });
});
</script>
