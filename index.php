<?php
session_start();
include_once("pages/functions.php");
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Your Notes</title>
    <link rel="stylesheet" href="css/bootstrap.min.css">
</head>

<body>
        <div class="row">
            <header class="col-sm-12 col-md-12 col-lg-12 bg-secondary">
                <?php
                ?>
            </header>
        </div>
        <div class="row">
            <nav class="col-sm-12 col-md-12 col-lg-12">
                <?php
                include_once("pages/menu.php");
                ?>
            </nav>
        </div>
        <div class="row" style="min-height: 80vh">
            <section class="col-sm-12 col-md-12 col-lg-12">
                <?php
                if (isset($_GET["page"])) {
                    $page = $_GET["page"];
                    switch ($page) {
                        case 1:
                            include_once("pages/notes.php");
                            break;
                        case 2:
                            include_once("pages/registration.php");
                            break;
                        case 3:
                            include_once("pages/privacy.php");
                            break;
                        default:
                            include_once("pages/not_found.php");
                            break;
                    }
                }
                ?>
            </section>
        </div>
        <div class="row">
            <footer>2024, &copy; All Rights Reserved by nobody. </footer>
        </div>


    <script src="js/bootstrap.bundle.min.js"></script>
</body>

</html>