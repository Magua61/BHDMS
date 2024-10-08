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
   <!-- <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script> -->
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
                    <a href="index.html" class="btn-dashboard">
                        <span class="material-icons-sharp">grid_view</span>
                        <h3>Dashboard</h3>
                    </a>

                    <a href="#" class="btn-evacuees active">
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

                <h1>Health Profile</h1>
                
                <div class="health-profile-card">
                    <h2>Personal Details</h1>
                    <div class="personal-details-card">
                        <h3>Name: <span id="person-name">Alfred Panfilo Valencia</span><input type="text" id="edit-name" class="edit-field" style="display:none"></h3>
                        <h3>Age: <span id="person-age">35</span><input type="number" id="edit-age" class="edit-field" style="display:none"></h3>
                        <h3>Birthday: <span id="birthday">July 21, 1989</span><input type="date" id="edit-birthday" class="edit-field" style="display:none"></h3>
                        <h3>Address: <span id="address">San Isidro, Pasig City</span><input type="text" id="edit-address" class="edit-field" style="display:none"></h3>
                        <h3>Phone Number: <span id="phone-number">0917-123-123</span><input type="text" id="edit-phone" class="edit-field" style="display:none"></h3>
                        <h3>Email Address: <span id="email">alfred@gmail.com</span><input type="email" id="edit-email" class="edit-field" style="display:none"></h3>
                        <h3>Occupation: <span id="occupation">Truck Driver</span><input type="text" id="edit-occupation" class="edit-field" style="display:none"></h3>
                        <h3>Ethnicity: <span id="ethnicity">Tagalog</span><input type="text" id="edit-ethnicity" class="edit-field" style="display:none"></h3>
                        <h3>Family: <span id="family">Aripaypay-Valencia</span><input type="text" id="edit-family" class="edit-field" style="display:none"></h3>
                        <button class="edit-btn" id="edit-personal" onclick="editPersonalDetails()">Edit</button>
                        <button class="edit-btn" id="save-personal" onclick="savePersonalDetails()" style="display:none">Save</button>
                    </div>
                
                    <!-- Medical Details Section -->
                    <div class="medical-details-card">

                        <!-- Medical details fields -->
                        <h3>Medical Conditions: 
                            <span id="person-medical-conditions">Hypertension, Diabetes</span>
                            <div style="display: grid; grid-template-columns: 80% 20%;">
                                <h3 id="edit-medical-conditions" class="edit-field" style="display:none"></h3>
                                <button id="edit-medical-conditions-btn" data-modal-target="#modal-medical-condition" style="display: none;">Edit</button>
                            </div>
                        </h3>
                        <h3>Mental Health History: 
                            <span id="person-mental-health-history">Anxiety</span>
                            <div style="display: grid; grid-template-columns: 80% 20%;">
                            <h3 id="edit-mental-health-history" class="edit-field" style="display:none"></h3>
                            <button id="edit-mental-health-history-btn" data-modal-target="#modal-mental-health-history" style="display: none;">Edit</button>
                            </div>
                        </h3>
                        <h3>Allergies: 
                            <span id="person-allergies">None</span>
                            <div style="display: grid; grid-template-columns: 80% 20%;">
                                <h3 id="edit-allergies" class="edit-field" style="display:none"></h3>
                                <button id="edit-allergies-btn" data-modal-target="#modal-allergies" style="display: none;">Edit</button>
                            </div>
                        </h3>
                        <h3>Vaccination: 
                            <span id="person-vaccination">COVID-19 (2 doses), Influenza</span>
                            <div style="display: grid; grid-template-columns: 80% 20%;">
                            <h3 id="edit-vaccination" class="edit-field" style="display:none"></h3>
                            <button id="edit-vaccination-btn" data-modal-target="#modal-vaccination" style="display: none;">Edit</button>
                            </div>
                        </h3>
                        <h3>Habits (Drugs, Smoking, Drinking): <span id="person-habits">None</span>
                            <div style="display: grid; grid-template-columns: 80% 20%;">
                            <h3 id="edit-habits" class="edit-field" style="display:none"></h3>
                            <button id="edit-habits-btn" data-modal-target="#modal-habits" style="display: none;">Edit</button>
                            </div>
                        </h3>
                    
                        <!-- Edit and Save buttons -->
                        <button class="edit-btn" id="edit-medical-details" onclick="editMedicalDetails()">Edit</button>
                        <button class="edit-btn" id="save-medical-details" onclick="saveMedicalDetails()" style="display: none;">Save</button>
                    </div>

                    <!-- Current Health Status Section -->
                    <div class="current-health-status-card">
                        <h3>Current Conditions: 
                            <span id="current-conditions">None</span>
                            <div style="display: grid; grid-template-columns: 80% 20%;">
                                <h3 id="edit-current-conditions" class="edit-field" style="display:none"></h3>
                                <button id="edit-current-conditions-btn" data-modal-target="#modal-current-condition" style="display: none;">Edit</button>
                            </div>
                        </h3>
                        <h3>Current Mental Health Conditions: 
                            <span id="current-mental-health">None</span>
                            <div style="display: grid; grid-template-columns: 80% 20%;">
                                <h3 id="edit-current-mental-health" class="edit-field" style="display:none"></h3>
                                <button id="edit-current-mental-health-btn" data-modal-target="#modal-current-mental-health" style="display: none;">Edit</button>
                            </div>
                        </h3>
                        <h3>Relevant Information: 
                            <span id="relevant-info">N/A</span>
                            <textarea id="edit-relevant-info" class="edit-field" style="display:none"></textarea>
                        </h3>
                        <h3>Medications: 
                            <span id="person-medications">Lisinopril</span>
                            <div style="display: grid; grid-template-columns: 80% 20%;">
                                <h3 id="edit-medications" class="edit-field" style="display:none"></h3>
                                <button id="edit-medications-btn" data-modal-target="#modal-medications" style="display: none;">Edit</button>
                            </div>
                        </h3>
                        <button class="edit-btn" id="edit-current-health" onclick="editCurrentHealthStatus()">Edit</button>
                        <button class="edit-btn" id="save-current-health" onclick="saveCurrentHealthStatus()" style="display:none">Save</button>
                    </div>
                </div>
                <!-- Modal -->
                <!-- Medical Condition -->
                <div class="modal" id="modal-medical-condition">
                    <div class="modal-header">
                        <div class="title"><span class= "material-icons-sharp">edit</span>
                            <h2>Edit Medical Conditions</h2>
                            <button data-close-button class="close-button"><span class="material-icons-sharp">close</span></button>
                        </div>
                    </div>
                    <div class="modal-body">
                        <div class="modal-body-input">
                            <div class="add-medical-condition">
                                <input list="medical-conditions" id="medical-condition-input" placeholder="Search medical conditions...">
                                <datalist id="medical-conditions">
                                    <option value="Hypertension"></option>
                                    <option value="Diabetes"></option>
                                    <option value="Asthma"></option>
                                    <option value="Heart Disease"></option>
                                    <option value="Allergy"></option>
                                </datalist>
                                <button id="add-condition-btn" onclick="addCondition()">Add</button>
                            </div>
                        <!-- Table for added medical conditions -->
                        <table id="medical-condition-table" style="width:100%;">
                            <thead>
                                <tr>
                                    <th>Condition</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody id="condition-list"></tbody>
                        </table>
                        </div>
                        <div class="modal-buttons">
                            <button onclick="saveMedicalConditions()">Save</button>
                            <button  data-close-button>Cancel</button>
                        </div>
                    </div>
                </div>

                <!-- Current Medical Condition -->
                <div class="modal" id="modal-current-condition">
                    <div class="modal-header">
                        <div class="title"><span class= "material-icons-sharp">edit</span>
                            <h2>Edit Current Medical Conditions</h2>
                            <button data-close-button class="close-button"><span class="material-icons-sharp">close</span></button>
                        </div>
                    </div>
                    <div class="modal-body">
                        <div class="modal-body-input">
                            <div class="add-current-medical-condition">
                                <input list="current-medical-conditions" id="current-medical-condition-input" placeholder="Search medical conditions...">
                                <datalist id="current-medical-conditions">
                                    <option value="Hypertension"></option>
                                    <option value="Diabetes"></option>
                                    <option value="Asthma"></option>
                                    <option value="Heart Disease"></option>
                                    <option value="Allergy"></option>
                                </datalist>
                                <button id="add-current-condition-btn" onclick="addCurrentCondition()">Add</button>
                            </div>
                        <!-- Table for added medical conditions -->
                        <table id="current-medical-condition-table" style="width:100%;">
                            <thead>
                                <tr>
                                    <th>Condition</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody id="current-condition-list"></tbody>
                        </table>
                        </div>
                        <div class="modal-buttons">
                            <button onclick="saveCurrentMedicalConditions()">Save</button>
                            <button  data-close-button>Cancel</button>
                        </div>
                    </div>
                </div>

                <!-- Mental Health History -->
                <div class="modal" id="modal-mental-health-history">
                    <div class="modal-header">
                        <div class="title"><span class= "material-icons-sharp">edit</span>
                            <h2>Edit Mental Health History</h2>
                            <button data-close-button class="close-button"><span class="material-icons-sharp">close</span></button>
                        </div>
                    </div>
                    <div class="modal-body">
                        <div class="modal-body-input">
                            <div class="add-mental-condition">
                                <input list="mental-conditions" id="mental-condition-input" placeholder="Search mental illness...">
                                <datalist id="mental-conditions">
                                    <option value="Depression"></option>
                                    <option value="Anxiety"></option>
                                    <option value="ADHD"></option>
                                    <option value="Bipolar"></option>
                                    <option value="Psychotic"></option>
                                </datalist>
                                <button id="add-mental-btn" onclick="addMentalCondition()">Add</button>
                            </div>
                        <!-- Table for added medical conditions -->
                        <table id="mental-condition-table" style="width:100%;">
                            <thead>
                                <tr>
                                    <th>Condition</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody id="mental-condition-list"></tbody>
                        </table>
                        </div>
                        <div class="modal-buttons">
                            <button onclick="saveMentalConditions()">Save</button>
                            <button  data-close-button>Cancel</button>
                        </div>
                    </div>
                </div>

                <!-- Current Mental Health -->
                <div class="modal" id="modal-current-mental-health">
                    <div class="modal-header">
                        <div class="title"><span class= "material-icons-sharp">edit</span>
                            <h2>Edit Current Mental Health </h2>
                            <button data-close-button class="close-button"><span class="material-icons-sharp">close</span></button>
                        </div>
                    </div>
                    <div class="modal-body">
                        <div class="modal-body-input">
                            <div class="add-current-mental-condition">
                                <input list="current-mental-conditions" id="current-mental-condition-input" placeholder="Search mental illness...">
                                <datalist id="current-mental-conditions">
                                    <option value="Depression"></option>
                                    <option value="Anxiety"></option>
                                    <option value="ADHD"></option>
                                    <option value="Bipolar"></option>
                                    <option value="Psychotic"></option>
                                </datalist>
                                <button id="add-current-mental-btn" onclick="addCurrentMentalCondition()">Add</button>
                            </div>
                        <!-- Table for added medical conditions -->
                        <table id="current-mental-condition-table" style="width:100%;">
                            <thead>
                                <tr>
                                    <th>Condition</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody id="current-mental-condition-list"></tbody>
                        </table>
                        </div>
                        <div class="modal-buttons">
                            <button onclick="saveCurrentMentalConditions()">Save</button>
                            <button  data-close-button>Cancel</button>
                        </div>
                    </div>
                </div>
                <!-- Habits -->
                <div class="modal" id="modal-habits">
                    <div class="modal-header">
                        <div class="title"><span class= "material-icons-sharp">edit</span>
                            <h2>Edit Habits</h2>
                            <button data-close-button class="close-button"><span class="material-icons-sharp">close</span></button>
                        </div>
                    </div>
                    <div class="modal-body">
                        <div class="modal-body-input">
                            <div class="add-habits">
                                <input list="habits" id="habits-input" placeholder="Search habits...">
                                <datalist id="habits">
                                    <option value="Smoking"></option>
                                    <option value="Drinking"></option>
                                    <option value="Substances"></option>
                                </datalist>
                                <button id="add-habits-btn" onclick="addHabits()">Add</button>
                            </div>
                        <!-- Table for added medical conditions -->
                        <table id="habits-table" style="width:100%;">
                            <thead>
                                <tr>
                                    <th>Condition</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody id="habits-list"></tbody>
                        </table>
                        </div>
                        <div class="modal-buttons">
                            <button onclick="saveHabits()">Save</button>
                            <button  data-close-button>Cancel</button>
                        </div>
                    </div>
                </div>

                <!-- Allergies -->
                <div class="modal" id="modal-allergies">
                    <div class="modal-header">
                        <div class="title"><span class= "material-icons-sharp">edit</span>
                            <h2>Edit Allergies</h2>
                            <button data-close-button class="close-button"><span class="material-icons-sharp">close</span></button>
                        </div>
                    </div>
                    <div class="modal-body">
                        <div class="modal-body-input">
                            <div class="add-allergies">
                                <input list="allergies" id="allergies-input" placeholder="Search allergies...">
                                <datalist id="allergies">
                                    <option value="Pollen"></option>
                                    <option value="Cats"></option>
                                    <option value="Dogs"></option>
                                    <option value="Seafood"></option>
                                    <option value="Chicken"></option>
                                </datalist>
                                <button id="add-allergies-btn" onclick="addAllergies()">Add</button>
                            </div>
                        <!-- Table for added medical conditions -->
                        <table id="allergies-table" style="width:100%;">
                            <thead>
                                <tr>
                                    <th>Condition</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody id="allergies-list"></tbody>
                        </table>
                        </div>
                        <div class="modal-buttons">
                            <button onclick="saveAllergies()">Save</button>
                            <button  data-close-button>Cancel</button>
                        </div>
                    </div>
                </div>

                <!-- Medications -->
                <div class="modal" id="modal-medications">
                    <div class="modal-header">
                        <div class="title"><span class= "material-icons-sharp">edit</span>
                            <h2>Edit Allergies</h2>
                            <button data-close-button class="close-button"><span class="material-icons-sharp">close</span></button>
                        </div>
                    </div>
                    <div class="modal-body">
                        <div class="modal-body-input">
                            <div class="add-medications">
                                <input list="medications" id="medications-input" placeholder="Search medications...">
                                <datalist id="medications">
                                    <option value="Lisinopril"></option>
                                    <option value="Clyndamycin"></option>
                                    <option value="Isonoin"></option>
                                </datalist>
                                <button id="add-medications-btn" onclick="addMedications()">Add</button>
                            </div>
                        <!-- Table for added medical conditions -->
                        <table id="medications-table" style="width:100%;">
                            <thead>
                                <tr>
                                    <th>Condition</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody id="medications-list"></tbody>
                        </table>
                        </div>
                        <div class="modal-buttons">
                            <button onclick="saveMedications()">Save</button>
                            <button  data-close-button>Cancel</button>
                        </div>
                    </div>
                </div>

                <!-- Vaccination -->
                <div class="modal" id="modal-vaccination">
                    <div class="modal-header">
                        <div class="title"><span class= "material-icons-sharp">edit</span>
                            <h2>Edit Vaccination</h2>
                            <button data-close-button class="close-button"><span class="material-icons-sharp">close</span></button>
                        </div>
                    </div>
                    <div class="modal-body">
                        <div class="modal-body-input">
                            <div class="add-vaccination">
                                <input list="vaccination" id="vaccination-input" placeholder="Search vaccinations...">
                                <datalist id="vaccination">
                                    <option value="COVID-19"></option>
                                    <option value="Influenza"></option>
                                    <option value="Rabies"></option>
                                    <option value="Measles"></option>
                                    <option value="Tetanus"></option>
                                </datalist>
                                <button id="add-vaccination-btn" onclick="addVaccination()">Add</button>
                            </div>
                        <!-- Table for added medical conditions -->
                        <table id="vaccination-table" style="width:100%;">
                            <thead>
                                <tr>
                                    <th>Condition</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody id="vaccination-list"></tbody>
                        </table>
                        </div>
                        <div class="modal-buttons">
                            <button onclick="saveVaccination()">Save</button>
                            <button  data-close-button>Cancel</button>
                        </div>
                    </div>
                </div>
                <div id="overlay"></div>
                    
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
                        <h2>Health Warning</h2>
                        <div class="evacuee analysis">
                            <div class="icon">
                                <span class= "material-icons-sharp">device_thermostat</span>
                            </div>
                            <div class="right">
                                <div class="info">
                                    <h3>Diabetes</h3>
                                    <small class="text-muted">Prone to Diabetes</small>
                                </div>
                                <h3 class="cause">Heredity</h3>
                            </div>
                        </div>

                        <div class="volunteer analysis">
                            <div class="icon">
                                <span class="material-icons-sharp">device_thermostat</span>
                            </div>
                            <div class="right">
                                <div class="info">
                                    <h3>Lung Cancer</h3>
                                    <small class="text-muted">Prone to Lung Cancer</small>
                                </div>
                                <h3 class="cause">Habits</h3>
                            </div>
                        </div>

                    </div>

            </div>
        </div>

        <script src="chart.js"></script>
        <script src="default.js"></script>
   
</body>
</html>