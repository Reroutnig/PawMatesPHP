<?php
// Include the configuration file that contains database connection settings
include 'config.php';

// Start a session to manage user login state
session_start();

// Check if the login form is submitted
if(isset($_POST['submit'])){
   
   // retrieve user input for email and password
   $email = mysqli_real_escape_string($conn, $_POST['email']);
   $pass = mysqli_real_escape_string($conn, md5($_POST['password'])); 

   // Query the database to find a user with the provided email and  password
   $select = mysqli_query($conn, "SELECT * FROM `user_form` WHERE email = '$email' AND password = '$pass'") or die('query failed');

   // If a matching user is found, log them in and redirect to websearch.php
   if(mysqli_num_rows($select) > 0){
      $row = mysqli_fetch_assoc($select);
      $_SESSION['user_id'] = $row['id']; // Store the user ID in the session for future authentication
      header('location:websearch.php'); // Redirect to the websearch page after successful login
   } else {
      $message[] = 'incorrect email or password!'; // If no matching user is found, set an error message
   }

}

?>
<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>login</title>

   <!-- Link CSS files -->
   <link rel="stylesheet" href="css/style.css">
   <link rel="stylesheet" href="css/loginpage.css">
</head>
<body>
   <h1>PawMates</h1>

   <!-- Login form container -->
   <div class="form-container">
      <form action="" method="post" enctype="multipart/form-data">
         <h3>login</h3>
         
         <!-- Display error messages if there are any -->
         <?php
         if(isset($message)){
            foreach($message as $message){
               echo '<div class="message">'.$message.'</div>';
            }
         }
         ?>
         
         <!-- Input fields for email and password -->
         <input type="email" name="email" placeholder="enter email" class="box" required>
         <input type="password" name="password" placeholder="enter password" class="box" required>
         
         <!-- Submit button to log in -->
         <input type="submit" name="submit" value="login now" class="btn">
         
         <!-- Links for user actions: registration and password reset -->
         <p>don't have an account? <a href="register.php">Signup!</a></p>
         <a href="resetpwd.php"><p>Forgot Password?</a></p>
      </form>
   </div>
</body>
</html>
