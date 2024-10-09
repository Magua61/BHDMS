<?php
// Connection to the database
$conn = new mysqli("localhost", "root", "", "abhds");

// Check if the connection is successful
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Get the total number of users in the system
$total_users_sql = "SELECT COUNT(user_id) AS total_users FROM user";
$total_users_result = $conn->query($total_users_sql);
$total_users_row = $total_users_result->fetch_assoc();
$total_users = (int)$total_users_row['total_users'];

// Prepare the SQL query to fetch vaccinated counts for each vaccine
$sql = "
    SELECT v.vaccine_name,
           COUNT(DISTINCT mh.user_id) AS vaccinated
    FROM vaccine v
    LEFT JOIN medical_vaccination mv ON v.vaccine_id = mv.vaccine_id
    LEFT JOIN medical_history mh ON mv.medical_id = mh.medical_id
    GROUP BY v.vaccine_name
";

// Execute the query
$result = $conn->query($sql);

// Prepare an array to store the data
$vaccination_data = [];

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $vaccinated = (int)$row['vaccinated'];
        $unvaccinated = $total_users - $vaccinated;  // Calculate unvaccinated

        $vaccination_data[$row['vaccine_name']] = [
            'vaccinated' => $vaccinated,
            'unvaccinated' => $unvaccinated
        ];
    }
}

// Return the data as JSON
header('Content-Type: application/json');
echo json_encode($vaccination_data);

// Close the database connection
$conn->close();
?>