<?php

include 'components/connect.php';

session_start();

if (isset($_SESSION['user_id'])) {
   $user_id = $_SESSION['user_id'];
} else {
   $user_id = '';
};

if (isset($_POST['submit'])) {

   $name = $_POST['name'];
   $name = filter_var($name, FILTER_SANITIZE_STRING);
   $email = $_POST['email'];
   $email = filter_var($email, FILTER_SANITIZE_STRING);
   $pass = ($_POST['pass']);
   $pass = filter_var($pass, FILTER_SANITIZE_STRING);
   $cpass = ($_POST['cpass']);
   $cpass = filter_var($cpass, FILTER_SANITIZE_STRING);

   $select_user = $conn->prepare("SELECT * FROM `users` WHERE email = ?");
   $select_user->execute([$email]);
   $row = $select_user->fetch(PDO::FETCH_ASSOC);

   if ($select_user->rowCount() > 0) {
      $message[] = 'email already exists!';
   } else {
      if ($pass != $cpass) {
         $message[] = 'confirm password not matched!';
      } else {
         $insert_user = $conn->prepare("INSERT INTO `users`(name, email, password) VALUES(?,?,?)");
         $insert_user->execute([$name, $email, $cpass]);
         $message[] = 'registered successfully, login now please!';
      }
   }
}


?>

<!DOCTYPE html>
<html lang="en">

<!--<script>
   function uname_validation() {
      var name = document.forms["form"]["name"].value;
      var nameformat = /^[a-zA-Z\s]*$/;
      if (name.trim() == "") {
         document.getElementById('nerror').innerHTML = "Name required";

      } else if (!nameformat.test(name)) {
         document.getElementById('nerror').innerHTML = "Name only contain alphabates";

      } else {
         document.getElementById('nerror').innerHTML = "";
      }
   }
</script> -->


<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>register</title>

   <!-- font awesome cdn link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">

   <!-- custom css file link  -->
   <link rel="stylesheet" href="css/style.css">

</head>

<body>

   <?php include 'components/user_header.php'; ?>

   <section class="form-container">

      <form action="" method="post" name="form">
         <h3>register now</h3>
         <span id="nerror" style="color: red;"></span>
         <input type="text" name="name" required placeholder="enter your Name" maxlength="20" class="box" oninput="uname_validation();">
         <span id="valid_email" style="color: red;"></span>
         <input type="email" name="email" required placeholder="enter your email" maxlength="50" class="box" oninput="this.value = this.value.replace(/\s/g, '')">
         <input type="password" name="pass" required placeholder="enter your password" maxlength="20" class="box" oninput="email_validation();" onkeyup="this.value = this.value.replace(/\s/g, '')">
         <input type="password" name="cpass" required placeholder="confirm your password" maxlength="20" class="box" onkeyup="this.value = this.value.replace(/\s/g, '')">
         <input type="submit" value="register now" class="btn" name="submit">
         <p>already have an account?</p>
         <a href="user_login.php" class="option-btn">login now</a>
      </form>



   </section>

   <?php include 'components/footer.php'; ?>

   <script src="js/script.js"></script>
   <script type="text/javascript">
      function uname_validation() {
         var name = document.forms["form"]["name"].value;
         var nameformat = /^[a-zA-Z\s]*$/;
         if (name.trim() == "") {
            document.getElementById('nerror').innerHTML = "Name required";

         } else if (!nameformat.test(name)) {
            document.getElementById('nerror').innerHTML = "Name only contain alphabates";

         } else {
            document.getElementById('nerror').innerHTML = "";
         }
      }


      function email_validation() {
         var name = document.forms["form"]["name"].value;

         if (name.trim() == "") {
            document.getElementById('valid_email').innerHTML = "Email is required";

         } else if (!nameformat.test(name)) {
            document.getElementById('valid_email').innerHTML = "Enter valid email";

         } else {
            document.getElementById('valid_email').innerHTML = "";
         }
      }
   </script>

</body>

</html>