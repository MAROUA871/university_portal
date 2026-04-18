<h2 class="title">📘 Module Students</h2>

<?php if (!empty($data) && is_array($data)): ?>

    <table class="notes-table">
        <thead>
            <tr>
                <th>Name</th>
                <th>Exam</th>
                <th>TD</th>
                <th>Presence</th>
                <th>Average</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($data as $row): ?>
                <tr>
                    <td><?= htmlspecialchars($row['student']['first_name'] ?? '-') ?></td>
                    <td><?= htmlspecialchars($row['notes']['exam'] ?? '-') ?></td>
                    <td><?= htmlspecialchars($row['notes']['td'] ?? '-') ?></td>
                    <td><?= htmlspecialchars($row['notes']['presence'] ?? '-') ?></td>
                    <td><?= htmlspecialchars($row['average'] ?? '-') ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

<?php else: ?>

    <p class="empty">⚠️ No student data available.</p>

<?php endif; ?>