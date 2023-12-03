<?php
// Sama modularnya dipake
require 'koneksi.php';

// Ngambil id dari link pake get
$id_product = $_GET["id_product"];

// Kita queryin
$query = "SELECT * FROM products WHERE ProductID = $id_product";
$hasil = mysqli_query($koneksi, $query);
?>

<h1>Detail Produk</h1>

<?php
// Pengecekan lagi
if (mysqli_num_rows($hasil) > 0) :
  // Ini gak pake while karena cukup 1 data yang kita perlukan
  $data = mysqli_fetch_array($hasil);
?>
  <ul>
    <!-- Nampilin datanya + penulisan USD jadi koma dibelakang -->
    <li>ProductID : <?= $data['ProductID'] ?></li>
    <li>ProductName : <?= $data['ProductName'] ?></li>
    <li>QuantitiyPerUnit : <?= $data['QuantityPerUnit'] ?></li>
    <!-- // ini masih full tapi saya ingin menjadi 2 digit belakang 0 -->
    <!-- <li>UnitPrice : <?= $data['UnitPrice'] ?></li> -->
    <!-- // Maka menjadi seperti ini -->
    <li>UnitPrice : <?= number_format($data['UnitPrice'], 2) ?></li>
  </ul>

  <hr>

  <!-- Bagian shoping cartnya, kirim quantity sama ProductId nya -->
  <form action="shoppingcart.php" method="POST">
    <label for="quantity">Quantity</label>
    <br>
    <input type="number" name="Quantity" id="quantity" value=1>
    <input type="hidden" name="ProductID" value="<?= $data['ProductID'] ?>">
    <br><br>
    <!-- Dibikin name buat membantu dalam shopingcartnya nanti -->
    <button type="submit" name="tambahKeKeranjang">Tambah ke Keranjang</button>
  </form>



<?php
endif;
?>