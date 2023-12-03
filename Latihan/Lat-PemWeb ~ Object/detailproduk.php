<?php
include 'connect.php';

$pi = $_GET['pi'];
$q = "SELECT ProductID, ProductName, QuantityPerUnit, UnitPrice FROM products WHERE ProductID = '$pi'";

?>
<h1>Detail Produk</h1>
<?php

$results = $conn->query($q);
if ($results->num_rows > 0) {
  $result = $results->fetch_object();
  ?>
    <ul>
      <li>ProductID : <?= $result->ProductID ?></li>
      <li>ProductName : <?= $result->ProductName ?></li>
      <li>QuantityPerUnit : <?= $result->QuantityPerUnit ?></li>
      <li>UnitPrice : <?= number_format($result->UnitPrice, 2) ?></li>
    </ul>

    <hr>

    <form action="shopcart.php" method="post">
      <label for="quantity">Quantity</label>
      <br>
      <br>
      <input type="number" name="quantity" id="quantity" value="1">
      <input type="hidden" name="ProductID" value="<?= $result->ProductID ?>">
      <br>
      <br>
      <button type="submit" name="addToCart">
        Add to cart
      </button>
    </form>
    
  <?php

}


