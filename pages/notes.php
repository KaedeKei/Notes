<?php
if (!isset($_SESSION["user"])) {    
    echo "<div class='container'>
    <h3><span style='color: red;'>Вход только для зарегистрированных пользователей!</span></h3>
    </div>";
    exit();
}
?>

<div class="row">
    <div class="col-sm-12 col-md-12 col-lg-12 left">
        <?php
        $link = connect();
        $userid = get_id();
        $sel = "select * from notes where userid = $userid order by id";
        $res = $link->query($sel);
        echo "<div class='container'>";
        echo "<form action='index.php?page=1' method='post' class='input-group' id='formnote'>";
        echo "<input type='text' class='form-control mt-2' name='note-title' placeholder='Введите заголовок' />";
        echo "<input type='text' class='form-control mt-2' name='note-text' placeholder='Введите текст' />";

        echo "<input type='submit' class='btn btn-secondary mt-2' value='Сохранить' name='addnote' />";
        echo "</div>";

        echo "<div class='container my-4'>
        <div class='row'>
        ";
        
        foreach ($res as $row) {
            echo "<div class='col-sm-4 col-md-3 col-lg-3'>
            <div class='card mb-4'>
                    <div class='card-body'>
                    <div class='col'>
                    <h5 class='card-title'>" . $row["notes_title"] . "</h5>
                        <p class='card-text'>" . $row["notes_text"] . "</p>
                        <input type='checkbox' class='form-check-input' name='cb" . $row["id"] . "' />
                        <input type='submit' class='btn btn-outline-danger mt-2' value='Удалить' name='delnote' />
                        </div>
                    </div>
                    </div>
            </div>";
        }
        echo "</div>";
        echo "</div>";
        echo "</form>";

        if (isset($_POST["addnote"])) {
            $notename = trim(htmlspecialchars($_POST["note-title"]));
            if ($notename == null) exit();

            $notetext = trim(htmlspecialchars($_POST["note-text"]));
            if ($notetext == null) exit();

            $userid = get_id();

            $ins = "insert into notes(notes_title, notes_text, userid) values('$notename', '$notetext', $userid)";
            $link->query($ins);


            //перезагрузка страницы
            echo "<script>window.location=document.URL</script>";

        }

        if (isset($_POST["delnote"])) {
            foreach ($_POST as $key => $value) {
                //проверяем, содержится ли в строке ключи, начинающиеся с "cb"
                if (substr($key, 0, 2) == "cb") {
                    //получаем из ключа значение id страны
                    $id = substr($key, 2);
                    $del = "delete from notes where id=$id";
                    $link->query($del);
                }
            }
            //перезагрузка страницы
            echo "<script>window.location=document.URL</script>";
        }
        ?>
    </div>
    
    
</div>