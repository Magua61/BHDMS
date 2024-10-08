<?php
// Connection to the database
$conn = new mysqli("localhost", "root", "", "abhds");

// Check if the connection is successful
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch the evacuee's data
$evacuee_id = 1; // Example ID, change as needed
$sql = "SELECT * FROM evacuees WHERE id = $evacuee_id";
$result = $conn->query($sql);
$evacuee = $result->fetch_assoc();
?>

<!DOCTYPE html>
<head>
    <link href="https://fonts.googleapis.com/css2?family=Material+Icons+Sharp"
      rel="stylesheet">
   <link rel="stylesheet" href="style.css">
   <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
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
                    <a href="evacuees.html" class="btn-evacuees">
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
                            <select name="vaccines" id="vaccines">
                                <option value="measles">Measles</option>
                              <option value="covid">Covid-19</option>
                              <option value="rabies">Rabies</option>
                              <option value="tetanus">Tetanus</option>
                            </select>
                        </div>
                        <div class="middle">
                            <div class="left">
                                 <h3>Vaccination Rate</h3>
                                <h1>Total Population: 854</h1>
                            </div>
                        </div>
                        <div id="pie-chart"></div>
                    </div>
                    <!====================== EVACUEES ====================!>

                    <div class="evacuees">
                        <span class= "material-icons-sharp">trending_up</span>
                        <div class="combo-box">
                            <select name="year" id="year">
                                <option value="2024">2024</option>
                              <option value="2023">2023</option>
                              <option value="2022">2022</option>
                              <option value="2021">2021</option>
                            </select>
                        </div>
                        <div class="middle">
                            <div class="left">
                                 <h3>Disease Prevalence Trend</h3>
                            </div>
                        </div>
                        <div id="line-chart"></div>
                    </div>
                    <!====================== RELIEF ====================!>
                    <div class="inventory">
                        <span class= "material-icons-sharp">coronavirus</span>
                        <div class="combo-box">
                            <select name="disease-sort" id="disease-sort">
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
                        <div id="bar-chart"></div>
                    </div>
                    <!====================== CAPACITY ====================!>
                    <div class="mental">
                        <span class= "material-icons-sharp">psychology</span>
                        <div class="combo-box">
                            <select name="disease-sort" id="disease-sort">
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

                    <div class="evac-analytics">
                        <h2>Analytics</h2>
                        <div class="evacuee analysis">
                            <div class="icon">
                                <span class= "material-icons-sharp">groups</span>
                            </div>
                            <div class="right">
                                <div class="info">
                                    <h3>Residents</h3>
                                    <small class="text-muted">Last 24 Hours</small>
                                </div>
                                <h5 class="success">+26%</h5>
                                <h3>854</h3>
                            </div>
                        </div>

                        <div class="volunteer analysis">
                            <div class="icon">
                                <span class="material-icons-sharp">diversity_3</span>
                            </div>
                            <div class="right">
                                <div class="info">
                                    <h3>Families</h3>
                                    <small class="text-muted">Last 24 Hours</small>
                                </div>
                                <h5 class="danger">-15%</h5>
                                <h3>23</h3>
                            </div>
                        </div>


                    </div>

            </div>
        </div>

        <script src="chart.js"></script>
        <script src="default.js"></script>
</body>
</html>