<?php
include 'connect.php';

$ci = $_GET['ci'];

$q = "SELECT ProductName, ProductID FROM products WHERE CategoryID = '$ci'";
$results = $conn->query($q);

?>
<h1>
  List Produk
</h1>
<?php

if ($results->num_rows > 0) {
  while ($result = $results->fetch_object()) {
    ?>
      <a href="detailproduk.php?pi=<?= $result->ProductID ?>">
        <?= $result->ProductName ?>
      </a>
      <br>
      <br>
    <?php
  }
}