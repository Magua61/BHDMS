const sideMenu = document.querySelector("aside");
const menuBtn = document.querySelector("#menu-btn");
const closeBtn = document.querySelector("#close-btn");

// open sidebar
menuBtn.addEventListener('click', () =>{
    sideMenu.style.display = 'block';
})

// close sidebar
closeBtn.addEventListener('click', () =>{
    sideMenu.style.display = 'none';
})

document.querySelectorAll('.combo-box').forEach(select => {
    select.addEventListener('change', function() {
        const selectedValue = this.value;
        console.log('Selected option:', selectedValue);
        // Handle the option selection logic here
    });
});

function editPersonalDetails() {
    document.getElementById('edit-personal').style.display = 'none';
    document.getElementById('save-personal').style.display = 'inline';

    // Show input fields and hide text spans
    toggleEditMode('person-name', 'edit-name');
    toggleEditMode('person-age', 'edit-age');
    toggleEditMode('birthday', 'edit-birthday');
    toggleEditMode('address', 'edit-address');
    toggleEditMode('phone-number', 'edit-phone');
    toggleEditMode('email', 'edit-email');
    toggleEditMode('occupation', 'edit-occupation');
    toggleEditMode('ethnicity', 'edit-ethnicity');
    toggleEditMode('family', 'edit-family');
}

function savePersonalDetails() {
    document.getElementById('edit-personal').style.display = 'inline';
    document.getElementById('save-personal').style.display = 'none';

    // Save values and switch back to view mode
    toggleSaveMode('person-name', 'edit-name');
    toggleSaveMode('person-age', 'edit-age');
    toggleSaveMode('birthday', 'edit-birthday');
    toggleSaveMode('address', 'edit-address');
    toggleSaveMode('phone-number', 'edit-phone');
    toggleSaveMode('email', 'edit-email');
    toggleSaveMode('occupation', 'edit-occupation');
    toggleSaveMode('ethnicity', 'edit-ethnicity');
    toggleSaveMode('family', 'edit-family');
}

function editMedicalDetails() {
    document.getElementById('edit-medical-details').style.display = 'none'; // Correct ID
    document.getElementById('save-medical-details').style.display = 'inline';

    // Show textarea fields and hide text spans
    toggleEditModeMany('person-allergies', 'edit-allergies','edit-allergies-btn');
    toggleEditModeMany('person-vaccination', 'edit-vaccination', 'edit-vaccination-btn');
    toggleEditModeMany('person-mental-health-history', 'edit-mental-health-history', 'edit-mental-health-history-btn');
    toggleEditModeMany('person-medical-conditions', 'edit-medical-conditions','edit-medical-conditions-btn');
    toggleEditModeMany('person-habits', 'edit-habits','edit-habits-btn');
}

function saveMedicalDetails() {
    document.getElementById('edit-medical-details').style.display = 'inline'; // Correct ID
    document.getElementById('save-medical-details').style.display = 'none';

    // Save values and switch back to view mode
    toggleSaveModeMany('person-allergies', 'edit-allergies', 'edit-allergies-btn');
    toggleSaveModeMany('person-vaccination', 'edit-vaccination', 'edit-vaccination-btn');
    toggleSaveModeMany('person-mental-health-history', 'edit-mental-health-history', 'edit-mental-health-history-btn');
    toggleSaveModeMany('person-medical-conditions', 'edit-medical-conditions','edit-medical-conditions-btn');
    toggleSaveModeMany('person-habits', 'edit-habits','edit-habits-btn');
}


// Helper function to toggle between span and input/textarea for edit mode
function toggleEditMode(spanId, inputId) {
    document.getElementById(spanId).style.display = 'none';
    document.getElementById(inputId).style.display = 'inline';
    document.getElementById(inputId).value = document.getElementById(spanId).innerText;
}

// Helper function to save the value from input/textarea and switch back to view mode
function toggleSaveMode(spanId, inputId) {
    document.getElementById(spanId).style.display = 'inline';
    document.getElementById(inputId).style.display = 'none';
    document.getElementById(spanId).innerText = document.getElementById(inputId).value;
}

function toggleEditModeMany(spanId, inputId, editBtn) {
    document.getElementById(spanId).style.display = 'none';
    document.getElementById(inputId).style.display = 'inline';
    document.getElementById(editBtn).style.display='block';
    document.getElementById(inputId).innerText = document.getElementById(spanId).innerText;
}

function toggleSaveModeMany(spanId, inputId, editBtn) {
    document.getElementById(spanId).style.display = 'inline';
    document.getElementById(inputId).style.display = 'none';
    document.getElementById(editBtn).style.display='none';
    document.getElementById(spanId).innerText = document.getElementById(inputId).value;
}

function editCurrentHealthStatus() {
    document.getElementById('edit-current-health').style.display = 'none';
    document.getElementById('save-current-health').style.display = 'inline';

    toggleEditModeMany('current-conditions', 'edit-current-conditions','edit-current-conditions-btn');
    toggleEditModeMany('current-mental-health', 'edit-current-mental-health','edit-current-mental-health-btn');
    toggleEditMode('relevant-info', 'edit-relevant-info');
    toggleEditModeMany('person-medications', 'edit-medications','edit-medications-btn');
}

function saveCurrentHealthStatus() {
    document.getElementById('edit-current-health').style.display = 'inline';
    document.getElementById('save-current-health').style.display = 'none';

    toggleSaveModeMany('current-conditions', 'edit-current-conditions','edit-current-conditions-btn');
    toggleSaveModeMany('current-mental-health', 'edit-current-mental-health','edit-current-mental-health-btn');
    toggleSaveMode('relevant-info', 'edit-relevant-info');
    toggleSaveModeMany('person-medications', 'edit-medications', 'edit-medications-btn');
}
// fill table
/* Updates.forEach(update =>{
    const tr = document.createElement('tr');
    const trContent = ' <td>${update.Name}</td><td>${update.Address}</td><td>${update.Age}</td><td>${update.Sex}</td><td>${update.Room}</td><td class="${update.Status === 'Evacuated' ? 'success' : update.Status === 'Departed' ? 'danger' : 'primary'}">${update.Status}</td>';

    tr.innerHTML = trContent;
    document.querySelector('table tbody').appendChild(tr);
}) */

    var body = document.getElementsByTagName('body')[0];

const openModalButtons = document.querySelectorAll('[data-modal-target]');
const closeModalButtons = document.querySelectorAll('[data-close-button]');
const overlay = document.getElementById('overlay');

// Open modal when button is clicked
openModalButtons.forEach(button => {
    button.addEventListener('click', () => {
        const modal = document.querySelector(button.dataset.modalTarget);
        openModal(modal);
    });
});

// Close modal when overlay is clicked
overlay.addEventListener('click', () => {
    const modals = document.querySelectorAll('.modal.active');
    modals.forEach(modal => {
        closeModal(modal);
    });
});

// Close modal when close button is clicked
closeModalButtons.forEach(button => {
    button.addEventListener('click', () => {
        const modal = button.closest('.modal');
        closeModal(modal);
    });
});

// Open modal function
function openModal(modal) {
    if (modal == null) return;
    modal.classList.add('active');
    overlay.classList.add('active');
}

// Close modal function
function closeModal(modal) {
    if (modal == null) return;
    modal.classList.remove('active');
    overlay.classList.remove('active');
}

// Function to add a medical condition to the table
function addCondition() {
    const input = document.getElementById('medical-condition-input');
    const condition = input.value.trim();

    if (condition !== '') {
        const tableBody = document.getElementById('condition-list');

        // Create a new row for the condition
        const newRow = document.createElement('tr');

        // Create the first column for the condition
        const conditionCell = document.createElement('td');
        conditionCell.innerText = condition;

        // Create the second column for the delete button
        const actionCell = document.createElement('td');
        const deleteButton = document.createElement('button');
        deleteButton.innerText = 'Delete';
        deleteButton.classList.add('delete-btn');
        deleteButton.onclick = function () {
            tableBody.removeChild(newRow);
        };

        actionCell.appendChild(deleteButton);

        // Append the cells to the new row
        newRow.appendChild(conditionCell);
        newRow.appendChild(actionCell);

        // Append the new row to the table body
        tableBody.appendChild(newRow);

        // Clear the input field for the next condition
        input.value = '';
    } else {
        alert("Please enter a medical condition.");
    }
}

// Save function to store the conditions and close the modal
function saveMedicalConditions() {
    const conditions = [];
    const rows = document.querySelectorAll('#condition-list tr');
    console.log("condition saved");

    // Collect all conditions from the table
    rows.forEach(row => {
        const condition = row.cells[0].innerText;
        conditions.push(condition);
    });

    // Update the main field with the list of conditions
    document.getElementById('person-medical-conditions').value = conditions.join(', ');
    document.getElementById('edit-medical-conditions').innerText = conditions.join(', ');
    console.log(conditions.join(', '));

    // Close the modal after saving
    const modal = document.getElementById('modal-medical-condition'); // Reference your modal directly
    closeModal(modal);
}

function addCondition() {
    const input = document.getElementById('medical-condition-input');
    const condition = input.value.trim();

    if (condition !== '') {
        const tableBody = document.getElementById('condition-list');

        // Create a new row for the condition
        const newRow = document.createElement('tr');

        // Create the first column for the condition
        const conditionCell = document.createElement('td');
        conditionCell.innerText = condition;

        // Create the second column for the delete button
        const actionCell = document.createElement('td');
        const deleteButton = document.createElement('button');
        deleteButton.innerText = 'Delete';
        deleteButton.classList.add('delete-btn');
        deleteButton.onclick = function () {
            tableBody.removeChild(newRow);
        };

        actionCell.appendChild(deleteButton);

        // Append the cells to the new row
        newRow.appendChild(conditionCell);
        newRow.appendChild(actionCell);

        // Append the new row to the table body
        tableBody.appendChild(newRow);

        // Clear the input field for the next condition
        input.value = '';
    } else {
        alert("Please enter a medical condition.");
    }
}

// Save function to store the conditions and close the modal
function saveMedicalConditions() {
    const conditions = [];
    const rows = document.querySelectorAll('#condition-list tr');
    console.log("condition saved");

    // Collect all conditions from the table
    rows.forEach(row => {
        const condition = row.cells[0].innerText;
        conditions.push(condition);
    });

    // Update the main field with the list of conditions
    document.getElementById('person-medical-conditions').value = conditions.join(', ');
    document.getElementById('edit-medical-conditions').innerText = conditions.join(', ');
    console.log(conditions.join(', '));

    // Close the modal after saving
    const modal = document.getElementById('modal-medical-condition'); // Reference your modal directly
    closeModal(modal);
}

function addCurrentCondition() {
    const input = document.getElementById('current-medical-condition-input');
    const condition = input.value.trim();

    if (condition !== '') {
        const tableBody = document.getElementById('current-condition-list');

        // Create a new row for the condition
        const newRow = document.createElement('tr');

        // Create the first column for the condition
        const conditionCell = document.createElement('td');
        conditionCell.innerText = condition;

        // Create the second column for the delete button
        const actionCell = document.createElement('td');
        const deleteButton = document.createElement('button');
        deleteButton.innerText = 'Delete';
        deleteButton.classList.add('delete-btn');
        deleteButton.onclick = function () {
            tableBody.removeChild(newRow);
        };

        actionCell.appendChild(deleteButton);

        // Append the cells to the new row
        newRow.appendChild(conditionCell);
        newRow.appendChild(actionCell);

        // Append the new row to the table body
        tableBody.appendChild(newRow);

        // Clear the input field for the next condition
        input.value = '';
    } else {
        alert("Please enter a medical condition.");
    }
}

// Save function to store the conditions and close the modal
function saveCurrentMedicalConditions() {
    const conditions = [];
    const rows = document.querySelectorAll('#current-condition-list tr');
    console.log("condition saved");

    // Collect all conditions from the table
    rows.forEach(row => {
        const condition = row.cells[0].innerText;
        conditions.push(condition);
    });

    // Update the main field with the list of conditions
    document.getElementById('current-conditions').value = conditions.join(', ');
    document.getElementById('edit-current-conditions').innerText = conditions.join(', ');
    console.log(conditions.join(', '));

    // Close the modal after saving
    const modal = document.getElementById('modal-current-condition'); // Reference your modal directly
    closeModal(modal);
}



// Function to add a medical condition to the table
function addMentalCondition() {
    const input = document.getElementById('mental-condition-input');
    const condition = input.value.trim();

    if (condition !== '') {
        const tableBody = document.getElementById('mental-condition-list');

        // Create a new row for the condition
        const newRow = document.createElement('tr');

        // Create the first column for the condition
        const conditionCell = document.createElement('td');
        conditionCell.innerText = condition;

        // Create the second column for the delete button
        const actionCell = document.createElement('td');
        const deleteButton = document.createElement('button');
        deleteButton.innerText = 'Delete';
        deleteButton.classList.add('delete-btn');
        deleteButton.onclick = function () {
            tableBody.removeChild(newRow);
        };

        actionCell.appendChild(deleteButton);

        // Append the cells to the new row
        newRow.appendChild(conditionCell);
        newRow.appendChild(actionCell);

        // Append the new row to the table body
        tableBody.appendChild(newRow);

        // Clear the input field for the next condition
        input.value = '';
    } else {
        alert("Please enter a mental condition.");
    }
}

// Save function to store the conditions and close the modal
function saveMentalConditions() {
    const conditions = [];
    const rows = document.querySelectorAll('#mental-condition-list tr');
    console.log("condition saved");

    // Collect all conditions from the table
    rows.forEach(row => {
        const condition = row.cells[0].innerText;
        conditions.push(condition);
    });

    // Update the main field with the list of conditions
    document.getElementById('person-mental-health-history').value = conditions.join(', ');
    document.getElementById('edit-mental-health-history').innerText = conditions.join(', ');
    console.log(conditions.join(', '));

    // Close the modal after saving
    const modal = document.getElementById('modal-mental-health-history'); // Reference your modal directly
    closeModal(modal);
}

// Function to add a medical condition to the table
function addCurrentMentalCondition() {
    const input = document.getElementById('current-mental-condition-input');
    const condition = input.value.trim();

    if (condition !== '') {
        const tableBody = document.getElementById('current-mental-condition-list');

        // Create a new row for the condition
        const newRow = document.createElement('tr');

        // Create the first column for the condition
        const conditionCell = document.createElement('td');
        conditionCell.innerText = condition;

        // Create the second column for the delete button
        const actionCell = document.createElement('td');
        const deleteButton = document.createElement('button');
        deleteButton.innerText = 'Delete';
        deleteButton.classList.add('delete-btn');
        deleteButton.onclick = function () {
            tableBody.removeChild(newRow);
        };

        actionCell.appendChild(deleteButton);

        // Append the cells to the new row
        newRow.appendChild(conditionCell);
        newRow.appendChild(actionCell);

        // Append the new row to the table body
        tableBody.appendChild(newRow);

        // Clear the input field for the next condition
        input.value = '';
    } else {
        alert("Please enter a mental condition.");
    }
}

// Save function to store the conditions and close the modal
function saveCurrentMentalConditions() {
    const conditions = [];
    const rows = document.querySelectorAll('#current-mental-condition-list tr');
    console.log("condition saved");

    // Collect all conditions from the table
    rows.forEach(row => {
        const condition = row.cells[0].innerText;
        conditions.push(condition);
    });

    // Update the main field with the list of conditions
    document.getElementById('current-mental-health').value = conditions.join(', ');
    document.getElementById('edit-current-mental-health').innerText = conditions.join(', ');
    console.log(conditions.join(', '));

    // Close the modal after saving
    const modal = document.getElementById('modal-current-mental-health'); // Reference your modal directly
    closeModal(modal);
}

// Function to add a medical condition to the table
function addVaccination() {
    const input = document.getElementById('vaccination-input');
    const condition = input.value.trim();

    if (condition !== '') {
        const tableBody = document.getElementById('vaccination-list');

        // Create a new row for the condition
        const newRow = document.createElement('tr');

        // Create the first column for the condition
        const conditionCell = document.createElement('td');
        conditionCell.innerText = condition;

        // Create the second column for the delete button
        const actionCell = document.createElement('td');
        const deleteButton = document.createElement('button');
        deleteButton.innerText = 'Delete';
        deleteButton.classList.add('delete-btn');
        deleteButton.onclick = function () {
            tableBody.removeChild(newRow);
        };

        actionCell.appendChild(deleteButton);

        // Append the cells to the new row
        newRow.appendChild(conditionCell);
        newRow.appendChild(actionCell);

        // Append the new row to the table body
        tableBody.appendChild(newRow);

        // Clear the input field for the next condition
        input.value = '';
    } else {
        alert("Please enter a vaccine.");
    }
}

// Save function to store the conditions and close the modal
function saveVaccination() {
    const conditions = [];
    const rows = document.querySelectorAll('#vaccination-list tr');
    console.log("condition saved");

    // Collect all conditions from the table
    rows.forEach(row => {
        const condition = row.cells[0].innerText;
        conditions.push(condition);
    });

    // Update the main field with the list of conditions
    document.getElementById('person-vaccination').value = conditions.join(', ');
    document.getElementById('edit-vaccination').innerText = conditions.join(', ');
    console.log(conditions.join(', '));

    // Close the modal after saving
    const modal = document.getElementById('modal-vaccination'); // Reference your modal directly
    closeModal(modal);
}

function addAllergies() {
    const input = document.getElementById('allergies-input');
    const condition = input.value.trim();

    if (condition !== '') {
        const tableBody = document.getElementById('allergies-list');

        // Create a new row for the condition
        const newRow = document.createElement('tr');

        // Create the first column for the condition
        const conditionCell = document.createElement('td');
        conditionCell.innerText = condition;

        // Create the second column for the delete button
        const actionCell = document.createElement('td');
        const deleteButton = document.createElement('button');
        deleteButton.innerText = 'Delete';
        deleteButton.classList.add('delete-btn');
        deleteButton.onclick = function () {
            tableBody.removeChild(newRow);
        };

        actionCell.appendChild(deleteButton);

        // Append the cells to the new row
        newRow.appendChild(conditionCell);
        newRow.appendChild(actionCell);

        // Append the new row to the table body
        tableBody.appendChild(newRow);

        // Clear the input field for the next condition
        input.value = '';
    } else {
        alert("Please enter an allergy.");
    }
}

// Save function to store the conditions and close the modal
function saveAllergies() {
    const conditions = [];
    const rows = document.querySelectorAll('#allergies-list tr');
    console.log("condition saved");

    // Collect all conditions from the table
    rows.forEach(row => {
        const condition = row.cells[0].innerText;
        conditions.push(condition);
    });

    // Update the main field with the list of conditions
    document.getElementById('person-allergies').value = conditions.join(', ');
    document.getElementById('edit-allergies').innerText = conditions.join(', ');
    console.log(conditions.join(', '));

    // Close the modal after saving
    const modal = document.getElementById('modal-allergies'); // Reference your modal directly
    closeModal(modal);
}

function addAllergies() {
    const input = document.getElementById('allergies-input');
    const condition = input.value.trim();

    if (condition !== '') {
        const tableBody = document.getElementById('allergies-list');

        // Create a new row for the condition
        const newRow = document.createElement('tr');

        // Create the first column for the condition
        const conditionCell = document.createElement('td');
        conditionCell.innerText = condition;

        // Create the second column for the delete button
        const actionCell = document.createElement('td');
        const deleteButton = document.createElement('button');
        deleteButton.innerText = 'Delete';
        deleteButton.classList.add('delete-btn');
        deleteButton.onclick = function () {
            tableBody.removeChild(newRow);
        };

        actionCell.appendChild(deleteButton);

        // Append the cells to the new row
        newRow.appendChild(conditionCell);
        newRow.appendChild(actionCell);

        // Append the new row to the table body
        tableBody.appendChild(newRow);

        // Clear the input field for the next condition
        input.value = '';
    } else {
        alert("Please enter an allergy.");
    }
}

// Save function to store the conditions and close the modal
function saveAllergies() {
    const conditions = [];
    const rows = document.querySelectorAll('#allergies-list tr');
    console.log("condition saved");

    // Collect all conditions from the table
    rows.forEach(row => {
        const condition = row.cells[0].innerText;
        conditions.push(condition);
    });

    // Update the main field with the list of conditions
    document.getElementById('person-allergies').value = conditions.join(', ');
    document.getElementById('edit-allergies').innerText = conditions.join(', ');
    console.log(conditions.join(', '));

    // Close the modal after saving
    const modal = document.getElementById('modal-allergies'); // Reference your modal directly
    closeModal(modal);
}

function addMedications() {
    const input = document.getElementById('medications-input');
    const condition = input.value.trim();

    if (condition !== '') {
        const tableBody = document.getElementById('medications-list');

        // Create a new row for the condition
        const newRow = document.createElement('tr');

        // Create the first column for the condition
        const conditionCell = document.createElement('td');
        conditionCell.innerText = condition;

        // Create the second column for the delete button
        const actionCell = document.createElement('td');
        const deleteButton = document.createElement('button');
        deleteButton.innerText = 'Delete';
        deleteButton.classList.add('delete-btn');
        deleteButton.onclick = function () {
            tableBody.removeChild(newRow);
        };

        actionCell.appendChild(deleteButton);

        // Append the cells to the new row
        newRow.appendChild(conditionCell);
        newRow.appendChild(actionCell);

        // Append the new row to the table body
        tableBody.appendChild(newRow);

        // Clear the input field for the next condition
        input.value = '';
    } else {
        alert("Please enter a medication.");
    }
}

// Save function to store the conditions and close the modal
function saveMedications() {
    const conditions = [];
    const rows = document.querySelectorAll('#medications-list tr');
    console.log("condition saved");

    // Collect all conditions from the table
    rows.forEach(row => {
        const condition = row.cells[0].innerText;
        conditions.push(condition);
    });

    // Update the main field with the list of conditions
    document.getElementById('person-medications').value = conditions.join(', ');
    document.getElementById('edit-medications').innerText = conditions.join(', ');
    console.log(conditions.join(', '));

    // Close the modal after saving
    const modal = document.getElementById('modal-medications'); // Reference your modal directly
    closeModal(modal);
}

function addHabits() {
    const input = document.getElementById('habits-input');
    const condition = input.value.trim();

    if (condition !== '') {
        const tableBody = document.getElementById('habits-list');

        // Create a new row for the condition
        const newRow = document.createElement('tr');

        // Create the first column for the condition
        const conditionCell = document.createElement('td');
        conditionCell.innerText = condition;

        // Create the second column for the delete button
        const actionCell = document.createElement('td');
        const deleteButton = document.createElement('button');
        deleteButton.innerText = 'Delete';
        deleteButton.classList.add('delete-btn');
        deleteButton.onclick = function () {
            tableBody.removeChild(newRow);
        };

        actionCell.appendChild(deleteButton);

        // Append the cells to the new row
        newRow.appendChild(conditionCell);
        newRow.appendChild(actionCell);

        // Append the new row to the table body
        tableBody.appendChild(newRow);

        // Clear the input field for the next condition
        input.value = '';
    } else {
        alert("Please enter a medication.");
    }
}

// Save function to store the conditions and close the modal
function saveHabits() {
    const conditions = [];
    const rows = document.querySelectorAll('#habits-list tr');
    console.log("condition saved");

    // Collect all conditions from the table
    rows.forEach(row => {
        const condition = row.cells[0].innerText;
        conditions.push(condition);
    });

    // Update the main field with the list of conditions
    document.getElementById('person-habits').value = conditions.join(', ');
    document.getElementById('edit-habits').innerText = conditions.join(', ');
    console.log(conditions.join(', '));

    // Close the modal after saving
    const modal = document.getElementById('modal-habits'); // Reference your modal directly
    closeModal(modal);
}