<?php
session_start();
$koneksi = new mysqli('localhost', 'root', '', 'nwind');

if (isset($_POST["checkout"])) {
  session_destroy();
  header("refresh:0");
}

//cek beli
if (isset($_POST["ProductID"])) {
  $ProductID = $_POST["ProductID"];
  $jumlah = $_POST["jumlah"];
  $query = "SELECT ProductID, ProductName, QuantityPerUnit, UnitPrice FROM products WHERE ProductID = $ProductID";
  $hasil = mysqli_query($koneksi, $query);
  $data = mysqli_fetch_array($hasil);

  if (isset($_SESSION['shop'])) {
    $kondisi = false;
    //nambah data product id yang sama
    foreach ($_SESSION['shop'] as $i => $item) {
      if ($item['ProductID'] == $ProductID) {
        $_SESSION['shop'][$i]['Jumlah'] += $jumlah;
        $_SESSION['shop'][$i]['SubTotal'] = $_SESSION['shop'][$i]['Jumlah'] * $_SESSION['shop'][$i]['UnitPrice'];
        $kondisi = true;
      }
    }
    //nambah data product yang beda
    if ($kondisi == false) {
      $SubTotal = $data['UnitPrice'] * $jumlah;
      $index = count($_SESSION['shop']);
      $_SESSION['shop'][$index] = (array)[
        'ProductID' => $data['ProductID'],
        'ProductName' => $data['ProductName'],
        'UnitPrice' => $data['UnitPrice'],
        'Jumlah' => $jumlah,
        'SubTotal' => $SubTotal,
      ];
    }
  } else {
    //nambahkan data index 0
    $SubTotal = $data['UnitPrice'] * $jumlah;
    $_SESSION['shop'][0] = (array)[
      'ProductID' => $data['ProductID'],
      'ProductName' => $data['ProductName'],
      'UnitPrice' => $data['UnitPrice'],
      'Jumlah' => $jumlah,
      'SubTotal' => $SubTotal,
    ];
  }
}
?>

<h1>Shopping Cart</h1>
<table border="1px">
  <tr>
    <th>ProductID</th>
    <th>ProductName</th>
    <th>UnitPrice</th>
    <th>Jumlah</th>
    <th>SubTotal</th>
  </tr>
  <?php
  $total = 0;
  if (isset($_SESSION['shop'])) {
    foreach ($_SESSION['shop'] as $data) { ?>
      <tr>
        <td><?= $data['ProductID'] ?></td>
        <td><?= $data['ProductName'] ?></td>
        <td><?= $data['UnitPrice'] ?></td>
        <td><?= $data['Jumlah'] ?></td>
        <td><?= $data['SubTotal'] ?></td>
      </tr>
      <?php $total += $data['SubTotal'] ?>
  <?php }
  }
  ?>
  <tr>
    <td colspan="4">Total</td>
    <td><?= $total ?></td>
  </tr>
</table>

<br>
<a href="index.php">Kembali Ke Awal</a>
<br><br>

<!-- TAMBAHAN -->
<h4>Checkout</h4>
<form action="" method="post">
  <button type="submit" name="checkout">checkout</button>
</form>