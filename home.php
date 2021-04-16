<?php
session_start();
if (!isset($_SESSION['isLogged']) || "1" != $_SESSION['isLogged']) {
    header('Location:signin.php');
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Signup Page</title>
</head>

<body>
    <nav class="navbar navbar-default navbar-static-top">
        <div class="container">
            <form action="<?php echo htmlspecialchars("logout.php"); ?>" method="POST">
                <button type="submit" class="btn btn-danger navbar-btn navbar-right?" name="signout">Log out</button>
            </form>
        </div>
    </nav>

        <p>
            <?php
            if ($_SESSION['email']) {
                echo "Welcome " . $_SESSION['email'];
            }
            ?>
        </p>
               
</body>

</html>