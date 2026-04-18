<h2>All Students Notes</h2>

<table border="1">
<tr>
    <th>Name</th>
    <th>Email</th>
    <th>Average</th>
    <th>Status</th>
</tr>

<?php foreach ($data as $row): ?>
<tr onclick="window.location='?student_id=<?= $row['student']['id'] ?>'">
    <td><?= $row['student']['first_name'] ?> <?= $row['student']['last_name'] ?></td>
    <td><?= $row['student']['email'] ?></td>
    <td><?= $row['average'] ?></td>
    <td><?= $row['status'] ?></td>
</tr>
<?php endforeach; ?>
</table>