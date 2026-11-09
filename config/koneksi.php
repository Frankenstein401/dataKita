<?php

$conn = mysqli_connect('localhost', 'root', 'root', 'data_kita');
if(!$conn) {
    die('Koneksi gagal' . mysqli_connect_error());
}