<?php
require_once __DIR__ . "/config/db.php";

$sql = "SELECT * FROM students ORDER BY id ASC";
$stmt = $conn->prepare($sql);
$stmt->execute();
$students = $stmt->fetchAll();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Management System</title>
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>
<div class="container">
    <h1>Student Management System</h1>

    <?php if (isset($_GET['success'])): ?>
        <p class="alert alert-success">Student registered successfully!</p>
    <?php endif; ?>

    <?php if (isset($_GET['updated'])): ?>
        <p class="alert alert-success">Student updated successfully!</p>
    <?php endif; ?>

    <?php if (isset($_GET['deleted'])): ?>
        <p class="alert alert-success">Student deleted successfully!</p>
    <?php endif; ?>

    <p class="page-top"><a href="create.php" class="btn btn-primary">+ Register New Student</a></p>

    <h2>Registered Students</h2>

    <div class="table-wrapper">
    <table>
        <thead>
        <tr>
            <th>ID</th>
            <th>Full Name</th>
            <th>Email</th>
            <th>Age</th>
            <th>Course</th>
            <th>Edit or Delete</th>
        </tr>
        </thead>
        <tbody>
        <?php if (count($students) > 0): ?>
            <?php foreach ($students as $student): ?>
                <tr>
                    <td><?= htmlspecialchars((string) $student['id']) ?></td>
                    <td><?= htmlspecialchars($student['full_name']) ?></td>
                    <td><?= htmlspecialchars($student['email']) ?></td>
                    <td><?= htmlspecialchars((string) $student['age']) ?></td>
                    <td><?= htmlspecialchars($student['course']) ?></td>
                    <td>
                        <div class="actions">
                            <a class="btn btn-warning" href="edit.php?id=<?= urlencode((string) $student['id']) ?>">Edit</a>
                            <form action="delete.php" method="POST"
                                  onsubmit="return confirm('Are you sure you want to delete this student?');">
                                <input type="hidden" name="id"
                                       value="<?= htmlspecialchars((string) $student['id']) ?>">
                                <button type="submit" name="delete" value="1" class="btn btn-danger">Delete</button>
                            </form>
                        </div>
                    </td>
                </tr>
            <?php endforeach; ?>
        <?php else: ?>
            <tr>
                <td colspan="6" class="empty-row">No students found</td>
            </tr>
        <?php endif; ?>
        </tbody>
    </table>
    </div>
</div>
</body>
</html>
