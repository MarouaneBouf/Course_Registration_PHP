<?php
    include("database.blade.php");
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" href="style.css?v=<?php echo time(); ?>">
    <link rel="icon" href="./images/metamask.png" />
    <script src="./script.js"></script>
    <title>Login Page</title>
</head>

<body>

    <div id="container">
        <div id="left-section">
            <img src="./images/Design-TIME1.jpg" alt="Photograph" width="100%" />
        </div>
        <div id="right-section">
            <h1 style="font-size: 29px">Welcome Back!</h1>
            <p style="font-size: 13px; color: rgb(160, 160, 160)">
                Please log in to continue.
            </p>
            <div id="inputs">
                <form action="" method="post">
                    <input class="input" type="text" placeholder="Name" name="NAME" autocomplete="off" />
                    <input name="FILIERE" class="input" type="text" placeholder="Filiere" autocomplete="off" />
                    <input name="PASS" class="input" type="password" placeholder="Password" autocomplete="off" />

            </div>
            <div id="btns">
                <button id="new_acc" type="submit" name="submit">Login here</button>
                <button id="google">
                    <div id="google_div">
                        <img src="./images/Google Logo.png" alt="Google Logo" width="7%" />
                        <p>Login with Google</p>
                    </div>
                </button>
                <p id="last_question">
                    Are you a professor? <span id="span_log"><a href="./login_prof.blade.php">Switch</a></span>
                </p>
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

        // prepare the SQL statement
        $stmt = $conn->prepare("SELECT * FROM etudiants WHERE nom = ?");
        $stmt->bind_param("s", $login_name);
        $stmt->execute();
        $result = $stmt->get_result();
        // check if the login name exists in the database
        if ($result->num_rows > 0) {
            $_SESSION['NAME'] = $login_name;
            header("Location: dashEtd.blade.php");
            exit();
        }
        $query = "SELECT * FROM professeurs WHERE nom_prf = '$login_name'";
        $result1 = mysqli_query($conn, $query);

        // Check If Professor
        if (mysqli_num_rows($result1) == 1) {
            $_SESSION['NAME'] = $login_name;
            header("Location: professor_info.blade.php");
            //exit();
        } 
        else {
            header("Location: error.html");
        }


    }
?>