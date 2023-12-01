<!-- HALAMAN AWAL -->

<?php
// Awal ini masih koneksi dll pokoknya gak modular, terus pas di halaman 2 baru jadi modular
require 'koneksi.php';


// Nanti sambil lihat di db apa urutannya aja
$query = "SELECT CategoryID, CategoryName FROM categories";
$hasil = mysqli_query($koneksi, $query);
?>

<h1>Categoreis</h1>
<?php
// Buat pengecekan apakah berhasil atau tidak jadi perlu num_rows
if (mysqli_num_rows($hasil) > 0) :
  // Buat ngambil categories menjadi categori
  while ($data = mysqli_fetch_array($hasil)) : ?>

    <!-- Nanti ngirin id, idnya itu dari yang kita fetch datanya -->
    <a href="hal2_lisproduk.php?id_categories=<?= $data['CategoryID'] ?>">
      <!-- Ini tampil seperti biasa -->
      <?= $data['CategoryName'] ?>
    </a>
    <br><br>
    
<!-- Terus pake endwhile biarleih keliatan ketimbang tanda kurung -->
<?php endwhile;
endif;
?>