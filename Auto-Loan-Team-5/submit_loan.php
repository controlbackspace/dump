<?php
session_start();
include 'connect.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    exit('Invalid request method.');
}

try {
    $conn->begin_transaction();

    // === Function to get next sequential ID (e.g., PD012, B007) === //
    function getNextID($conn, $table, $idColumn, $prefix, $padLength = 3) {
        $query = "SELECT MAX($idColumn) AS max_id FROM $table WHERE $idColumn LIKE ?";
        $likePattern = $prefix . '%';

        $stmt = $conn->prepare($query);
        $stmt->bind_param("s", $likePattern);
        $stmt->execute();
        $result = $stmt->get_result();
        $row = $result->fetch_assoc();

        if ($row && $row['max_id']) {
            $currentMax = (int)substr($row['max_id'], strlen($prefix));
            $next = $currentMax + 1;
        } else {
            $next = 1;
        }

        return $prefix . str_pad($next, $padLength, '0', STR_PAD_LEFT);
    }

    $personalDataID = getNextID($conn, "personaldata", "PersonalDataID", "PD", 3);
    $businessID = null;

    // === STEP 1: Get or Create Business Entry === //
    $businessName = $_POST['employer'];
    $officeAddress = $_POST['officeAddress'];
    $officeTel = $_POST['officeTel'];

    if (!empty($businessName) && !empty($officeAddress) && !empty($officeTel)) {
        $stmt = $conn->prepare("SELECT BusinessID FROM business WHERE BusinessName = ? AND OfficeAddress = ? AND OfficeTelNum = ?");
        $stmt->bind_param("ssi", $businessName, $officeAddress, $officeTel);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($row = $result->fetch_assoc()) {
            $businessID = $row['BusinessID'];
        } else {
            $businessID = getNextID($conn, "business", "BusinessID", "B", 3);
            $stmt = $conn->prepare("INSERT INTO business (BusinessID, BusinessName, OfficeAddress, OfficeTelNum) VALUES (?, ?, ?, ?)");
            $stmt->bind_param("sssi", $businessID, $businessName, $officeAddress, $officeTel);
            $stmt->execute();
        }
    }

    // === STEP 2: Insert into personaldata === //
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
