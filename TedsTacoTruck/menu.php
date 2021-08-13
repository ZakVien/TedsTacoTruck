<?php
/***************WORKING IN XAAMP****/
//Start the session
session_start();

if(isset($_SESSION["cart"])){
    if(is_null($_SESSION["cart"])){
        $_SESSION["cart"] = array();
    }
}else{
    $_SESSION["cart"] = array();
}
?>
<?php 
    if($_SERVER["REQUEST_METHOD"] == "POST"){
        $error2 = $success2 = $alreadyInCart = $addedToCart = "";
        require_once("connect-db.php");

        $productId = $_POST["productId"];
        $product = $_POST["product"];
        $price = $_POST["price"];
        $quantity = $_POST["quantity"];

        $cartArray = array(                           
            'productId' => $productId,
            'product_name' => $product,
            'product_price' => $price,
            'product_quantity' => $quantity
        );

        $product_array_id = array_column($_SESSION["cart"], "productId");
        if(!in_array($productId, $product_array_id)){
            $count = count($_SESSION["cart"]);
            $_SESSION["cart"][$count] = $cartArray;
            $addedToCart = "true";
        }else{
            $alreadyInCart = "true";
        }
    }
?>
<!-------------------------------------------------->
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
                        <h2>Ted's Menu</h2>
                    </div>
                </div>
                <div class="row">
                    <div class="col">
                        <?php if(!empty($alreadyInCart)){ ?>
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <p class="mb-0"><?php echo $product;?> is already in your cart. View your <a href="view-cart.php" class="alert-link">cart</a> to change your quantity.</p>
                            <button type="button" class="close" data-dismiss="alert"><span>&times;</span></button>
                        </div>
                        <?php }else if(!empty($addedToCart)){ ?>
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            <p class="mb-0"><?php echo $product;?> was added to your cart.</p>
                            <button type="button" class="close" data-dismiss="alert"><span>&times;</span></button>
                        </div>
                        <?php } ?>
                    </div>
                </div>
                <div class="row">
				<?php
					$error = $success = "";
					$error2 = $success2 = "";
					$sql = $sql2 = "";
					$statement1 = $statement2 = "";
					require_once("connect-db.php");
					
					$sql = "select * from products order by productid";
					
					$statement1 = $db->prepare($sql);
					if($statement1->execute()){
						function test_input($data){
							$data = trim($data);
							$data = stripslashes($data);
							$data = htmlspecialchars($data);
							return $data;
						}
                        if($statement1->execute()){
                            $products = $statement1->fetchAll();
                            $statement1->closeCursor();
                        }else{
                            $error = "Error finding menu.";
                        }
                    ?>
                    <div class="col-lg-8">
                        <table class="table table-hover">
                            <tr>
                                <th>Item</th>
                                <th>Description</th>
                                <th>Price</th>
                                <th>Quantity</th>
                                <th>Add</th>
                            </tr>
                        <?php foreach($products as $p){ ?>
                            <tr>
                                <td><?php echo $p["product"];?></td>
                                <td><?php echo $p["description"];?></td>
                                <td>$<?php echo $p["price"];?></td>
                                <form method="post" action="<?php echo $_SERVER['PHP_SELF'];?>">
                                    <td><input type="num" name="quantity" value="1"></td>
                                    <td>
                                        <input type="hidden" name="productId" value="<?php echo $p["productId"];?>">
                                        <input type="hidden" name="product" value="<?php echo $p["product"];?>">
                                        <input type="hidden" name="price" value="<?php echo $p["price"];?>">
                                        <button type="submit" class="btn btn-primary">Add</button>
                                    </td>
                                </form>
                            </tr>
                        <?php 
                          }
                    }
                ?>
                        </table>
                    </div>
                    <div class="col-lg-4 d-none d-lg-block text-center ">
                        <?php
                            if(!empty($_SESSION["cart"])){ ?>
                        <h5>Your Cart</h5>
                        <table class="table">
                                <?php 
                                  $totalCost = 0;
                                  foreach($_SESSION["cart"] as $key => $value){ 
                                    $totalCost = $totalCost + number_format(($value["product_price"] * $value["product_quantity"]), 2); ?>
                            <tr>
                                <td><?php echo $value["product_quantity"] . " x " . $value["product_name"];?></td>
                                <td>$<?php echo number_format($value["product_price"] * $value["product_quantity"], 2);?></td>
                            </tr>
                        <?php } ?>
                        </table>
                        <div class="text-center">
                            <p><b>Total: $<?php echo $totalCost; ?></b></p>
                        </div>
                        <div>
                            <a href="view-cart.php"><button class="btn btn-warning w-100">View Cart</button></a>
                        </div>
                        <?php } ?>
                    </div>
				</div>
            </div>
            <?php include("footer.html");?>
            </article>
    </div>
     <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
     <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
     <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
</body>

</html>
