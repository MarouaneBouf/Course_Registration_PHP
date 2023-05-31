<?php
session_start();
include("database.blade.php");

// Check if the user is logged in
if (!isset($_SESSION['NAME'])) {
    header("Location: index.blade.php");
    exit();
}

$studentName = $_SESSION['NAME'];
$sql = "SELECT * FROM etudiants WHERE nom = '$studentName'";
$res_sql = mysqli_fetch_assoc(mysqli_query($conn, $sql));

// YOU NEED TO TRACK THE LAST ID FOR ENROLLEMENT!!! and the following piece of code does the trick!
$lastID_query = "SELECT EnrollmentID FROM enrollment ORDER BY EnrollmentID DESC LIMIT 1";
$last_IDenrollement_result = mysqli_query($conn, $lastID_query);
if (mysqli_num_rows($last_IDenrollement_result) > 0) {
    $last_IDenrollement = mysqli_fetch_assoc($last_IDenrollement_result)['EnrollmentID'];
} else {
    $last_IDenrollement = 0;
}
$newID_enrollement = $last_IDenrollement + 1;



// Check if the form has been submitted
if (isset($_POST['submit'])) {
    $studentName = $_SESSION['NAME'];
    $courseID = $_POST['course'];
    $professorID = $_POST['professor'];
    
    // Check if the student is already enrolled in the course
    $query_find_ID = "SELECT cne FROM etudiants WHERE etudiants.nom = '$studentName'";
    $studentID = mysqli_fetch_assoc(mysqli_query($conn, $query_find_ID))["cne"];
    // print_r($studentID);
    $check_query = "SELECT * FROM enrollment WHERE StudentID = '$studentID' AND CourseID = '$courseID'";
    $check_result = mysqli_query($conn, $check_query);
    if (mysqli_num_rows($check_result) > 0) {
        $error = "You are already registered for this course!";
    } else {
        // Insert the enrollment data into the database

        $query = "INSERT INTO enrollment(EnrollmentID, StudentID, CourseID, ProfessorID) VALUES ('$newID_enrollement', '$studentID', '$courseID', '$professorID')"; 
        $result = mysqli_query($conn, $query);
        if ($result) {
            $success = "You have successfully registered for the course!";
        } else {
            $error = "An error occurred while registering for the course. Please try again.";
        }
    }
}

// Retrieve the list of available courses from the database
$courses_query = "SELECT * FROM cours";
$courses_result = mysqli_query($conn, $courses_query);

// Retrieve the list of available professors from the database
$professors_query = "SELECT * FROM professeurs";
$professors_result = mysqli_query($conn, $professors_query);
?>

<!DOCTYPE html>
<html>

<head>
    <title>Course Registration</title>
    <link rel="stylesheet" type="text/css" href="register_style.css">
</head>

<body>
    <div class="container">
        <div class="right">
            <h1>Course Registration</h1>
            <?php if (isset($error)) { ?>
            <div class="error"><?php echo $error; ?></div>
            <?php } ?>
            <?php if (isset($success)) { ?>
            <div class="success"><?php echo $success; ?></div>
            <?php } ?>
            <form method="post" action="">
                <div class="form-group">
                    <label for="course">Course:</label>
                    <select name="course" id="course">
                        <?php while ($course = mysqli_fetch_assoc($courses_result)) { ?>
                        <option value="<?php echo $course['id']; ?>"><?php echo $course['name']; ?></option>
                        <?php } ?>
                    </select>
                </div>
                <div class="form-group">
                    <label for="professor">Professor:</label>
                    <select name="professor" id="professor">
                        <?php while ($professor = mysqli_fetch_assoc($professors_result)) { ?>
                        <option value="<?php echo $professor['prf_id']; ?>">
                            <?php echo $professor['prenom_prf'] . " " . $professor['nom_prf']; ?></option>
                        <?php } ?>
                    </select>
                </div>
                <div class="form-group">
                    <input type="submit" name="submit" value="Register">
                </div>
            </form>
            <a href="index.php" class="logout-btn">Logout</a>
        </div>
    </div>
</body>

</html>