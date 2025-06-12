-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jun 11, 2025 at 07:07 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `autoloan_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `applicant`
--

CREATE TABLE `applicant` (
  `ApplicantID` char(4) NOT NULL,
  `PersonalDataID` char(5) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `applicant`
--

INSERT INTO `applicant` (`ApplicantID`, `PersonalDataID`) VALUES
('A001', 'PD001'),
('A002', 'PD003'),
('A003', 'PD005'),
('A004', 'PD007'),
('A005', 'PD009'),
('A006', 'PD010');

-- --------------------------------------------------------

--
-- Table structure for table `autoloan`
--

CREATE TABLE `autoloan` (
  `AutoLoanID` char(6) NOT NULL,
  `ApplicantID` char(4) NOT NULL,
  `CoMakerID` char(5) NOT NULL,
  `LoanType` char(11) NOT NULL,
  `PurposeOfUse` varchar(12) NOT NULL,
  `UnitModel` char(30) NOT NULL,
  `UnitModelYear` int(11) NOT NULL,
  `PrimaryUser` char(15) NOT NULL,
  `RelationshipToApplicant` char(15) NOT NULL,
  `PlaceOfUse` char(30) NOT NULL,
  `UnitPrice` decimal(10,2) NOT NULL,
  `DownPayment` int(11) NOT NULL,
  `LoanAmount` decimal(10,2) NOT NULL,
  `Terms` int(11) NOT NULL,
  `ApplicationStatus` enum('Approved','Pending','Rejected','') NOT NULL DEFAULT 'Pending',
  `ApplicationDate` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `autoloan`
--

INSERT INTO `autoloan` (`AutoLoanID`, `ApplicantID`, `CoMakerID`, `LoanType`, `PurposeOfUse`, `UnitModel`, `UnitModelYear`, `PrimaryUser`, `RelationshipToApplicant`, `PlaceOfUse`, `UnitPrice`, `DownPayment`, `LoanAmount`, `Terms`, `ApplicationStatus`, `ApplicationDate`) VALUES
('ATL001', 'A001', 'CM001', 'Brand new', 'Private', 'Honda Civic', 2023, 'Self', 'Self', 'Metro Manila', 730000.00, 25, 530000.00, 24, 'Approved', '2023-11-09 12:57:04'),
('ATL002', 'A002', 'CM002', 'Second hand', 'Business', 'Toyota Hilux', 2019, 'Self', 'Self', 'Rizal Province', 1000000.00, 20, 200000.00, 36, 'Rejected', '2023-12-25 18:57:12'),
('ATL003', 'A003', 'CM003', 'Brand New	', 'Private', 'Toyota Vios', 2024, 'Self	', 'Self	', 'Metro Manila', 850000.00, 20, 680000.00, 60, 'Approved', '2024-02-14 23:11:01'),
('ATL004', 'A004', 'CM004', 'Second Hand', 'Business	', 'Mitsubishi L300	', 2020, 'Brother', 'Sibling	', 'Metro Manila', 550000.00, 10, 495000.00, 48, 'Approved', '2024-11-17 16:21:04'),
('ATL005', 'A005', 'CM005', 'Brand New	', 'Private	', 'Honda Civic RS	', 2025, 'Self', 'Self', 'Makati City	', 1300000.00, 25, 975000.00, 72, 'Pending', '2025-01-07 17:45:21'),
('ATL006', 'A006', 'CM006', 'Brand New', 'Private', 'BYD E2', 2024, 'Self', 'Self', 'Marikina City', 970000.00, 20, 776000.00, 60, 'Pending', '2025-06-12 00:49:58');

-- --------------------------------------------------------

--
-- Table structure for table `business`
--

CREATE TABLE `business` (
  `BusinessID` char(4) NOT NULL,
  `BusinessName` varchar(30) NOT NULL,
  `OfficeAddress` varchar(255) NOT NULL,
  `OfficeTelNum` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `business`
--

INSERT INTO `business` (`BusinessID`, `BusinessName`, `OfficeAddress`, `OfficeTelNum`) VALUES
('B001', 'Metro Finance Group', '46 Tordesillas Street, Makati City', 898654341),
('B002', 'Sofi Café and Bakery', '23 Main Street, Quezon City', 85375463),
('B003', 'Alonzo Marketing Inc.', '19 Castro St., Taguig City', 88865432),
('B004', 'Vicente Consulting', '11 Quezon Ave., Pasig City', 86453210),
('B005', 'Prime Builders Inc.', '9th Ave, Bonifacio Global City, Taguig City', 88451234),
('B006', 'Pixel Nest Studio	', '22nd Floor, Orient Square Building, F. Ortigas Jr. Road, Ortigas Center, Pasig City', 88405566),
('B007', 'St. Luke\'s Medical Center', '279 E. Rodriguez Sr. Ave., Quezon City', 87230101),
('B008', 'Vista Mall Holdings', '36th Floor, Vista Hub, Mandaluyong City', 87799888);

-- --------------------------------------------------------

--
-- Table structure for table `comaker`
--

CREATE TABLE `comaker` (
  `CoMakerID` char(5) NOT NULL,
  `PersonalDataID` char(5) NOT NULL,
  `CoMakerRelationship` char(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `comaker`
--

INSERT INTO `comaker` (`CoMakerID`, `PersonalDataID`, `CoMakerRelationship`) VALUES
('CM001', 'PD002', 'Spouse'),
('CM002', 'PD004', 'Cousin'),
('CM003', 'PD006', 'Spouse'),
('CM004', 'PD008', 'Sibling'),
('CM005', 'PD010', 'Cousin'),
('CM006', 'PD011', 'Uncle');

-- --------------------------------------------------------

--
-- Table structure for table `existingloans`
--

CREATE TABLE `existingloans` (
  `ExistingLoansID` char(4) NOT NULL,
  `ApplicantID` char(4) NOT NULL,
  `FinancingInstitution` varchar(30) DEFAULT NULL,
  `MonthlyAmortization` decimal(10,2) DEFAULT NULL,
  `OriginalTerm` int(11) DEFAULT NULL,
  `RemainingTerm` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `existingloans`
--

INSERT INTO `existingloans` (`ExistingLoansID`, `ApplicantID`, `FinancingInstitution`, `MonthlyAmortization`, `OriginalTerm`, `RemainingTerm`) VALUES
('L001', 'A001', 'China Banking Corporation', 10000.00, 12, 6),
('L002', 'A001', 'BDO', 15000.00, 24, 12),
('L003', 'A001', 'Philippine National Bank', 20000.00, 20, 10),
('L004', 'A002', 'Union Bank', 11000.00, 15, 8),
('L005', 'A002', 'Philippine National Bank', 20000.00, 12, 4),
('L006', 'A003', 'BDO', 8500.00, 36, 12),
('L007', 'A003', 'China Banking Corporation', 12000.00, 24, 5),
('L008', 'A004', 'EastWest', 5700.00, 24, 6);

-- --------------------------------------------------------

--
-- Table structure for table `personaldata`
--

CREATE TABLE `personaldata` (
  `PersonalDataID` char(5) NOT NULL,
  `Name` varchar(50) NOT NULL,
  `Birthday` date NOT NULL,
  `TelNum` char(8) NOT NULL,
  `MobileNum` varchar(11) NOT NULL,
  `Citizenship` varchar(20) NOT NULL,
  `MaritalStatus` varchar(15) NOT NULL,
  `JobTitle` varchar(30) NOT NULL,
  `IncomeSourceType` varchar(12) NOT NULL,
  `YearsWithEmployer` int(11) NOT NULL,
  `BusinessID` char(5) NOT NULL,
  `HomeAddress` varchar(255) NOT NULL,
  `YearsAtAddress` int(11) NOT NULL,
  `BasisOfHomeOwnership` char(1) NOT NULL,
  `MonthlyPayment` decimal(10,2) NOT NULL,
  `PreviousHomeAddress` varchar(255) DEFAULT NULL,
  `YearsAtPrevHomeAddress` int(11) DEFAULT NULL,
  `ProvincialAddress` varchar(255) DEFAULT NULL,
  `YearsAtProvincialAddress` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `personaldata`
--

INSERT INTO `personaldata` (`PersonalDataID`, `Name`, `Birthday`, `TelNum`, `MobileNum`, `Citizenship`, `MaritalStatus`, `JobTitle`, `IncomeSourceType`, `YearsWithEmployer`, `BusinessID`, `HomeAddress`, `YearsAtAddress`, `BasisOfHomeOwnership`, `MonthlyPayment`, `PreviousHomeAddress`, `YearsAtPrevHomeAddress`, `ProvincialAddress`, `YearsAtProvincialAddress`) VALUES
('PD001', 'Miguel Ramirez Gonzales', '1986-10-07', '81237890', '09176547890', 'Filipino', 'Married', 'Financial Analyst', 'Employment', 5, 'B001', '56 Chester Street, Pasig City', 7, 'R', 23000.00, '88 Pine Drive, Manila City', 3, '123 Rizal St., Barangay San Isidro, Lipa City, Batangas', 5),
('PD002', 'Sofia Mendoza Gonzales', '1987-09-18', '84356723', '09182316547', 'Filipino', 'Married', 'Owner', 'Own Business', 5, 'B002', '56 Chester Street, Pasig City', 7, 'R', 23000.00, '88 Pine Drive, Manila City', 3, '123 Rizal St., Barangay San Isidro, Lipa City, Batangas', 5),
('PD003', 'Jasmine Torres Alonzo', '1990-11-15', '82256789', '09178765432', 'Filipino', 'Single', 'Marketing Manager', 'Own Business', 3, 'B003', '25 Maple Ave., Quezon City', 4, 'O', 0.00, '88 Rivera St., Makati City', 2, '9 P. Gomez St., Cavite', 6),
('PD004', 'Mark Vicente Torres', '1989-02-25', '83546720', '09184321098', 'Filipino', 'Married', 'Accountant', 'Own Business', 6, 'B004', '56 San Jose St., Makati City', 5, 'O', 0.00, '74 Aquino St., Quezon City', 3, '13 M. Dizon St., Bulacan', 8),
('PD005', 'Carlos Garcia Santiago', '1988-04-22', '86311234', '09171234567', 'Filipino', 'Married	', 'Civil Engineer	', 'Employment	', 5, 'B005', '23 Sampaguita St., Marikina City	', 3, 'O', 0.00, '45 Ilang-Ilang St., Makati City	', 3, '78 Mabini St., Tarlac City	', 5),
('PD006', 'Maria Ramos Santiago', '1990-10-14', '83625678', '09181234567', 'Filipino	', 'Married', 'Accountant', 'Employment', 6, 'B005', '23 Sampaguita St., Marikina City	', 3, 'O', 0.00, '12 Orchid Ave., Pasig City	', 3, '78 Mabini St., Tarlac City	', 5),
('PD007', 'Jasmine Tan Reyes', '1997-03-08', '85122233', '09193456789', 'Filipino', 'Single', 'Graphic Designer	', 'Employment', 2, 'B006', '15 Daisy St., Caloocan City	', 2, 'R', 5000.00, '90 Molave St., Quezon City	', 3, NULL, NULL),
('PD008', 'Micah Tan Reyes	', '1995-06-12', '85134455', '09203456789', 'Filipino', 'Single', 'Software Developer	', 'Employment	', 3, 'B001', '15 Daisy St., Caloocan City	', 2, 'R', 5000.00, '33 Jacinto St., Quezon City	', 2, NULL, NULL),
('PD009', 'Andrea Gomez Valdez', '1992-12-02', '87338899', '09301234567', 'Filipino', 'Single', 'Nurse', 'Employment', 4, 'B007', '78 Lilac St., San Juan City	', 2, 'O', 0.00, '21 Laurel St., Mandaluyong City	', 3, NULL, NULL),
('PD010', 'Marco Villanueva Dizon', '1993-09-27', '87331122', '09321234567', 'Filipino', 'Single', 'Sales Manager	', 'Employment', 6, 'B007', '78 Lilac St., San Juan City	', 2, 'O', 0.00, '35 Mabait St., Mandaluyong City	', 3, NULL, NULL),
('PD011', 'Leonardo Reyes Villanueva', '1992-04-10', '8829921', '09178892211', 'Filipino', 'Single', 'Marketing Specialist', 'Employment', 4, 'B006', '118 Gen. Luna St, Marikina City', 3, 'R', 8500.00, '30 JP Rizal, Makati City', 2, 'Sta. Maria, Bulacan', 5);

-- --------------------------------------------------------

--
-- Table structure for table `reference`
--

CREATE TABLE `reference` (
  `ReferenceID` char(5) NOT NULL,
  `ApplicantID` char(4) NOT NULL,
  `ReferenceName` varchar(30) NOT NULL,
  `ReferenceAddress` varchar(255) NOT NULL,
  `ReferenceTelNum` char(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `reference`
--

INSERT INTO `reference` (`ReferenceID`, `ApplicantID`, `ReferenceName`, `ReferenceAddress`, `ReferenceTelNum`) VALUES
('RF001', 'A001', 'Luis Herrera', '90 Orchard St., Taguig City', '09276789102'),
('RF002', 'A001', 'Elena Santos', '34 Palm St. Quezon City', '09197654321'),
('RF003', 'A001', 'Carlos Bautista', '12 Legazpi St., Makati City', '09158542273'),
('RF004', 'A002', 'Maria Flores', '12 Bayani St., Caloocan City', '09144567890'),
('RF005', 'A002', 'Antonio Reyes', '56 Roxas St., Manila City', '09172345678'),
('RF006', 'A003', 'Maria Santos	', '45 Zamora St, Caloocan City	', '09171234567'),
('RF007', 'A003', 'Joseph Dela Cruz	', '12 Bonifacio Ave, Pasig City	', '09284567890'),
('RF008', 'A004', 'Angela Ramos	', '234 Roosevelt Ave., San Francisco Del Monte, Quezon City', '09339876543'),
('RF009', 'A004', 'Carlo Mendoza	', '88 Aurora Blvd, San Juan City	', '09182223344'),
('RF010', 'A005', 'Katrina Velasquez	', '56 JP Rizal St, Makati City	', '09051112233'),
('RF011', 'A005', 'Brian Lopez	', '74 Magsaysay Ave, Manila	', '09168897766'),
('RF012', 'A005', 'Denise Cruz	', '21 Kalayaan Ave, Taguig City	', '09273345566'),
('RF013', 'A006', 'Maria Dela Cruz', '123 Mabini St, Caloocan City', '09171234567'),
('RF014', 'A006', 'Carlos Santos', '789 Bonifacio Ave, Quezon City', '09181234567'),
('RF015', 'A006', 'Jenica Ramos', '456 Rizal Ave, Manila', '09191234567');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `Id` int(11) NOT NULL,
  `firstName` varchar(50) NOT NULL,
  `lastName` varchar(50) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(50) NOT NULL,
  `is_admin` tinyint(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`Id`, `firstName`, `lastName`, `email`, `password`, `is_admin`) VALUES
(1, 'mingyu', 'kim', 'mingyu@gmail.com', 'e0f52c3e8da21017f40f7e8679d76f11', 0),
(2, 'jennie', 'kim', 'jennie@gmail.com', 'jennie', 0),
(3, 'SHOUMA KING', 'SORIANO', 'shoumasoriano@gmail.com', '202cb962ac59075b964b07152d234b70', 1);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `applicant`
--
ALTER TABLE `applicant`
  ADD PRIMARY KEY (`ApplicantID`),
  ADD KEY `PersonalDataID_idx` (`PersonalDataID`);

--
-- Indexes for table `autoloan`
--
ALTER TABLE `autoloan`
  ADD PRIMARY KEY (`AutoLoanID`),
  ADD KEY `ApplicantID_idx` (`ApplicantID`),
  ADD KEY `CoMakerID_idx` (`CoMakerID`);

--
-- Indexes for table `business`
--
ALTER TABLE `business`
  ADD PRIMARY KEY (`BusinessID`);

--
-- Indexes for table `comaker`
--
ALTER TABLE `comaker`
  ADD PRIMARY KEY (`CoMakerID`),
  ADD KEY `CPersonalDataID` (`PersonalDataID`);

--
-- Indexes for table `existingloans`
--
ALTER TABLE `existingloans`
  ADD PRIMARY KEY (`ExistingLoansID`),
  ADD KEY `EApplicantID_idx` (`ApplicantID`);

--
-- Indexes for table `personaldata`
--
ALTER TABLE `personaldata`
  ADD PRIMARY KEY (`PersonalDataID`),
  ADD KEY `BusinessID` (`BusinessID`);

--
-- Indexes for table `reference`
--
ALTER TABLE `reference`
  ADD PRIMARY KEY (`ReferenceID`),
  ADD KEY `RApplicantID_idx` (`ApplicantID`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`Id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `Id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `applicant`
--
ALTER TABLE `applicant`
  ADD CONSTRAINT `APersonalDataID` FOREIGN KEY (`PersonalDataID`) REFERENCES `personaldata` (`PersonalDataID`) ON UPDATE CASCADE;

--
-- Constraints for table `autoloan`
--
ALTER TABLE `autoloan`
  ADD CONSTRAINT `ApplicantID` FOREIGN KEY (`ApplicantID`) REFERENCES `applicant` (`ApplicantID`) ON UPDATE CASCADE,
  ADD CONSTRAINT `CoMakerID` FOREIGN KEY (`CoMakerID`) REFERENCES `comaker` (`CoMakerID`) ON UPDATE CASCADE;

--
-- Constraints for table `comaker`
--
ALTER TABLE `comaker`
  ADD CONSTRAINT `CPersonalDataID` FOREIGN KEY (`PersonalDataID`) REFERENCES `personaldata` (`PersonalDataID`) ON UPDATE CASCADE;

--
-- Constraints for table `existingloans`
--
ALTER TABLE `existingloans`
  ADD CONSTRAINT `EApplicantID` FOREIGN KEY (`ApplicantID`) REFERENCES `applicant` (`ApplicantID`) ON UPDATE CASCADE;

--
-- Constraints for table `personaldata`
--
ALTER TABLE `personaldata`
  ADD CONSTRAINT `BusinessID` FOREIGN KEY (`BusinessID`) REFERENCES `business` (`BusinessID`) ON UPDATE CASCADE;

--
-- Constraints for table `reference`
--
ALTER TABLE `reference`
  ADD CONSTRAINT `RApplicantID` FOREIGN KEY (`ApplicantID`) REFERENCES `applicant` (`ApplicantID`) ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
