<?php
require_once __DIR__ . "/config/db.php";

$error = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['submit'])) {
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
        $sql = "INSERT INTO students (full_name, email, age, course)
                VALUES (:name, :email, :age, :course)";
        $stmt = $conn->prepare($sql);
        $stmt->execute([
            ':name' => $name,
            ':email' => $email,
            ':age' => (int) $ageInput,
            ':course' => $course
        ]);

        header("Location: index.php?success=1");
        exit();
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Registration</title>
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>
<div class="container">
    <h2>Student Registration Form</h2>

    <?php if ($error !== ''): ?>
        <p class="alert alert-error"><?= htmlspecialchars($error) ?></p>
    <?php endif; ?>

    <form action="create.php" method="POST">
        <div class="form-group">
            <label for="name">Full Name:</label>
            <input type="text" id="name" name="name"
                   value="<?= htmlspecialchars($_POST['name'] ?? '') ?>" required>
        </div>

        <div class="form-group">
            <label for="email">Email:</label>
            <input type="email" id="email" name="email"
                   value="<?= htmlspecialchars($_POST['email'] ?? '') ?>"
                   placeholder="example@gmail.com" required maxlength="254">
        </div>

        <div class="form-group">
            <label for="age">Age:</label>
            <input type="number" id="age" name="age" min="1" max="100"
                   value="<?= htmlspecialchars($_POST['age'] ?? '') ?>" required>
        </div>

        <div class="form-group">
            <label for="course">Course:</label>
            <input type="text" id="course" name="course"
                   value="<?= htmlspecialchars($_POST['course'] ?? '') ?>" required>
        </div>

        <button type="submit" name="submit" value="1" class="btn btn-success">Register Student</button>
    </form>

    <p><a class="back-link" href="index.php">&larr; Back to Students</a></p>
</div>
</body>
</html>
