<?php
// 1. Shooping cart pake session biar kalo pindah pindah datanya gak ilang
session_start();
// 1. Perlu koneksi jadi pake require
require 'koneksi.php';

// 2. Langkah biar datanya ilang alias udah di checkout, 
if (isset($_POST['checkout'])) {
  //2. Ini diilangin
  session_destroy();
  //2. kita refresh
  header("refresh:0");
}

// 1. karena kita kirim tambahKeKeranjang jadi kita bisa pake itu
if (isset($_POST["tambahKeKeranjang"])) {
  $ProductID = $_POST["ProductID"];
  $Quantity = $_POST["Quantity"];

  $query = "SELECT ProductID, ProductName, UnitPrice FROM products WHERE ProductID = $ProductID";
  $hasil = mysqli_query($koneksi, $query);
  $data = mysqli_fetch_array($hasil);

  // 2. Ini kalo mau masuk lagi kan session udah terset
  if (isset($_SESSION['shopcart'])) {
    // 3. Kalo semial data beda
    $kondisi = false;
    // 2. Kalo kondisinya menambahakn data yang sama
    foreach ($_SESSION['shopcart'] as $i => $cartItem) {
      if ($cartItem['ProductID'] == $ProductID) {
        $_SESSION['shopcart'][$i]["Quantity"] += $Quantity;
        $_SESSION['shopcart'][$i]["Subtotal"] = $_SESSION['shopcart'][$i]["Quantity"] * $_SESSION['shopcart'][$i]["UnitPrice"];
        // 4. Maka yang bagian ini kita kasih true biar gak masuk baris, tapi menimpa data yang sebelumnya
        $kondisi = true;
      }
    }

    // 3. Kalo beda nanti bakal nambah nambah maka kondisinya false, penjelasannya hampir sama kaya tadi
    if ($kondisi == false) {
      $Subtotal = $data['UnitPrice'] * $Quantity;
      $hitung = count($_SESSION['shopcart']);
      $_SESSION['shopcart'][$hitung] = (array) [
        'ProductID' => $data["ProductID"],
        'ProductName' => $data["ProductName"],
        'Quantity' => "$Quantity",
        'UnitPrice' => $data["UnitPrice"],
        'Subtotal' => $Subtotal,
      ];
    }
    // 2. Jangan lupa nulis else untuk pengkondisian data baru
  } else {
    // 1. dibikin subtotal
    $Subtotal = $data['UnitPrice'] * $Quantity;
    // 1. Ini masukin data baru makanya array index masih 0, terus kita masukin array yang baru kita bikin
    $_SESSION['shopcart'][0] = (array) [
      'ProductID' => $data["ProductID"],
      'ProductName' => $data["ProductName"],
      'Quantity' => "$Quantity",
      'UnitPrice' => $data["UnitPrice"],
      'Subtotal' => $Subtotal,
    ];
  }
}

?>
<!-- 1. Pembuatan tambelnya -->
<h1>Shooping Cart</h1>
<h3>Isi</h3>
<table border="1px" style="border: 1px solid black; border-collapse: collapse; padding: 2px;">
  <tr>
    <th>ProductId</th>
    <th>ProductName</th>
    <th>Quantity</th>
    <th>UnitPrice</th>
    <th>Subtotal</th>
  </tr>
  <?php
  // 1. Total nya kasih 0 karena kalo data nya kosong ka jadinya 0
  $total = 0;
  // 1. Penecekan
  if (isset($_SESSION['shopcart'])) {
    // 1. di foreach biar jadi kecil kecil
    foreach ($_SESSION['shopcart'] as $data) { ?>
      <tr>
        <!-- 1. Tampilin data + format USD penulisan nomernya -->
        <td> <?= $data['ProductID'] ?></td>
        <td> <?= $data['ProductName'] ?></td>
        <td> <?= $data['Quantity'] ?></td>
        <td> <?= number_format($data['UnitPrice']) . " USD" ?></td>
        <td> <?= number_format($data['Subtotal']) . " USD" ?></td>
      </tr>
  <?php
      // 1. Ini kalo nanti datanya di tambah tambah biar nambah
      $total += $data['Subtotal'];
    }
  }
  ?>

  <!-- Ini nampilin Data yang ditambah tadi -->
  <tr>
    <td colspan="4">Total</td>
    <td> <?= $total . " USD" ?></td>
  </tr>
</table>

<br><br>
<!-- 1. Ini bikin biar nanti user bisa milih lagi -->
<a href="index.php">
  Back to Category
</a>

<br><br>

<!-- 1. Ini bikin biar user bisa check out jadi datanya ilang di session, gak kasih action karena ngirim ke halaman ini sendiri -->
<form method="post">
  <button type="submit" name="checkout">Check Out</button>
</form>