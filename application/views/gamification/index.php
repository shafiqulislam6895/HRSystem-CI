<div class="content-wrapper">
    <section class="content-header">
        <h1><?= $title ?></h1>
    </section>

    <section class="content">
        <div class="row">
            <div class="col-md-6">
                <div class="box box-primary">
                    <div class="box-header with-border">
                        <h3 class="box-title">Performance Leaderboard</h3>
                    </div>
                    <div class="box-body">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>Rank</th>
                                    <th>Employee</th>
                                    <th>Points</th>
                                    <th>Achievements</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($leaderboard as $employee): ?>
                                    <tr>
                                        <td><?= $employee['rank'] ?></td>
                                        <td><?= $employee['name'] ?></td>
                                        <td><span class="label label-success"><?= $employee['points'] ?></span></td>
                                        <td><?= $employee['achievements'] ?></td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <div class="col-md-6">
                <div class="box box-info">
                    <div class="box-header with-border">
                        <h3 class="box-title">Available Badges</h3>
                    </div>
                    <div class="box-body">
                        <?php foreach ($badges as $badge): ?>
                            <div class="callout callout-info">
                                <h4><i class="fa <?= $badge['icon'] ?>"></i> <?= $badge['name'] ?></h4>
                                <p><?= $badge['description'] ?></p>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
