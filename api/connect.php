<?php
$connection = new mysqli('localhost','root','','dbBascugF1');

if (!$connection) {
    die(mysqli_error($mysqli));
}