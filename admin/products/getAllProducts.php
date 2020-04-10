<?php
include("../frontend/component.php");
// Instantiate product object
$productObj = new Product($databaseHandler, $upload_folder);

$result=$productObj->fetchAllProducts();

?>

<div class="product-list">
<table class="table ">
  <thead>
    <tr>
      <th scope="col">#</th>
      <th scope="col">Name</th>
      <th scope="col">Price</th>
      <th scope="col">Update</th>
      <th scope="col">Delete</th>
    </tr>
  </thead>
  <tbody>
  <?php
    foreach($result as $row){
        tableContent($row['id'], $row['name'],$row['price'], $token);
    }
  ?>
  </tbody>
</table>
</div>


