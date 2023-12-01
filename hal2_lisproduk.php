<?php
// Disini baru pake modular, karena nanti setiap halaman perlu pake koneksi
require 'koneksi.php';

// Ngambil id dari link kan ngirim idnya untuk querynya
$id_categories = $_GET["id_categories"];

// Nanti kopi aja biar cepet
$query = "SELECT ProductID, ProductName, UnitPrice FROM products WHERE CategoryID = $id_categories";
$hasil = mysqli_query($koneksi, $query);
?>

<h1>List Produk</h1>
<?php
// Sama seperti sebelumnya pengecekan
if (mysqli_num_rows($hasil) > 0) {
  // Ini juga ngambil produknya apa aja
  while ($data = mysqli_fetch_array($hasil)) : ?>

    <!-- Nanti ngirim id product valuenya dari yang kita query -->
    <a href="hal3_detailproduk.php?id_product=<?= $data['ProductID'] ?>">
      <!-- disini nampilin product name sama unit price karena perintah + kasih number_format karena datanya itu kan komanya ada yang sekitan, jadi pake penulisan USD -->
      <?= $data['ProductName'] ?> --- <?= number_format($data['UnitPrice'], 2) ?>
    </a>
    <br><br>
<?php
  endwhile;
}
