<?php
$servername = "localhost";
$username = "root";
$password = "";
$database = "users";

$conn = new mysqli($servername, $username, $password, $database);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Updated query to robustly exclude user_id '22017'
$sql = "SELECT id, user_id, surname, first_name, middle_name, role, section 
        FROM users 
        WHERE TRIM(LOWER(role)) = 'student' AND TRIM(CAST(user_id AS CHAR)) != '22017'";
$result = $conn->query($sql);
?>
<!DOCTYPE html>
<html>
<head>
    <title>Student Grading System - Student List</title>
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
        .box {
            background-color: #f9f9f9;
            padding: 0;
            margin-bottom: 30px;
            border-radius: 8px;
            border: 1px solid #ccc;
            width: 95%;
            overflow: hidden;
        }
        .box-header {
            background-color: #007bff;
            color: white;
            padding: 15px 20px;
            font-size: 20px;
            font-weight: bold;
            border-top-left-radius: 8px;
            border-top-right-radius: 8px;
        }
        .box-content {
            padding: 10px 15px;
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
    </style>
</head>
<body>
    <h1 class="title"><img src="BCP.png" style="width:100px; height:auto;"> Student Grading System</h1>
    <div class="sidebar">
    <a href="/grading-system/teacher/dashboard.php">Dashboard</a>
    <a href="/grading-system/teacher/input.php">Manage Grades</a>
    <a href="/grading-system/teacher/section.php">Section</a>
    <a href="/grading-system/teacher/announcement.php">Announcement</a>
    <br><br><br><br><br><br><br><br><br><br><br><br>
    <br><br><br><br><br><br><br><br><br><br><br><br>
    <br><br><br>
    <a href="/grading-system/login.php?logout=1">Logout</a>
    </div>
    <div class="main-content">
        <div class="box">
            <div class="box-header">List of Students</div>
            <div class="box-content">
                <?php if ($result && $result->num_rows > 0): ?>
                <table>
                    <tr>
                        <th>Student ID (user_id)</th>
                        <th>Surname</th>
                        <th>First Name</th>
                        <th>Middle Name</th>
                        <th>Role</th>
                        <th>Section</th>
                    </tr>
                    <?php while ($row = $result->fetch_assoc()): ?>
                        <tr>
                            <td><?= htmlspecialchars($row['user_id']) ?></td>
                            <td><?= htmlspecialchars($row['surname']) ?></td>
                            <td><?= htmlspecialchars($row['first_name']) ?></td>
                            <td><?= htmlspecialchars($row['middle_name']) ?></td>
                            <td><?= htmlspecialchars($row['role']) ?></td>
                            <td><?= htmlspecialchars($row['section']) ?></td>
                        </tr>
                    <?php endwhile; ?>
                </table>
                <?php else: ?>
                    <p>No students found.</p>
                <?php endif; ?>
            </div>
        </div>
    </div>
</body>
</html>