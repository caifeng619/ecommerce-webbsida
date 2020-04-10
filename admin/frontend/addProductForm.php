<div class="form-container">
    <form class="form" action="http://localhost:1234/sunglasses/admin/products/addProduct.php?token=<?php echo $token; ?>" enctype="multipart/form-data" method="POST">
        <input type="text" name="name" placeholder="Name" /><br />
        <input type="number" name="price" placeholder="Price" /><br />
        <input type="file" name="file_to_upload"><br />
        <input type="submit" name="submit" value="Add" />
    </form>
</div>