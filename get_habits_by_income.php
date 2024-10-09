<?php
// Connection to the database
$conn = new mysqli("localhost", "root", "", "abhds");

// Check if the connection is successful
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Prepare SQL query to get habits data by income group
$sql = "
    SELECT 
        CASE 
            WHEN household_income < 10000 THEN '<10000'
            WHEN household_income BETWEEN 10000 AND 30000 THEN '10000-30000'
            WHEN household_income BETWEEN 30001 AND 50000 THEN '30001-50000'
            ELSE '50000+' 
        END AS income_group,
        SUM(CASE WHEN smoking = 1 THEN 1 ELSE 0 END) AS smokers,
        SUM(CASE WHEN drinking = 1 THEN 1 ELSE 0 END) AS drinkers,
        SUM(CASE WHEN drugs = 1 THEN 1 ELSE 0 END) AS drug_users
    FROM habits
    JOIN medical_history ON habits.medical_id = medical_history.medical_id
    JOIN user ON medical_history.user_id = user.user_id
    GROUP BY income_group
";

// Execute the query
$result = $conn->query($sql);
$habits_data = [];

if ($result) { // Check if the query was successful
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $habits_data[$row['income_group']] = [
                'smokers' => (int)$row['smokers'],
                'drinkers' => (int)$row['drinkers'],
                'drug_users' => (int)$row['drug_users'],
            ];
        }
    } else {
        // No records found
        $habits_data['No data'] = ['smokers' => 0, 'drinkers' => 0, 'drug_users' => 0];
    }
} else {
    // Handle SQL error
    $habits_data['Error'] = $conn->error; // Store the error message
}

// Return the data as JSON
header('Content-Type: application/json');
echo json_encode($habits_data);

// Close the database connection
$conn->close();
?>