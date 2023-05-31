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
$coursephps_result = mysqli_query($conn, $courses_query);
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <title>Dashboard Professor</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/meyer-reset/2.0/reset.min.css" />
    <link rel="stylesheet" href="./styleDashboard.css" />
    <style>
    a {
        text-decoration: none;
        /* no underline */
    }
    </style>
</head>

<body>
    <!-- partial:index.partial.html -->
    <div class="app">
        <header class="app-header">
            <div class="app-header-logo">
                <div class="logo">
                    <span class="logo-icon">
                        <img src="./images/metamask-logo-white.png" />
                    </span>
                    <h1 class="logo-title">
                        <span>Metamask</span>
                        <span>Management</span>
                    </h1>
                </div>
            </div>
            <div class="app-header-navigation">
                <div class="tabs">
                    <a href="#"> Personal </a>
                    <a href="#" class="active"> Overview</a>
                    <a href="#"> Account </a>
                    <a href="#"> System </a>
                    <a href="#"> Departement</a>
                </div>
            </div>
            <div class="app-header-actions">
                <span>Pr. <?php echo $res_sql['nom_prf'] . " " . $res_sql['prenom_prf']; ?></span>

                <div class="app-header-actions-buttons">
                    <button class="icon-button large">
                        <i class="ph-magnifying-glass"></i>
                    </button>
                    <button class="icon-button large">
                        <i class="ph-bell"></i>
                    </button>
                </div>
            </div>
            <div class="app-header-mobile">
                <button class="icon-button large">
                    <i class="ph-list"></i>
                </button>
            </div>
        </header>
        <div class="app-body">
            <div class="app-body-navigation">
                <nav class="navigation">
                    <a href="./dashboardUI.blade.php">
                        <i class="ph-browsers"></i>
                        <span>Dashboard</span>
                    </a>
                    <a href="#">
                        <i class="ph-check-square"></i>
                        <span>Emplois</span>
                    </a>
                    <a href="#">
                        <i class="ph-swap"></i>
                        <span>Reunions</span>
                    </a>
                    <a href="#">
                        <i class="ph-file-text"></i>
                        <span>Doctorants</span>
                    </a>
                    <a href="#">
                        <i class="ph-globe"></i>
                        <span>Exams</span>
                    </a>
                    <a href="./home_page.html">
                        <i class="ph-clipboard-text"></i>
                        <span>Home</span>
                    </a>
                </nav>
                <footer class="footer">
                    <h1>Metamask<small>©</small></h1>
                    <div>
                        Metamsk ©<br />
                        Academic Web Project 2023
                    </div>
                </footer>
            </div>
            <div class="app-body-main-content">
                <section class="service-section">
                    <h2>ENSAKH Dashboard</h2>
                    <div class="service-section-header">
                        <div class="search-field">
                            <i class="ph-magnifying-glass"></i>
                            <input type="text" placeholder="Account number" style="color: whitesmoke;" />
                        </div>
                        <div class="dropdown-field">
                            <select>
                                <option>Home</option>
                                <option>Work</option>
                            </select>
                            <i class="ph-caret-down"></i>
                        </div>
                        <button class="flat-button">Search</button>
                    </div>
                    <div class="mobile-only">
                        <button class="flat-button">Toggle search</button>
                    </div>
                </section>

                <section class="transfer-section">
                    <div class="transfer-section-header">
                        <h2>My Courses</h2>
                        <div class="filter-options">
                            <p>ENSA KHOURIBGA</p>
                        </div>
                    </div>
                    <div class="transfers">
                        <?php while ($course = mysqli_fetch_assoc($coursephps_result)): 
                                $query1 = "SELECT id FROM cours WHERE name = ?";
                                $stmt1 = mysqli_prepare($conn, $query1);
                                mysqli_stmt_bind_param($stmt1, "s", $course['name']);
                                mysqli_stmt_execute($stmt1);
                                $result1 = mysqli_stmt_get_result($stmt1);
                                $row1 = mysqli_fetch_assoc($result1);
                                $course_id = $row1['id'];

                                $enrollment_query = "SELECT COUNT(*) as enrollment_count FROM enrollment WHERE CourseID = ?";
                                $stmt2 = mysqli_prepare($conn, $enrollment_query);
                                mysqli_stmt_bind_param($stmt2, "i", $course_id);
                                mysqli_stmt_execute($stmt2);
                                $enrollment_result = mysqli_stmt_get_result($stmt2);
                                $enrollment_count = mysqli_fetch_assoc($enrollment_result)['enrollment_count'];
                            ?>
                        <div class="transfer">
                            <dl class="transfer-details">
                                <div>
                                    <dt><a
                                            href="./generate_infos.blade.php?course_name=<?php echo $course['name']; ?>"><?php echo $course['name']; ?></a>
                                    </dt>
                                    <dd>Cours & TD</dd>
                                </div>
                                <div>
                                    <dt>0<?php echo $enrollment_count; ?></dt>
                                    <dd>Enrolled Students</dd>
                                </div>
                                <div>
                                    <dt>2023 - 2022</dt>
                                    <dd>Academic Year</dd>
                                </div>
                            </dl>
                        </div>
                        <?php endwhile; ?>
                    </div>

                </section>
            </div>
            <div class=" app-body-sidebar">
                <section class="payment-section">
                    <form method="post">
                        <div class="faq">
                            <p>You can add courses here!</p>
                            <div>
                                <label for="name">Course</label>
                                <input type="text" placeholder="Type here" name="name" autocomplete="off"
                                    style="color:whitesmoke;" />
                            </div>
                            <div>
                                <label for="department">Departement</label>
                                <input type="text" placeholder="Type here" name="department" required autocomplete="off"
                                    style="color:whitesmoke;" />
                            </div>
                        </div>
                        <div class="payment-section-footer">
                            <button class="save-button" name="submit">Save</button>
                            <button class="settings-button">
                                <i class="ph-gear"></i>
                                <span>More settings</span>
                            </button>
                        </div>
                        <?php
                            // Check if form is submitted
                            if ($_SERVER["REQUEST_METHOD"] == "POST") {
                                $name = $_POST["name"];
                                $department = $_POST["department"];
                            
                                // Check if course already exists in database
                                $sql_check = "SELECT * FROM cours WHERE name='$name'";
                                $result_check = $conn->query($sql_check);
                                if ($result_check->num_rows > 0) {
                                echo "<p><br>Course already exists in database.</p>";
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
                                    echo "<p><br>New course added successfully.</p>";
                                } else {
                                    echo "Error: " . $sql_insert . "<br>" . $conn->error;
                                }
                                }
                            }             
                        ?>
                    </form>

                </section>
            </div>
        </div>
    </div>
    </div>
    <!-- partial -->

    <script src="https://unpkg.com/phosphor-icons"></script>
    <script src="./scriptDashboard.js"></script>
</body>

</html>