<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

$servername = "localhost";
$username = "root";
$password = "";
$database = "users";

$conn = new mysqli($servername, $username, $password, $database);
if ($conn->connect_error) {
    http_response_code(500);
    die("Connection failed: " . $conn->connect_error);
}

$input = json_decode(file_get_contents("php://input"), true);
if (!$input || !is_array($input)) {
    http_response_code(400);
    echo "Invalid input.";
    exit;
}

$success = true;
$error_message = '';
foreach ($input as $user) {
    $id = isset($user['id']) ? intval($user['id']) : 0;
    $user_id = isset($user['user_id']) ? trim($user['user_id']) : '';
    $surname = isset($user['surname']) ? trim($user['surname']) : '';
    $first_name = isset($user['first_name']) ? trim($user['first_name']) : '';
    $middle_name = isset($user['middle_name']) ? trim($user['middle_name']) : '';
    $role = isset($user['role']) ? trim($user['role']) : '';
    $subject = isset($user['subject']) ? trim($user['subject']) : null;
    $section = isset($user['section']) ? trim($user['section']) : null;

    if ($id <= 0) continue;

    if ($subject !== null) {
        // Teacher update, with subject
        $stmt = $conn->prepare("UPDATE users SET user_id=?, surname=?, first_name=?, middle_name=?, role=?, subject=? WHERE id=?");
        if (!$stmt) {
            $success = false;
            $error_message = $conn->error;
            break;
        }
        $stmt->bind_param("ssssssi", $user_id, $surname, $first_name, $middle_name, $role, $subject, $id);
    } elseif ($section !== null) {
        // Student update, with section
        $stmt = $conn->prepare("UPDATE users SET user_id=?, surname=?, first_name=?, middle_name=?, role=?, section=? WHERE id=?");
        if (!$stmt) {
            $success = false;
            $error_message = $conn->error;
            break;
        }
        $stmt->bind_param("ssssssi", $user_id, $surname, $first_name, $middle_name, $role, $section, $id);
    } else {
        // User update (fallback, no subject or section)
        $stmt = $conn->prepare("UPDATE users SET user_id=?, surname=?, first_name=?, middle_name=?, role=? WHERE id=?");
        if (!$stmt) {
            $success = false;
            $error_message = $conn->error;
            break;
        }
        $stmt->bind_param("sssssi", $user_id, $surname, $first_name, $middle_name, $role, $id);
    }

    if (!$stmt->execute()) {
        $success = false;
        $error_message = $stmt->error;
        $stmt->close();
        break;
    }
    $stmt->close();
}

$conn->close();

if ($success) {
    echo "Users updated successfully!";
} else {
    http_response_code(500);
    echo "Failed to update one or more users. Error: " . $error_message;
}
?>