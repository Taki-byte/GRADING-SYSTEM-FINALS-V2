<?php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'student') {
    header("Location: /grading-system/login.php");
    exit;
}

// --- DB connection (adjust as needed) ---
$servername = "localhost";
$username = "root";      // Change if not root
$password = "";          // Change if you have a password
$dbname = "users";       // Make sure this is your students' DB!

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) { die("Connection failed: " . $conn->connect_error); }

$student_id   = $_SESSION['user_id'] ?? '';
$first_name   = $_SESSION['first_name'] ?? '';
$surname      = $_SESSION['surname'] ?? '';
$middle_name  = $_SESSION['middle_name'] ?? '';
$section      = $_SESSION['section'] ?? '';
$role         = $_SESSION['role'] ?? '';

// Announcements logic
$filename = $_SERVER['DOCUMENT_ROOT'] . "/grading-system/student/announcements.txt";
$announcements = [];
if (file_exists($filename)) {
    $lines = file($filename, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
    foreach (array_reverse($lines) as $line) {
        $data = json_decode($line, true);
        if ($data) $announcements[] = $data;
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Student Grading System</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 0; }
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
            color: white;
        }
        .sidebar {
            width: 200px;
            background-color: #333;
            height: 100vh;
            position: fixed;
            padding-top: 20px;
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
        .box, .summary-box {
            background-color: #f9f9f9;
            padding: 0;
            margin-bottom: 30px;
            border-radius: 8px;
            border: 1px solid #ccc;
            width: 95%;
            overflow: hidden;
        }
        .box-header{
            background-color: #007bff;
            width: 100%;
            color: white;
            padding: 15px 20px;
            font-size: 20px;
            font-weight: bold;
            border-top-left-radius: 8px;
            border-top-right-radius: 8px;
        }
        .box-content {
            background-color: #f9f9f9;
            color: #333;
            padding: 10px 15px;
            font-size: 16px;
            border-bottom-left-radius: 8px;
            border-bottom-right-radius: 8px;
        }
        table {
            border-collapse: collapse;
            width: 95%;
            margin: auto;
        }
        th, td {
            border: 1px solid #333;
            padding: 10px;
            text-align: left;
        }
        th {
            background-color: #007bff;
            color: white;
        }
        .divider {
            text-align: center;
            margin: 20px;
        }
        .divider a {
            padding: 10px 20px;
            text-decoration: none;
            border: 1px solid #333;
            margin: 0 5px;
        }
        .divider a:hover {
            background-color: #007bff;
            color: white;
        }
        .announcement {
            margin: 30px auto 10px auto;
            width: 95%;
            background-color: #f1f1f1;
            border-radius: 10px;
            box-shadow: 0 4px 10px rgba(0,0,0,0.07);
            padding: 20px 30px;
        }
        .announcement h3 {
            color: #007bff;
            margin-top: 0;
        }
        .announcement .date {
            color: #888;
            font-size: 13px;
            margin-bottom: 10px;
        }
        .no-announcement {
            text-align: center;
            color: #888;
            font-size: 18px;
            margin-top: 50px;
        }
    </style>
</head>
<body>
    <h1 class="title"><img src="BCP.png" style="width:100px; height:auto;"> Student Grading System</h1>
    <div class="sidebar">
        <a href="dashboardstudent.php">Dashboard</a>
        <a href="/grading-system/student/view.php">Grades</a>
        <a href="subject.php">Subjects</a>
<br><br><br><br><br><br><br><br><br><br><br><br>
    <br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br>
    <a href="/grading-system/login.php?logout=1">Logout</a>
    </div>

    <div class="main-content">
        <h1>Dashboard</h1>
        <div class="box">
            <div class="box-header">Profile</div>
            <div class="box-content">
                <p><strong>Student ID:</strong> <?= htmlspecialchars($student_id) ?></p><br>
                <p><strong>Name:</strong> <?= htmlspecialchars($first_name . ' ' . $surname) ?></p><br>
                <p><strong>Middle Name:</strong> <?= htmlspecialchars($middle_name) ?></p><br>
                <p><strong>Section:</strong> <?= htmlspecialchars($section) ?></p><br>
                <p><strong>Role:</strong> <?= htmlspecialchars($role) ?></p><br>
            </div>
        </div>

        <div class="box">
            <div class="box-header">Announcements</div>
            <div class="box-content">
                <?php if (count($announcements) === 0): ?>
                    <div class="no-announcement">No announcements posted yet.</div>
                <?php else: ?>
                    <?php foreach ($announcements as $ann): ?>
                        <div class="announcement">
                            <div class="date"><?= htmlspecialchars($ann['date']) ?></div>
                            <h3><?= htmlspecialchars($ann['title']) ?></h3>
                            <p><?= nl2br(htmlspecialchars($ann['message'])) ?></p>
                        </div>
                    <?php endforeach; ?>
                <?php endif; ?>
            </div>
        </div>
    </div>
</body>
</html>