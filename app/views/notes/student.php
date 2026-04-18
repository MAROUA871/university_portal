<h2>My Grades</h2>

<?php foreach ($data['modules'] as $m): ?>
    <h3><?= $m['module']['name'] ?></h3>

    Exam: <?= $m['notes']['exam'] ?><br>
    TD: <?= $m['notes']['td'] ?><br>
    Presence: <?= $m['notes']['presence'] ?><br>

    <strong>Module Average: <?= $m['average'] ?></strong>
    <hr>
<?php endforeach; ?>

<h2>General Average: <?= $data['general_average'] ?></h2>