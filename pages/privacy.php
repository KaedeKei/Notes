<?php
if (!isset($_SESSION["admin"])) {
    echo "<h3><span style='color: red;'>Вход только для администраторов!</span></h3>";
    exit();
}
?>
<div class="container">
<?php
$link = connect();

echo "<form action='index.php?page=3' method='post' class='w-100' enctype='multipart/form-data'>";
echo "<select name='userid' class='form-select w-100 mt-4'>";
$sel = "select * from users where roleid=2 order by login";
$res = $link->query($sel);
foreach ($res as $row) {
    echo "<option value='" . $row["id"] . "'>" . $row['login'] . "</option>";
}
echo "</select>";
echo "<input type='submit' name='addadmin' value='Сделать администратором' class='btn btn-secondary mt-3'/>";
echo "</form>";

if (isset($_POST["addadmin"])) {
    $userid = $_POST["userid"];

    $upd = "update users set roleid=1 where id=$userid";
    $link->query($upd);

    
    echo "<script>window.location=document.URL</script>";
}

$sel = "select * from users where roleid=1 order by login";
$res = $link->query($sel);

echo "<table class='table table-striped table-hover text-center align-middle mt-5'>";
echo "<thead><tr class='table-info'><td>ID</td><td>Login</td><td>Email</td></tr></thead>";
echo "<tbody>";
foreach ($res as $row) {
    echo "<tr>";
    echo "<td>" . $row['id'] . "</td>";
    echo "<td>" . $row['login'] . "</td>";
    echo "<td>" . $row['email'] . "</td>";
}
echo "</tbody>";
echo "</table>";
?>

</div>