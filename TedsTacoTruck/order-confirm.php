<?php
//Start the session
session_start();

if(!empty($_SESSION["userLogin"]) || !empty($_SESSION["adminLogin"])){}else{
    ?>
    <script>
        window.location.replace("login.php");
    </script>
<?php };?>
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
                        <h2>Confirm Order Page</h2>
                    </div>
                </div>
                <div class="row">
                    <div class="col">
                        <table class="table table-hover">
                            <tr>
                                <th>Item</th>
                                <th class="text-center">Quantity</th>
                                <th class="text-center">Price</th>
                                <th class="text-right">Item Total</th>
                            </tr>
                            <?php 
                            if(!empty($_SESSION["cart"])){
                                $total = 0;
                                foreach($_SESSION["cart"] as $key => $value){
                                    ?>
                            <tr>
                                    <td><?php echo $value["product_name"]; ?></td>
                                    <td class="text-center"><?php echo $value['product_quantity']; ?></td>
                                    <td class="text-center">$ <?php echo $value["product_price"]; ?></td>
                                    <td class="text-right">$ <?php echo number_format(($value["product_quantity"] * $value["product_price"]), 2); ?></td>
                            </tr>
                            <?php
                                $total = $total + number_format(($value["product_quantity"] * $value["product_price"]), 2);
                                }//end foreach
                            ?>
                            <tr>
                                <td colspan="4" class="text-right"><b>Total: $<?php echo $total; ?></b></td>
                            </tr>
                            <?php }else{
                                echo '<script>alert("Your cart is empty. Please add items before checking out.")</script>';
                                echo '<script>window.location.replace("menu.php")';
                            } ?>
                        </table>
                    </div>
                </div>
                <div class="row">
                    <div class="col">
                        <?php
                            require_once("connect-db.php");
                            $error = $success = "";
                            
                            $userid = $_SESSION["userLogin"];
                            
                            $sql = "select * from users where userid = :userid";
                            
                            $statement1 = $db->prepare($sql);
                            $statement1->bindValue(":userid", $userid);
                            
                            if($statement1->execute()){
                                $userInfo = $statement1->fetchAll();
                                $statement1->closeCursor();
                                
                                foreach($userInfo as $u){ ?>
                                    <p><b>Name: </b> <?php echo $u["first"] . " " . $u["last"]; ?></p>
                                    <p><b>Billing Address: </b> <?php echo $u["address"]; ?></p>
                                    <p><b>City: </b> <?php echo $u["city"]; ?></p>
                                    <p><b>State: </b> <?php echo $u["state"]; ?></p>
                                    <p><b>Zip: </b> <?php echo $u["zip"]; ?></p>
                        
                        <?php
                                }
                            }
                        ?>
                        <a href="update-account.php"><button class="btn btn-warning">Update Billing Information</button></a>
                    </div>
                </div>
                <br>
                <div class="row">
                    <div class="col">
                        <form method="post" action="checkout.php">
                            <input type="radio" name="payment" id="cash" value="Cash" checked>
                            <label for="cash">Cash</label>
                            <br>
                            <input type="radio" name="payment" id="amex" value="Amex">
                            <label for="amex">AmEx</label>
                            <br>
                            <input type="radio" name="payment" id="visa" value="Visa">
                            <label for="visa">Visa</label>
                            <br>
                            <input type="radio" name="payment" id="mastercard" value="Mastercard">
                            <label for="mastercard">MasterCard</label>
                            <br>
                            <input type="hidden" name="total" value="<?php echo $total;?>">
                            <button type="submit" class="btn btn-success">Checkout</button>
                        </form>
                    </div>
                </div>
                <div class="row">
                </div>
            </div>
        </article>
        <?php include("footer.html");?>
    </div>
     <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
     <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
     <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
</body>

</html>
