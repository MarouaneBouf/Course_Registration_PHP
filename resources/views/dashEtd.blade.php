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
    $res_map = mysqli_fetch_assoc($result);

    // Store the course details in an array
    $courses = array();
    while ($row = mysqli_fetch_assoc($result)) {
        $courses[] = $row;
    }
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <title>Dashboard Std</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/meyer-reset/2.0/reset.min.css" />
    <link rel="stylesheet" href="./styleDashboard.css" />
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
                <span><?php echo strtoupper($res_map['nom']." ".$res_map['prenom'])                                                                               ; ?></span>

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
                    <a href="#">
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
                    <a href="index.php">
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
                    <div class="tiles">
                        <article class="tile">
                            <div class="tile-header">
                                <i class="ph-lightning-light"></i>
                                <h3>
                                    <span>Absence</span>
                                    <span>Fiche d'Absence</span>
                                </h3>
                            </div>
                            <a href="#">
                                <span>Go to service</span>
                                <span class="icon-button">
                                    <i class="ph-caret-right-bold"></i>
                                </span>
                            </a>
                        </article>
                        <article class="tile">
                            <div class="tile-header">
                                <i class="ph-fire-simple-light"></i>
                                <h3>
                                    <span>Notes</span>
                                    <span>Fiche de Notes</span>
                                </h3>
                            </div>
                            <a href="#">
                                <span>Go to service</span>
                                <span class="icon-button">
                                    <i class="ph-caret-right-bold"></i>
                                </span>
                            </a>
                        </article>
                        <article class="tile">
                            <div class="tile-header">
                                <i class="ph-file-light"></i>
                                <h3>
                                    <span>Liste Etudiant</span>
                                    <span>Fiche des Etudiants</span>
                                </h3>
                            </div>
                            <a href="#">
                                <span>Go to service</span>
                                <span class="icon-button">
                                    <i class="ph-caret-right-bold"></i>
                                </span>
                            </a>
                        </article>
                    </div>
                    <div class="service-section-footer">
                        <p>
                            Les services doivent etre implementer en code php.
                        </p>
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
                        <?php foreach ($courses as $course) { ?>
                        <div class="transfer">
                            <dl class="transfer-details">
                                <div>
                                    <dt> <?php echo $course['course_name']; ?>
                                    </dt>
                                    <dd><?php echo $course['course_department']; ?></dd>
                                </div>
                                <div>
                                    <dt><?php echo $course['nom_prf'] . " " . $course['prenom_prf']; ?></dt>
                                    <dd>Professor Name</dd>
                                </div>
                                <div>
                                    <dt>2023/2022 </dt>
                                    <dd>Academic year</dd>
                                </div>
                            </dl>
                        </div>
                        <?php } ?>
                    </div>
                </section>

            </div>
            <div class="app-body-sidebar">
                <section class="payment-section">
                    <form method="post">
                        <div class="faq">
                            <p>You can register for courses here!</p>
                            <div>
                                <label for="name">Course</label>
                                <input type="text" placeholder="Type here" name="name" autocomplete="off"
                                    style="color:whitesmoke;" />
                            </div>
                            <div>
                                <label for="department">Departement</label>
                                <input type="text" placeholder="Type here" name="department" autocomplete="off" required
                                    style="color:whitesmoke;" />
                            </div>
                        </div>
                        <div class="payment-section-footer">
                            <button class="save-button" onclick="location.href='register.blade.php'">
                                Register for a new course
                            </button>
                            <button class="settings-button">
                                <i class="ph-gear"></i>
                                <span>More settings</span>
                            </button>
                        </div>
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