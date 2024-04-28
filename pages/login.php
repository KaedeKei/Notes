<?php
//если есть активный пользователь - выводим приветствие и кнопку выхода
if (isset($_SESSION["user"])) {
    echo "<form action='index.php";
    if (isset($_GET["page"])) echo "?page=" . $_GET['page'] . "'";
    echo " method='post' class='my-1'>";

    echo "<div class='d-flex justify-content align-items-center w-auto ms-auto'>";
    echo "<h4 class='fw-bold fs-5 me-3'><span>" . $_SESSION["user"] . "</span></h4>";
    echo "<input type='submit' value='Выйти' id='exit' name='exit' class='btn btn-danger' />";
    echo "</div></form>";

    //если нажата кнопка Выйти
    if (isset($_POST["exit"])) {
        //сбрасываем пользователя в сессии
        unset($_SESSION["user"]);
        //unset($_SESSION["admin"]);
        echo "<script>window.location.reload()</script>"; //перезагрузка страницы
    }
} else {
    //если в сессии нет активного пользователя - выводим форму аутентификации
    if (isset($_POST["enter"])) {
        //если нажата кнопка Войти - перезагружаем страницу, чтобы сохранить активного пользователя и вывести приветствие
        if (login($_POST["login"], $_POST["pass"])) {
            echo "<script>window.location.reload()</script>"; //перезагрузка страницы
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
