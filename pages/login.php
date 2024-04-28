<?php
if (isset($_SESSION["user"])) {
    echo "<form action='index.php";
    if (isset($_GET["page"])) echo "?page=" . $_GET['page'] . "'";
    echo " method='post' class='my-1'>";

    echo "<div class='d-flex justify-content align-items-center w-auto ms-auto'>";
    echo "<h4 class='fw-bold fs-5 me-3'><span>" . $_SESSION["user"] . "</span></h4>";
    echo "<input type='submit' value='Выйти' id='exit' name='exit' class='btn btn-danger' />";
    echo "</div></form>";

    if (isset($_POST["exit"])) {
        unset($_SESSION["user"]);
        //unset($_SESSION["admin"]);
        echo "<script>window.location.reload()</script>"; 
    }
} else {
    if (isset($_POST["enter"])) {
        if (login($_POST["login"], $_POST["pass"])) {
            echo "<script>window.location.reload()</script>"; 
        }
    } else {
        echo "<form action='index.php";
        if (isset($_GET["page"])) echo "?page=" . $_GET['page'] . "'";
        echo " method='post' class='my-1'>";

        echo "<div class='d-flex justify-content-between align-items-center w-auto ms-auto'>";
        echo "<input type='text' name='login' class='form-control me-3' placeholder='Логин'/>";
        echo "<input type='password' name='pass' class='form-control me-3' placeholder='Пароль'/>";
        echo "<input type='submit' value='Войти' name='enter' class='btn btn-secondary'/>";
        echo "</div></form>";
    }
}
