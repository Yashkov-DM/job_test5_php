<?php
$servername = 'localhost';
$username = 'root';
$password = '';
$db = 'test_store_DB';

$conn = new mysqli($servername, $username, $password, $db);
if ($conn->connect_error){
    die('Ошибка подключения к базе данных' . $conn->connect_error);
}

