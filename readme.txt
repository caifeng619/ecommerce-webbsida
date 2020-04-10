This is a API for sunglasses e-handel

API end points:
user side
v1:
    users:
    addUser.php: add new user.
    userLogin.php: user login to system.

    products:
    getAllproducts.php: get all products from database, if search field or sort field is set, then get the search or sort results.
    


    shoppingcart:
    adddItem.php: add a new product in the cart if the product is not in the cart, 
                increase the quantity if the product is already in the cart.
    changeQuantityOfItem.php: increase or decrease the product quantity, if the product quantity is 1 then delete the product from cart.
    countItemsInCart.php count how many items there are in the cart.
    getCart.php: get all products in the cart.
    checkout.php: change the cart status to checkout and the cart blir empty.

admin side:
    adminUsers:
    adminLogin.php  admin user login to admin panel.

    products:
    addProduct.php: add a new product
    updateProduct.php: uppdate a specific product
    deleteProduct.php: delete a specific product.



