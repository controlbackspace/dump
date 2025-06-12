<?php
session_start();
include 'connect.php';

if(isset($_POST['signUp'])) {
    $fName = $_POST['fName'];
    $lastName = $_POST['lastName'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $password = md5($password); // Hash the password for security
    
    $checkEmail = "SELECT * FROM users WHERE email='$email'";
    $result = $conn->query($checkEmail);
    if($result->num_rows > 0) {
        echo "Email already exists. Please use a different email.";
    } else {
        $insertQuery = "INSERT INTO users (firstName, lastName, email, password) VALUES ('$fName', '$lastName', '$email', '$password')";
        if($conn->query($insertQuery) === TRUE) {
            header("Location: index.php");
            exit();
        }
        else {
            echo "Error:.".$conn->error;
        }
    }
}

if(isset($_POST['signIn'])) {
    $email = $_POST['email'];
    $password = $_POST['password'];
    $password = md5($password); // Hash the password for security
   
    $sql = "SELECT * FROM users WHERE email='$email' AND password='$password'";
    $result = $conn->query($sql);
    
    if($result && $result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $_SESSION['email'] = $row['email'];
        $_SESSION['firstName'] = $row['firstName'];
        $_SESSION['lastName'] = $row['lastName'];
        $_SESSION['userId'] = $row['Id'];
        $_SESSION['is_admin'] = $row['is_admin'];
        
        // Redirect to admin page if user is admin
        if($row['is_admin'] == 1) {
            header("Location: admin.php");
        } else {
            // Check if user came from Apply Now button
            if(isset($_POST['source']) && $_POST['source'] === 'apply_now') {
                header("Location: loan-form.html");
            } else {
                header("Location: landing.php");
            }
        }
        exit();
    } else {   
        echo "Invalid email or password.";
    }   
}
?>