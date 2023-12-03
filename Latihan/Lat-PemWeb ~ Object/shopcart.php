<?php
session_start();
include 'connect.php';

if (isset($_POST['checkout'])) {
  session_destroy();
  header("refresh:0");
}

if (isset($_POST['addToCart'])) {
  $ProductID = $_POST['ProductID'];
  $Quantity = $_POST['quantity'];

  $q = "SELECT ProductID, ProductName, UnitPrice FROM products WHERE ProductID = '$ProductID'";
  $result = $conn->query($q)->fetch_object();

  if (isset($_SESSION['shopcart']) && is_countable($_SESSION['shopcart']) && count($_SESSION['shopcart']) > 0) {
    $cond = false;
    foreach ($_SESSION['shopcart'] as $i => $value) {
      if ($value->ProductID == $ProductID) {
        $_SESSION['shopcart'][$i]->Quantity += $Quantity;
        $_SESSION['shopcart'][$i]->SubTotal = $_SESSION['shopcart'][$i]->Quantity * $_SESSION['shopcart'][$i]->UnitPrice;
        $cond = true;
      }
    }

    if ($cond == false) {
      $Subtotal = $result->UnitPrice * $Quantity;
      $count = count($_SESSION['shopcart']);
      $_SESSION['shopcart'][$count] = (object) [
        'ProductID' => "$result->ProductID",
        'ProductName' => "$result->ProductName",
        'Quantity' => "$Quantity",
        'UnitPrice' => "$result->UnitPrice",
        'SubTotal' => "$Subtotal"
      ];
    }
  } else {
    $Subtotal = $result->UnitPrice * $Quantity;
    $_SESSION['shopcart'][0] = (object) [
      'ProductID' => "$result->ProductID",
      'ProductName' => "$result->ProductName",
      'Quantity' => "$Quantity",
      'UnitPrice' => "$result->UnitPrice",
      'SubTotal' => "$Subtotal"
    ];
  }
}
?>
<h1>Shopping Cart</h1>

<?php
echo "isi : ";

?>
<table border="1px" style="border: 1px black solid;">
  <tr>
    <th>
      ProductID
    </th>
    <th>
      ProductName
    </th>
    <th>
      Quantity
    </th>
    <th>
      UnitPrice
    </th>
    <th>
      SubTotal
    </th>
  </tr>
  <?php
  $total = 0;
  if (isset($_SESSION['shopcart'])) {
    foreach ($_SESSION['shopcart'] as $element) {
  ?>
      <tr>
        <td>
          <?= $element->ProductID ?>
        </td>
        <td>
          <?= $element->ProductName ?>
        </td>
        <td>
          <?= $element->Quantity ?>
        </td>
        <td>
          <?= number_format($element->UnitPrice, 2) . " USD" ?>
        </td>
        <td>
          <?= number_format($element->SubTotal, 2) . " USD" ?>
        </td>
      </tr>
  <?php
      $total += $element->SubTotal;
    }
  } 
  ?>
  <tr>
    <td colspan="4">Total</td>
    <td><?= number_format($total, 2) . " USD" ?></td>
  </tr>
</table>
<br>
<br>
<a href="index.php">
  Back to Category
</a>
<br>
<form method="post">
  <br>
  <br>
  <button type="submit" name="checkout">
    Check out
  </button>
</form>