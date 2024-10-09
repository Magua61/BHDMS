<?php
// Connection to the database
$conn = new mysqli("localhost", "root", "", "abhds");

// Check if the connection is successful
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Prepare SQL query to get habits data by education level
$sql = "
    SELECT 
        CASE 
            WHEN user_education IN ('Elementary Graduate', 'Below') THEN 'Elementary Graduate & below'
            WHEN user_education = 'High School Graduate' THEN 'High School Graduate'
            ELSE 'College Graduate' 
        END AS education_level,
        SUM(CASE WHEN smoking = 1 THEN 1 ELSE 0 END) AS smokers,
        SUM(CASE WHEN drinking = 1 THEN 1 ELSE 0 END) AS drinkers,
        SUM(CASE WHEN drugs = 1 THEN 1 ELSE 0 END) AS drug_users
    FROM habits
    JOIN medical_history ON habits.medical_id = medical_history.medical_id
    JOIN user ON medical_history.user_id = user.user_id
    GROUP BY education_level
";

// Execute the query
$result = $conn->query($sql);
$habits_data = [];

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $habits_data[$row['education_level']] = [
            'smokers' => (int)$row['smokers'],
            'drinkers' => (int)$row['drinkers'],
            'drug_users' => (int)$row['drug_users'],
        ];
    }
}

// Return the data as JSON
header('Content-Type: application/json');
echo json_encode($habits_data);

// Close the database connection
$conn->close();
?>