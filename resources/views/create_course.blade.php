?php
session_start();
include("database.blade.php");

// Check if the user is logged in as a professor
if (!isset($_SESSION['PROF_ID'])) {
header("Location: index.php");
exit();
}

if (isset($_POST['submit'])) {
$courseName = $_POST['course_name'];
$department = $_POST['department'];

// Insert the course data into the database
$query = "INSERT INTO cours(name, department) VALUES ('$courseName', '$department')";
$result = mysqli_query($conn, $query);

if ($result) {
$success = "Course created successfully!";
} else {
$error = "An error occurred while creating the course. Please try again.";
}
}
?>