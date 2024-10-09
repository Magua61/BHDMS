<?php
include 'db_connection.php';

// fetch FAMILY data  
$familysql = "select * from family"; 
$familyresult = ($conn->query($familysql)); 
$familydata = [];  

if ($familyresult->num_rows > 0)  
{ 
    $familydata = $familyresult->fetch_all(MYSQLI_ASSOC);   
}

// fetch VACCINE data
$diseasesql = "select * from disease"; 
$diseaseresult = ($conn->query($diseasesql)); 
$diseasedata = [];  

if ($diseaseresult->num_rows > 0)  
{ 
    $diseasedata = $diseaseresult->fetch_all(MYSQLI_ASSOC);   
}    

// fetch VACCINE data
$vaccinesql = "select * from vaccine"; 
$vaccineresult = ($conn->query($vaccinesql)); 
$vaccinedata = [];  

if ($vaccineresult->num_rows > 0)  
{ 
    $vaccinedata = $vaccineresult->fetch_all(MYSQLI_ASSOC);   
}

// fetch CURRENT data
$currentsql = "select * from disease"; 
$currentresult = ($conn->query($currentsql)); 
$currentdata = [];  

if ($currentresult->num_rows > 0)  
{ 
    $currentdata = $currentresult->fetch_all(MYSQLI_ASSOC);   
}    

// fetch MEDICATION data
$medicinesql = "select * from medicine"; 
$medicineresult = ($conn->query($medicinesql)); 
$medicinedata = [];  

if ($medicineresult->num_rows > 0)  
{ 
    $medicinedata = $medicineresult->fetch_all(MYSQLI_ASSOC);   
}    

// fetch ALLERGY data
$allergysql = "select * from allergy"; 
$allergyresult = ($conn->query($allergysql)); 
$allergydata = [];  

if ($allergyresult->num_rows > 0)  
{ 
    $allergydata = $allergyresult->fetch_all(MYSQLI_ASSOC);   
}

// fetch MEDICATION data
$mentalsql = "select * from mental_illness"; 
$mentalresult = ($conn->query($mentalsql)); 
$mentaldata = [];  

if ($mentalresult->num_rows > 0)  
{ 
    $mentaldata = $mentalresult->fetch_all(MYSQLI_ASSOC);   
}    
?>