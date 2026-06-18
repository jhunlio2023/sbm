<?php
$division_total = count($data);
$dashboard_url = base_url();
$table_definitions = array(
    'sgod_action_plan' => array(
        'label' => 'Action Plan',
        'badge_class' => 'success',
        'chip_class' => 'summary-action'
    ),
    'sbm' => array(
        'label' => 'Self-Assessment',
        'badge_class' => 'info',
        'chip_class' => 'summary-checklist'
    ),
    'sbm_ta' => array(
        'label' => 'TA Form',
        'badge_class' => 'primary',
        'chip_class' => 'summary-ta'
    )
);
$submission_counts_by_division = array();
$summary_totals = array_fill_keys(array_keys($table_definitions), 0);

foreach ($data as $row) {
    foreach ($table_definitions as $table => $definition) {
        $count = $this->Common->two_cond_count_row_gb(
            $table,
            'division',
            $row->id,
            'fy',
            $this->session->fy,
            'school_id'
        )->num_rows();

        $submission_counts_by_division[(string) $row->id][$table] = $count;
        $summary_totals[$table] += $count;
    }
}
?>

<style>
    .division-directory-page {
        --directory-primary: #8b1e3f;
        --directory-primary-dark: #64142d;
        --directory-border: #e8ecf4;
        --directory-muted: #6b7280;
    }

    .division-directory-page .alert {
        border: 0;
        border-radius: 12px;
        box-shadow: 0 6px 18px rgba(31, 45, 75, .07);
    }

    .division-directory-hero {
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

    .division-directory-hero h2 {
        margin: 0 0 7px;
        color: #fff;
        font-size: 25px;
        font-weight: 700;
    }

    .division-directory-hero p {
        max-width: 720px;
        margin: 0;
        color: rgba(255, 255, 255, .82);
    }

    .division-directory-actions {
        display: flex;
        align-items: center;
        flex-wrap: wrap;
        gap: 10px;
    }

    .directory-pill,
    .directory-back-link {
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

    .directory-back-link:hover {
        color: var(--directory-primary-dark);
        background: #fff;
        text-decoration: none;
    }

    .division-summary-grid {
        display: grid;
        grid-template-columns: repeat(4, minmax(0, 1fr));
        gap: 16px;
        margin-bottom: 22px;
    }

    .division-summary-card {
        padding: 18px;
        border: 1px solid var(--directory-border);
        border-radius: 16px;
        background: #fff;
        box-shadow: 0 8px 24px rgba(31, 45, 75, .06);
    }

    .division-summary-card span {
        display: block;
        color: var(--directory-muted);
        font-size: 11px;
        font-weight: 700;
        letter-spacing: .05em;
        text-transform: uppercase;
    }

    .division-summary-card strong {
        display: block;
        margin-top: 10px;
        color: #27324a;
        font-size: 27px;
        line-height: 1;
    }

    .division-summary-card.summary-action strong { color: #16835a; }
    .division-summary-card.summary-checklist strong { color: #17718d; }
    .division-summary-card.summary-ta strong { color: #4a56c7; }

    .directory-card {
        border: 1px solid var(--directory-border);
        border-radius: 16px;
        background: #fff;
        box-shadow: 0 8px 28px rgba(31, 45, 75, .07);
        overflow: hidden;
    }

    .directory-card .card-body {
        padding: 0;
    }

    .directory-card-header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 16px;
        padding: 20px 24px;
        border-bottom: 1px solid var(--directory-border);
    }

    .directory-card-header h4 {
        margin: 0 0 3px;
        color: #27324a;
        font-size: 17px;
        font-weight: 700;
    }

    .directory-card-header p {
        margin: 0;
        color: var(--directory-muted);
        font-size: 12px;
    }

    .directory-card-badge {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        padding: 7px 11px;
        border-radius: 999px;
        color: var(--directory-primary-dark);
        background: #f9e9ee;
        font-size: 11px;
        font-weight: 700;
        white-space: nowrap;
    }

    .directory-table-wrap {
        padding: 8px 24px 24px;
    }

    .division-directory-page table {
        margin: 0;
    }

    .division-directory-page table thead th {
        padding: 11px 14px;
        border-top: 0;
        color: #687086;
        font-size: 10px;
        font-weight: 700;
        letter-spacing: .06em;
        text-transform: uppercase;
        white-space: nowrap;
    }

    .division-directory-page table tbody td {
        padding: 14px;
        vertical-align: middle;
    }

    .directory-sequence {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        min-width: 34px;
        height: 34px;
        padding: 0 8px;
        border-radius: 9px;
        color: var(--directory-primary-dark);
        background: #f9e9ee;
        font-size: 11px;
        font-weight: 700;
    }

    .division-name-cell {
        display: flex;
        align-items: center;
        gap: 12px;
        min-width: 250px;
    }

    .division-icon {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        width: 42px;
        height: 42px;
        flex: 0 0 42px;
        border-radius: 12px;
        color: #fff;
        background: linear-gradient(135deg, #8b1e3f, #c65a77);
        font-size: 19px;
    }

    .division-name {
        color: #27324a;
        font-weight: 700;
    }

    .division-meta {
        display: block;
        margin-top: 2px;
        color: var(--directory-muted);
        font-size: 11px;
    }

    .submission-link {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        min-width: 44px;
        padding: 6px 10px;
        border-radius: 999px;
        font-size: 11px;
        font-weight: 700;
        transition: transform .15s ease;
    }

    .submission-link:hover {
        transform: translateY(-1px);
        text-decoration: none;
    }

    .submission-link.summary-action,
    .submission-link.badge-success {
        color: #16835a;
        background: #e6f7ef;
    }

    .submission-link.summary-checklist,
    .submission-link.badge-info {
        color: #17718d;
        background: #e8f6fa;
    }

    .submission-link.summary-ta,
    .submission-link.badge-primary {
        color: #4a56c7;
        background: #eef0ff;
    }

    .directory-empty {
        padding: 48px 24px;
        color: var(--directory-muted);
        text-align: center;
    }

    .directory-empty i {
        display: block;
        margin-bottom: 10px;
        color: #aab2c3;
        font-size: 38px;
    }

    @media (max-width: 991.98px) {
        .division-summary-grid {
            grid-template-columns: repeat(2, minmax(0, 1fr));
        }
    }

    @media (max-width: 767.98px) {
        .division-directory-hero {
            align-items: flex-start;
            flex-direction: column;
            padding: 22px;
            border-radius: 14px;
        }

        .division-directory-actions {
            width: 100%;
        }

        .directory-pill,
        .directory-back-link {
            justify-content: center;
            flex: 1 1 auto;
        }

        .division-summary-grid {
            grid-template-columns: 1fr;
        }

        .directory-card-header {
            align-items: flex-start;
            flex-direction: column;
            padding: 18px;
        }

        .directory-table-wrap {
            padding: 8px 14px 18px;
        }
    }
</style>

<div class="division-directory-page">
    <div class="row">
        <div class="col-12">
            <div class="division-directory-hero">
                <div>
                    <h2><i class="mdi mdi-office-building mr-2"></i>Regional Division Directory</h2>
                    <p>Review each division and open its district-level submission breakdown for action plans, self-assessment checklists, and TA forms.</p>
                </div>
                <div class="division-directory-actions">
                    <span class="directory-pill">
                        <i class="mdi mdi-format-list-bulleted-square"></i>
                        <?= $division_total; ?> <?= $division_total === 1 ? 'division' : 'divisions'; ?>
                    </span>
                    <a href="<?= $dashboard_url; ?>" class="directory-back-link">
                        <i class="mdi mdi-arrow-left"></i> Back to Dashboard
                    </a>
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

    <div class="division-summary-grid">
        <div class="division-summary-card">
            <span>Divisions</span>
            <strong><?= $division_total; ?></strong>
        </div>
        <div class="division-summary-card summary-action">
            <span>Action Plan Submissions</span>
            <strong><?= $summary_totals['sgod_action_plan']; ?></strong>
        </div>
        <div class="division-summary-card summary-checklist">
            <span>Self-Assessment Submissions</span>
            <strong><?= $summary_totals['sbm']; ?></strong>
        </div>
        <div class="division-summary-card summary-ta">
            <span>TA Form Submissions</span>
            <strong><?= $summary_totals['sbm_ta']; ?></strong>
        </div>
    </div>

    <div class="row">
        <div class="col-12">
            <div class="card directory-card">
                <div class="card-body">
                    <div class="directory-card-header">
                        <div>
                            <h4><?= html_escape($title); ?></h4>
                            <p>Click any submission count to open the district-level breakdown for that division.</p>
                        </div>
                        <span class="directory-card-badge">
                            <i class="mdi mdi-view-list-outline"></i> Fiscal Year <?= html_escape($this->session->fy); ?>
                        </span>
                    </div>

                    <?php if (!empty($data)) { ?>
                        <div class="directory-table-wrap table-responsive">
                            <table class="table mb-0">
                                <thead>
                                    <tr>
                                        <th>No.</th>
                                        <th>Division</th>
                                        <th class="text-center">Action Plan</th>
                                        <th class="text-center">Self-Assessment</th>
                                        <th class="text-center">TA Form</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($data as $index => $row) { ?>
                                        <tr>
                                            <td><span class="directory-sequence"><?= $index + 1; ?></span></td>
                                            <td>
                                                <div class="division-name-cell">
                                                    <span class="division-icon"><i class="mdi mdi-office-building-outline"></i></span>
                                                    <div>
                                                        <span class="division-name"><?= html_escape($row->description); ?></span>
                                                        <span class="division-meta">Open district submission details for this division</span>
                                                    </div>
                                                </div>
                                            </td>
                                            <?php foreach ($table_definitions as $table => $definition) :
                                                $count = isset($submission_counts_by_division[(string) $row->id][$table])
                                                    ? $submission_counts_by_division[(string) $row->id][$table]
                                                    : 0;
                                            ?>
                                                <td class="text-center">
                                                    <a
                                                        href="<?= base_url(); ?>Pages/district_list_division/<?= $row->id; ?>/<?= $table; ?>"
                                                        class="submission-link <?= $definition['chip_class']; ?>"
                                                        title="View <?= html_escape($definition['label']); ?> details for <?= html_escape($row->description); ?>"
                                                    >
                                                        <?= $count; ?>
                                                    </a>
                                                </td>
                                            <?php endforeach; ?>
                                        </tr>
                                    <?php } ?>
                                </tbody>
                            </table>
                        </div>
                    <?php } else { ?>
                        <div class="directory-empty">
                            <i class="mdi mdi-office-building-remove-outline"></i>
                            No divisions are available for the active region.
                        </div>
                    <?php } ?>
                </div>
            </div>
        </div>
    </div>
</div>
