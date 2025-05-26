<?php
include "../db.php";

$grade = null;

if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['id'], $_GET['task'], $_GET['week'], $_GET['term'])) {
    $orig_id = trim($_GET['id']);
    $orig_task = trim($_GET['task']);
    $orig_week = trim($_GET['week']);
    $orig_term = trim($_GET['term']);

    $stmt = $conn->prepare(
        "SELECT * FROM grades 
        WHERE student_id=? AND task_name=? AND week=? AND term=?"
    );
    $stmt->bind_param("ssss", $orig_id, $orig_task, $orig_week, $orig_term);
    $stmt->execute();
    $grade = $stmt->get_result()->fetch_assoc();

} elseif ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['orig_id'], $_POST['orig_task'], $_POST['orig_week'], $_POST['orig_term'])) {

    $orig_id = $_POST['orig_id'];
    $orig_task = $_POST['orig_task'];
    $orig_week = $_POST['orig_week'];
    $orig_term = $_POST['orig_term'];

    $new_id = $_POST['student_id'];
    $new_name = $_POST['student_name'];
    $new_task = $_POST['task_name'];
    $new_score = $_POST['score'];
    $new_week = $_POST['week'];
    $new_term = $_POST['term'];

    $update = $conn->prepare(
        "UPDATE grades
        SET student_id = ?, student_name = ?, task_name = ?, score = ?, week = ?, term = ?
        WHERE student_id = ? AND task_name = ? AND week = ? AND term = ?"
    );
    $update->bind_param(
        "sssissssss",
        $new_id, $new_name, $new_task, $new_score, $new_week, $new_term,
        $orig_id, $orig_task, $orig_week, $orig_term
    );
    $update->execute();

    $redirect_url = "edit_grade.php?id=" . urlencode($new_id)
        . "&task=" . urlencode($new_task)
        . "&week=" . urlencode($new_week)
        . "&term=" . urlencode($new_term);

    error_log("Redirecting to: " . $redirect_url);

    header("Location: " . $redirect_url);
    exit;
} else {
    die("Missing parameters.");
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Edit Grade</title>
    <style>
        .title {
            background-color: #007bff;
            width: 100%;
            font-size: 40px;
            height: 100px;
            position: fixed;
            margin-top: -100px;
            align-items: center;
            display: flex;
            padding-left: 20px;
        }

        .sidebar {
            width: 200px;
            background-color: #333;
            height: 100vh;
            position: fixed;
            padding-top: 20px;
            color: white;
        }

        .sidebar h2 {
            text-align: center;
            color: #fff;
            margin-bottom: 20px;
        }

        .sidebar a {
            display: block;
            color: white;
            padding: 22px 25px;
            text-decoration: none;
            transition: background 0.3s;
        }

        .sidebar a:hover {
            background-color: #575757;
        }

        .main-content {
            margin-top: 100px;
            margin-left: 250px;
            padding: 20px;
        }

        .box {
            width: 80%;
            border-radius: 15px;
            overflow: hidden;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
            font-family: Arial, sans-serif;
            margin: 50px auto;
        }

       .box-header {
            background-color: #007bff;
            color: white;
            padding: 15px;
            font-size: 18px;
            font-weight: bold;
        }

        .box-content {
            background-color: white;
            padding: 20px;
            margin: 10px auto;
        }   

        </style>
</head>
<body>
<h1 class="title">Student Grading System</h1>
<div class="sidebar">
        <a href="/grading-system/admin/admin.php">Users</a>
        <a href="/grading-system/admin/announcement.php">Announcement</a>
        <a href="/grading-system/admin/view.php">View Grade</a>
    </div>
    <div class="main-content">
    <h2>Edit Grade</h2>
    <?php if ($grade): ?>
            <input type="hidden" name="orig_id" value="<?= htmlspecialchars($orig_id) ?>">
            <input type="hidden" name="orig_task" value="<?= htmlspecialchars($orig_task) ?>">
            <input type="hidden" name="orig_week" value="<?= htmlspecialchars($orig_week) ?>">
            <input type="hidden" name="orig_term" value="<?= htmlspecialchars($orig_term) ?>">
            <div class="box">
            <div class="box-header">
            </div>
            <div class="box-content">
            <label>Student ID:<br>
                <input type="text" name="student_id" value="<?= htmlspecialchars($grade['student_id']) ?>" required>
            </label><br><br>

            <label>Student Name:<br>
                <input type="text" name="student_name" value="<?= htmlspecialchars($grade['student_name']) ?>" required>
            </label><br><br>

            <label>Task Name:<br>
                <input type="text" name="task_name" value="<?= htmlspecialchars($grade['task_name']) ?>" required>
            </label><br><br>

            <label>Score:<br>
                <input type="number" name="score" value="<?= htmlspecialchars($grade['score']) ?>" required>
            </label><br><br>

            <label>Week:<br>
                <input type="text" name="week" value="<?= htmlspecialchars($grade['week']) ?>" required>
            </label><br><br>

            <label>Term:<br>
                <input type="text" name="term" value="<?= htmlspecialchars($grade['term']) ?>" required>
            </label><br><br>

            <button type="submit">Update</button>
            <br>
            <br>
            <a href="/grading-system/admin/view.php">back</a>
        </form>
    </div>
    <?php else: ?>
        <p style="color:red;">Grade record not found. Please go back and try again.</p>
    <?php endif; ?>
</body>
</html>
