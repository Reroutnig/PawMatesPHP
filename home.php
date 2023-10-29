<?php
// Include the configuration file which contains database connection settings
include 'config.php';

// Start a session to manage user login state
session_start();

// Get the user ID from the session data
$user_id = $_SESSION['user_id'];

// If user is not logged in, redirect them to the login page
if (!isset($user_id)) {
    header('location:login.php');
}

// If the logout parameter is set in the URL, unset user ID, destroy session, and redirect to login page
if (isset($_GET['logout'])) {
    unset($user_id);
    session_destroy();
    header('location:login.php');
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>home</title>

    <!-- Link CSS file -->
    <link rel="stylesheet" href="css/style.css">

</head>
<body>
   
<div class="container">

   <!-- Profile section -->
   <div class="profile">
      <?php
         // Query the database to fetch user data based on the stored user ID
         $select = mysqli_query($conn, "SELECT * FROM `user_form` WHERE id = '$user_id'") or die('query failed');
         // If user data is found, fetch it and display the user's image and name
         if(mysqli_num_rows($select) > 0){
            $fetch = mysqli_fetch_assoc($select);
         }
         // If the user does not have a profile image, display a default avatar; otherwise, display the uploaded image
         if($fetch['image'] == ''){
            echo '<img src="images/default-avatar.png">';
         } else {
            echo '<img src="uploaded_img/'.$fetch['image'].'">';
         }
      ?>
      <!-- Display the user's name -->
      <h3><?php echo $fetch['name']; ?></h3>
     
      <!-- Logout button that includes the user ID as a parameter for logout functionality -->
      <a href="home.php?logout=<?php echo $user_id; ?>" class="delete-btn">logout</a>
   </div>

</div>

</body>
</html>
