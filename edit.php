<?php
require_once __DIR__ . "/config/db.php";

if (!isset($_GET['id']) || !ctype_digit((string) $_GET['id']) || (int) $_GET['id'] < 1) {
    http_response_code(400);
    exit("Invalid student ID.");
}

$id = (int) $_GET['id'];

$stmt = $conn->prepare("SELECT * FROM students WHERE id = :id");
$stmt->execute([':id' => $id]);
$student = $stmt->fetch();

if (!$student) {
    http_response_code(404);
    exit("Student not found.");
}

$error = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update'])) {
    $name = trim($_POST['name'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $ageInput = trim($_POST['age'] ?? '');
    $course = trim($_POST['course'] ?? '');

    if ($name === '' || $email === '' || $ageInput === '' || $course === '') {
        $error = "Please fill in all fields.";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error = "Please enter a valid email address.";
    } elseif (!ctype_digit($ageInput) || (int) $ageInput < 1 || (int) $ageInput > 100) {
        $error = "Please enter an age between 1 and 100.";
    } else {
        $sql = "UPDATE students
                SET full_name = :name, email = :email, age = :age, course = :course
                WHERE id = :id";
        $stmt = $conn->prepare($sql);
        $stmt->execute([
            ':name' => $name,
            ':email' => $email,
            ':age' => (int) $ageInput,
            ':course' => $course,
            ':id' => $id
        ]);

        header("Location: index.php?updated=1");
        exit();
    }

    $student['full_name'] = $name;
    $student['email'] = $email;
    $student['age'] = $ageInput;
    $student['course'] = $course;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Student</title>
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>
<div class="container">
    <h2>Edit Student Information</h2>

    <?php if ($error !== ''): ?>
        <p class="alert alert-error"><?= htmlspecialchars($error) ?></p>
    <?php endif; ?>

    <form action="edit.php?id=<?= urlencode((string) $id) ?>" method="POST">
        <div class="form-group">
            <label for="name">Full Name:</label>
            <input type="text" id="name" name="name"
                   value="<?= htmlspecialchars((string) $student['full_name']) ?>" required>
        </div>

        <div class="form-group">
            <label for="email">Email:</label>
            <input type="email" id="email" name="email"
                   value="<?= htmlspecialchars((string) $student['email']) ?>" required maxlength="254">
        </div>

        <div class="form-group">
            <label for="age">Age:</label>
            <input type="number" id="age" name="age" min="1" max="100"
                   value="<?= htmlspecialchars((string) $student['age']) ?>" required>
        </div>

        <div class="form-group">
            <label for="course">Course:</label>
            <input type="text" id="course" name="course"
                   value="<?= htmlspecialchars((string) $student['course']) ?>" required>
        </div>

        <button type="submit" name="update" value="1" class="btn btn-success">Update Student</button>
    </form>

    <p><a class="back-link" href="index.php">&larr; Back to Students</a></p>
</div>
</body>
</html>
