<div class="content-wrapper">
    <section class="content-header">
        <h1><?= $title ?></h1>
    </section>

    <section class="content">
        <div class="box">
            <div class="box-header with-border">
                <h3 class="box-title">Skill Gap Details for <?= html_escape($analysis['employee']['first_name'] . ' ' . $analysis['employee']['last_name']) ?> (<?= html_escape($analysis['employee']['des_name']) ?>)</h3>
            </div>
            <div class="box-body">
                <?php if ($analysis): ?>
                    
                    <div class="row">
                        <div class="col-md-6">
                            <h4>Required Skills for Designation:</h4>
                            <ul class="list-group">
                                <?php foreach ($analysis['required_skills'] as $skill_name => $required_level): ?>
                                    <li class="list-group-item">
                                        <?= html_escape($skill_name) ?> <span class="badge bg-primary pull-right"><?= html_escape($required_level) ?></span>
                                    </li>
                                <?php endforeach; ?>
                            </ul>
                        </div>
                        <div class="col-md-6">
                            <h4>Employee's Current Skills:</h4>
                            <ul class="list-group">
                                <?php foreach ($analysis['employee_skills'] as $skill_name => $current_level): ?>
                                    <li class="list-group-item">
                                        <?= html_escape($skill_name) ?> <span class="badge bg-success pull-right"><?= html_escape($current_level) ?></span>
                                    </li>
                                <?php endforeach; ?>
                            </ul>
                        </div>
                    </div>

                    <hr>

                    <h3>Skill Gap (Needs Training)</h3>
                    <?php if (!empty($analysis['gap'])): ?>
                        <table class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>Skill</th>
                                    <th>Required Level</th>
                                    <th>Current Level</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($analysis['gap'] as $item): ?>
                                    <tr class="danger">
                                        <td><?= html_escape($item['skill']) ?></td>
                                        <td><?= html_escape($item['required']) ?></td>
                                        <td><?= html_escape($item['current']) ?></td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    <?php else: ?>
                        <p class="text-success">No significant skill gap detected. Employee meets all required skill levels.</p>
                    <?php endif; ?>

                    <hr>

                    <h3>Training Recommendations</h3>
                    <?php if (!empty($analysis['recommendations'])): ?>
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>Course/Training</th>
                                    <th>Link</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($analysis['recommendations'] as $rec): ?>
                                    <tr>
                                        <td><?= html_escape($rec['course_name']) ?></td>
                                        <td><a href="<?= html_escape($rec['link']) ?>" target="_blank" class="btn btn-success btn-xs">View Course</a></td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    <?php else: ?>
                        <p class="text-info">No specific training recommendations found for the current skill gaps.</p>
                    <?php endif; ?>

                <?php else: ?>
                    <p class="text-warning">No skill gap analysis found for this employee.</p>
                <?php endif; ?>
                <a href="<?= site_url('skillgap') ?>" class="btn btn-default">Back to Employee List</a>
            </div>
        </div>
    </section>
</div>
