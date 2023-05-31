<!DOCTYPE html>
<html>

<head>
    <title>Dashboard</title>
</head>

<body>
    <?php
        session_start();
        include("database.blade.php");

        // // Check if the user is logged in as a professor
        // if (!isset($_SESSION['PROF_ID'])) {
        //     header("Location: index.php");
        //     exit();
        // }

        $professorNAME = $_SESSION['NAME'];
        echo "{$professorNAME}";
        $sql = "SELECT * FROM professeurs WHERE nom_prf = '$professorNAME'";
        $res_sql = mysqli_fetch_assoc(mysqli_query($conn, $sql));
    ?>

    <h1>Welcome, <?php echo $res_sql['nom_prf'] . " " . $res_sql['prenom_prf']; ?></h1>

    <form method="POST" action="create_course.php">
        <label>Course Name:</label>
        <input type="text" name="course_name"><br><br>

        <label>Department:</label>
        <input type="text" name="department"><br><br>

        <input type="submit" name="submit" value="Create Course">
    </form>

</body>

</html>