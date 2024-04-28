<?php
if (!isset($_SESSION["admin"]) && !isset($_SESSION["customer"])) {
    echo "<h3><span style='color: red;'>Вход только для зарегистрированных пользователей!</span></h3>";
    exit();
}

$link = connect();
$username = $_SESSION["user"];

echo "<form action='index.php?page=2' method='post' id='formhotel' class='mb-4'>";
echo "<div class='form-group d-flex'><select class='form-select mt-2 w-25' name='hotelid'>";
$res = $link->query("select ci.id as cityid, ci.city, co.id as countryid, co.country, ho.id as hotelid, ho.hotel from countries co, cities ci, hotels ho where co.id=ci.countryid and ho.cityid=ci.id");
foreach ($res as $row) {
    echo "<option value='" . $row["hotelid"] . "'>" . $row["hotel"] . ", " . $row["city"] . ", " . $row["country"] . "</option>";
}
echo "</select>";
echo "<div class='form-group mt-2 w-75'><textarea name='comment' placeholder='Введите комментарий' rows='1' class='form-control'></textarea></div></div>";
echo "<input type='submit' class='btn btn-outline-primary mt-2' value='Добавить комментарий' name='addcomment' />";
echo "</form>";

if (isset($_POST["addcomment"])) {
    $idhotel = $_POST['hotelid'];
    //я не  стала переделывать базу, чтобы проще было проверять работу и сделала комменты в файле
    //поэтому чтобы id отеля правильно считывлся, просто пока представим, что потолок - 99 отелей
    //и если id меньше 10, т.е. из 1 символа, добавим в начало нолик
    //чтобы потом могли прочитать
    if ($idhotel < 10)
    {
        $idhotel = "0" . $idhotel;
    }
    $comment = trim(htmlspecialchars($_POST["comment"]));
    //пришлось заменять перенос строк для многостраничного комментария
    $forreplace = array("\r\n", "\n", "\r");
    //и брать для этого костыль в виде малоиспользуемого символа
    $replaceon = '◲';
    $comment = str_replace($forreplace, $replaceon, $comment);
    $file = "comments.txt";
    //читаем весь файл комментариев
    $current = file_get_contents($file);
    //и добавляем наш комментарий
    //тут костыль в виде другого символа "▙", который вряд ли кому-то придет в голову добавлять
    //если добавят, будет печаль
    $str = $current . "\n" . $idhotel. "▙". $_SESSION["user"] . "▙". $comment;
    file_put_contents($file, $str);
    echo "<script>window.location=document.URL</script>";
}

echo "<hr>";

echo "<form action='index.php?page=2' method='post' id='formhotel' class='mb-4'>";
echo "<select class='form-select mt-2' name='hotelidforselect'>";
$res = $link->query("select ci.id as cityid, ci.city, co.id as countryid, co.country, ho.id as hotelid, ho.hotel from countries co, cities ci, hotels ho where co.id=ci.countryid and ho.cityid=ci.id");
foreach ($res as $row) {
    echo "<option value='" . $row["hotelid"] . "'>" . $row["hotel"] . ", " . $row["city"] . ", " . $row["country"] . "</option>";
}
echo "</select>";
echo "<input type='submit' class='btn btn-outline-primary mt-2' value='Показать комментарии' name='showcomments' />";
echo "</form>";

if (isset($_POST["showcomments"])) {
    $hotelidforselect = $_POST['hotelidforselect'];
    $file = "comments.txt";
    $lines = file($file);
    foreach ($lines as $line_number => $line_text)
    {
        $hotelidfromcomments = intval(substr($line_text, 0, 2));
        if($hotelidfromcomments == $hotelidforselect){
            //делим строку по второму костылю
            $commenttext = explode('▙', $line_text);
            //и меняем первый на перенос строки
            $forreplace1 = '◲';
            $replaceon1 = "<br/>";
            $commentforshow = str_replace($forreplace1, $replaceon1, $commenttext[2]);
            echo "<div class='border mb-4 rounded'><strong>$commenttext[1]</strong> <p><em>$commentforshow</em></div>";
            //я не стала пока выводить аватар, потому что делать это через файл txt такое себе
        }
    }
}
?>