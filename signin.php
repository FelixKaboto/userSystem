<?php
// Start a session
session_start();

include 'head.php';
include 'validation.php';

$email = $password = "";
$emailErr = $passwordErr = "";

if (isset($_POST['submitted'])) {
    $email = test_input($_POST["email"]);

    if (empty($_POST["email"])) {
        $emailErr = "* Email is required";
    } else {
        $email = test_input($_POST["email"]);
    }

    if (empty($_POST["password"])) {
        $passwordErr = "* Password is required";
    } else {
        $password = md5(test_input($_POST["password"]));
    }

    // Check is the user details passes validation
    if ($email && $password) {
        $fileName = 'database/' . $email . ".json";

        // Checks if the user exists
        if (!file_exists($fileName)) {
            echo "User does not exist";
        } else {
            //Opens the user file
            $myFile = fopen($fileName, "r") or die("Unable to open file!");
            $userData = fread($myFile, filesize($fileName));
            $userArray = json_decode($userData, true);
            fclose($myFile);

            // Check if the input password matches the user password
            if ($password == $userArray['password']) {
                $_SESSION['isLogged'] = "1";
                $_SESSION['email'] = $email;

                if (isset($_SESSION['email'])) {
                    header("Location:home.php");
                }
            } else {
                echo "Incorrect details entered";
            }
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
    </style>
</head>

<body>
    <div class="container">
        <h1>Login</h1><br><br>

        <form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">

            <legend>

                <label for="email">Email</label>

                <input type="email" name="email" id="email" placeholder="Email"> <br><br>
                <span class="error text-danger"><?php echo $emailErr; ?></span>

                <label for="password">Password</label>

                <input type="password" name="password" id="password" placeholder="Password"><br><br>
                <span> <?php echo $passwordErr; ?></span>

                <button type="submit" name="submitted">Sign in</button><br><br>

                <p>Forgot Your Password?</p><button><a href="passwordreset.php">Reset here</a></button>

            </legend>

        </form>
    </div>

</body>

</html>