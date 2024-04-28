<?php
function connect(
    $host = "localhost",
    $user = "root",
    $pass = "w(-d31qsFwpw@]Gj",
    $dbname = "notes"
) {
    $link = new mysqli($host, $user, $pass, $dbname);
    if ($link->connect_error) {
        die("Ошибка: " . $link->connect_error);
    }
    return $link;
}

function register($login, $pass, $email)
{
    //удаление лишних символов из строки(пробелыб переносы строк, табуляции и т.д.)
    $login = trim(htmlspecialchars($login));
    $pass = trim(htmlspecialchars($pass));
    $email = trim(htmlspecialchars($email));

    //проверка заполнения полей формы и соблюдения условий длины логина и пароля
    if ($login == "" || $pass == "" || $email == "") {
        echo "<h3><span style='color: red;'>Заполните все поля!</span></h3>";
        return false;
    }
    if (strlen($login) < 2 || strlen($login) > 30) {
        echo "<h3><span style='color: red;'>Длина логина должна быть от 2 до 30 символов!</span></h3>";
        return false;
    }
    if (strlen($pass) < 6 || strlen($pass) > 30) {
        echo "<h3><span style='color: red;'>Длина пароля должна быть от 6 до 30 символов!</span></h3>";
        return false;
    }
    //хэшированный пароль
    $hash_pass = md5($pass);

    $ins = "insert into users(login, pass, email, roleid) values('$login', '$hash_pass', '$email', 2)";
    $link = connect(); //получение объекта подключения
    $link->query($ins); //выполнение запроса
    $link->close(); //закрытие подключения
    return true;
}

function login($login, $pass)
{
    $login = trim(htmlspecialchars($login));
    $pass = trim(htmlspecialchars($pass));

    if ($login == "" || $pass == "") {
        echo "<h3><span style='color: red;'>Заполните все поля!</span></h3>";
        return false;
    }
    if (strlen($login) < 2 || strlen($login) > 30) {
        echo "<h3><span style='color: red;'>Длина логина должна быть от 2 до 30 символов!</span></h3>";
        return false;
    }
    if (strlen($pass) < 6 || strlen($pass) > 30) {
        echo "<h3><span style='color: red;'>Длина пароля должна быть от 6 до 30 символов!</span></h3>";
        return false;
    }

    $hash_pass = md5($pass);

    $link = connect();
    $sel = "select * from users where login='$login' and pass='$hash_pass'";
    $res = $link->query($sel);
    if ($row = $res->fetch_assoc()) {
        $_SESSION["user"] = $login;
        if ($row["roleid"] == 1) {
            $_SESSION["admin"] = $login;
        }
        return true;
    } else {
        echo "<h3><span style='color: red;'>Пользователь не найден!</span></h3>";
        return false;
    }
}

function get_id()
{
    $link = connect();

    if (isset($_SESSION["user"])) {
        $username = $_SESSION["user"];
    }
    else {
        $username = $_SESSION["admin"];
    }

    $sel = "select id from users where login = '$username'";
    $res = $link->query($sel);    
    
    foreach ($res as $row) {
        $userid = $row["id"];
    }
    return $userid;
}

function get_role()
{
    $link = connect();

    if (isset($_SESSION["user"])) {
        $username = $_SESSION["user"];
    }
    else {
        $username = $_SESSION["admin"];
    }

    $sel = "select roleid from users where login = '$username'";
    $res = $link->query($sel);    
    
    foreach ($res as $row) {
        $userrole = $row["roleid"];
    }
    return $userrole;
}

?>