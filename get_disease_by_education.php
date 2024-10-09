<?php
// Connection to the database
$conn = new mysqli("localhost", "root", "", "abhds");

// Check if the connection is successful
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Prepare SQL query to get disease data by education level
$sql = "
    SELECT 
        CASE 
            WHEN u.user_education IN ('Elementary Graduate', 'Below') THEN 'Elementary Graduate & below'
            WHEN u.user_education = 'High School Graduate' THEN 'High School Graduate'
            ELSE 'College Graduate' 
        END AS education_level,
        d.disease_name,
        COUNT(mc.disease_id) AS count
    FROM user u
    JOIN medical_history mh ON u.user_id = mh.user_id
    JOIN medical_condition mc ON mh.medical_id = mc.medical_id
    JOIN disease d ON mc.disease_id = d.disease_id
    GROUP BY education_level, d.disease_name
";

// Execute the query
$result = $conn->query($sql);
$disease_data = [];

// Fetch data and store in the disease_data array
if ($result) { // Check if the query was successful
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $educationLevel = $row['education_level'];
            $diseaseName = $row['disease_name'];
            $count = (int)$row['count'];

            // Initialize the array for education level if not set
            if (!isset($disease_data[$educationLevel])) {
                $disease_data[$educationLevel] = [];
            }

            // Store disease count
            $disease_data[$educationLevel][$diseaseName] = $count;
        }
    } else {
        // No records found
        $disease_data['No data'] = [];
    }
} else {
    // Handle SQL error
    $disease_data['Error'] = $conn->error; // Store the error message
}

// Prepare the top diseases data for each education level
$top_disease_data = [];

// Get top 3 diseases for each education level
foreach ($disease_data as $educationLevel => $diseases) {
    // Sort diseases by count in descending order
    arsort($diseases);

    // Get top 3 diseases
    $top_diseases = array_slice($diseases, 0, 3, true);

    // Ensure we always have 3 entries
    while (count($top_diseases) < 3) {
        $top_diseases[" "] = 0; // Add an entry with empty name and count 0
    }

    // Store the top diseases for the education level
    $top_disease_data[$educationLevel] = $top_diseases;
}

// Return the data as JSON
header('Content-Type: application/json');
echo json_encode($top_disease_data);

// Close the database connection
$conn->close();
?>
