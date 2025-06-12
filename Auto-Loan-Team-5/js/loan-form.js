document.addEventListener('DOMContentLoaded', () => {
    // Form elements
    const form = document.getElementById('loanApplicationForm');
    const steps = document.querySelectorAll('.form-step');
    const stepItems = document.querySelectorAll('.step-item');
    const prevBtn = document.querySelector('.btn-prev');
    const nextBtn = document.querySelector('.btn-next');
    const submitBtn = document.querySelector('.btn-submit');

    // Form data storage
    const formData = {
        personalInfo: {},
        residenceInfo: {},
        financialInfo: {},
        loanDetails: {},
        references: {}
    };

    let currentStep = 1;
    const totalSteps = steps.length;

    // Initialize form
    function initForm() {
        // Hide all steps except the first one
        steps.forEach((step, index) => {
            step.classList.remove('active');
            if (index === 0) {
                step.classList.add('active');
            }
        });
        
        updateNavigationButtons();
        updateStepIndicators();
    }

    // Update navigation buttons state
    function updateNavigationButtons() {
        prevBtn.disabled = currentStep === 1;
        
        if (currentStep === totalSteps) {
            nextBtn.style.display = 'none';
            submitBtn.style.display = 'block';
        } else {
            nextBtn.style.display = 'block';
            submitBtn.style.display = 'none';
        }
    }

    // Update step indicators in sidebar
    function updateStepIndicators() {
        stepItems.forEach((item, index) => {
            const stepNumber = index + 1;
            item.classList.toggle('active', stepNumber === currentStep);
            item.classList.toggle('completed', stepNumber < currentStep);
        });
    }

    // Show specific step
    function showStep(stepNumber) {
        // Hide all steps
        steps.forEach(step => {
            step.classList.remove('active');
        });
        
        // Show the selected step
        const selectedStep = document.querySelector(`.form-step[data-step="${stepNumber}"]`);
        if (selectedStep) {
            selectedStep.classList.add('active');
        }
        
        currentStep = stepNumber;
        updateNavigationButtons();
        updateStepIndicators();
        
        // Scroll to top of form
        form.scrollIntoView({ behavior: 'smooth' });
    }

    // Save current step data
    function saveStepData() {
        const currentStepElement = document.querySelector(`.form-step[data-step="${currentStep}"]`);
        const formElements = currentStepElement.querySelectorAll('input, select, textarea');
        
        formElements.forEach(element => {
            if (element.name) {
                switch (currentStep) {
                    case 1:
                        formData.personalInfo[element.name] = element.value;
                        break;
                    case 2:
                        formData.residenceInfo[element.name] = element.value;
                        break;
                    case 3:
                        formData.financialInfo[element.name] = element.value;
                        break;
                    case 4:
                        formData.loanDetails[element.name] = element.value;
                        break;
                    case 5:
                        formData.references[element.name] = element.value;
                        break;
                }
            }
        });
    }

    // Validate current step
    function validateStep() {
        const currentStepElement = document.querySelector(`.form-step[data-step="${currentStep}"]`);
        const requiredFields = currentStepElement.querySelectorAll('[required]');
        let isValid = true;

        requiredFields.forEach(field => {
            if (!field.value.trim()) {
                isValid = false;
                field.classList.add('error');
                
                // Add error message if not exists
                if (!field.nextElementSibling?.classList.contains('error-message')) {
                    const errorMessage = document.createElement('div');
                    errorMessage.className = 'error-message';
                    errorMessage.textContent = 'This field is required';
                    field.parentNode.insertBefore(errorMessage, field.nextSibling);
                }
            } else {
                field.classList.remove('error');
                const errorMessage = field.nextElementSibling;
                if (errorMessage?.classList.contains('error-message')) {
                    errorMessage.remove();
                }
            }
        });

        return isValid;
    }
    
    // Event Listeners
    prevBtn.addEventListener('click', () => {
        if (currentStep > 1) {
            saveStepData();
            showStep(currentStep - 1);
        }
    });

    nextBtn.addEventListener('click', () => {
        if (validateStep()) {
            saveStepData();
            showStep(currentStep + 1);
        }
    });

    // Allow clicking on step items to navigate
    stepItems.forEach((item, index) => {
        item.addEventListener('click', () => {
            const stepNumber = index + 1;
            if (stepNumber < currentStep || validateStep()) {
                saveStepData();
                showStep(stepNumber);
            }
        });
    });

    // Form submission
    form.addEventListener('submit', (e) => {
    if (!validateStep()) {
        e.preventDefault(); // Block submit if last step is invalid
        return;
    }

    // Save last step's data to formData (for client-side use if needed)
    saveStepData();
    console.log('Submitting to PHP with final formData:', formData);


    // ✅ DO NOT call e.preventDefault() here.
    // Let it submit to submit_loan.php and process via PHP.
});


    // Dynamic Record Addition
    const addLoanBtn = document.getElementById('addLoanBtn');
    const addReferenceBtn = document.getElementById('addReferenceBtn');
    const existingLoansContainer = document.getElementById('existingLoansContainer');
    const referencesContainer = document.getElementById('referencesContainer');

    // Add new loan record
    function addLoanRecord() {
        const loanRecord = document.createElement('div');
        loanRecord.className = 'loan-record';
        loanRecord.innerHTML = `
            <button type="button" class="btn-remove" onclick="this.parentElement.remove()">×</button>
            <div class="form-group">
                <label for="loanInstitution">Loan Institution</label>
                <input type="text" name="loanInstitution[]">
            </div>
            <div class="form-group">
                <label for="monthlyAmortization">Monthly Amortization</label>
                <div class="input-with-symbol">
                    <span class="symbol">₱</span>
                    <input type="number" name="monthlyAmortization[]" placeholder="0.00">
                </div>
            </div>
            <div class="form-group">
                <label for="originalTerm">Original Term</label>
                <input type="number" name="originalTerm[]">
            </div>
            <div class="form-group">
                <label for="remainingTerm">Remaining Term</label>
                <input type="number" name="remainingTerm[]">
            </div>
        `;
        existingLoansContainer.appendChild(loanRecord);
    }

    // Add new reference record
    function addReferenceRecord() {
        const referenceCount = document.querySelectorAll('.reference-record').length + 1;
        const referenceRecord = document.createElement('div');
        referenceRecord.className = 'reference-record';
        referenceRecord.innerHTML = `
            <button type="button" class="btn-remove" onclick="this.parentElement.remove()">×</button>
            <h3>Reference ${referenceCount}</h3>
            <div class="form-group">
                <label for="refName">Name</label>
                <input type="text" name="refName[]" required>
            </div>
            <div class="form-group">
                <label for="refAddress">Address</label>
                <textarea name="refAddress[]" required></textarea>
            </div>
            <div class="form-group">
                <label for="refPhone">Phone</label>
                <input type="tel" name="refPhone[]" required>
            </div>
        `;
        referencesContainer.appendChild(referenceRecord);
    }

    // Event listeners for add buttons
    addLoanBtn.addEventListener('click', addLoanRecord);
    addReferenceBtn.addEventListener('click', addReferenceRecord);

    // Initialize form
    initForm();
}); 

