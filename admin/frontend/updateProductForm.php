<?php
$id = isset($_GET['id']) ? $_GET['id'] : "";
$name = isset($_GET['name']) ? $_GET['name'] : "";
$price = isset($_GET['price']) ? $_GET['price'] : "";

?>
<div class="form-container">
    <form class="form" action="http://localhost:1234/sunglasses/admin/products/updateProduct.php?token=<?php echo $token; ?>" enctype="multipart/form-data" method="POST">
        <input type="text" name="id" placeholder="id" value="<?php echo $id; ?>"><br />
        <input type="text" name="name" placeholder="name" value="<?php echo $name; ?>" /><br />
        <input type="number" name="price" placeholder="price" value="<?php echo $price; ?>" /><br />
        <input type="file" name="file_to_upload"><br />
        <input type="submit" name="submit" value="Update" />
    </form>
</div>