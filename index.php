<?php
// Connection to the database
$conn = new mysqli("localhost", "root", "", "abhds");

// Check if the connection is successful
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
// Prepare SQL queries to count users and families
$user_result = $conn->query("SELECT COUNT(*) AS total_users FROM user");
$family_result = $conn->query("SELECT COUNT(*) AS total_families FROM family");
if ($user_result) {
    $row = $user_result->fetch_assoc();
    $totalUsers = $row['total_users'];
} else {
    echo "Error: " . $conn->error;
}

if ($family_result) {
    $row = $family_result->fetch_assoc();
    $totalFamilies = $row['total_families'];
} else {
    echo "Error: " . $conn->error;
}

$conn->close();
?>

<!DOCTYPE html>
<head>
    <link href="https://fonts.googleapis.com/css2?family=Material+Icons+Sharp"
      rel="stylesheet">
   <link rel="stylesheet" href="style.css">

   </head>
<body>

        <div class="container">
            <aside>
                <div class="top">
                    <div class ="logo">
                        <img src="assets/logo.png">
                        <h2>ABHDS</h2>
                    </div>
                    <div class="close" id="close-btn">
                        <span class="material-icons-sharp">close</span>
                    </div>
                </div>

                <div class ="sidebar">
                    <a href="#" class="btn-dashboard active">
                        <span class="material-icons-sharp">grid_view</span>
                        <h3>Dashboard</h3>
                    </a>
                    <a href="profile.php" class="btn-evacuees">
                        <span class="material-icons-sharp">medical_information</span>
                        <h3>Health Profile</h3>
                    </a>
                    <a href="#" class="btn-logout">
                        <span class="material-icons-sharp">logout</span>
                        <h3>Logout</h3>
                    </a>

                </div>
            </aside>
            <!===================== END OF ASIDE =======================!>

            <main>
                <h1>Dashboard</h1>
                <div class="date">
                    <script>
                    date = new Date().toLocaleDateString();
                    document.write(date);
                    </script>
                </div>
                <div class="insights">
                    <!====================== Residents ====================!>
                    <div class="cap">
                        <span class= "material-icons-sharp">vaccines</span>
                        <div class="combo-box">
                            <select name="vaccines" id="vaccine-select" onchange="updatePieChart()">
                                <option value="Measles">Measles</option>
                                <option value="Covid-19">Covid-19</option>
                                <option value="Rabies">Rabies</option>
                                <option value="Tetanus">Tetanus</option>
                            </select>
                        </div>
                        <div class="middle">
                            <div class="left">
                                 <h3>Vaccination Statistics</h3>
                            </div>
                        </div>

                        <!-- Pie chart container -->
                        <div id="pie-chart"></div>

                    </div>
                    <!====================== EVACUEES ====================!>

                    <div class="evacuees">
                    <span class="material-icons-sharp">trending_up</span>
                    <div class="combo-box">
                        <select name="habits" id="habits-sort">
                            <option value="age">Age</option>
                            <option value="income">Income</option>
                            <option value="ethnicity">Ethnicity</option>
                            <option value="education">Education</option>
                        </select>
                    </div>
                    <div class="middle">
                        <div class="left">
                            <h3>Health Habits Overview</h3>
                        </div>
                    </div>
                    <div id="habits-bar-chart" ></div>
                    </div>
                    <!====================== RELIEF ====================!>
                    <div class="inventory">
                        <span class= "material-icons-sharp">coronavirus</span>
                        <div class="combo-box">
                            <select name="disease" id="disease-sort">
                                <option value="age">Age</option>
                              <option value="income">Income</option>
                              <option value="ethnicity">Ethnicity</option>
                              <option value="education">Education</option>
                            </select>
                        </div>
                        <div class="middle">
                            <div class="left">
                                 <h3>Most Common Disease</h3>
                            </div>
                        </div>
                        <div id="disease-bar-chart"></div>
                    </div>
                    <!====================== CAPACITY ====================!>
                    <div class="mental">
                        <span class= "material-icons-sharp">psychology</span>
                        <div class="combo-box">
                            <select name="mental" id="mental-sort">
                                <option value="age">Age</option>
                              <option value="income">Income</option>
                              <option value="ethnicity">Ethnicity</option>
                              <option value="education">Education</option>
                            </select>
                        </div>
                        <div class="middle">
                            <div class="left">
                                 <h3>Mental Health Statistics</h3>
                            </div>
                        </div>
                        <div id="mental-bar-chart"></div>
                    </div>
                </div>
            </main>
            <!  ------------------- END OF MAIN -----------------------  !>

            <div class="right">
                <div class="top">
                    <button id="menu-btn">
                        <span class= "material-icons-sharp">menu</span>
                    </button>
                    <div class="profile">
                        <div class="info">
                            <p>Hey, <b>Daniel</b></p>
                            <small class="text-muted">Admin</small>
                        </div>
                    </div>

                </div>
                <! ---------------- End of Top ---------------- !>

                    <div class="health-warning">
                        <h2>Analytics</h2>
                        <div class="hereditary warning">
                            <div class="icon">
                                <span class= "material-icons-sharp">groups</span>
                            </div>
                            <div class="right">
                                <div class="info">
                                    <h3>Residents</h3>
                                    <small class="text-muted">Last 24 Hours</small>
                                </div>
                                <h3><?php echo $totalUsers?></h3>
                            </div>
                        </div>

                        <div class="habits warning">
                            <div class="icon">
                                <span class="material-icons-sharp">diversity_3</span>
                            </div>
                            <div class="right">
                                <div class="info">
                                    <h3>Families</h3>
                                    <small class="text-muted">Last 24 Hours</small>
                                </div>
                                <h3><?php echo $totalFamilies?></h3>
                            </div>
                        </div>


                    </div>

            </div>
        </div>
        <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
        <script src="chart.js"></script>
        <script src="default.js"></script>
</body>
</html>