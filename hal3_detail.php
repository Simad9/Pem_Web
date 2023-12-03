<?php
$koneksi = new mysqli('localhost', 'root', '', 'nwind');
$id_p = $_GET["id_p"];
$query = "SELECT ProductID, ProductName, QuantityPerUnit, UnitPrice FROM products WHERE ProductID = $id_p";
$hasil = mysqli_query($koneksi, $query);
?>

<h1>Detail Product</h1>
<?php
if (mysqli_num_rows($hasil) > 0) {
  $data = mysqli_fetch_array($hasil); ?>

  <ul>
    <li>ProductID : <?= $data['ProductID'] ?></li>
    <li>ProductName : <?= $data['ProductName'] ?></li>
    <li>QuantityPerUnit : <?= $data['QuantityPerUnit'] ?></li>
    <li>UnitPrice : <?= $data['UnitPrice'] ?></li>
  </ul>

  <h2>Jumlah</h2>
  <form action="shopcart.php" method="post">
    <input type="hidden" name="ProductID" value="<?= $data['ProductID'] ?>">
    <input type="number" name="jumlah" value="1">
    <button type="submit" name="beli">beli</button>
  </form>

<?php
}
?>