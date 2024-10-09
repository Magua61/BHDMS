<?php
// Connection to the database
$conn = new mysqli("localhost", "root", "", "abhds");

// Check if the connection is successful
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Prepare SQL query to get mental illness data grouped by ethnicity
$sql = "
    SELECT 
        u.user_ethnicity,
        mi.mental_name,
        COUNT(mm.mental_id) AS count
    FROM user u
    JOIN medical_history mh ON u.user_id = mh.user_id
    JOIN medical_mental mm ON mh.medical_id = mm.medical_id
    JOIN mental_illness mi ON mm.mental_id = mi.mental_id
    GROUP BY u.user_ethnicity, mi.mental_name
";

// Execute the query
$result = $conn->query($sql);
$mental_data = [];

// Fetch data and store in the mental_data array
if ($result) { // Check if the query was successful
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $ethnicity = $row['user_ethnicity'];
            $mentalName = $row['mental_name'];
            $count = (int)$row['count'];

            // Initialize the array for ethnicity if not set
            if (!isset($mental_data[$ethnicity])) {
                $mental_data[$ethnicity] = [];
            }

            // Store mental illness count
            $mental_data[$ethnicity][$mentalName] = $count;
        }
    } else {
        // No records found
        $mental_data['No data'] = [];
    }
} else {
    // Handle SQL error
    $mental_data['Error'] = $conn->error; // Store the error message
}

// Prepare the top mental illnesses data for each ethnicity
$top_mental_data = [];

// Get top 3 mental illnesses for each ethnicity
foreach ($mental_data as $ethnicity => $mentalIllnesses) {
    // Sort mental illnesses by count in descending order
    arsort($mentalIllnesses);

    // Get top 3 mental illnesses
    $top_mental = array_slice($mentalIllnesses, 0, 3, true);

    // Ensure we always have 3 entries
    while (count($top_mental) < 3) {
        $top_mental[" "] = 0; // Add an entry with empty name and count 0
    }

    // Store the top mental illnesses for the ethnicity
    $top_mental_data[$ethnicity] = $top_mental;
}

// Return the data as JSON
header('Content-Type: application/json');
echo json_encode($top_mental_data);

// Close the database connection
$conn->close();
?>
