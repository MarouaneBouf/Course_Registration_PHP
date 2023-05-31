<?php
session_start();
include("database.blade.php");

// Check if the user is logged in
if (!isset($_SESSION['NAME'])) {
    header("Location: login.blade.php");
    exit();
}

$professorName = $_SESSION['NAME'];
$sql = "SELECT * FROM professeurs WHERE nom_prf = '$professorName'";
$res_sql = mysqli_fetch_assoc(mysqli_query($conn, $sql));

// Get the courses taught by the professor
$courses_query = "SELECT DISTINCT cours.name FROM enrollment
                  INNER JOIN cours ON enrollment.CourseID = cours.id
                  WHERE enrollment.ProfessorID = '{$res_sql['prf_id']}'";
$courses_result = mysqli_query($conn, $courses_query);
?>

<!DOCTYPE html>
<html>

<head>
    <title>Professor Information</title>
    <link rel="stylesheet" href="prof_style.css?v=<?php echo time(); ?>">
    <link rel="icon" href="./images/metamask.png" />
</head>

<body>
    <h1>Welcome, <?php echo $res_sql['nom_prf'] . " " . $res_sql['prenom_prf']; ?></h1>
    <h2>Department: <?php echo $res_sql['departement_prf']; ?></h2>
    <h3>Courses Taught:</h3>
    <ul>
        <?php while ($course = mysqli_fetch_assoc($courses_result)): ?>
        <li><?php echo $course['name']; ?></li>
        <?php endwhile; ?>
    </ul>
    <div id="malek">
        <h2>You can add new courses!</h2>
        <form method="post">
            <label for="name">Course name:</label>
            <input type="text" id="name" name="name" autocomplete="off" required>
            <br>
            <label for="department">Department:</label>
            <input type="text" id="department" autocomplete="off" name="department" required>
            <br>
            <input type="submit" name="submit" value="Add Course">
            <?php
                // Check if form is submitted
                if ($_SERVER["REQUEST_METHOD"] == "POST") {
                    $name = $_POST["name"];
                    $department = $_POST["department"];
                
                    // Check if course already exists in database
                    $sql_check = "SELECT * FROM cours WHERE name='$name'";
                    $result_check = $conn->query($sql_check);
                    if ($result_check->num_rows > 0) {
                    echo "<p>Course already exists in database.</p>";
                    } else {
                    // Get last ID from cours table and increment by 1
                    $sql_id = "SELECT MAX(id) as max_id FROM cours";
                    $result_id = $conn->query($sql_id);
                    if ($result_id->num_rows > 0) {
                        $row = $result_id->fetch_assoc();
                        $id = $row["max_id"] + 1;
                    } else {
                        $id = 1;
                    }
                
                    // Insert new course into database
                    $sql_insert = "INSERT INTO cours (id, name, department) VALUES ('$id', '$name', '$department')";
                    if ($conn->query($sql_insert) === TRUE) {
                        echo "<p>New course added successfully.</p>";
                    } else {
                        echo "Error: " . $sql_insert . "<br>" . $conn->error;
                    }
                    }
                }             
                // Close database connection
                $conn->close();
            ?>
        </form>
    </div>
</body>

</html>