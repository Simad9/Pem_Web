<?php
$koneksi = new mysqli('localhost', 'root', '', 'nwind');
$query = "SELECT CategoryID, CategoryName FROM categories";
$hasil = mysqli_query($koneksi, $query);
?>

<h1>Categories</h1>
<?php
if (mysqli_num_rows($hasil) > 0) {
  while ($data = mysqli_fetch_array($hasil)) { ?>

    <a href="hal2_product.php?id_c=<?= $data['CategoryID'] ?>"><?= $data['CategoryName'] ?></a>
    <br><br>

<?php  }
}

?>