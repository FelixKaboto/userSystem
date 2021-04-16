<?php
include 'head.php';
include 'validation.php';

// define variables and set to empty values
$email = $password = '';
$emailErr = $passwordErr = '';

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


    if ($email && $password) // validating user details
    {
        $fileName = 'database/' . $email . ".json";


        if (!file_exists($fileName)) // validating if the user exists
        {
            echo "User is not in the system";
        } else {

            $myFile = fopen($fileName, "r+") or die("Unable to open file!");
            $userData = fread($myFile, filesize($fileName));
            $userArray = json_decode($userData, true);
            $newUserData = [
                'firstName' => strtolower($userArray['firstName']),
                'surname' => strtolower($userArray['surname']),
                'email' => strtolower($userArray['email']),
                'password' => $password
            ];
            fclose($myFile);

            file_put_contents('database/' . $newUserData['email'] . ".json", json_encode($newUserData));

            echo "Your password was successfully changed";
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
    <title>Password Reset</title>

    <style>
        .form_wrapper {
            text-align: center;
        }

        a {
            text-decoration: none;
        }
    </style>
</head>

<body>

    <button>
        <p><a href="index.php" role="button">Home</a></p>
    </button>
    <div class="form_wrapper">

        
            <h1>Password Reset</h1>
                    <form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">

                        <label for="email">Email</label>

                        <input type="email" name="email" id="email" placeholder="Email"> <br> <br>
                        <span><?php echo $emailErr; ?></span>

                        <label for="password">New password</label>
                        <input type="password" name="password" id="password" placeholder="New password"> <br> <br>
                        <span><?php echo $passwordErr; ?></span>
                        <button type="submit" name="submitted">Reset</button>
                    </form>
        
    </div>

</body>

</html>