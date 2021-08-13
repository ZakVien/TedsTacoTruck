<?php
//Start the session
session_start();
?>
<?php
    $error = $success = "";
    
    function test_input($data){
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
    }
    if(isset($_POST["update"])){
        $productId = $_POST["productId"];
        $product = $_POST["product"];
        $price = $_POST["price"];
        $quantity = test_input($_POST["quantity"]);
        
        $cartArrayId = $_POST["productArrayId"];
        $cartArray = array(                     
            'productId' => $productId,
            'product_name' => $product,
            'product_price' => $price,
            'product_quantity' => $quantity
        );
        $_SESSION["cart"][$cartArrayId] = $cartArray;
    }
if(isset($_POST["remove"])){
    $cartArrayId = $_POST["productArrayId"];
    
    unset($_SESSION["cart"][$cartArrayId]);
}
if(isset($_POST["removeAll"])){
    unset($_SESSION["cart"]);
}
?>
<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <title>Ted's Tasty Taco Truck</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
    <link rel="stylesheet" href="stylesheet.css" type="text/css">
</head>

<body>
    <div class="container">
        <?php 
            if(isset($_SESSION["adminLogin"]) && ($_SESSION["adminLogin"] != "")){
                include("nav-admin.html");
            }else if(isset($_SESSION["userLogin"]) && ($_SESSION["userLogin"] != "")){
                include("nav-user.html");
            }else{
                include("nav.html");
            }
        ?>
        <article>
            <div class="container">
                <div class="row">
                    <div class="col">
                        <h2>Your Cart</h2>
                    </div>
                </div>
                <?php 
                if(!empty($_SESSION["cart"][0])){?>
                <div class="row">
                    <div class="col">
                        <table class="table table-hover">
                            <tr>
                                <th>Item</th>
                                <th class="text-center">Quantity</th>
                                <th class="text-center">Price</th>
                                <th class="text-center">Item Total</th>
                                <th class="text-center">Update</th>
                                <th class="text-right">Remove</th>
                            </tr>
                            <?php
                                $total = 0;
                                foreach($_SESSION["cart"] as $key => $value){
                                    ?>
                            <tr>
                                <form id="update" method="post" action="<?php echo $_SERVER['PHP_SELF'];?>">
                                    <td><?php echo $value["product_name"]; ?></td>
                                    <td class="text-center"><input type="num" name="quantity" value="<?php echo $value['product_quantity']; ?>"></td>
                                    <td class="text-center">$<?php echo $value["product_price"]; ?></td>
                                    <td class="text-center">$<?php echo number_format($value["product_quantity"] * $value["product_price"], 2); ?></td>
                                    <td class="text-center">
                                        <input type="hidden" name="productId" value="<?php echo $value["productId"]; ?>">
                                        <input type="hidden" name="product" value="<?php echo $value["product_name"]; ?>">
                                        <input type="hidden" name="price" value="<?php echo $value["product_price"]; ?>">
                                        <input type="hidden" name="updateId" value="<?php echo $value["productid"]; ?>">
                                        <input type="hidden" name="productArrayId" value="<?php echo $key; ?>">
                                        <button type="submit" name="update" class="btn btn-warning">Update Qty</button>
                                    </td>
                                </form>
                                <td class="text-right">
                                    <form method="post" action="<?php echo $_SERVER['PHP_SELF'];?>">
                                        <input name="productArrayId" type="hidden" value="<?php echo $key; ?>">
                                        <button name= "remove" type="submit" class="btn btn-danger">Remove</button>
                                    </form>
                                </td>
                            </tr>
                            <?php
                                $total = $total + number_format(($value["product_quantity"] * $value["product_price"]), 2);
                                }//end foreach
                            ?>
                        </table>
                    </div>
                </div>
                <div class="row">
                    <div class="col text-right">
                        <form method="post" action="<?php echo $_SERVER['PHP_SELF'];?>">
                            <button type="submit" name="removeAll" id="removeAll" class="btn btn-primary">Empty Cart</button>
                        </form>
                    </div>
                </div>
                <div class="row">
                    <div class="col text-right">
                        <p><b>Total: $<?php echo $total; ?></b></p>
                    </div>
                </div>
                <?php }else{
                    $error = "Your shopping cart is empty. View our <a href='menu.php'>menu</a> to fill your cart.";
                }
                if($error != ""){ ?>
                <div class="row">
                    <div class="col">
                        <h5 class="text-center"><?php echo $error;?></h5>
                    </div>
                </div>
                <?php }else{
                    if(empty($_SESSION["userLogin"])){
                        if(!empty($_SESSION["adminLogin"])){ ?>
                            <div class="row">
                                <div class="col text-center">
                                    <div class="alert alert-warning" role="alert">
                                        <p>You are currently logged in as an administrator. To check out, please <a href="login.php" class="alert-link">log back in</a> without administrator permissions.</p>
                                    </div>
                                </div>
                            </div>
                        <?php }else{?>
                        <div class="row">
                            <div class="col text-center">
                                <div class="alert alert-danger" role="alert">
                                    <p>Please <a href="login.php" class="alert-link"><b>log in</b></a> or <a href="create-account.php" class="alert-link"><b>create an account</b></a> to continue checking out.</p>
                                    <hr>
                                    <p>Don't worry, the items in your cart will still be there.</p>
                                </div>
                            </div>
                        </div>
                <?php }}else{ ?>
                        <div class="text-right">
                            <a href="order-confirm.php"><button class="btn btn-success">Review Order</button></a>
                        </div>
                        <?php } } ?>
                    </div>
        </article>
        <?php include("footer.html");?>
    </div>
     <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
     <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
     <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
</body>

</html>
