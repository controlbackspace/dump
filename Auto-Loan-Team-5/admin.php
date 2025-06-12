<?php
session_start();
include 'connect.php';

// Check if user is logged in and is admin
if (!isset($_SESSION['email']) || !isset($_SESSION['is_admin']) || $_SESSION['is_admin'] != 1) {
    header("Location: index.php");
    exit();
}

// Get all users
$sql = "SELECT * FROM users";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CarPlayLater Admin Dashboard</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css">
    <link rel="stylesheet" href="styles/admin.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
</head>
<body>
    <!-- Top Navigation -->
    <nav class="navbar">
        <div class="nav-container">
            <div class="logo">
                <img src="placeholder-logo.png" alt="CarPlayLater Logo">
            </div>
            <div class="nav-links">
                <a href="#dashboard" class="active"><i class="fas fa-chart-line"></i> Dashboard</a>
                <a href="#applicants"><i class="fas fa-users"></i> Applicants</a>
                <a href="#loans"><i class="fas fa-file-invoice-dollar"></i> Loan Applications</a>
                <a href="#settings"><i class="fas fa-cog"></i> Settings</a>
            </div>
            <div class="profile-dropdown">
                <button class="profile-btn">
                    <i class="fas fa-user-circle"></i>
                    <span>Admin</span>
                    <i class="fas fa-chevron-down"></i>
                </button>
                <div class="dropdown-content">
                    <a href="landing.php"><i class="fas fa-home"></i> User View</a>
                    <a href="#settings"><i class="fas fa-cog"></i> Settings</a>
                    <a href="#" onclick="handleLogout()"><i class="fas fa-sign-out-alt"></i> Logout</a>
                </div>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <main class="main-content">
        <!-- Welcome Section -->
        <section class="welcome-section">
            <h1>Welcome back, Admin!</h1>
            <p>Here's what's happening with your loan applications today.</p>
        </section>

        <!-- Statistics Cards -->
        <section class="stats-grid">
            <div class="stat-card">
                <div class="stat-icon">
                    <i class="fas fa-users"></i>
                </div>
                <div class="stat-info">
                    <h3>Total Applicants</h3>
                    <p class="stat-number">1,234</p>
                    <p class="stat-change positive">+12% from last month</p>
                </div>
            </div>
            <div class="stat-card">
                <div class="stat-icon">
                    <i class="fas fa-file-invoice-dollar"></i>
                </div>
                <div class="stat-info">
                    <h3>Active Loans</h3>
                    <p class="stat-number">856</p>
                    <p class="stat-change positive">+5% from last month</p>
                </div>
            </div>
            <div class="stat-card">
                <div class="stat-icon">
                    <i class="fas fa-clock"></i>
                </div>
                <div class="stat-info">
                    <h3>Pending Applications</h3>
                    <p class="stat-number">45</p>
                    <p class="stat-change negative">-8% from last month</p>
                </div>
            </div>
            <div class="stat-card">
                <div class="stat-icon">
                    <i class="fas fa-check-circle"></i>
                </div>
                <div class="stat-info">
                    <h3>Approval Rate</h3>
                    <p class="stat-number">92%</p>
                    <p class="stat-change positive">+2% from last month</p>
                </div>
            </div>
        </section>

        <!-- Main Dashboard Sections -->
        <div class="dashboard-grid">
            <!-- User Management Section -->
            <section class="dashboard-section" id="users">
                <div class="section-header">
                    <h2>User Management</h2>
                </div>
                <div class="table-container">
                    <table class="data-table">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>First Name</th>
                                <th>Last Name</th>
                                <th>Email</th>
                                <th>Admin Status</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            if ($result->num_rows > 0) {
                                while($row = $result->fetch_assoc()) {
                                    echo "<tr>";
                                    echo "<td>" . $row['Id'] . "</td>";
                                    echo "<td>" . $row['firstName'] . "</td>";
                                    echo "<td>" . $row['lastName'] . "</td>";
                                    echo "<td>" . $row['email'] . "</td>";
                                    echo "<td>" . ($row['is_admin'] ? 'Yes' : 'No') . "</td>";
                                    echo "<td>
                                            <button class='btn-icon' onclick='toggleAdmin(" . $row['Id'] . ", " . $row['is_admin'] . ")'><i class='fas fa-user-shield'></i></button>
                                            <button class='btn-icon' onclick='deleteUser(" . $row['Id'] . ")'><i class='fas fa-trash'></i></button>
                                          </td>";
                                    echo "</tr>";
                                }
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
            </section>

            <!-- Applicant Management -->
            <section class="dashboard-section" id="applicants">
                <div class="section-header">
                    <h2>Applicant Management</h2>
                    <button class="btn-primary"><i class="fas fa-plus"></i> Add New Applicant</button>
                </div>
                <div class="table-container">
                    <table class="data-table">
                        <thead>
                            <tr>
                                <th>Applicant ID</th>
                                <th>Name</th>
                                <th>Role</th>
                                <th>Status</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>A001</td>
                                <td>Jake Lamac</td>
                                <td>Applicant</td>
                                <td><span class="status-badge active">Active</span></td>
                                <td>
                                    <button class="btn-icon"><i class="fas fa-edit"></i></button>
                                    <button class="btn-icon"><i class="fas fa-trash"></i></button>
                                </td>
                            </tr>
                            <tr>
                                <td>A002</td>
                                <td>Bien Dela Paz</td>
                                <td>Applicant</td>
                                <td><span class="status-badge active">Active</span></td>
                                <td>
                                    <button class="btn-icon"><i class="fas fa-edit"></i></button>
                                    <button class="btn-icon"><i class="fas fa-trash"></i></button>
                                </td>
                            </tr>
                            <tr>
                                <td>A003</td>
                                <td>Ethan Loanzon</td>
                                <td>Applicant</td>
                                <td><span class="status-badge active">Active</span></td>
                                <td>
                                    <button class="btn-icon"><i class="fas fa-edit"></i></button>
                                    <button class="btn-icon"><i class="fas fa-trash"></i></button>
                                </td>
                            </tr>
                            <tr>
                                <td>A004</td>
                                <td>Charis Dela Cruz</td>
                                <td>Applicant</td>
                                <td><span class="status-badge active">Active</span></td>
                                <td>
                                    <button class="btn-icon"><i class="fas fa-edit"></i></button>
                                    <button class="btn-icon"><i class="fas fa-trash"></i></button>
                                </td>
                            </tr>
                            <tr>
                                <td>A005</td>
                                <td>Shouma Soriano</td>
                                <td>Applicant</td>
                                <td><span class="status-badge active">Active</span></td>
                                <td>
                                    <button class="btn-icon"><i class="fas fa-edit"></i></button>
                                    <button class="btn-icon"><i class="fas fa-trash"></i></button>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </section>

            <!-- Loan Applications -->
            <section class="dashboard-section" id="loans">
                <div class="section-header">
                    <h2>Loan Applications</h2>
                    <div class="filter-group">
                        <select class="filter-select">
                            <option value="all">All Status</option>
                            <option value="pending">Pending</option>
                            <option value="approved">Approved</option>
                            <option value="rejected">Rejected</option>
                        </select>
                    </div>
                </div>
                <div class="table-container">
                    <table class="data-table">
                        <thead>
                            <tr>
                                <th>AutoLoanID</th>
                                <th>Applicant</th>
                                <th>Amount</th>
                                <th>Term</th>
                                <th>Status</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>ATL001</td>
                                <td>Jake Lamac</td>
                                <td>₱750,000</td>
                                <td>36 months</td>
                                <td><span class="status-badge pending">Pending</span></td>
                                <td>
                                    <button class="btn-preview" onclick="showLoanApplicationDetails('ATL001')"><i class="fas fa-eye"></i> Preview</button>
                                    <button class="btn-icon"><i class="fas fa-check"></i></button>
                                    <button class="btn-icon"><i class="fas fa-times"></i></button>
                                </td>
                            </tr>
                            <tr>
                                <td>ATL002</td>
                                <td>Bien Dela Paz</td>
                                <td>₱850,000</td>
                                <td>48 months</td>
                                <td><span class="status-badge active">Approved</span></td>
                                <td>
                                    <button class="btn-preview" onclick="showLoanApplicationDetails('ATL002')"><i class="fas fa-eye"></i> Preview</button>
                                    <button class="btn-icon"><i class="fas fa-check"></i></button>
                                    <button class="btn-icon"><i class="fas fa-times"></i></button>
                                </td>
                            </tr>
                            <tr>
                                <td>ATL003</td>
                                <td>Ethan Loanzon</td>
                                <td>₱650,000</td>
                                <td>24 months</td>
                                <td><span class="status-badge pending">Pending</span></td>
                                <td>
                                    <button class="btn-preview" onclick="showLoanApplicationDetails('ATL003')"><i class="fas fa-eye"></i> Preview</button>
                                    <button class="btn-icon"><i class="fas fa-check"></i></button>
                                    <button class="btn-icon"><i class="fas fa-times"></i></button>
                                </td>
                            </tr>
                            <tr>
                                <td>ATL004</td>
                                <td>Charis Dela Cruz</td>
                                <td>₱900,000</td>
                                <td>60 months</td>
                                <td><span class="status-badge active">Approved</span></td>
                                <td>
                                    <button class="btn-preview" onclick="showLoanApplicationDetails('ATL004')"><i class="fas fa-eye"></i> Preview</button>
                                    <button class="btn-icon"><i class="fas fa-check"></i></button>
                                    <button class="btn-icon"><i class="fas fa-times"></i></button>
                                </td>
                            </tr>
                            <tr>
                                <td>ATL005</td>
                                <td>Shouma Soriano</td>
                                <td>₱800,000</td>
                                <td>36 months</td>
                                <td><span class="status-badge pending">Pending</span></td>
                                <td>
                                    <button class="btn-preview" onclick="showLoanApplicationDetails('ATL005')"><i class="fas fa-eye"></i> Preview</button>
                                    <button class="btn-icon"><i class="fas fa-check"></i></button>
                                    <button class="btn-icon"><i class="fas fa-times"></i></button>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </section>

            <!-- Loan History Search -->
            <section class="dashboard-section" id="loan-history">
                <div class="section-header">
                    <h2>Loan History Search</h2>
                </div>
                <div class="search-container">
                    <input type="text" placeholder="Search by applicant name or ID..." class="search-input">
                    <button class="btn-primary"><i class="fas fa-search"></i> Search</button>
                </div>
                <div class="table-container">
                    <table class="data-table">
                        <thead>
                            <tr>
                                <th>AutoLoanID</th>
                                <th>Applicant</th>
                                <th>Amount</th>
                                <th>Date</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>ATL001</td>
                                <td>Jake Lamac</td>
                                <td>₱750,000</td>
                                <td>2024-03-15</td>
                                <td><span class="status-badge pending">Pending</span></td>
                            </tr>
                            <tr>
                                <td>ATL002</td>
                                <td>Bien Dela Paz</td>
                                <td>₱850,000</td>
                                <td>2024-03-14</td>
                                <td><span class="status-badge active">Approved</span></td>
                            </tr>
                            <tr>
                                <td>ATL003</td>
                                <td>Ethan Loanzon</td>
                                <td>₱650,000</td>
                                <td>2024-03-13</td>
                                <td><span class="status-badge pending">Pending</span></td>
                            </tr>
                            <tr>
                                <td>ATL004</td>
                                <td>Charis Dela Cruz</td>
                                <td>₱900,000</td>
                                <td>2024-03-12</td>
                                <td><span class="status-badge active">Approved</span></td>
                            </tr>
                            <tr>
                                <td>ATL005</td>
                                <td>Shouma Soriano</td>
                                <td>₱800,000</td>
                                <td>2024-03-11</td>
                                <td><span class="status-badge pending">Pending</span></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </section>

            <!-- System Settings -->
            <section class="dashboard-section" id="settings">
                <div class="section-header">
                    <h2>System Settings</h2>
                </div>
                <div class="settings-grid">
                    <div class="settings-card">
                        <h3>Admin Users</h3>
                        <button class="btn-secondary"><i class="fas fa-user-plus"></i> Add Admin</button>
                        <div class="admin-list">
                            <!-- Admin users will be listed here -->
                        </div>
                    </div>
                    <div class="settings-card">
                        <h3>Company Information</h3>
                        <form class="settings-form">
                            <div class="form-group">
                                <label>Company Name</label>
                                <input type="text" value="CarPlayLater">
                            </div>
                            <div class="form-group">
                                <label>Contact Email</label>
                                <input type="email" value="support@carplaylater.com">
                            </div>
                            <div class="form-group">
                                <label>Phone Number</label>
                                <input type="tel" value="+1 (555) 123-4567">
                            </div>
                            <button type="submit" class="btn-primary">Save Changes</button>
                        </form>
                    </div>
                </div>
            </section>
        </div>
    </main>

    <!-- Loan Application Preview Modal -->
    <div id="loanPreviewModal" class="modal">
        <div class="modal-content">
            <div class="modal-header">
                <h2>Loan Application Details</h2>
                <span class="close-modal">&times;</span>
            </div>
            <div class="modal-body">
                <div class="application-steps">
                    <!-- Step 1: Personal Information -->
                    <div class="step-section">
                        <h3>Step 1: Personal Information</h3>
                        
                        <div class="section-header">
                            <h4>Applicant Information</h4>
                        </div>
                        <div class="info-grid">
                            <div class="info-item">
                                <label>Full Name:</label>
                                <span id="preview-fullname"></span>
                            </div>
                            <div class="info-item">
                                <label>Birth Date:</label>
                                <span id="preview-birthdate"></span>
                            </div>
                            <div class="info-item">
                                <label>Telephone Number:</label>
                                <span id="preview-telephone"></span>
                            </div>
                            <div class="info-item">
                                <label>Citizenship:</label>
                                <span id="preview-citizenship"></span>
                            </div>
                            <div class="info-item">
                                <label>Marital Status:</label>
                                <span id="preview-marital-status"></span>
                            </div>
                        </div>

                        <div class="section-header">
                            <h4>Employment Information</h4>
                        </div>
                        <div class="info-grid">
                            <div class="info-item">
                                <label>Job Title:</label>
                                <span id="preview-job-title"></span>
                            </div>
                            <div class="info-item">
                                <label>Type of Income Source:</label>
                                <span id="preview-income-source"></span>
                            </div>
                            <div class="info-item">
                                <label>Employer/Business Name:</label>
                                <span id="preview-employer"></span>
                            </div>
                            <div class="info-item">
                                <label>Years with Employer:</label>
                                <span id="preview-years-employed"></span>
                            </div>
                            <div class="info-item">
                                <label>Office Address:</label>
                                <span id="preview-office-address"></span>
                            </div>
                            <div class="info-item">
                                <label>Office Telephone Number:</label>
                                <span id="preview-office-telephone"></span>
                            </div>
                        </div>

                        <div class="section-header">
                            <h4>Spouse/Co-maker Information</h4>
                        </div>
                        <div class="info-grid">
                            <div class="info-item">
                                <label>Full Name:</label>
                                <span id="preview-comaker-name"></span>
                            </div>
                            <div class="info-item">
                                <label>Relationship to Applicant:</label>
                                <span id="preview-comaker-relationship"></span>
                            </div>
                            <div class="info-item">
                                <label>Job Title:</label>
                                <span id="preview-comaker-job-title"></span>
                            </div>
                            <div class="info-item">
                                <label>Type of Income Source:</label>
                                <span id="preview-comaker-income-source"></span>
                            </div>
                            <div class="info-item">
                                <label>Own Business:</label>
                                <span id="preview-comaker-own-business"></span>
                            </div>
                            <div class="info-item">
                                <label>Employer/Business Name:</label>
                                <span id="preview-comaker-employer"></span>
                            </div>
                            <div class="info-item">
                                <label>Years with Employer:</label>
                                <span id="preview-comaker-years-employed"></span>
                            </div>
                            <div class="info-item">
                                <label>Office Address:</label>
                                <span id="preview-comaker-office-address"></span>
                            </div>
                            <div class="info-item">
                                <label>Office Telephone Number:</label>
                                <span id="preview-comaker-office-telephone"></span>
                            </div>
                        </div>
                    </div>

                    <!-- Step 2: Residence Information -->
                    <div class="step-section">
                        <h3>Step 2: Residence Information</h3>
                        <div class="info-grid">
                            <div class="info-item">
                                <label>Home Address:</label>
                                <span id="preview-home-address"></span>
                            </div>
                            <div class="info-item">
                                <label>Years at Current Address:</label>
                                <span id="preview-years-current-address"></span>
                            </div>
                            <div class="info-item">
                                <label>Basis of Home Ownership:</label>
                                <span id="preview-home-ownership"></span>
                            </div>
                            <div class="info-item">
                                <label>Previous Home Address:</label>
                                <span id="preview-previous-address"></span>
                            </div>
                            <div class="info-item">
                                <label>Years at Previous Address:</label>
                                <span id="preview-years-previous-address"></span>
                            </div>
                            <div class="info-item">
                                <label>Provincial Address:</label>
                                <span id="preview-provincial-address"></span>
                            </div>
                            <div class="info-item">
                                <label>Years at Provincial Address:</label>
                                <span id="preview-years-provincial-address"></span>
                            </div>
                        </div>
                    </div>

                    <!-- Step 3: Existing Loans -->
                    <div class="step-section">
                        <h3>Step 3: Existing Loans</h3>
                        <div class="info-grid">
                            <div class="info-item">
                                <label>Financial Institution:</label>
                                <span id="preview-financial-institution"></span>
                            </div>
                            <div class="info-item">
                                <label>Monthly Amortization:</label>
                                <span id="preview-monthly-amortization"></span>
                            </div>
                            <div class="info-item">
                                <label>Original Term (months):</label>
                                <span id="preview-original-term"></span>
                            </div>
                            <div class="info-item">
                                <label>Remaining Term (months):</label>
                                <span id="preview-remaining-term"></span>
                            </div>
                        </div>
                    </div>

                    <!-- Step 4: Vehicle Information -->
                    <div class="step-section">
                        <h3>Step 4: Vehicle Information</h3>
                        <div class="info-grid">
                            <div class="info-item">
                                <label>Loan Type:</label>
                                <span id="preview-loan-type"></span>
                            </div>
                            <div class="info-item">
                                <label>Purpose of Use:</label>
                                <span id="preview-purpose"></span>
                            </div>
                            <div class="info-item">
                                <label>Unit Model Name and Year:</label>
                                <span id="preview-unit-model"></span>
                            </div>
                            <div class="info-item">
                                <label>Primary User:</label>
                                <span id="preview-primary-user"></span>
                            </div>
                            <div class="info-item">
                                <label>Relationship to Applicant:</label>
                                <span id="preview-user-relationship"></span>
                            </div>
                            <div class="info-item">
                                <label>Place of Use:</label>
                                <span id="preview-place-of-use"></span>
                            </div>
                        </div>

                        <div class="section-header">
                            <h4>Financing Information</h4>
                        </div>
                        <div class="info-grid">
                            <div class="info-item">
                                <label>Unit Price:</label>
                                <span id="preview-unit-price"></span>
                            </div>
                            <div class="info-item">
                                <label>Downpayment:</label>
                                <span id="preview-downpayment"></span>
                            </div>
                            <div class="info-item">
                                <label>Loan Amount:</label>
                                <span id="preview-loan-amount"></span>
                            </div>
                            <div class="info-item">
                                <label>Term (months):</label>
                                <span id="preview-term"></span>
                            </div>
                        </div>
                    </div>

                    <!-- Step 5: References -->
                    <div class="step-section">
                        <h3>Step 5: References</h3>
                        <div class="info-grid">
                            <div class="info-item">
                                <label>Reference Name:</label>
                                <span id="preview-ref-name"></span>
                            </div>
                            <div class="info-item">
                                <label>Reference Address:</label>
                                <span id="preview-ref-address"></span>
                            </div>
                            <div class="info-item">
                                <label>Reference Telephone:</label>
                                <span id="preview-ref-telephone"></span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="js/admin.js"></script>

    <script>
        // Handle logout
        function handleLogout() {
            fetch('logout.php')
                .then(response => response.json())
                .then(data => {
                    if(data.success) {
                        window.location.href = 'landing.php';
                    } else {
                        alert('Error logging out: ' + data.message);
                    }
                });
        }

        function toggleAdmin(userId, currentStatus) {
            if(confirm('Are you sure you want to change this user\'s admin status?')) {
                fetch('toggle_admin.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/x-www-form-urlencoded',
                    },
                    body: 'userId=' + userId + '&currentStatus=' + currentStatus
                })
                .then(response => response.json())
                .then(data => {
                    if(data.success) {
                        location.reload();
                    } else {
                        alert('Error: ' + data.message);
                    }
                });
            }
        }

        function deleteUser(userId) {
            if(confirm('Are you sure you want to delete this user?')) {
                fetch('delete_user.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/x-www-form-urlencoded',
                    },
                    body: 'userId=' + userId
                })
                .then(response => response.json())
                .then(data => {
                    if(data.success) {
                        location.reload();
                    } else {
                        alert('Error: ' + data.message);
                    }
                });
            }
        }
    </script>
</body>
</html> 