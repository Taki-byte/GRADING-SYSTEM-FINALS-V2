<?php
include "../db.php";

$records_per_page = 20;
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$offset = ($page - 1) * $records_per_page;

$search = '';
$result = null;

if (isset($_GET['id']) && $_GET['id'] !== '') {
    $search = $_GET['id'];
    $stmt = $conn->prepare("SELECT student_id, student_name, task_name, score, week, term, date FROM grades WHERE student_id = ? OR student_name LIKE ? ORDER BY date ASC LIMIT ?, ?");
    $like = "%" . $search . "%";
    $stmt->bind_param("ssii", $search, $like, $offset, $records_per_page);
    $stmt->execute();
    $result = $stmt->get_result();
} else {
    $stmt = $conn->prepare("SELECT student_id, student_name, task_name, score, week, term, date FROM grades ORDER BY date ASC LIMIT ?, ?");
    $stmt->bind_param("ii", $offset, $records_per_page);
    $stmt->execute();
    $result = $stmt->get_result();
}

$total_stmt = $conn->prepare("SELECT COUNT(*) FROM grades");
$total_stmt->execute();
$total_result = $total_stmt->get_result();
$total_rows = $total_result->fetch_row()[0];
$total_pages = ceil($total_rows / $records_per_page);

$avg_activity = 0;
$avg_test = 0;
$final_grade = 0;

if ($search !== '') {
    $total_activity = 0;
    $count_activity = 0;
    $total_test = 0;
    $count_test = 0;

    $stmt_total = $conn->prepare("SELECT task_name, score FROM grades WHERE student_id = ? OR student_name LIKE ?");
    $stmt_total->bind_param("ss", $search, $like);
    $stmt_total->execute();
    $grades_result = $stmt_total->get_result();

    while ($grade = $grades_result->fetch_assoc()) {
        $task = strtolower(trim($grade['task_name']));
        $score = (float)$grade['score'];

        if (strpos($task, 'activity') !== false) {
            $total_activity += $score;
            $count_activity++;
        } elseif (strpos($task, 'test') !== false) {
            $total_test += $score;
            $count_test++;
        }
    }

    $avg_activity = $count_activity ? $total_activity / $count_activity : 0;
    $avg_test = $count_test ? $total_test / $count_test : 0;
    $final_grade = round(($avg_activity * 0.3) + ($avg_test * 0.3), 2);
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Student Grading System</title>
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

        table {
            border-collapse: collapse;
            width: 90%;
            margin: 20px auto;
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
            margin-top: 20px;
        }

        .divider a {
            padding: 10px 20px;
            text-decoration: none;
            border: 1px solid #333;
            margin: 0 5px;
        }

        .divider a:hover {
            background-color: #575757;
            color: white;
        }

        .summary-box {
            width: 90%;
            margin: 30px auto;
            padding: 20px;
            border: 1px solid #007bff;
            border-radius: 10px;
            background-color: #f0f8ff;
        }

        .summary-box h3 {
            margin-bottom: 10px;
        }
    </style>
</head>
<body>
    <h1 class="title">Student Grading System</h1>
    <div class="sidebar">
        <a href="/grading-system/teacher/dashboard.php">Dashboard</a>
        <a href="/grading-system/teacher/input.php">Input Grade</a>
        <a href="/grading-system/teacher/view.php">View Grade</a>
        <a href="/grading-system/teacher/section.php">Section</a>
        <a href="/grading-system/teacher/announcement.php">Announcement</a>
        <br><br><br><br><br><br><br><br><br><br><br><br>
    <br><br><br><br><br><br><br><br><br><br><br><br>
    <a href="/grading-system/login.php?logout=1">Logout</a>
    </div>

    <div class="main-content">
        <form method="GET" action="view.php">
            <input type="text" name="id" placeholder="Enter your Student ID or Name" required>
            <button type="submit">View Grades</button>
        </form>

        <h2>Grades</h2>
        <table>
            <tr>
                <th>Student ID</th>
                <th>Name</th>
                <th>Task</th>
                <th>Score</th>
                <th>Week</th>
                <th>Term</th>
                <th>Date</th>
            </tr>
            <?php while ($row = $result->fetch_assoc()) { ?>
                <tr>
                    <td><?= htmlspecialchars($row["student_id"]) ?></td>
                    <td><?= htmlspecialchars($row["student_name"]) ?></td>
                    <td><?= htmlspecialchars($row["task_name"]) ?></td>
                    <td><?= htmlspecialchars($row["score"]) ?></td>
                    <td><?= htmlspecialchars($row["week"]) ?></td>
                    <td><?= htmlspecialchars($row["term"]) ?></td>
                    <td><?= htmlspecialchars($row["date"]) ?></td>
                </tr>
            <?php } ?>
        </table>

        <?php if ($search !== ''): ?>
            <div class="summary-box">
                <h3>Grade Summary</h3>
                <p><strong>Activity Average:</strong> <?= number_format($avg_activity, 2) ?></p>
                <p><strong>Test Average:</strong> <?= number_format($avg_test, 2) ?></p>
                <p><strong>Total Grade (30% Activity + 30% Test):</strong> <?= number_format($final_grade, 2) ?></p>
            </div>
        <?php endif; ?>

        <div class="divider">
            <?php if ($page > 1) { ?>
                <a href="?id=<?= htmlspecialchars($search) ?>&page=<?= $page - 1 ?>">Previous</a>
            <?php } ?>
            <?php if ($page < $total_pages) { ?>
                <a href="?id=<?= htmlspecialchars($search) ?>&page=<?= $page + 1 ?>">Next</a>
            <?php } ?>
        </div>
    </div>
</body>
</html>
