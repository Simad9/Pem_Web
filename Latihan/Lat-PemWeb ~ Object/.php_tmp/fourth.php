<?php
/* Halaman keempat adalah halaman shopping cart tersebut. Halaman ini akan menampilkan semua produk yang akan dibeli beserta info jumlah, subtotal dan total harga nya. (clue: gunakan session management) */
session_start();
if (isset($_POST['reset'])) {
  session_unset();
  session_destroy();
}
$status = "";
if (isset($_POST['addToCart'])) {
  if (!($_POST['jumlah'] < 1)) {
    $order = array(
      'nama' => $_POST['namaproduk'],
      'jumlah' => $_POST['jumlah'],
      'harga' => $_POST['harga'],
      'subtotal' => $_POST['jumlah'] * $_POST['harga'],
      'kategori' => $_POST['kategori'],
      'supplier' => $_POST['supplier'],
      'quantityperunit' => $_POST['quantityperunit']
    );

    if (isset($_SESSION['cart']) && is_countable($_SESSION['cart']) && count($_SESSION['cart']) > 0) {
      $cond = false;
      foreach ($_SESSION['cart'] as $key => $value) {
        if ($_SESSION['cart'][$key]['nama'] == $_POST['namaproduk']) {
          $_SESSION['cart'][$key]['jumlah'] += $_POST['jumlah'];
          $_SESSION['cart'][$key]['subtotal'] = $_SESSION['cart'][$key]['jumlah'] * $_POST['harga'];
          $cond = true;
        }
      }
      if (!$cond) {
        $count = count($_SESSION['cart']);
        $_SESSION['cart'][$count] = $order;
      }
    } else {
      $_SESSION['cart'][0] = $order;
    }
  }
} else {
  $status = "<h1>You have no cart</h1>";
}



?>

<!DOCTYPE html>
<html>

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <link href="" rel="stylesheet" />
  <title>Cart</title>
</head>

<body>
  <a href="index.php">back</a>
  <?= $status ?>
  <?php
  if (isset($_SESSION['cart'])) {
    ?>
    <h1>Your Cart</h1>
    <?php
    var_dump($_SESSION['cart']);
    ?>
    <form method="post">
      <button type="submit" name="reset">end session</button>
    </form>
    <?php
  }
  ?>

</body>

</html>