Выбираем архив:
<form enctype="multipart/form-data" action="" method="POST">
    <input name="userfile" type="file" />
    <select name="date" style="display: none">
        <option value="may">Май</option>
        <option value="june">Июнь</option>
    </select>
    <br />
    <br />
    <input type="submit" name="load" value="Загрузить xls" />
</form>

<?php

include("parser.php");

if(@$_POST["date"]) {

    $uploaddir = '/var/www/cluster/web/parser/tmp/';

    $loc = $uploaddir . $_FILES['userfile']['name'];

    move_uploaded_file($_FILES['userfile']['tmp_name'], $loc);
}

    $xls = SimpleXLS::parse($loc);
    foreach ($xls->rows() as $r => $row) {

        echo '<br><br>EXCEL разбор:<pre>';
        print_r($xls->rows());
        echo '</pre>';
    }


?>