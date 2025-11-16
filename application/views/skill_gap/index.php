<div class="content-wrapper">
    <section class="content-header">
        <h1><?= $title ?></h1>
    </section>

    <section class="content">
        <div class="box">
            <div class="box-header with-border">
                <h3 class="box-title">Select Employee for Analysis</h3>
            </div>
            <div class="box-body">
                <table class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>Employee Name</th>
                            <th>Designation</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($employees as $employee): ?>
                            <tr>
                                <td><?= html_escape($employee['first_name'] . ' ' . $employee['last_name']) ?></td>
                                <td><?= html_escape($employee['des_name']) ?></td>
                                <td>
                                    <a href="<?= site_url('skillgap/analyze/' . $employee['em_id']) ?>" class="btn btn-info btn-sm">Analyze Gap</a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </section>
</div>
section>
</div>
</div>
</div>
</div>
