<?php
// Connection to the database
$conn = new mysqli("localhost", "root", "", "abhds");

// Check if the connection is successful
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// SQL query to get the most common diseases sorted by age groups
$sql = "
    SELECT 
        CASE 
            WHEN user_age BETWEEN 0 AND 20 THEN '0-20'
            WHEN user_age BETWEEN 21 AND 40 THEN '21-40'
            WHEN user_age BETWEEN 41 AND 60 THEN '41-60'
            WHEN user_age BETWEEN 61 AND 80 THEN '61-80'
            ELSE '81+' 
        END AS age_group,
        d.disease_name,
        COUNT(mc.disease_id) AS count
    FROM user
    JOIN medical_history AS mh ON user.user_id = mh.user_id
    JOIN medical_condition AS mc ON mh.medical_id = mc.medical_id
    JOIN disease AS d ON mc.disease_id = d.disease_id
    GROUP BY age_group, d.disease_name
";

// Execute the query
$result = $conn->query($sql);
$disease_data = [];

// Process the results
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $ageGroup = $row['age_group'];
        $diseaseName = $row['disease_name'];
        $count = (int)$row['count'];

        // Initialize the array for age group if not set
        if (!isset($disease_data[$ageGroup])) {
            $disease_data[$ageGroup] = [];
        }

        // Store disease count
        $disease_data[$ageGroup][$diseaseName] = $count;
    }
}

// Prepare an array for the top 3 diseases
$top_disease_data = [];

// Get top 3 diseases for each age group
foreach ($disease_data as $ageGroup => $diseases) {
    // Sort diseases by count in descending order
    arsort($diseases);

    // Get top 3 diseases
    $top_diseases = array_slice($diseases, 0, 3, true);

    // Ensure we always have 3 entries
    while (count($top_diseases) < 3) {
        $top_diseases[" "] = 0; // Add an entry with empty name and count 0
    }

    // Store the top diseases for the age group
    $top_disease_data[$ageGroup] = $top_diseases;
}

// Return the data as JSON
header('Content-Type: application/json');
echo json_encode($top_disease_data);

// Close the database connection
$conn->close();
?>
