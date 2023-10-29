<?php
// Include the configuration file that contains database connection settings
include 'config.php';

// Check if the registration form is submitted
if(isset($_POST['submit'])){
   
   //retrieves user input for name, email, and passwords
   $name = mysqli_real_escape_string($conn, $_POST['name']);
   $email = mysqli_real_escape_string($conn, $_POST['email']);
   $pass = mysqli_real_escape_string($conn, md5($_POST['password'])); 
   $cpass = mysqli_real_escape_string($conn, md5($_POST['cpassword']));
   
   // Query the database to check if a user with the provided email and password already exists
   $select = mysqli_query($conn, "SELECT * FROM `user_form` WHERE email = '$email' AND password = '$pass'") or die('query failed');
   // If a user with the same email and password combination is found, set an error message
   if(mysqli_num_rows($select) > 0){
      $message[] = 'user already exists'; 
   } else {
      // If the passwords do not match, set an error message
      if($pass != $cpass){
         $message[] = 'confirm password not matched!';
      }
     
      }
   }

?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>register</title>

   <!-- Link CSS files  -->
   <link rel="stylesheet" href="css/style.css">
   <link rel="stylesheet" href="css/signup.css">
</head>
<body>
   <h1>PawMates</h1>

   <!-- Registration form container -->
   <div class="form-container">
      <form action="" method="post" enctype="multipart/form-data">
         <h3>Sign-up!</h3>
         
         <!-- Display error messages if there are any -->
         <?php
         if(isset($message)){
            foreach($message as $message){
               echo '<div class="message">'.$message.'</div>';
            }
         }
         ?>
         
         <!-- Input fields for name, email, and passwords -->
         <input type="text" name="name" placeholder="enter username" class="box" required>
         <input type="email" name="email" placeholder="enter email" class="box" required>
         <input type="password" name="password" placeholder="enter password" class="box" required>
         <input type="password" name="cpassword" placeholder="confirm password" class="box" required>
        
         <!-- Submit button to register -->
         <input type="submit" name="submit" value="register now" class="btn">
         
         <!-- Link for users to login if they already have an account -->
         <p>already have an account? <a href="login.php">Login Here</a></p>
      </form>
   </div>
</body>
</html>
