<?php
// Connection to the database
$conn = new mysqli("localhost", "root", "", "abhds");

// Check if the connection is successful
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Prepare SQL query to get habits data grouped by age
$sql = "
    SELECT 
        CASE 
            WHEN user_age BETWEEN 0 AND 20 THEN '0-20'
            WHEN user_age BETWEEN 21 AND 40 THEN '21-40'
            WHEN user_age BETWEEN 41 AND 60 THEN '41-60'
            WHEN user_age BETWEEN 61 AND 80 THEN '61-80'
            ELSE '81+' 
        END AS age_group,
        SUM(CASE WHEN habits.smoking = 1 THEN 1 ELSE 0 END) AS smokers,
        SUM(CASE WHEN habits.drinking = 1 THEN 1 ELSE 0 END) AS drinkers,
        SUM(CASE WHEN habits.drugs = 1 THEN 1 ELSE 0 END) AS drug_users
    FROM habits
    JOIN medical_history ON habits.medical_id = medical_history.medical_id
    JOIN user ON medical_history.user_id = user.user_id
    GROUP BY age_group
    ORDER BY 
        CASE 
            WHEN age_group = '0-20' THEN 1
            WHEN age_group = '21-40' THEN 2
            WHEN age_group = '41-60' THEN 3
            WHEN age_group = '61-80' THEN 4
            ELSE 5
        END
";

// Execute the query
$result = $conn->query($sql);

// Check if the query execution was successful
if (!$result) {
    die("Query failed: " . $conn->error);
}

$habits_data = [];

// Fetch results and structure the data
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $habits_data[$row['age_group']] = [
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