<?php
session_start();
include "../db.php";

$teacher_id = $_SESSION['user_id'] ?? '';
$teacher_subject = $_SESSION['subject'] ?? '';

$records_per_page = 20;
$page = isset($_GET['page']) ? max(1, (int)$_GET['page']) : 1;
$offset = ($page - 1) * $records_per_page;

$search = '';
$success_message = "";
$result = false;

// ----- New: Get selected term (for summary box), default to 'prelim'
$selected_term = isset($_GET['grade_term']) ? strtolower(trim($_GET['grade_term'])) : 'prelim';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['ajax_update'])) {
    $student_id = $_POST['student_id'];
    $student_name = $_POST['student_name'];
    $task_name = $_POST['task_name'];
    $score = $_POST['score'];
    $week = $_POST['week'];
    $term = $_POST['term'];
    $subject = $teacher_subject;
    $orig_id = $_POST['orig_id'];
    $orig_task = $_POST['orig_task'];
    $orig_week = $_POST['orig_week'];
    $orig_term = $_POST['orig_term'];

    $update = $conn->prepare(
        "UPDATE grades
        SET student_id = ?, student_name = ?, task_name = ?, score = ?, week = ?, term = ?, subject=?
        WHERE student_id = ? AND task_name = ? AND week = ? AND term = ?"
    );
    $update->bind_param(
        "sssisssssss",
        $student_id, $student_name, $task_name, $score, $week, $term, $subject,
        $orig_id, $orig_task, $orig_week, $orig_term
    );
    if ($update->execute()) {
        echo "success";
    } else {
        echo "error: " . $update->error;
    }
    exit;
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && !isset($_POST['ajax_update'])) {
    $student_id   = $_POST["student_id"];
    $student_name = $_POST["student_name"];
    $task_name    = $_POST["task_name"];
    $score        = $_POST["score"];
    $week         = $_POST["week"];
    $term         = $_POST["term"];
    $subject      = $teacher_subject;
    $date         = date("Y-m-d");

    $sql = "INSERT INTO grades (student_id, student_name, task_name, score, week, term, subject, date)
            VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssssssss", $student_id, $student_name, $task_name, $score, $week, $term, $subject, $date);

    if ($stmt->execute()) {
        $success_message = "Grade submitted successfully!";
    } else {
        $success_message = "Error submitting grade: " . $stmt->error;
    }
    $stmt->close();
}

if (isset($_GET['success'])) {
    $success_message = $_GET['success'];
}

if (isset($_GET['id']) && $_GET['id'] !== '') {
    $search = $_GET['id'];
}

if ($search !== '') {
    $like = "%" . $search . "%";
    $stmt = $conn->prepare("SELECT subject, student_id, student_name, task_name, score, week, term, date 
                            FROM grades 
                            WHERE student_id = ? OR student_name LIKE ? 
                            ORDER BY date DESC 
                            LIMIT ?, ?");
    $stmt->bind_param("ssii", $search, $like, $offset, $records_per_page);
    $stmt->execute();
    $result = $stmt->get_result();

    $total_stmt = $conn->prepare("SELECT COUNT(*) FROM grades WHERE student_id = ? OR student_name LIKE ?");
    $total_stmt->bind_param("ss", $search, $like);
    $total_stmt->execute();
    $total_rows = $total_stmt->get_result()->fetch_row()[0];
    $total_pages = max(1, ceil($total_rows / $records_per_page));
    $total_stmt->close();

    // ----------- New: Prelim summary calculation for summary box -------------
    $prelim_test = 0;
    $prelim_activity_sum = 0;
    $prelim_activity_count = 0;

    $stmt_total = $conn->prepare("SELECT task_name, score, term FROM grades WHERE student_id = ? OR student_name LIKE ?");
    $stmt_total->bind_param("ss", $search, $like);
    $stmt_total->execute();
    $grades_result = $stmt_total->get_result();

    while ($grade = $grades_result->fetch_assoc()) {
        $task = strtolower($grade['task_name']);
        $term = strtolower($grade['term']);
        $score = (float)$grade['score'];

        if ($term === 'prelim') {
            if (strpos($task, 'test') !== false) {
                $prelim_test = $score; // If multiple, you may wish to average or take latest
            }
            if (strpos($task, 'activity') !== false) {
                $prelim_activity_sum += $score;
                $prelim_activity_count++;
            }
        }
    }
    $stmt_total->close();

    $prelim_activity_avg = $prelim_activity_count ? $prelim_activity_sum / $prelim_activity_count : 0;

    // ----------- New: Dynamic label/weight for summary box -------------
    if ($selected_term === 'prelim') {
        $test_label = "(30%) Prelim Test";
        $activity_label = "(30%) Activity";
    } elseif ($selected_term === 'midterm') {
        $test_label = "(30%) Prelim Test";
        $activity_label = "(30%) Activity";
    } elseif ($selected_term === 'finals') {
        $test_label = "(40%) Prelim Test";
        $activity_label = "(30%) Activity";
    } else {
        $test_label = "(30%) Prelim Test";
        $activity_label = "(30%) Activity";
    }
} else {
    $stmt = $conn->prepare("SELECT subject, student_id, student_name, task_name, score, week, term, date 
                            FROM grades 
                            ORDER BY date DESC 
                            LIMIT ?, ?");
    $stmt->bind_param("ii", $offset, $records_per_page);
    $stmt->execute();
    $result = $stmt->get_result();

    $total_stmt = $conn->prepare("SELECT COUNT(*) FROM grades");
    $total_stmt->execute();
    $total_rows = $total_stmt->get_result()->fetch_row()[0];
    $total_pages = max(1, ceil($total_rows / $records_per_page));
    $total_stmt->close();
    $stmt->close();

    // No summary if not searching.
    $prelim_test = 0;
    $prelim_activity_avg = 0;
    $test_label = $activity_label = '';
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
            padding: 20px;
            margin-bottom: 30px;
            border-radius: 8px;
            border: 1px solid #ccc;
            width: 95%;
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
        .save-btn {
            background: #28a745;
            color: #fff;
            border: none;
            border-radius: 4px;
            padding: 4px 10px;
            text-decoration: none;
            margin-right: 5px;
            cursor: pointer;
        }
        .edit-cell input,
        .edit-cell select {
            width: 90px;
            padding: 2px 5px;
        }
        .edit-cell select {
            width: 100px;
        }
        .success-msg { color: #28a745; font-weight: bold; }
        .error-msg { color: #dc3545; font-weight: bold; }
    </style>
    <script>
    function saveRow(rowId) {
        var row = document.getElementById("grade-row-"+rowId);
        if (!row) return;
        var tds = row.querySelectorAll('.edit-cell');
        var data = {};

        data['subject'] = <?= json_encode($teacher_subject) ?>;
        data['student_id'] = tds[1].querySelector('input').value;
        data['student_name'] = tds[2].querySelector('input').value;
        data['task_name'] = tds[3].querySelector('input').value;
        data['score'] = tds[4].querySelector('input').value;
        data['week'] = tds[5].querySelector('input').value;
        data['term'] = tds[6].querySelector('select').value;

        data['orig_id'] = row.getAttribute('data-orig-id');
        data['orig_task'] = row.getAttribute('data-orig-task');
        data['orig_week'] = row.getAttribute('data-orig-week');
        data['orig_term'] = row.getAttribute('data-orig-term');
        data['ajax_update'] = 1;

        var xhr = new XMLHttpRequest();
        xhr.open('POST', '', true);
        xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
        xhr.onload = function() {
            if (xhr.responseText.trim() === "success") {
                alert('Grade updated successfully!');
                row.setAttribute('data-orig-id', data['student_id']);
                row.setAttribute('data-orig-task', data['task_name']);
                row.setAttribute('data-orig-week', data['week']);
                row.setAttribute('data-orig-term', data['term']);
            } else {
                alert('Failed to update grade: ' + xhr.responseText);
            }
        };
        var params = [];
        for (var key in data) {
            params.push(encodeURIComponent(key) + '=' + encodeURIComponent(data[key]));
        }
        xhr.send(params.join('&'));
    }
    </script>
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
            <form method="GET" action="">
                <input type="text" name="id" placeholder="Search by ID or Name" value="<?= htmlspecialchars($search) ?>">
                <!-- New: grade term filter dropdown -->
                <select name="grade_term">
                    <option value="prelim" <?= $selected_term=='prelim'?'selected':''; ?>>Prelim</option>
                    <option value="midterm" <?= $selected_term=='midterm'?'selected':''; ?>>Midterm</option>
                    <option value="finals" <?= $selected_term=='finals'?'selected':''; ?>>Finals</option>
                </select>
                <button type="submit">Search</button>
            </form>
            <h2>Grades</h2>
            <form method="POST">
                <table>
                    <tr>
                        <th><label for="student_id">Student ID:</label><br>
                            <input id="student_id" name="student_id" required></th>
                        <th><label for="student_name">Name:</label><br>
                            <input id="student_name" name="student_name" required></th>
                        <th><label for="task_name">Task name:</label><br>
                            <input id="task_name" name="task_name" required></th>
                        <th><label for="score">Score:</label><br>
                            <input type="number" id="score" name="score" required></th>
                        <th><label for="week">Week:</label><br>
                            <select id="week" name="week">
                                <?php for ($i = 1; $i <= 19; $i++) echo "<option value='Week $i'>Week $i</option>"; ?>
                            </select></th>
                        <th><label for="term">Term:</label><br>
                            <select id="term" name="term">
                                <option>Prelim</option>
                                <option>Midterm</option>
                                <option>Finals</option>
                            </select></th>
                        <th>
                            <button type="submit" name="add_grade">Submit</button>
                        </th>
                    </tr>
            </form>
            <?php if (!empty($success_message)) : ?>
                <p class="success-msg"><?= htmlspecialchars($success_message) ?></p>
            <?php endif; ?>
        </div>
        <table>
            <tr>
                <th>Student ID</th>
                <th>Name</th>
                <th>Task</th>
                <th>Score</th>
                <th>Week</th>
                <th>Term</th>
                <th>Date</th>
                <th>Action</th>
            </tr>
            <?php if ($result && $result->num_rows > 0): ?>
                <?php $rownum=0; while ($row = $result->fetch_assoc()) : $rownum++; ?>
                    <tr id="grade-row-<?= $rownum ?>"
                        data-orig-id="<?= htmlspecialchars($row["student_id"]) ?>"
                        data-orig-task="<?= htmlspecialchars($row["task_name"]) ?>"
                        data-orig-week="<?= htmlspecialchars($row["week"]) ?>"
                        data-orig-term="<?= htmlspecialchars($row["term"]) ?>">
                        <td class="edit-cell">
                            <input type="text" value="<?= htmlspecialchars($row["student_id"]) ?>">
                        </td>
                        <td class="edit-cell">
                            <input type="text" value="<?= htmlspecialchars($row["student_name"]) ?>">
                        </td>
                        <td class="edit-cell">
                            <input type="text" value="<?= htmlspecialchars($row["task_name"]) ?>">
                        </td>
                        <td class="edit-cell">
                            <input type="number" value="<?= htmlspecialchars($row["score"]) ?>">
                        </td>
                        <td class="edit-cell">
                            <input type="text" value="<?= htmlspecialchars($row["week"]) ?>">
                        </td>
                        <td class="edit-cell">
                            <select>
                                <option <?= $row['term']=='Prelim'?'selected':'' ?>>Prelim</option>
                                <option <?= $row['term']=='Midterm'?'selected':'' ?>>Midterm</option>
                                <option <?= $row['term']=='Finals'?'selected':'' ?>>Finals</option>
                            </select>
                        </td>
                        <td><?= htmlspecialchars($row["date"]) ?></td>
                        <td>
                            <button type="button" class="save-btn" onclick="saveRow('<?= $rownum ?>')">Save</button>
                        </td>
                    </tr>
                <?php endwhile; ?>
            <?php else: ?>
                <tr><td colspan="9" style="text-align:center;">No records found.</td></tr>
            <?php endif; ?>
        </table>
        <br><br>
        <?php if ($search !== ''): ?>
            <div class="summary-box">
                <h3>Grade Summary (<?= htmlspecialchars(ucfirst($selected_term)) ?>)</h3>
                <p><strong><?= $test_label ?>:</strong> <?= number_format($prelim_test, 2) ?></p>
                <p><strong><?= $activity_label ?>:</strong> <?= number_format($prelim_activity_avg, 2) ?></p>
            </div>
        <?php endif; ?>
        <div class="divider" style="text-align:center;margin-top:20px;">
            <?php
                $search_param = $search !== '' ? '&id=' . urlencode($search) : '';
            ?>
            <a class="pagination-btn<?= $page <= 1 ? ' disabled' : '' ?>" 
               href="<?= $page <= 1 ? '#' : '?id=' . urlencode($search) . '&page=' . ($page - 1) . '&grade_term=' . urlencode($selected_term) ?>"
               <?= $page <= 1 ? 'tabindex="-1" aria-disabled="true"' : '' ?>>Previous</a>

            <span class="pagination-info">Page <?= $page ?> of <?= $total_pages ?></span>

            <a class="pagination-btn<?= $page >= $total_pages ? ' disabled' : '' ?>"
               href="<?= $page >= $total_pages ? '#' : '?id=' . urlencode($search) . '&page=' . ($page + 1) . '&grade_term=' . urlencode($selected_term) ?>"
               <?= $page >= $total_pages ? 'tabindex="-1" aria-disabled="true"' : '' ?>>Next</a>
        </div>
    </div>
</body>
</html>