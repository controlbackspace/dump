<?php
session_start();
include 'connect.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    exit('Invalid request method.');
}

try {
    $conn->begin_transaction();

    // === STEP 1: Generate a new PersonalDataID === //
    function generateID($prefix, $length = 3) {
        return $prefix . str_pad(mt_rand(1, pow(10, $length) - 1), $length, '0', STR_PAD_LEFT);
    }

    $personalDataID = generateID("PD");
    $businessID = null;

    // === STEP 2: Get or Create Business Entry === //
    $businessName = $_POST['employer'];
    $officeAddress = $_POST['officeAddress'];
    $officeTel = $_POST['officeTel'];

    if (!empty($businessName) && !empty($officeAddress) && !empty($officeTel)) {
        // Check if business exists
        $stmt = $conn->prepare("SELECT BusinessID FROM business WHERE BusinessName = ? AND OfficeAddress = ? AND OfficeTelNum = ?");
        $stmt->bind_param("ssi", $businessName, $officeAddress, $officeTel);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($row = $result->fetch_assoc()) {
            $businessID = $row['BusinessID'];
        } else {
            // Create new BusinessID
            $businessID = generateID("B");
            $stmt = $conn->prepare("INSERT INTO business (BusinessID, BusinessName, OfficeAddress, OfficeTelNum) VALUES (?, ?, ?, ?)");
            $stmt->bind_param("sssi", $businessID, $businessName, $officeAddress, $officeTel);
            $stmt->execute();
        }
    }

    // === STEP 3: Insert into personaldata === //
    $stmt = $conn->prepare("INSERT INTO personaldata (
        PersonalDataID, Name, Birthday, TelNum, MobileNum, Citizenship, MaritalStatus, 
        JobTitle, IncomeSourceType, YearsWithEmployer, BusinessID, HomeAddress, 
        YearsAtAddress, BasisOfHomeOwnership, MonthlyPayment, 
        PreviousHomeAddress, YearsAtPrevHomeAddress, 
        ProvincialAddress, YearsAtProvincialAddress
    ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");

    $basisOfHomeOwnership = strtoupper(substr($_POST['homeOwnership'], 0, 1));
    $monthlyPayment = $_POST['monthlyPayment'] ?: 0;

    $stmt->bind_param("ssssssssisssisdsisi",
        $personalDataID,
        $_POST['fullName'],
        $_POST['birthDate'],
        $_POST['telephone'], // TelNum
        $_POST['telephone'], // MobileNum
        $_POST['citizenship'],
        $_POST['maritalStatus'],
        $_POST['jobTitle'],
        $_POST['incomeSource'],
        $_POST['yearsWithEmployer'],
        $businessID,
        $_POST['homeAddress'],
        $_POST['yearsAtAddress'],
        $basisOfHomeOwnership,
        $monthlyPayment,
        $_POST['previousAddress'],
        $_POST['yearsAtPreviousAddress'],
        $_POST['provincialAddress'],
        $_POST['yearsAtProvincialAddress']
    );

    $stmt->execute();

    $conn->commit();
    echo "✅ Application successfully submitted!";
} catch (Exception $e) {
    $conn->rollback();
    echo "❌ Application submission failed: " . $e->getMessage();
}
?>
