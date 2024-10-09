<?php
include 'db_connection.php';

$message = "";
$toastClass = "";


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get check-in and check-out dates from POST request
    $user_name = $_POST['user_name'];
    $user_birthday = $_POST['user_birthday'];
    $user_age = $_POST['user_age'];
    $user_gender = $_POST['user_gender'];
    $user_email = $_POST['user_email'];
    $user_phone = $_POST['user_phone'];
    $user_ethnicity = $_POST['user_ethnicity'];
    $user_occupation = $_POST['user_occupation'];
    $user_address = $_POST['user_address'];
    $user_password = $_POST['user_password'];
    $family_id = $_POST['family_id'];
    $family_position = $_POST['family_position'];


    // Check if email already exists
    $checkEmailStmt = $conn->prepare("SELECT user_email FROM user WHERE user_email = ?");
    $checkEmailStmt->bind_param("s", $user_email);
    $checkEmailStmt->execute();
    $checkEmailStmt->store_result();

    if ($checkEmailStmt->num_rows > 0) {
        $message = "Email ID already exists";
        $toastClass = "#007bff"; // Primary color
    } else {
        // Prepare and bind
        $stmt = $conn->prepare("INSERT INTO user (user_name, user_birthday, user_age, user_gender, user_email, user_phone, user_ethnicity, user_occupation, user_address, user_password, family_id, family_position) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("ssssssssssss", $user_name, $user_birthday, $user_age, $user_gender, $user_email, $user_phone, $user_ethnicity, $user_occupation, $user_address, $user_password, $family_id, $family_position);

        if ($stmt->execute()) {
            $message = "Account created successfully";
            $toastClass = "#28a745"; // Success color
        } else {
            $message = "Error: " . $stmt->error;
            $toastClass = "#dc3545"; // Danger color
        }

        $stmt->close();
    }
    // Redirect to another page or show success message
    header("Location: index.php");
    $checkEmailStmt->close();
    $conn->close();
}
    // exit();
?>