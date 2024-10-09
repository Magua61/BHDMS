<?php
// Connection to the database
$conn = new mysqli("localhost", "root", "", "abhds");

// Check if the connection is successful
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Function to fetch data using prepared statements
function fetchData($conn, $sql, $params) {
    $stmt = $conn->prepare($sql);
    if ($stmt === false) {
        die("Error preparing the SQL statement: " . $conn->error);
    }
    $stmt->bind_param(...$params);
    $stmt->execute();
    return $stmt->get_result();
}
$disease_names = [];
$disease_conditions_sql = "SELECT disease_name FROM disease";

if ($disease_conditions_stmt = $conn->prepare($disease_conditions_sql)) {
    $disease_conditions_stmt->execute();
    $disease_conditions_result = $disease_conditions_stmt->get_result();
    
    while ($row = $disease_conditions_result->fetch_assoc()) {
        $disease_names[] = $row['disease_name'];
    }
    
    $disease_conditions_stmt->close();
}
// Fetch the evacuee's data
$user_id = 00000001; // Example ID, change as needed
$user_sql = "SELECT * FROM user WHERE user_id = ?";
$user_result = fetchData($conn, $user_sql, ['i', $user_id]);
$user = $user_result->fetch_assoc();
$family_id = $user['family_id'];
// Get family data
$family_result = fetchData($conn, "SELECT * FROM family WHERE family_id = ?", ['i', $user['family_id']]);
$family = $family_result->fetch_assoc();

// Get medical history
$medical_result = fetchData($conn, "SELECT * FROM medical_history WHERE user_id = ?", ['i', $user_id]);
$medical = $medical_result->fetch_assoc();
$medical_id = $medical['medical_id'];

$current_health_result = fetchData($conn, "SELECT * FROM current_health WHERE user_id = ?", ['i', $user_id]);
$current = $current_health_result->fetch_assoc();
$current_health_id = $current['current_health_id'];

// Get medical habits
$habits_result = fetchData($conn, "SELECT smoking, drinking, drugs FROM habits WHERE medical_id = ?", ['i', $medical_id]);
$habits_row = $habits_result->fetch_assoc();
$habits_array = array_filter([
    'smoking' => $habits_row['smoking'] == 1,
    'drinking' => $habits_row['drinking'] == 1,
    'drugs' => $habits_row['drugs'] == 1
], fn($v) => $v);

// Get disease from habits//
$habits_diseases = [];
if ($habits_row['smoking'] == 1) {
    $habits_diseases[] = 'Pneumonia';
    $habits_diseases[] = 'Tuberculosis';
    $habits_diseases[] = 'Cancer';
}
// Use array_keys to get the keys (habit names) where the values are true
$habits_array = array_keys($habits_array);

// Get allergies
$allergies_result = fetchData($conn, "
    SELECT a.allergy_name
    FROM allergy a
    INNER JOIN medical_allergy ma ON a.allergy_id = ma.allergy_id
    INNER JOIN medical_history mh ON ma.medical_id = mh.medical_id
    INNER JOIN user u ON mh.user_id = u.user_id
    WHERE u.user_id = ?", ['i', $user_id]);

$allergies = [];
while ($row = $allergies_result->fetch_assoc()) {
    $allergies[] = $row['allergy_name'];
}

// Get medical conditions
$medical_conditions_result = fetchData($conn, "
    SELECT disease.disease_name
    FROM disease
    INNER JOIN medical_condition ON disease.disease_id = medical_condition.disease_id
    INNER JOIN medical_history ON medical_condition.medical_id = medical_history.medical_id
    INNER JOIN user ON medical_history.user_id = user.user_id
    WHERE user.user_id = ?", ['i', $user_id]);

$medical_conditions = [];
while ($row = $medical_conditions_result->fetch_assoc()) {
    $medical_conditions[] = $row['disease_name'];
}

// Get mental illnesses
$mental_illnesses_result = fetchData($conn, "
    SELECT mental_illness.mental_name
    FROM mental_illness
    INNER JOIN medical_mental ON mental_illness.mental_id = medical_mental.mental_id
    INNER JOIN medical_history ON medical_mental.medical_id = medical_history.medical_id
    INNER JOIN user ON medical_history.user_id = user.user_id
    WHERE user.user_id = ?", ['i', $user_id]);

$mental_illnesses = [];
while ($row = $mental_illnesses_result->fetch_assoc()) {
    $mental_illnesses[] = $row['mental_name'];
}

// Get vaccinations
$vaccinations_result = fetchData($conn, "
    SELECT vaccine.vaccine_name
    FROM vaccine
    INNER JOIN medical_vaccination ON vaccine.vaccine_id = medical_vaccination.vaccine_id
    INNER JOIN medical_history ON medical_vaccination.medical_id = medical_history.medical_id
    INNER JOIN user ON medical_history.user_id = user.user_id
    WHERE user.user_id = ?", ['i', $user_id]);

$vaccinations = [];
while ($row = $vaccinations_result->fetch_assoc()) {
    $vaccinations[] = $row['vaccine_name'];
}
// Fetch current conditions
$current_condition_result = fetchData($conn, "
    SELECT disease.disease_name 
    FROM disease 
    INNER JOIN current_condition ON disease.disease_id = current_condition.disease_id 
    INNER JOIN current_health ON current_condition.current_health_id = current_health.current_health_id 
    INNER JOIN user ON current_health.user_id = user.user_id 
    WHERE user.user_id = ?", ['i', $user_id]);

$current_condition = [];
while ($row = $current_condition_result->fetch_assoc()) {
    $current_condition[] = $row['disease_name'];
}

// Fetch current mental illnesses
$current_mental_result = fetchData($conn, "
    SELECT mental_illness.mental_name
    FROM mental_illness
    INNER JOIN current_mental ON mental_illness.mental_id = current_mental.mental_id
    INNER JOIN current_health ON current_mental.current_health_id = current_health.current_health_id
    INNER JOIN user ON current_health.user_id = user.user_id
    WHERE user.user_id = ?", ['i', $user_id]);

$current_mental_illnesses = [];
while ($row = $current_mental_result->fetch_assoc()) {
    $current_mental_illnesses[] = $row['mental_name'];
}

// Fetch current medications
$current_medications_result = fetchData($conn, "
    SELECT medicine_name
    FROM medicine
    INNER JOIN current_medication ON medicine.medicine_id = current_medication.medicine_id
    INNER JOIN current_health ON current_medication.current_health_id = current_health.current_health_id
    INNER JOIN user ON current_health.user_id = user.user_id
    WHERE user.user_id = ?", ['i', $user_id]);

$current_medications = [];
while ($row = $current_medications_result->fetch_assoc()) {
    $current_medications[] = $row['medicine_name'];
}

$hereditary_result = fetchData($conn, "
SELECT disease.disease_name
    FROM disease
    INNER JOIN current_condition ON disease.disease_id = current_condition.disease_id
    INNER JOIN current_health ON current_condition.current_health_id = current_health.current_health_id
    INNER JOIN user ON current_health.user_id = user.user_id
    WHERE disease.disease_hereditary = 1 AND user.family_id = ?", ['i', $family_id]);

$hereditary_diseases =[];
while ($row = $hereditary_result->fetch_assoc()) {
    $hereditary_diseases[] = $row['disease_name']; 
}


// Close the connection
$conn->close();
?>

<!DOCTYPE html>
<head>
    <link href="https://fonts.googleapis.com/css2?family=Material+Icons+Sharp"
      rel="stylesheet">
   <link rel="stylesheet" href="style.css">
   <script src="start.js"></script>
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
                    <a href="index.php" class="btn-dashboard">
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
                        <h3>Name: <span id="person-name"><?php echo $user['user_name'];?></span><input type="text" id="edit-name" class="edit-field" style="display:none"></h3>
                        <h3>Age: <span id="person-age"><?php echo $user['user_age'];?></span><input type="number" id="edit-age" class="edit-field" style="display:none"></h3>
                        <h3>Birthday: <span id="birthday"><?php echo $user['user_birthday'];?></span><input type="date" id="edit-birthday" class="edit-field" style="display:none"></h3>
                        <h3>Address: <span id="address"><?php echo $user['user_address'];?></span><input type="text" id="edit-address" class="edit-field" style="display:none"></h3>
                        <h3>Phone Number: <span id="phone-number"><?php echo $user['user_phone'];?></span><input type="text" id="edit-phone" class="edit-field" style="display:none"></h3>
                        <h3>Email Address: <span id="email"><?php echo $user['user_email'];?></span><input type="email" id="edit-email" class="edit-field" style="display:none"></h3>
                        <h3>Occupation: <span id="occupation"><?php echo $user['user_occupation'];?></span><input type="text" id="edit-occupation" class="edit-field" style="display:none"></h3>
                        <h3>Ethnicity: <span id="ethnicity"><?php echo $user['user_ethnicity'];?></span><input type="text" id="edit-ethnicity" class="edit-field" style="display:none"></h3>
                        <h3>Family: <span id="family"><?php echo $family['family_name'];?></span><input type="text" id="edit-family" class="edit-field" style="display:none"></h3>
                        <button class="edit-btn" id="edit-personal" onclick="editPersonalDetails()">Edit</button>
                        <button class="edit-btn" id="save-personal" onclick="savePersonalDetails()" style="display:none">Save</button>
                    </div>
                
                    <!-- Medical Details Section -->
                    <div class="medical-details-card">

                        <!-- Medical details fields -->
                        <h3>Medical Conditions: 
                            <span id="person-medical-conditions">
                                <?php if (count($medical_conditions) > 0) {
                                    foreach ($medical_conditions as $condition) {
                                        echo $condition . ",";
                                    }
                                } else {
                                    echo "None";
                                }?>
                            </span>
                            <div style="display: grid; grid-template-columns: 80% 20%;">
                                <h3 id="edit-medical-conditions" class="edit-field" style="display:none"></h3>
                                <button id="edit-medical-conditions-btn" data-modal-target="#modal-medical-condition" style="display: none;">Edit</button>
                            </div>
                        </h3>
                        <h3>Mental Health History: 
                            <span id="person-mental-health-history">
                                <?php if (count($mental_illnesses) > 0) {
                                    foreach ($mental_illnesses as $mental) {
                                        echo $mental . ",";
                                    }
                                } else {
                                    echo "None";
                                }?></span>
                            <div style="display: grid; grid-template-columns: 80% 20%;">
                            <h3 id="edit-mental-health-history" class="edit-field" style="display:none"></h3>
                            <button id="edit-mental-health-history-btn" data-modal-target="#modal-mental-health-history" style="display: none;">Edit</button>
                            </div>
                        </h3>
                        <h3>Allergies: 
                            <span id="person-allergies">
                                <?php if (count($allergies) > 0) {
                                    foreach ($allergies as $allergy) {
                                        echo $allergy . ",";
                                     }
                                } else {
                                    echo "None";
                                }?>
                            </span>
                            <div style="display: grid; grid-template-columns: 80% 20%;">
                                <h3 id="edit-allergies" class="edit-field" style="display:none"></h3>
                                <button id="edit-allergies-btn" data-modal-target="#modal-allergies" style="display: none;">Edit</button>
                            </div>
                        </h3>
                        <h3>Vaccination: 
                            <span id="person-vaccination">
                            <?php if (count($vaccinations) > 0) {
                                    foreach ($vaccinations as $vaccination) {
                                        echo $vaccination . ",";
                                     }
                                } else {
                                    echo "None";
                                }?>
                            </span>
                            <div style="display: grid; grid-template-columns: 80% 20%;">
                            <h3 id="edit-vaccination" class="edit-field" style="display:none"></h3>
                            <button id="edit-vaccination-btn" data-modal-target="#modal-vaccination" style="display: none;">Edit</button>
                            </div>
                        </h3>
                        <h3>Habits: 
                            <span id="person-habits">
                                <?php if (count($habits_array) > 0) {
                                    foreach ($habits_array as $habit) {
                                        echo $habit . ",";
                                     }
                                } else {
                                    echo "None";
                                }?>
                            </span>
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
                            <span id="current-conditions">
                                <?php if (count($current_condition) > 0) {
                                    foreach ($current_condition as $condition) {
                                        echo $condition . ",";
                                    }
                                } else {
                                    echo "None";
                                }?>
                            </span>
                            <div style="display: grid; grid-template-columns: 80% 20%;">
                                <h3 id="edit-current-conditions" class="edit-field" style="display:none"></h3>
                                <button id="edit-current-conditions-btn" data-modal-target="#modal-current-condition" style="display: none;">Edit</button>
                            </div>
                        </h3>
                        <h3>Current Mental Health Conditions: 
                            <span id="current-mental-health">
                                <?php if (count($current_mental_illnesses) > 0) {
                                    foreach ($current_mental_illnesses as $mental) {
                                        echo $mental . ",";
                                    }
                                } else {
                                    echo "None";
                                }?>
                            </span>
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
                            <span id="person-medications">
                            <?php if (count($current_medications) > 0) {
                                    foreach ($current_medications as $medicine) {
                                        echo $medicine . ",";
                                    }
                                } else {
                                    echo "None";
                                }?>
                            </span>
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
                                <?php foreach ($disease_names as $disease): ?>
                                    <option value="<?php echo htmlspecialchars($disease); ?>"></option>
                                <?php endforeach; ?>
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
                            <tbody id="condition-list">
                            <?php foreach ($medical_conditions as $condition): ?>
                                <tr>
                                    <td><?php echo $condition; ?></td>
                                    <td><button class="delete-btn" onclick="removeCondition(this)">Delete</button></td>
                                </tr>
                            <?php endforeach; ?>
                            </tbody>
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
                <div class="health-warning">
                    <h2>Health Warning</h2>
                    <?php
                        if (!empty($hereditary_diseases)) {
                            // Loop through the hereditary diseases array and create a div for each disease
                            foreach ($hereditary_diseases as $disease) {
                                // Get the disease link
                                echo '<div class="hereditary warning">';
                                echo '    <div class="icon">';
                                echo '        <span class="material-icons-sharp">device_thermostat</span>';
                                echo '    </div>';
                                echo '    <div class="right">';
                                echo '        <div class="info">';
                                echo '            <h3>' . htmlspecialchars($disease) . '</h3>'; // Display disease name
                                // Automatically set the link using JavaScript in a script tag
                                echo '            <a id="whoLink_' . htmlspecialchars($disease) . '" class="primary" style="text-decoration: underline;" href="' . "javascript:void(0);" . '" target="_blank">Click for more info...</a>'; // Placeholder for the link
                                echo '            <script>';
                                echo '                document.getElementById("whoLink_' . htmlspecialchars($disease) . '").href = getDiseaseLink("' . addslashes(htmlspecialchars($disease)) . '");';
                                echo '            </script>';
                                echo '        </div>';
                                echo '        <h3 class="cause">Heredity</h3>';
                                echo '    </div>';
                                echo '</div>';
                            }
                            
                        } else {
                            // Optional: Handle the case where there are no hereditary diseases
                            echo '<div class="no-warning">';
                            echo '    <h2>No hereditary diseases reported.</h2>';
                            echo '</div>';
                        }

                        //Habits Disease
                        if (!empty($habits_diseases)) {
                            // Loop through the hereditary diseases array and create a div for each disease
                            foreach ($habits_diseases as $disease) {
                                // Get the disease link
                                echo '<div class="habits warning">';
                                echo '    <div class="icon">';
                                echo '        <span class="material-icons-sharp">device_thermostat</span>';
                                echo '    </div>';
                                echo '    <div class="right">';
                                echo '        <div class="info">';
                                echo '            <h3>' . htmlspecialchars($disease) . '</h3>'; // Display disease name
                                // Automatically set the link using JavaScript in a script tag
                                echo '            <a id="whoLink_' . htmlspecialchars($disease) . '" class="primary" style="text-decoration: underline;" href="' . "javascript:void(0);" . '" target="_blank">Click for more info...</a>'; // Placeholder for the link
                                echo '            <script>';
                                echo '                document.getElementById("whoLink_' . htmlspecialchars($disease) . '").href = getDiseaseLink("' . addslashes(htmlspecialchars($disease)) . '");';
                                echo '            </script>';
                                echo '        </div>';
                                echo '        <h3 class="cause">Habits</h3>';
                                echo '    </div>';
                                echo '</div>';
                            }
                           
                        } else {
                            // Optional: Handle the case where there are no hereditary diseases
                            echo '<div class="no-warning">';
                            echo '    <h2>No hereditary diseases reported.</h2>';
                            echo '</div>';
                        }
                    ?>

                </div>
            </div>
        </div>

        <script src="chart.js"></script>
        <script src="default.js"></script>
        
   
</body>
</html>