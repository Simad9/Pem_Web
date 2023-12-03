<?php
$koneksi = new mysqli('localhost', 'root', '', 'nwind');
$id_c = $_GET["id_c"];
$query = "SELECT ProductID, ProductName, UnitPrice FROM products WHERE CategoryID = $id_c";
$hasil = mysqli_query($koneksi, $query);
?>

<h1>Products</h1>
<?php
if (mysqli_num_rows($hasil) > 0) {
  while ($data = mysqli_fetch_array($hasil)) { ?>

    <p>
      <?= $data['ProductID'] ?> --- <a href="hal3_detail.php?id_p=<?= $data['ProductID'] ?>"><?= $data['ProductName'] ?></a> --- <?= $data['UnitPrice'] ?>
    </p>

<?php }
}
?>