<?php
    // ini_set('display_errors', 0);
    include("database.blade.php");
    session_start();
    $actual_name = $_SESSION['NAME'];
    // If the user clicks the logout button, destroy the session and redirect to the login page
    
    if (isset($_POST['logout'])) {
        session_destroy();
        header("Location: index.blade.php");
        exit();
    }

?>

<?php
    // Retrieve the student's cours details from the database using a join operation
    $query = "SELECT e.cne, e.nom, e.prenom, e.filiere, c.name AS course_name, c.department AS course_department, p.nom_prf, p.prenom_prf
    FROM etudiants e
    JOIN enrollment en ON e.cne = en.StudentID
    JOIN cours c ON en.CourseID = c.id
    JOIN professeurs p ON en.ProfessorID = p.prf_id
    WHERE e.nom = '{$actual_name}'";
    $result = mysqli_query($conn, $query);

    // Store the course details in an array
    $courses = array();
    while ($row = mysqli_fetch_assoc($result)) {
        $courses[] = $row;
    }
?>

<!DOCTYPE html>
<html>

<head>
    <title>Dashboard</title>
    <link rel="stylesheet" href="./etd_style.css">
    <link rel="icon" href="./images/metamask.png" />
</head>

<body>
    <div class="container">
        <h1>Student Course Details</h1>
        <p class="welcome">Welcome, <?php echo $actual_name?>!</p>
        <table>
            <thead>
                <tr>
                    <th>Course Name</th>
                    <th>Department Name</th>
                    <th>Professor Name</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($courses as $course) { ?>
                <tr>
                    <td><?php echo $course['course_name']; ?></td>
                    <td><?php echo $course['course_department']; ?></td>
                    <td><?php echo $course['nom_prf'] . " " . $course['prenom_prf']; ?></td>
                </tr>
                <?php } ?>
            </tbody>
        </table>
        <div class="sub_container">
            <form method="post">
                <button name="logout" onclick="location.href='index.blade.php'">Home</button>
            </form>
            <a href="./register.blade.php">
                <button id="register-button">
                    Register for a new course
                </button>

            </a>
        </div>

    </div>
    <br><br>

</body>

</html>