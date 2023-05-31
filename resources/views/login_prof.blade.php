<?php
    include("database.blade.php");
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="icon" href="./images/professor.png" />
    <script src="./script.js"></script>
    <link rel="stylesheet" href="style_prof.css?v=<?php echo time(); ?>">
    <link rel="icon" href="./images/metamask.png" />
    <title>Professors Login</title>
</head>

<body>
    <div class="container">
        <div id="left-section">
            <img src="./images/Design-TIME.jpg" alt="Photograph" width="80%" />
        </div>
        <div id="right-section">
            <h1 style="font-size: 29px">Welcome Professor!</h1>
            <p style="font-size: 13px; color: rgb(160, 160, 160)">
                Please log in to continue.
            </p>
            <form action="" method="post">
                <div id="inputs">
                    <input class="input" type="text" placeholder="Name" name="NAME" autocomplete="off" />
                    <input name="PASS" class="input" type="password" placeholder="Password" autocomplete="off" />
                </div>
                <div id="btns">
                    <button id="new_acc" type="submit" name="submit">Login here</button>
                </div>

            </form>
        </div>
    </div>
</body>

</html>


<?php
    session_start();
    ini_set('display_errors', 0);

    // check if the login form has been submitted
    if(isset($_POST['submit'])){

        // retrieve the login name from the form
        $login_name = $_POST['NAME'];
        $query = "SELECT * FROM professeurs WHERE nom_prf = '$login_name'";
        $result1 = mysqli_query($conn, $query);

        // Check If Professor
        if (mysqli_num_rows($result1) == 1) {
            $_SESSION['NAME'] = $login_name;
            header("Location: dashboardUI.blade.php");
            //exit();
        } 
        else {
            header("Location: error.html");
        }
    }
?>