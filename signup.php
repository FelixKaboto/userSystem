<?php
include 'head.php'; #calling the code in this file
include 'validation.php';   #calling the code in this file

// defining variables with empty values
$firstName = $surname = $email = $password = "";
$firstNameErr = $surnameErr = $emailErr = $passwordErr = "";

// Data submitted handling method
if ($_SERVER["REQUEST_METHOD"] == "POST") {

  $email = test_input($_POST["email"]);

  if (empty($_POST["firstName"])) {
    $firstNameErr = "* First name is required";
  } elseif (!preg_match("/^[a-zA-Z ]*$/", $firstName)) {
    $firstNameErr = "Only letters and white space allowed";
  } else {
    $firstName = test_input($_POST["firstName"]);
  }

  if (empty($_POST["surname"])) {
    $surnameErr = "* Last name is required";
  } elseif (!preg_match("/^[a-zA-Z ]*$/", $surname)) {
    $surnameErr = "Only letters and white space allowed";
  } else {
    $surname = test_input($_POST["surname"]);
  }
  if (empty($_POST["email"])) {
    $emailErr = "* Email is required";
  } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    $emailErr = "Invalid email format";
  } else {
    $email = test_input($_POST["email"]);
  }
  if (empty($_POST["password"])) {
    $passwordErr = "* Password is required";
  } else {
    $password = test_input($_POST["password"]);
  }

  // user validation and outputs
  if ($firstName && $surname && $email && $password) {
    if (!file_exists('database/' . $firstName . $surname)) {

      $firstName = strtolower($_POST['firstName']);
      $surname = strtolower($_POST['surname']);
      $email = strtolower($_POST['email']);
      $password = md5($_POST['password']);

      $arrayData = [
        'firstName' => $firstName,
        'surname' => $surname,
        'email' => $email,
        'password' => $password
      ];

      file_put_contents('database/' . $arrayData['email'] . ".json", json_encode($arrayData));

      echo "User profile successfully created";
    } else {
      echo "User details already exists";
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
  <title>Login</title>

  <style>
    .container {
      text-align: center;
      border-radius: 5px;
      background-color: #f2f2f2;
      padding: 20px;
    }

    a {
      text-decoration: none;
    }

    .home{
      padding: 10px, 0, 10px, 0;
      margin: 10px;
    }
  </style>
</head>


<body>
  <h1>Signup Form</h1>

  <button class="home"><a href="index.php" role="button">Home</a></button>

  <div class="container">
    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST">

      <label for="firstName">First name</label>
      <input type="text" id="firstName" name="firstName" placeholder="First name">
      <span><?php echo $firstNameErr; ?></span> <br><br>


      <label for="surname">Last name</label>
      <input type="text" id="surname" name="surname" placeholder="Last name">
      <span><?php echo $surnameErr; ?></span> <br><br>


      <label for="email">Email address</label>
      <input type="email" id="email" name="email" placeholder="Email">
      <span><?php echo $emailErr; ?></span> <br><br>


      <label for="password">Password</label>
      <input type="password" id="password" name="password" placeholder="Password">
      <span><?php echo $passwordErr; ?></span><br><br>

      <button type="submit" name="submit">Submit</button>
    </form>
  </div>
</body>

</html>