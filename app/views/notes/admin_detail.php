<h2>Student Detail</h2>

<?php foreach ($data['modules'] as $m): ?>

<h3><?= $m['module']['name'] ?></h3>

Exam: <?= $m['notes']['exam'] ?><br>
TD: <?= $m['notes']['td'] ?><br>
Presence: <?= $m['notes']['presence'] ?><br>

<strong>Average: <?= $m['average'] ?></strong>

<hr>

<?php endforeach; ?>

<h2>General: <?= $data['general_average'] ?></h2>