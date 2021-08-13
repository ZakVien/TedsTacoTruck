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
                        <h2>Checkout Page</h2>
                    </div>
                </div>
                <div class="row">
                    <div class="col">
                        <?php 
                            $error = $success = "";
                            require_once("connect-db.php");

                            $userId = $_SESSION["userLogin"];
                            $payment = $_POST["payment"];
                            $total = $_POST["total"];

                            //add record into orders table
                            $sql = "insert into orders (userid, payment, total) values (:userid, :payment, :total)";

                            $statement1 = $db->prepare($sql);
                            $statement1->bindValue(":userid", $userId);
                            $statement1->bindValue(":payment", $payment);
                            $statement1->bindValue(":total", $total);
                            
                            if($statement1->execute()){
                                //get orderid number
                                $sql2 = "select orderId from orders where userId = :userid";

                                $statement2 = $db->prepare($sql2);
                                $statement2->bindValue(":userid", $userId);
                                
                                if($statement2->execute()){
                                    $orders = $statement2->fetchAll();
                                    $statement2->closeCursor();
                                    
                                    //grab most recent orderID
                                    $orderArrayId = array_key_last($orders);
                                    $orderId = array_column($orders, 'orderId');
                                    $orderId = end($orderId);
                                    
                                    $sql3 = "insert into ordersproducts (orderId, productId, userId, quantity, price) values (:orderId, :productId, :userId, :quantity, :price)";
                                    $statement3 = $db->prepare($sql3);
                                    
                                    foreach($_SESSION["cart"] as $key => $value){
                                        $productId = $value["productId"];
                                        $quantity = $value["product_quantity"];
                                        $price = $value["product_price"];

                                        $statement3->bindValue(":orderId", $orderId);
                                        $statement3->bindValue(":productId", $productId);
                                        $statement3->bindValue(":userId", $userId);
                                        $statement3->bindValue(":quantity", $quantity);
                                        $statement3->bindValue(":price", $price);

                                        if($statement3->execute()){
                                            $success = "Order successfully placed.";
                                            unset($_SESSION["cart"]);
                                        }else{
                                            $error = "Error submitting order.";
                                        }
                                    }
                                }else{
                                    $
                                    $error = "Error connecting to database.";
                                }
                            }else{
                                $error = "Error connecting to database.";
                            }
                            if($error != ""){
                                echo $error;
                                ?><br><a href="view-cart.php"><button class="btn btn-primary">Back to cart</button></a><?php
                            }else{
                                echo $success;
                                ?>
                        <br><a href="previous-orders.php"><button class="btn btn-primary">Previous Orders</button></a>
                            <?php } ?>
                        
                    </div>
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
