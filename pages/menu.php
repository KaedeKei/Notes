<nav class="navbar navbar-expand-lg navbar-light bg-light nav-justified py-3">
<div class="container">
    <a class="navbar-brand" href="index.php?page=1">Your notes</a>

    <div class="collapse navbar-collapse" id="navbarTogglerDemo02">
        <ul class="navbar-nav mr-auto mt-2 mt-lg-0">
            <li class="nav-item">
                <a class="nav-link" href="index.php?page=2">Registration</a>
            </li>

    <?php
        $userrole = get_role();
        if (!isset($_SESSION["user"])) {
        }
        else if ($userrole == 1)
        {
            echo "<li class='nav-item'>
            <a class='nav-link' href='index.php?page=3'>Privacy</a>
            </li>";
        }
        
    ?>

        </ul>
    </div>

    <div>
        
    <?php
            include_once("pages/login.php");
    ?>
        
    </div>

    </div>
</nav>


    