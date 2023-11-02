<?php

$config = parse_ini_file('bd.ini');
$conn = mysqli_connect($config['dbhost'], $config['username'], $config['password']);
mysqli_select_db($conn, $config['db']);

$sql = "INSERT INTO person (name, birthdate, gender, maritalstatus, taxid, phone, email) VALUES ('{$_POST['name']}', '{$_POST['birthdate']}', '{$_POST['gender']}', '{$_POST['maritalstatus']}', '{$_POST['taxid']}', '{$_POST['phone']}', '{$_POST['email']}')";
if(mysqli_query($conn, $sql)) {
    @mysqli_close($conn);
    header('Location: index.html');
    exit();
}
else {
    @mysqli_close($conn);
    header('Location: index.html');
    exit();
}