<?php
session_start();
include 'connect.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    exit('Invalid request method.');
}

try {
    $conn->begin_transaction();

    // === FUNCTION TO GET OR CREATE BUSINESS === //
    function getOrCreateBusiness($conn, $businessName, $officeAddress, $officeTel) {
        if (empty($businessName) || empty($officeAddress) || empty($officeTel)) {
            return null;
        }
        
        // Check if this business already exists
        $stmt = $conn->prepare("SELECT BusinessID FROM business WHERE BusinessName = ? AND OfficeAddress = ? AND OfficeTelNum = ?");
        $stmt->bind_param("sss", $businessName, $officeAddress, $officeTel);
        $stmt->execute();
        $result = $stmt->get_result();
        $businessRow = $result->fetch_assoc();
        $stmt->close();

        if ($businessRow) {
            return $businessRow['BusinessID'];
        } else {
            $stmt = $conn->prepare("INSERT INTO business (BusinessName, OfficeAddress, OfficeTelNum) VALUES (?, ?, ?)");
            $stmt->bind_param("sss", $businessName, $officeAddress, $officeTel);
            $stmt->execute();
            $businessID = $stmt->insert_id;
            $stmt->close();
            return $businessID;
        }
    }

    // === STAGE 1: APPLICANT'S BUSINESS === //
    $employer = trim($_POST['employer'] ?? '');
    $officeAddress = trim($_POST['officeAddress'] ?? '');
    $officeTel = trim($_POST['officeTel'] ?? '');

    // Debug if missing
    if (empty($employer) || empty($officeAddress) || empty($officeTel)) {
        throw new Exception("Missing business fields — employer: [$employer], address: [$officeAddress], tel: [$officeTel]");
    }


    $businessID = getOrCreateBusiness($conn, $employer, $officeAddress, $officeTel);

    // === PERSONAL DATA === //
    $fullName = $_POST['fullName'];
    $birthDate = $_POST['birthDate'];
    $telephone = $_POST['telephone'];
    $mobile = $_POST['mobile'] ?? null;
    $citizenship = $_POST['citizenship'];
    $maritalStatus = $_POST['maritalStatus'];
    $jobTitle = $_POST['jobTitle'];
    $incomeSource = $_POST['incomeSource'];
    $yearsWithEmployer = $_POST['yearsWithEmployer'];

    $homeAddress = $_POST['homeAddress'];
    $yearsAtAddress = $_POST['yearsAtAddress'];
    $homeOwnership = $_POST['homeOwnership'];
    $monthlyPayment = $_POST['monthlyPayment'] ?? 0;
    $previousAddress = $_POST['previousAddress'] ?? '';
    $yearsAtPrev = $_POST['yearsAtPreviousAddress'] ?? 0;
    $provincialAddress = $_POST['provincialAddress'] ?? '';
    $yearsAtProv = $_POST['yearsAtProvincialAddress'] ?? 0;

    // Insert personal data with BusinessID (always required for applicant)
    if (!$businessID) {
        throw new Exception("Business information is required for the applicant.");
    }

    $stmt = $conn->prepare("INSERT INTO personaldata (
        Name, Birthday, TelNum, MobileNum, Citizenship, MaritalStatus,
        JobTitle, IncomeSourceType, YearsWithEmployer, BusinessID,
        HomeAddress, YearsAtAddress, BasisOfHomeOwnership, MonthlyPayment,
        PreviousHomeAddress, YearsAtPrevHomeAddress, ProvincialAddress, YearsAtProvincialAddress
    ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");

    $stmt->bind_param(
    "ssssssssisssdsissi",
    $fullName, $birthDate, $telephone, $mobile, $citizenship, $maritalStatus,
    $jobTitle, $incomeSource, $yearsWithEmployer, $businessID,
    $homeAddress, $yearsAtAddress, $homeOwnership, $monthlyPayment,
    $previousAddress, $yearsAtPrev, $provincialAddress, $yearsAtProv
    );

    $stmt->execute();

    if ($stmt->affected_rows === 0) {
        throw new Exception("Failed to insert personal data.");
    }

    $personalDataID = $conn->insert_id;
    $stmt->close();

    // === APPLICANT === //
    $stmt = $conn->prepare("INSERT INTO applicant (PersonalDataID) VALUES (?)");
    $stmt->bind_param("i", $personalDataID);
    $stmt->execute();
    $applicantID = $conn->insert_id;
    $stmt->close();

    // === COMAKER/SPOUSE BUSINESS === //
    $spouseEmployer = $_POST['spouseEmployer'] ?? '';
    $spouseOfficeAddress = $_POST['spouseOfficeAddress'] ?? '';
    $spouseOfficeTel = $_POST['spouseOfficeTel'] ?? '';
    
    $spouseBusinessID = getOrCreateBusiness($conn, $spouseEmployer, $spouseOfficeAddress, $spouseOfficeTel);

    // === COMAKER === //
    $spouseName = $_POST['spouseName'];
    $spouseRelationship = $_POST['spouseRelationship'];
    $spouseJobTitle = $_POST['spouseJobTitle'] ?? '';
    $spouseIncomeSource = $_POST['spouseIncomeSource'] ?? '';
    $spouseYearsWithEmployer = $_POST['spouseYearsWithEmployer'] ?? 0;

    // Insert comaker personal data with proper BusinessID handling
    if ($spouseBusinessID) {
        $stmt = $conn->prepare("INSERT INTO personaldata (
            Name, JobTitle, IncomeSourceType, YearsWithEmployer, BusinessID
        ) VALUES (?, ?, ?, ?, ?)");
        $stmt->bind_param("sssii", $spouseName, $spouseJobTitle, $spouseIncomeSource, $spouseYearsWithEmployer, $spouseBusinessID);
    } else {
        // Insert without BusinessID if no business information provided
        $stmt = $conn->prepare("INSERT INTO personaldata (
            Name, JobTitle, IncomeSourceType, YearsWithEmployer
        ) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("sssi", $spouseName, $spouseJobTitle, $spouseIncomeSource, $spouseYearsWithEmployer);
    }
    
    $stmt->execute();
    
    if ($stmt->affected_rows === 0) {
        throw new Exception("Failed to insert comaker personal data.");
    }
    
    $comakerPersonalDataID = $conn->insert_id;
    $stmt->close();

    $stmt = $conn->prepare("INSERT INTO comaker (PersonalDataID, CoMakerRelationship) VALUES (?, ?)");
    $stmt->bind_param("is", $comakerPersonalDataID, $spouseRelationship);
    $stmt->execute();
    $coMakerID = $conn->insert_id;
    $stmt->close();

    // === AUTOLOAN === //
    $loanType = $_POST['loanType'];
    $purposeUse = $_POST['purposeUse'];
    $unitModel = $_POST['unitModel'];
    $unitModelYear = date('Y');
    $primaryUser = $_POST['primaryUser'];
    $relationshipToApplicant = $_POST['relationshipToApplicant'];
    $placeUse = $_POST['placeUse'];
    $unitPrice = $_POST['unitPrice'];
    $downpayment = $_POST['downpayment'];
    $loanAmount = $_POST['loanAmount'];
    $term = $_POST['term'];

    $stmt = $conn->prepare("INSERT INTO autoloan (
        ApplicantID, CoMakerID, LoanType, PurposeOfUse, UnitModel, UnitModelYear,
        PrimaryUser, RelationshipToApplicant, PlaceOfUse, UnitPrice,
        DownPayment, LoanAmount, Terms
    ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");

    $stmt->bind_param(
        "iisssisssdddi",
        $applicantID, $coMakerID, $loanType, $purposeUse, $unitModel, $unitModelYear,
        $primaryUser, $relationshipToApplicant, $placeUse, $unitPrice,
        $downpayment, $loanAmount, $term
    );
    $stmt->execute();
    $stmt->close();

    // === EXISTING LOANS === //
    if (!empty($_POST['loanInstitution'])) {
        $loanInstitutions = $_POST['loanInstitution'];
        $monthlyAmortizations = $_POST['monthlyAmortization'];
        $originalTerms = $_POST['originalTerm'];
        $remainingTerms = $_POST['remainingTerm'];

        $stmt = $conn->prepare("INSERT INTO existingloans (
            ApplicantID, FinancingInstitution, MonthlyAmortization, OriginalTerm, RemainingTerm
        ) VALUES (?, ?, ?, ?, ?)");

        for ($i = 0; $i < count($loanInstitutions); $i++) {
            $stmt->bind_param("isdii", $applicantID, $loanInstitutions[$i], $monthlyAmortizations[$i], $originalTerms[$i], $remainingTerms[$i]);
            $stmt->execute();
        }
        $stmt->close();
    }

    // === REFERENCES === //
    if (!empty($_POST['refName'])) {
        $refNames = $_POST['refName'];
        $refAddresses = $_POST['refAddress'];
        $refPhones = $_POST['refPhone'];

        $stmt = $conn->prepare("INSERT INTO reference (ApplicantID, ReferenceName, ReferenceAddress, ReferenceTelNum) VALUES (?, ?, ?, ?)");

        for ($i = 0; $i < count($refNames); $i++) {
            $stmt->bind_param("isss", $applicantID, $refNames[$i], $refAddresses[$i], $refPhones[$i]);
            $stmt->execute();
        }
        $stmt->close();
    }

    $conn->commit();
    header("Location: thank-you.php");
    exit();

} catch (Exception $e) {
    $conn->rollback();
    echo "❌ Transaction failed: " . $e->getMessage();
    // Add some debugging info
    echo "<br>Last error: " . $conn->error;
}
?>