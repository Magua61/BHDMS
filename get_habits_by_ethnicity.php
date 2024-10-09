<?php
// Connection to the database
$conn = new mysqli("localhost", "root", "", "abhds");

// Check if the connection is successful
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Prepare SQL query to get habits data grouped by ethnicity
$sql = "
    SELECT 
        u.user_ethnicity,
        SUM(CASE WHEN h.smoking = 1 THEN 1 ELSE 0 END) AS smokers,
        SUM(CASE WHEN h.drinking = 1 THEN 1 ELSE 0 END) AS drinkers,
        SUM(CASE WHEN h.drugs = 1 THEN 1 ELSE 0 END) AS drug_users
    FROM user u
    JOIN medical_history mh ON u.user_id = mh.user_id
    JOIN habits h ON mh.medical_id = h.medical_id
    GROUP BY u.user_ethnicity
";

// Execute the query
$result = $conn->query($sql);
$habits_data = [];

// Fetch data and store in the habits_data array
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $habits_data[$row['user_ethnicity']] = [
            'smokers' => (int)$row['smokers'],
            'drinkers' => (int)$row['drinkers'],
            'drug_users' => (int)$row['drug_users']
        ];
    }
}

// Return the data as JSON
header('Content-Type: application/json');
echo json_encode($habits_data);

// Close the database connection
$conn->close();
?>