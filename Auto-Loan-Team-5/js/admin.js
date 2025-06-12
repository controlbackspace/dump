// Profile Dropdown Toggle
const profileBtn = document.querySelector('.profile-btn');
const dropdownContent = document.querySelector('.dropdown-content');

if (profileBtn && dropdownContent) {
    profileBtn.addEventListener('click', (e) => {
        e.stopPropagation();
        dropdownContent.style.display = dropdownContent.style.display === 'block' ? 'none' : 'block';
    });

    // Close dropdown when clicking outside
    document.addEventListener('click', (e) => {
        if (!profileBtn.contains(e.target) && !dropdownContent.contains(e.target)) {
            dropdownContent.style.display = 'none';
        }
    });

    // Prevent dropdown from closing when clicking inside
    dropdownContent.addEventListener('click', (e) => {
        e.stopPropagation();
    });
}

// Navigation Active State
const navLinks = document.querySelectorAll('.nav-links a');
navLinks.forEach(link => {
    link.addEventListener('click', () => {
        navLinks.forEach(l => l.classList.remove('active'));
        link.classList.add('active');
    });
});

// Table Row Actions
document.querySelectorAll('.btn-icon').forEach(btn => {
    btn.addEventListener('click', (e) => {
        const action = e.target.closest('.btn-icon').querySelector('i').classList[1];
        const row = e.target.closest('tr');
        const id = row.querySelector('td').textContent;

        switch(action) {
            case 'fa-edit':
                // Placeholder for edit functionality
                console.log(`Edit ${id}`);
                break;
            case 'fa-trash':
                if(confirm('Are you sure you want to delete this record?')) {
                    // Placeholder for delete functionality
                    console.log(`Delete ${id}`);
                }
                break;
            case 'fa-eye':
                // Placeholder for view functionality
                console.log(`View ${id}`);
                break;
            case 'fa-check':
                // Placeholder for approve functionality
                console.log(`Approve ${id}`);
                break;
            case 'fa-times':
                // Placeholder for reject functionality
                console.log(`Reject ${id}`);
                break;
        }
    });
});

// Loan Application Filter
const filterSelect = document.querySelector('.filter-select');
if(filterSelect) {
    filterSelect.addEventListener('change', (e) => {
        const status = e.target.value;
        // Placeholder for filter functionality
        console.log(`Filter by: ${status}`);
    });
}

// Search Functionality
const searchInput = document.querySelector('.search-input');
const searchButton = document.querySelector('.search-container .btn-primary');

if(searchInput && searchButton) {
    const performSearch = () => {
        const query = searchInput.value.trim();
        if(query) {
            // Placeholder for search functionality
            console.log(`Searching for: ${query}`);
        }
    };

    searchButton.addEventListener('click', performSearch);
    searchInput.addEventListener('keypress', (e) => {
        if(e.key === 'Enter') {
            performSearch();
        }
    });
}

// Settings Form
const settingsForm = document.querySelector('.settings-form');
if(settingsForm) {
    settingsForm.addEventListener('submit', (e) => {
        e.preventDefault();
        // Placeholder for settings update functionality
        console.log('Settings updated');
    });
}

// Add New Applicant Button
const addApplicantBtn = document.querySelector('.section-header .btn-primary');
if(addApplicantBtn) {
    addApplicantBtn.addEventListener('click', () => {
        // Placeholder for add applicant functionality
        console.log('Add new applicant');
    });
}

// Add Admin Button
const addAdminBtn = document.querySelector('.settings-card .btn-secondary');
if(addAdminBtn) {
    addAdminBtn.addEventListener('click', () => {
        // Placeholder for add admin functionality
        console.log('Add new admin');
    });
}

// Intersection Observer for fade-in animations
const observerOptions = {
    root: null,
    rootMargin: '0px',
    threshold: 0.1
};

const observer = new IntersectionObserver((entries, observer) => {
    entries.forEach(entry => {
        if (entry.isIntersecting) {
            entry.target.classList.add('fade-in');
            observer.unobserve(entry.target);
        }
    });
}, observerOptions);

// Observe all dashboard sections
document.querySelectorAll('.dashboard-section').forEach(section => {
    observer.observe(section);
});

// Modal functionality
const modal = document.getElementById('loanPreviewModal');
const closeModal = document.querySelector('.close-modal');

// Close modal when clicking the X button
closeModal.addEventListener('click', () => {
    modal.style.display = 'none';
});

// Close modal when clicking outside
window.addEventListener('click', (event) => {
    if (event.target === modal) {
        modal.style.display = 'none';
    }
});

// Function to show loan application details
function showLoanApplicationDetails(applicationId) {
    // Here you would typically fetch the application details from your backend
    // For now, we'll use sample data
    const sampleData = {
        personalInfo: {
            fullName: 'John Doe',
            birthDate: '1990-01-01',
            telephone: '+1 234 567 8900',
            citizenship: 'Filipino',
            maritalStatus: 'Single'
        },
        employmentInfo: {
            jobTitle: 'Software Engineer',
            incomeSource: 'Employment',
            employer: 'ABC Company',
            yearsEmployed: '5',
            officeAddress: '123 Business St, City',
            officeTelephone: '+1 234 567 8901'
        },
        comakerInfo: {
            name: 'Jane Doe',
            relationship: 'Spouse',
            jobTitle: 'Project Manager',
            incomeSource: 'Employment',
            ownBusiness: 'No',
            employer: 'XYZ Corporation',
            yearsEmployed: '3',
            officeAddress: '456 Work St, City',
            officeTelephone: '+1 234 567 8902'
        },
        residenceInfo: {
            homeAddress: '789 Home St, City',
            yearsCurrentAddress: '3',
            homeOwnership: 'Rented',
            previousAddress: '321 Old St, City',
            yearsPreviousAddress: '2',
            provincialAddress: 'Not Applicable',
            yearsProvincialAddress: 'N/A'
        },
        existingLoans: {
            financialInstitution: 'ABC Bank',
            monthlyAmortization: '₱15,000',
            originalTerm: '36',
            remainingTerm: '24'
        },
        vehicleInfo: {
            loanType: 'New Car',
            purpose: 'Personal Use',
            unitModel: 'Toyota Camry 2023',
            primaryUser: 'John Doe',
            userRelationship: 'Self',
            placeOfUse: 'Metro Manila'
        },
        financingInfo: {
            unitPrice: '₱1,500,000',
            downpayment: '₱300,000',
            loanAmount: '₱1,200,000',
            term: '36'
        },
        reference: {
            name: 'Mike Johnson',
            address: '101 Friend St, City',
            telephone: '+1 234 567 8903'
        }
    };

    // Populate the modal with the data
    // Personal Information
    document.getElementById('preview-fullname').textContent = sampleData.personalInfo.fullName;
    document.getElementById('preview-birthdate').textContent = sampleData.personalInfo.birthDate;
    document.getElementById('preview-telephone').textContent = sampleData.personalInfo.telephone;
    document.getElementById('preview-citizenship').textContent = sampleData.personalInfo.citizenship;
    document.getElementById('preview-marital-status').textContent = sampleData.personalInfo.maritalStatus;

    // Employment Information
    document.getElementById('preview-job-title').textContent = sampleData.employmentInfo.jobTitle;
    document.getElementById('preview-income-source').textContent = sampleData.employmentInfo.incomeSource;
    document.getElementById('preview-employer').textContent = sampleData.employmentInfo.employer;
    document.getElementById('preview-years-employed').textContent = sampleData.employmentInfo.yearsEmployed;
    document.getElementById('preview-office-address').textContent = sampleData.employmentInfo.officeAddress;
    document.getElementById('preview-office-telephone').textContent = sampleData.employmentInfo.officeTelephone;

    // Co-maker Information
    document.getElementById('preview-comaker-name').textContent = sampleData.comakerInfo.name;
    document.getElementById('preview-comaker-relationship').textContent = sampleData.comakerInfo.relationship;
    document.getElementById('preview-comaker-job-title').textContent = sampleData.comakerInfo.jobTitle;
    document.getElementById('preview-comaker-income-source').textContent = sampleData.comakerInfo.incomeSource;
    document.getElementById('preview-comaker-own-business').textContent = sampleData.comakerInfo.ownBusiness;
    document.getElementById('preview-comaker-employer').textContent = sampleData.comakerInfo.employer;
    document.getElementById('preview-comaker-years-employed').textContent = sampleData.comakerInfo.yearsEmployed;
    document.getElementById('preview-comaker-office-address').textContent = sampleData.comakerInfo.officeAddress;
    document.getElementById('preview-comaker-office-telephone').textContent = sampleData.comakerInfo.officeTelephone;

    // Residence Information
    document.getElementById('preview-home-address').textContent = sampleData.residenceInfo.homeAddress;
    document.getElementById('preview-years-current-address').textContent = sampleData.residenceInfo.yearsCurrentAddress;
    document.getElementById('preview-home-ownership').textContent = sampleData.residenceInfo.homeOwnership;
    document.getElementById('preview-previous-address').textContent = sampleData.residenceInfo.previousAddress;
    document.getElementById('preview-years-previous-address').textContent = sampleData.residenceInfo.yearsPreviousAddress;
    document.getElementById('preview-provincial-address').textContent = sampleData.residenceInfo.provincialAddress;
    document.getElementById('preview-years-provincial-address').textContent = sampleData.residenceInfo.yearsProvincialAddress;

    // Existing Loans
    document.getElementById('preview-financial-institution').textContent = sampleData.existingLoans.financialInstitution;
    document.getElementById('preview-monthly-amortization').textContent = sampleData.existingLoans.monthlyAmortization;
    document.getElementById('preview-original-term').textContent = sampleData.existingLoans.originalTerm;
    document.getElementById('preview-remaining-term').textContent = sampleData.existingLoans.remainingTerm;

    // Vehicle Information
    document.getElementById('preview-loan-type').textContent = sampleData.vehicleInfo.loanType;
    document.getElementById('preview-purpose').textContent = sampleData.vehicleInfo.purpose;
    document.getElementById('preview-unit-model').textContent = sampleData.vehicleInfo.unitModel;
    document.getElementById('preview-primary-user').textContent = sampleData.vehicleInfo.primaryUser;
    document.getElementById('preview-user-relationship').textContent = sampleData.vehicleInfo.userRelationship;
    document.getElementById('preview-place-of-use').textContent = sampleData.vehicleInfo.placeOfUse;

    // Financing Information
    document.getElementById('preview-unit-price').textContent = sampleData.financingInfo.unitPrice;
    document.getElementById('preview-downpayment').textContent = sampleData.financingInfo.downpayment;
    document.getElementById('preview-loan-amount').textContent = sampleData.financingInfo.loanAmount;
    document.getElementById('preview-term').textContent = sampleData.financingInfo.term;

    // Reference
    document.getElementById('preview-ref-name').textContent = sampleData.reference.name;
    document.getElementById('preview-ref-address').textContent = sampleData.reference.address;
    document.getElementById('preview-ref-telephone').textContent = sampleData.reference.telephone;

    // Show the modal
    modal.style.display = 'block';
}

// Add click event listeners to all preview buttons
document.addEventListener('DOMContentLoaded', () => {
    const previewButtons = document.querySelectorAll('.btn-preview');
    previewButtons.forEach(button => {
        button.addEventListener('click', (e) => {
            const applicationId = e.target.closest('tr').querySelector('td:first-child').textContent;
            showLoanApplicationDetails(applicationId);
        });
    });
}); 