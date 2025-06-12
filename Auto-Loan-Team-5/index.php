<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Register & Login</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css" />
  <link rel="stylesheet" href="styles/style.css" />
</head>
<body>

  <!-- SIGN UP FORM -->
  <div class="container" id="signup" style="display: none;">
    <h1 class="form-title">Register</h1>
    <form method="post" action="register.php">
      <div class="input-group">
        <i class="fas fa-user"></i>
        <label for="fName">First Name</label>
        <input type="text" name="fName" id="fName" placeholder="First Name" required />
      </div>

      <div class="input-group">
        <i class="fas fa-user"></i>
        <label for="lastName">Last Name</label>
        <input type="text" name="lastName" id="lastName" placeholder="Last Name" required />
      </div>

      <div class="input-group">
        <i class="fas fa-envelope"></i>
        <label for="registerEmail">E-Mail</label>
        <input type="email" name="email" id="registerEmail" placeholder="E-mail" required />
      </div>

      <div class="input-group">
        <i class="fas fa-lock"></i>
        <label for="registerPassword">Password</label>
        <input type="password" name="password" id="registerPassword" placeholder="Password" required />
      </div>

      <input type="submit" class="btn" value="Sign Up" name="signUp" />
    </form>

    <p class="or">--------or----------</p>
    <div class="icons">
      <i class="fab fa-google"></i>
      <i class="fab fa-facebook"></i>
    </div>

    <div class="links">
      <p>Already have an account?</p>
      <button id="signInButton">Sign In</button>
    </div>
  </div>

  <!-- SIGN IN FORM -->
  <div class="container" id="signIn">
    <h1 class="form-title">Sign In</h1>
    <form method="post" action="register.php">
      <?php if(isset($_GET['source'])): ?>
      <input type="hidden" name="source" value="<?php echo htmlspecialchars($_GET['source']); ?>" />
      <?php endif; ?>
      <div class="input-group">
        <i class="fas fa-envelope"></i>
        <label for="loginEmail">E-Mail</label>
        <input type="email" name="email" id="loginEmail" placeholder="E-mail" required />
      </div>

      <div class="input-group">
        <i class="fas fa-lock"></i>
        <label for="loginPassword">Password</label>
        <input type="password" name="password" id="loginPassword" placeholder="Password" required />
      </div>

      <p class="recover">
        <a href="#">Recover Password</a>
      </p>

      <input type="submit" class="btn" value="Sign In" name="signIn" />
    </form>

    <p class="or">--------or----------</p>
    <div class="icons">
      <i class="fab fa-google"></i>
      <i class="fab fa-facebook"></i>
    </div>

    <div class="links">
      <p>Don't have an account yet?</p>
      <button id="signUpButton" >Sign Up</button>
    </div>
  </div>

  <script src="js/script.js"></script>
</body>
</html>
