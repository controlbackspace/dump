const signUpButton = document.getElementById('signUpButton');
const signInButton = document.getElementById('signInButton');
const signUpForm = document.getElementById('signup');
const signInForm = document.getElementById('signIn');

signUpButton.addEventListener('click', () => {
  signUpForm.style.display = 'block';
  signInForm.style.display = 'none';
});

signInButton.addEventListener('click', () => {
  signUpForm.style.display = 'none';
  signInForm.style.display = 'block';
});


// Signup functionality
const signupForm = document.querySelector('#signup form');
signupForm.addEventListener('submit', async (e) => {
    e.preventDefault();
    const fName = document.getElementById('fName').value;
    const lastName = document.getElementById('lastName').value;
    const email = document.getElementById('registerEmail').value;
    const password = document.getElementById('registerPassword').value;

    try {
        const formData = new FormData();
        formData.append('fName', fName);
        formData.append('lastName', lastName);
        formData.append('email', email);
        formData.append('password', password);
        formData.append('signUp', 'true');

        const response = await fetch('register.php', {
            method: 'POST',
            body: formData
        });

        const data = await response.text();
        
        if (response.ok) {
            window.location.href = 'index.php';
        } else {
            alert(data);
        }
    } catch (error) {
        console.error('Error:', error);
        alert('An error occurred during signup');
    }
});

