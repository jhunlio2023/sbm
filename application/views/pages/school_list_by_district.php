<?php
$division_total = count($data);
$dashboard_url = base_url();
?>

<style>
    .school-directory-page {
        --directory-primary: #8b1e3f;
        --directory-primary-dark: #64142d;
        --directory-border: #e8ecf4;
        --directory-muted: #6b7280;
    }

    .school-directory-page .alert {
        border: 0;
        border-radius: 12px;
        box-shadow: 0 6px 18px rgba(31, 45, 75, .07);
    }

    .school-directory-hero {
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

    .school-directory-hero h2 {
        margin: 0 0 7px;
        color: #fff;
        font-size: 25px;
        font-weight: 700;
    }

    .school-directory-hero p {
        max-width: 700px;
        margin: 0;
        color: rgba(255, 255, 255, .82);
    }

    .school-directory-actions {
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

    .school-directory-page .dataTables_wrapper .row:first-child {
        align-items: center;
        padding: 12px 0 6px;
    }

    .school-directory-page .dataTables_filter input,
    .school-directory-page .dataTables_length select {
        min-height: 38px;
        border: 1px solid #dce2ee;
        border-radius: 9px;
        box-shadow: none;
    }

    .school-directory-page table.dataTable {
        margin-top: 12px !important;
        border-collapse: separate !important;
        border-spacing: 0 8px !important;
    }

    .school-directory-page table.dataTable thead th {
        padding: 11px 14px;
        border: 0;
        color: #687086;
        font-size: 10px;
        font-weight: 700;
        letter-spacing: .06em;
        text-transform: uppercase;
        white-space: nowrap;
    }

    .school-directory-page table.dataTable tbody td {
        padding: 14px;
        border-top: 1px solid var(--directory-border);
        border-bottom: 1px solid var(--directory-border);
        vertical-align: middle;
        background: #fff;
    }

    .school-directory-page table.dataTable tbody td:first-child {
        border-left: 1px solid var(--directory-border);
        border-radius: 11px 0 0 11px;
    }

    .school-directory-page table.dataTable tbody td:last-child {
        border-right: 1px solid var(--directory-border);
        border-radius: 0 11px 11px 0;
    }

    .school-directory-page table.dataTable tbody tr:hover td {
        background: #fff7f9;
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

    .directory-name-cell {
        display: flex;
        align-items: center;
        gap: 12px;
        min-width: 230px;
    }

    .directory-icon {
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

    .directory-name {
        color: #27324a;
        font-weight: 700;
    }

    .directory-meta {
        display: block;
        margin-top: 2px;
        color: var(--directory-muted);
        font-size: 11px;
    }

    .directory-action .btn {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        padding: 8px 12px;
        border-radius: 9px;
        font-size: 11px;
        font-weight: 700;
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

    @media (max-width: 767.98px) {
        .school-directory-hero {
            align-items: flex-start;
            flex-direction: column;
            padding: 22px;
            border-radius: 14px;
        }

        .school-directory-actions {
            width: 100%;
        }

        .directory-pill,
        .directory-back-link {
            justify-content: center;
            flex: 1 1 auto;
        }

        .directory-card-header {
            align-items: flex-start;
            flex-direction: column;
            padding: 18px;
        }

        .directory-table-wrap {
            padding: 8px 14px 18px;
        }

        .school-directory-page .dataTables_wrapper .row:first-child > div {
            width: 100%;
            max-width: 100%;
            flex: 0 0 100%;
        }

        .school-directory-page .dataTables_filter,
        .school-directory-page .dataTables_length {
            text-align: left;
        }

        .school-directory-page .dataTables_filter input {
            width: calc(100% - 58px);
            margin-left: 6px;
        }

        .school-directory-page .dataTables_info,
        .school-directory-page .dataTables_paginate {
            text-align: center !important;
            white-space: normal;
        }
    }
</style>

<div class="school-directory-page">
    <div class="row">
        <div class="col-12">
            <div class="school-directory-hero">
                <div>
                    <h2><i class="mdi mdi-office-building mr-2"></i>School Directory by Division</h2>
                    <p>Select a division to open its school directory, then drill down into the schools listed under that division.</p>
                </div>
                <div class="school-directory-actions">
                    <span class="directory-pill">
                        <i class="mdi mdi-format-list-bulleted-square"></i>
                        <?= $division_total; ?> <?= $division_total === 1 ? 'division' : 'divisions'; ?>
                    </span>
                    <a href="<?= $dashboard_url; ?>" class="directory-back-link">
                        <i class="mdi mdi-arrow-left"></i> Back to Dashboard
                    </a>
                </div>
            </div>

            <?php if($this->session->flashdata('success')) : ?>
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    <?= $this->session->flashdata('success'); ?>
                </div>
            <?php endif; ?>

            <?php if($this->session->flashdata('danger')) : ?>
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
            <div class="card directory-card">
                <div class="card-body">
                    <div class="directory-card-header">
                        <div>
                            <h4><?= html_escape($title); ?></h4>
                            <p>Use the list below to open the schools recorded under each division.</p>
                        </div>
                        <span class="directory-card-badge">
                            <i class="mdi mdi-school-outline"></i> Division School Access
                        </span>
                    </div>

                    <?php if (!empty($data)) { ?>
                        <div class="directory-table-wrap table-responsive">
                            <table id="datatable" class="table dt-responsive" style="width: 100%;">
                                <thead>
                                    <tr>
                                        <th>No.</th>
                                        <th>Division</th>
                                        <th class="text-center">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($data as $index => $row) { ?>
                                        <tr>
                                            <td><span class="directory-sequence"><?= $index + 1; ?></span></td>
                                            <td>
                                                <div class="directory-name-cell">
                                                    <span class="directory-icon"><i class="mdi mdi-office-building-outline"></i></span>
                                                    <div>
                                                        <span class="directory-name"><?= html_escape($row->description); ?></span>
                                                        <span class="directory-meta">Browse schools recorded under this division</span>
                                                    </div>
                                                </div>
                                            </td>
                                            <td class="text-center directory-action">
                                                <a href="<?= base_url(); ?>Pages/schools/<?= $row->id; ?>" class="btn btn-success btn-sm">
                                                    <i class="mdi mdi-file-document-box-check-outline"></i> View Schools
                                                </a>
                                            </td>
                                        </tr>
                                    <?php } ?>
                                </tbody>
                            </table>
                        </div>
                    <?php } else { ?>
                        <div class="directory-empty">
                            <i class="mdi mdi-office-building-remove-outline"></i>
                            No divisions are available for your current region.
                        </div>
                    <?php } ?>
                </div>
            </div>
        </div>
    </div>
</div>
