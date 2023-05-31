<?php
    // ini_set('display_errors', 0);
    include("database.blade.php");
    session_start();
    $actual_name = $_SESSION['NAME'];
    $course_name = $_GET['course_name'];
    // If the user clicks the logout button, destroy the session and redirect to the login page
    
    if (isset($_POST['logout'])) {
        session_destroy();
        header("Location: index.blade.php");
        exit();
    }
?>
<?php
    // Retrieve the student's cours details from the database using a join operation
    $query = "SELECT a.id_absence, a.date, a.type_absence, e.cne, e.nom, e.prenom, e.filiere, c.id AS course_id, c.name AS course_name, c.department AS course_department, p.nom_prf, p.prenom_prf
    FROM etudiants e
    JOIN enrollment en ON e.cne = en.StudentID
    JOIN cours c ON en.CourseID = c.id
    JOIN professeurs p ON en.ProfessorID = p.prf_id
    JOIN absence a ON e.cne = a.etudiant_id AND c.id = a.cours_id
    WHERE c.name = '{$course_name}'";
    $result = mysqli_query($conn, $query);

    // Store the absence details in an array
    $absences = array();
    while ($row = mysqli_fetch_assoc($result)) {
        $absences[] = $row;
    }
?>

<?php
    // Retrieve the student's cours details from the database using a join operation
    $query = "SELECT e.cne, e.nom, e.prenom, e.filiere
    FROM etudiants e
    JOIN enrollment en ON e.cne = en.StudentID
    JOIN cours c ON en.CourseID = c.id
    WHERE c.name = '{$course_name}'";
    $result = mysqli_query($conn, $query);

    // Store the student details in an array
    $students = array();
    while ($row = mysqli_fetch_assoc($result)) {
        $students[] = $row;
    }
?>



<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <title>Dashboard Std</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/meyer-reset/2.0/reset.min.css" />
    <link rel="stylesheet" href="./styleDashboard_GenerateInfos.css" />
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
                <span>THIS NEED A FIX</span>

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
                    <a href="index.blade.php">
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
                    <h2 id="abs"> ENSAKH Dashboard</h2>
                    <div class="service-section-header">
                        <div class="search-field">
                            <i class="ph-magnifying-glass"></i>
                            <input type="text" placeholder="Account number" />
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
                        <article class="tile" id="Abscence">
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
                        <article class="tile" id="Letd">
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
                            Veuillez contacter l'administration si vous rencontrez un problème technique!
                        </p>
                    </div>
                </section>

                <section class="transfer-section">
                    <div class="abscence" style="display:none;">
                        <div class="transfer-section-header">
                            <h2>Les Absences</h2>
                            <div class="filter-options">
                                <p><?php echo $course_name?></p>
                            </div>
                        </div>
                        <!-- a.id_absence, a.date, a.type_absence, e.cne, e.nom, e.prenom, e.filiere, c.id -->
                        <div class=" transfers">
                            <?php foreach ($absences as $absence) { ?>
                            <div class="transfer">
                                <dl class="transfer-details">
                                    <div>
                                        <dt><?php echo $absence["prenom"]." ".$absence["nom"];?></dt>
                                        <dd>Etudiant</dd>
                                    </div>
                                    <div>
                                        <dt><?php echo $absence["type_absence"];?></dt>
                                        <dd>Type Absence</dd>
                                    </div>
                                    <div>
                                        <dt><?php echo $absence["filiere"]?></dt>
                                        <dd>Filiére</dd>
                                    </div>
                                    <div>
                                        <dt><?php echo $absence["date"]?></dt>
                                        <dd>Date Absence</dd>
                                    </div>
                                </dl>
                            </div>
                            <?php } ?>
                        </div>
                    </div>



                    <div class="ListeEtd" style="display:none;">
                        <br>
                        <div class="transfer-section-header">
                            <h2>Liste Etudiants</h2>
                            <div class="filter-options">
                                <p><?php echo $course_name?></p>
                            </div>
                        </div>
                        <!-- e.cne, e.nom, e.prenom, e.filiere -->
                        <div class="transfers">
                            <?php foreach ($students as $student) { ?>
                            <div class="transfer">
                                <dl class="transfer-details">
                                    <div>
                                        <dt><?php echo $student["prenom"]." ".$student["nom"];?></dt>
                                        <dd>Etudiant</dd>
                                    </div>
                                    <div>
                                        <dt>0<?php echo $student["cne"];?></dt>
                                        <dd>Code national de l'étudiant</dd>
                                    </div>
                                    <div>
                                        <dt><?php echo $student["filiere"]?></dt>
                                        <dd>Filiére</dd>
                                    </div>
                                </dl>
                            </div>
                            <?php } ?>
                        </div>
                    </div>


                </section>


            </div>

        </div>
    </div>
    </div>
    <!-- partial -->
    <script src="https://unpkg.com/phosphor-icons"></script>
    <script src="./scriptDashboard.js"></script>
</body>

<script>
document.addEventListener('DOMContentLoaded', () => {

    document.getElementById("Abscence").addEventListener('click', function() {
        const element = document.querySelector(".abscence");
        element.style.opacity = 0;
        element.style.display = 'block';
        setTimeout(() => {
            element.style.opacity = 1;
        }, 10);
    });
    document.getElementById("Letd").addEventListener('click', function() {
        const element = document.querySelector(".ListeEtd");
        element.style.opacity = 0;
        element.style
            .display = 'block';
        setTimeout(() => {
            element.style.opacity = 1;
        }, 10);
    });

});
</script>

</html>