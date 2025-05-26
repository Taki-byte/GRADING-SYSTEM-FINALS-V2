<?php
$servername = "localhost";
$username = "root";
$password = "";
$database = "users";

$conn = new mysqli($servername, $username, $password, $database);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$sql = "SELECT id, user_id, surname, first_name, middle_name, role, subject FROM users WHERE TRIM(LOWER(role)) = 'teacher'";
$result = $conn->query($sql);
?>
<!DOCTYPE html>
<html>
<head>
    <title>Student Grading System - Editable Teacher List</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 0; }
        .title {
            background-color: #007bff; width: 100%; font-size: 40px; height: 100px;
            position: fixed; margin-top: -100px; align-items: center; display: flex;
            padding-left: 20px; color: white;
        }
        .sidebar { width: 200px; background-color: #333; height: 100vh; position: fixed; padding-top: 20px; }
        .sidebar a { display: block; color: white; padding: 22px 25px; text-decoration: none; transition: background 0.3s; }
        .sidebar a:hover { background-color: #575757; }
        .main-content { margin-top: 100px; margin-left: 250px; padding: 20px; }
        .box { background-color: #f9f9f9; padding: 0; margin-bottom: 30px; border-radius: 8px; border: 1px solid #ccc; width: 95%; overflow: hidden;}
        .box-header{ background-color: #007bff; width: 100%; color: white; padding: 15px 20px; font-size: 20px; font-weight: bold; border-top-left-radius: 8px; border-top-right-radius: 8px; }
        .box-content { background-color: #f9f9f9; color: #333; padding: 10px 15px; font-size: 16px; border-bottom-left-radius: 8px; border-bottom-right-radius: 8px; }
        table { border-collapse: collapse; width: 95%; margin: auto; }
        th, td { border: 1px solid #333; padding: 10px; text-align: left; }
        th { background-color: #007bff; color: white; }
        .update-btn {
            background-color: #28a745; color: white; border: none; padding: 8px 20px;
            border-radius: 5px; cursor: pointer; font-size: 16px; margin-top: 10px;
        }
    </style>
    <script>
    function updateAllUsers() {
        const rows = document.querySelectorAll('tr[id^="row-"]');
        const data = [];

        rows.forEach(row => {
            const id = row.id.replace('row-', '');
            const user_id = row.querySelector('input[name="user_id"]').value;
            const surname = row.querySelector('input[name="surname"]').value;
            const first_name = row.querySelector('input[name="first_name"]').value;
            const middle_name = row.querySelector('input[name="middle_name"]').value;
            const role = row.querySelector('input[name="role"]').value;
            const subject = row.querySelector('input[name="subject"]').value;

            data.push({ id, user_id, surname, first_name, middle_name, role, subject });
        });

        const xhr = new XMLHttpRequest();
        xhr.open('POST', 'update_user.php', true); // <-- changed to correct filename
        xhr.setRequestHeader('Content-Type', 'application/json');
        xhr.onload = function () {
            if (xhr.status == 200) {
                alert(xhr.responseText);
            } else {
                alert("Update failed! " + xhr.responseText); // Show backend error for debugging
            }
        };
        xhr.send(JSON.stringify(data));
    }
    </script>
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
        <div class="box" style="width: 100%; margin: 0 auto;">
            <h2> List of Teachers</h2>
            <div class="box-content">
            <?php if ($result && $result->num_rows > 0): ?>
                <table>
                    <tr>
                        <th>Teacher's ID</th>
                        <th>Surname</th>
                        <th>First Name</th>
                        <th>Middle Name</th>
                        <th>Role</th>
                        <th>Subject</th>
                    </tr>
                    <?php while ($row = $result->fetch_assoc()): ?>
                    <tr id="row-<?= htmlspecialchars($row['id']) ?>">
                        <td><input type="text" name="user_id" value="<?= htmlspecialchars($row['user_id']) ?>"></td>
                        <td><input type="text" name="surname" value="<?= htmlspecialchars($row['surname']) ?>"></td>
                        <td><input type="text" name="first_name" value="<?= htmlspecialchars($row['first_name']) ?>"></td>
                        <td><input type="text" name="middle_name" value="<?= htmlspecialchars($row['middle_name']) ?>"></td>
                        <td><input type="text" name="role" value="<?= htmlspecialchars($row['role']) ?>" style="width:70px;"></td>
                        <td><input type="text" name="subject" value="<?= htmlspecialchars($row['subject']) ?>"></td>
                    </tr>
                    <?php endwhile; ?>
                </table>
                <button class="update-btn" onclick="updateAllUsers()">Save</button>
            <?php else: ?>
                <p>No teachers found.</p>
            <?php endif; ?>
            </div>
        </div>
    </div>
</body>
</html>