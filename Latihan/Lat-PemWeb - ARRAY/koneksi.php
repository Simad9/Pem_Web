<?php
// Untuk koneksi ke database
$koneksi = new mysqli('localhost', 'root', '', 'northwind');
// pengendalian kalo koneksi tidak ada, untuk jaga jaga
if (!$koneksi) {
  die('error');
}
