<h2>Module Students</h2>

<table border="1">
<tr>
    <th>Name</th>
    <th>Exam</th>
    <th>TD</th>
    <th>Presence</th>
    <th>Average</th>
</tr>

<?php foreach ($data as $row): ?>
<tr>
    <td><?= $row['student']['first_name'] ?></td>
    <td><?= $row['notes']['exam'] ?></td>
    <td><?= $row['notes']['td'] ?></td>
    <td><?= $row['notes']['presence'] ?></td>
    <td><?= $row['average'] ?></td>
</tr>
<?php endforeach; ?>
</table>