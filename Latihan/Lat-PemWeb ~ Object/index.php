<?php
include "connect.php";

$q = "SELECT CategoryID, CategoryName FROM categories";
$results = $conn->query($q);
?>
<h1>Categories</h1>
<?php
if ($results->num_rows > 0) {
  while ($result = $results->fetch_object()) {
    ?>
    <a href="listproduk.php?ci=<?= $result->CategoryID ?>">
      <?= $result->CategoryName ?>
    </a>
    <br>
    <br>
    <?php
  }


}
