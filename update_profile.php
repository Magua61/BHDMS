<?php
$conn = new mysqli("localhost", "root", "", "abhds");
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Assuming you have user authentication and store user_id in the session
session_start();
$user_id = 1; // Retrieve user ID from session

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'];
    $age = $_POST['age'];
    $birthday = $_POST['birthday'];
    $address = $_POST['address'];
    $phone = $_POST['phone'];
    $email = $_POST['email'];
    $occupation = $_POST['occupation'];
    $ethnicity = $_POST['ethnicity'];

    // Update user information
    $sql = "UPDATE user u
            SET u.user_name = ?, u.user_age = ?, u.user_birthday = ?, u.user_address = ?,
                u.user_phone = ?, u.user_email = ?, u.user_occupation = ?, u.user_ethnicity = ?
            WHERE u.user_id = ?";

    if ($stmt = $conn->prepare($sql)) {
        $stmt->bind_param("sissssssi", $name, $age, $birthday, $address, $phone, $email, $occupation, $ethnicity, $user_id);
        if ($stmt->execute()) {
            echo "Profile updated successfully!";
        } else {
            echo "Error updating profile: " . $stmt->error;
        }
        $stmt->close();
    }
    $conn->close();
}
?>