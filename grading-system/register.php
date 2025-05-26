<?php
session_start();
$conn = new mysqli("localhost", "root", "", "users");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $role        = $_POST["role"];
    $user_id     = $_POST["user_id"];
    $surname     = $_POST["surname"];
    $first_name  = $_POST["first_name"];
    $middle_name = $_POST["middle_name"];
    $password    = $_POST["password"];
    $confirm     = $_POST["confirm"];
    $section     = $_POST["section"] ?? ''; // Get the section for student role

    if ($password !== $confirm) {
        echo "Passwords do not match.";
    } else {
        $hashed = password_hash($password, PASSWORD_DEFAULT);

        if ($role == 'student' && empty($section)) {
            echo "Section is required for students.";
        } else {
            if ($role == 'student') {
                $stmt = $conn->prepare("INSERT INTO users (user_id, surname, first_name, middle_name, password, role, section) VALUES (?, ?, ?, ?, ?, ?, ?)");
                $stmt->bind_param("sssssss", $user_id, $surname, $first_name, $middle_name, $hashed, $role, $section);
            } else {
                $stmt = $conn->prepare("INSERT INTO users (user_id, surname, first_name, middle_name, password, role) VALUES (?, ?, ?, ?, ?, ?)");
                $stmt->bind_param("ssssss", $user_id, $surname, $first_name, $middle_name, $hashed, $role);
            }

            if ($stmt->execute()) {
                echo "Registration successful. <a href='login.php'>Login</a>";
            } else {
                echo "Error: " . $stmt->error;
            }
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="login.css">
</head>
<body>

    <div class="container">
<h2>Register</h2>
<form method="POST">
    <select name="role" id="role" onchange="toggleLabels()" required>
        <option value="">Select</option>
        <option value="student">Student</option>
        <option value="teacher">Teacher</option>
    </select><br><br>
    <p>ID:</p>
    <label id="id-label"></label>
    <input type="text" name="user_id" required><br>
    <p>Surname:</p>
    <input type="text" name="surname" required><br>
    <p>First name:</p>
    <input type="text" name="first_name" required><br>
    <p>Middle name:</p>
    <input type="text" name="middle_name"><br>
    <p>Password:</p>
    <input type="password" name="password" required><br>
    <p>Confirm Password:</p>
    <input type="password" name="confirm" required><br>

    <div id="section-field" style="display:none;">
    <p>Section:</p>
    <input type="text" name="section"><br><br>
    </div>

    <input type="submit" value="Register">
</form>
<p>already have an account? <a href="login.php">Login here!</a> </p>

<script>
function toggleLabels() {
    const role = document.getElementById("role").value;
    const idLabel = document.getElementById("id-label");
    const sectionField = document.getElementById("section-field");

    idLabel.textContent = role === "student" ? "Student ID:" : "Teacher ID:";
    sectionField.style.display = role === "student" ? "block" : "none";
}
</script>
