<?php
include "../db.php";

$id = isset($_GET['id']) ? trim($_GET['id']) : '';

$records_per_page = 20;
$page = isset($_GET['page']) ? max(1, (int)$_GET['page']) : 1;
$offset = ($page - 1) * $records_per_page;

$search = '';
$result = null;

if (isset($_GET['id']) && $_GET['id'] !== '') {
    $search = $_GET['id'];
    $stmt = $conn->prepare("
        SELECT student_id, student_name, task_name, score, week, term, date, subject
          FROM grades
         WHERE student_id = ? OR student_name LIKE ?
         ORDER BY date DESC
         LIMIT ?, ?");
    $like = "%" . $search . "%";
    $stmt->bind_param("ssii", $search, $like, $offset, $records_per_page);
    $stmt->execute();
    $result = $stmt->get_result();
} else {
    $stmt = $conn->prepare("
        SELECT student_id, student_name, task_name, score, week, term, date, subject
          FROM grades
         ORDER BY date DESC
         LIMIT ?, ?");
    $stmt->bind_param("ii", $offset, $records_per_page);
    $stmt->execute();
    $result = $stmt->get_result();
}

// Get total count for pagination (preserve search)
if ($search !== '') {
    $count_stmt = $conn->prepare("SELECT COUNT(*) FROM grades WHERE student_id = ? OR student_name LIKE ?");
    $count_like = "%" . $search . "%";
    $count_stmt->bind_param("ss", $search, $count_like);
    $count_stmt->execute();
    $total_rows = $count_stmt->get_result()->fetch_row()[0];
    $count_stmt->close();
} else {
    $total_stmt = $conn->prepare("SELECT COUNT(*) FROM grades");
    $total_stmt->execute();
    $total_rows = $total_stmt->get_result()->fetch_row()[0];
    $total_stmt->close();
}
$total_pages = max(1, ceil($total_rows / $records_per_page));
?>
<!DOCTYPE html>
<html>
<head>
    <title>Student Grading System - Editable Student List</title>
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
        .update-btn {
            background-color: #28a745;
            color: white;
            border: none;
            padding: 6px 16px;
            border-radius: 5px;
            cursor: pointer;
            font-size: 14px;
        }
        .update-btn:disabled { background: #aaa; cursor: not-allowed; }
        .pagination-btn {
            display: inline-block;
            margin: 0 2px;
            padding: 8px 16px;
            background: #007bff;
            color: #fff;
            border-radius: 4px;
            text-decoration: none;
            border: none;
            font-size: 15px;
            transition: background 0.2s;
        }
        .pagination-btn:disabled, .pagination-btn.disabled {
            background: #aaa;
            cursor: not-allowed;
            pointer-events: none;
            color: #eee;
        }
        .pagination-info {
            margin: 0 10px;
            font-size: 15px;
        }
    </style>
</head>
<body>
    <h1 class="title"><img src="BCP.png" style="width:100px; height:auto;"> Student Grading System</h1>
    <div class="sidebar">
        <a href="/grading-system/admin/admin.php">Users</a>
        <a href="/grading-system/admin/announcement.php">Announcement</a>
        <a href="/grading-system/admin/view.php">Manage Grade</a>
        <br><br><br><br><br><br><br><br><br><br><br><br>
        <br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br>
        <a href="/grading-system/login.php?logout=1">Logout</a>
    </div>

    <div class="main-content">
        <form method="GET" action="view.php">
            <input type="text" name="id" placeholder="Enter your Student ID or Name" value="<?= htmlspecialchars($search) ?>" required>
            <button type="submit">View Grades</button>
        </form>

        <h2>Grades</h2>
        <?php if ($result && $result->num_rows): ?>
        <table>
            <tr>
                <th>Student ID</th><th>Name</th><th>Task</th><th>Subject</th><th>Score</th>
                <th>Week</th><th>Term</th><th>Date</th><th>Action</th>
            </tr>
            <?php while ($row = $result->fetch_assoc()): ?>
            <tr>
                <td><?= htmlspecialchars($row["student_id"]) ?></td>
                <td><?= htmlspecialchars($row["student_name"]) ?></td>  
                <td><?= htmlspecialchars($row["task_name"]) ?></td>
                <td><?= htmlspecialchars($row["subject"]) ?></td>
                <td><?= htmlspecialchars($row["score"]) ?></td>
                <td><?= htmlspecialchars($row["week"]) ?></td>
                <td><?= htmlspecialchars($row["term"]) ?></td>
                <td><?= htmlspecialchars($row["date"]) ?></td>
                <td>
                  <a href="edit_grade.php
                    ?id=<?= urlencode($row['student_id']) ?>
                    &task=<?= urlencode($row['task_name']) ?>
                    &week=<?= urlencode(trim($row['week'])) ?>
                    &term=<?= urlencode(trim($row['term'])) ?>
                    &subject=<?= urlencode(trim($row['subject'])) ?>">Edit</a>
                </td>
            </tr>
            <?php endwhile; ?>
        </table>
        <?php else: ?>
          <p style="text-align:center;">No grades found.</p>
        <?php endif; ?>

        <div class="divider" style="text-align:center;margin-top:20px;">
            <?php
                $search_param = $search !== '' ? '&id=' . urlencode($search) : '';
            ?>
            <a class="pagination-btn<?= $page <= 1 ? ' disabled' : '' ?>" 
               href="<?= $page <= 1 ? '#' : '?id=' . urlencode($search) . '&page=' . ($page - 1) ?>"
               <?= $page <= 1 ? 'tabindex="-1" aria-disabled="true"' : '' ?>>Previous</a>

            <span class="pagination-info">Page <?= $page ?> of <?= $total_pages ?></span>

            <a class="pagination-btn<?= $page >= $total_pages ? ' disabled' : '' ?>"
               href="<?= $page >= $total_pages ? '#' : '?id=' . urlencode($search) . '&page=' . ($page + 1) ?>"
               <?= $page >= $total_pages ? 'tabindex="-1" aria-disabled="true"' : '' ?>>Next</a>
        </div>
    </div>
</body>
</html>