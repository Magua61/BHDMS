<?php
// Connection to the database
$conn = new mysqli("localhost", "root", "", "abhds");

// Check if the connection is successful
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// SQL query to get the most common mental illnesses sorted by age groups
$sql = "
    SELECT 
        CASE 
            WHEN u.user_age BETWEEN 0 AND 20 THEN '0-20'
            WHEN u.user_age BETWEEN 21 AND 40 THEN '21-40'
            WHEN u.user_age BETWEEN 41 AND 60 THEN '41-60'
            WHEN u.user_age BETWEEN 61 AND 80 THEN '61-80'
            ELSE '81+' 
        END AS age_group,
        mi.mental_name,
        COUNT(mm.mental_id) AS count
    FROM user u
    JOIN medical_history AS mh ON u.user_id = mh.user_id
    JOIN medical_mental AS mm ON mh.medical_id = mm.medical_id
    JOIN mental_illness AS mi ON mm.mental_id = mi.mental_id
    GROUP BY age_group, mi.mental_name
";

// Execute the query
$result = $conn->query($sql);
$mental_data = [];

// Process the results
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $ageGroup = $row['age_group'];
        $mentalName = $row['mental_name'];
        $count = (int)$row['count'];

        // Initialize the array for age group if not set
        if (!isset($mental_data[$ageGroup])) {
            $mental_data[$ageGroup] = [];
        }

        // Store mental illness count
        $mental_data[$ageGroup][$mentalName] = $count;
    }
}

// Prepare an array for the top 3 mental illnesses
$top_mental_data = [];

// Get top 3 mental illnesses for each age group
foreach ($mental_data as $ageGroup => $mental) {
    // Sort mental illnesses by count in descending order
    arsort($mental);

    // Get top 3 mental illnesses
    $top_mental = array_slice($mental, 0, 3, true);

    // Ensure we always have 3 entries
    while (count($top_mental) < 3) {
        $top_mental[" "] = 0; // Add an entry with empty name and count 0
    }

    // Store the top mental illnesses for the age group
    $top_mental_data[$ageGroup] = $top_mental;
}

// Return the data as JSON
header('Content-Type: application/json');
echo json_encode($top_mental_data);

// Close the database connection
$conn->close();
?>
