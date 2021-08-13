<?php
//Start the session
session_start();

if(empty($_SESSION["userLogin"])){
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
                        <h2>Previous Orders Page</h2>
                    </div>
                </div>
                <div class="row">
                    <div class="col">
                        <?php
                            require_once("connect-db.php");
                            $error = $success = "";
                            
                            $userId = $_SESSION["userLogin"];
                            
                            $sql = "select * from ordersproducts 
                            inner join products 
                            on ordersproducts.productid = products.productid
                            inner join orders
                            on ordersproducts.orderid = orders.orderid
                            where orders.userid = :userId
                            order by orders.orderid desc";
                            
                            $statement1 = $db->prepare($sql);
                            $statement1->bindValue(":userId", $userId);
                            
                            //select all orders matching userID
                            if($statement1->execute()){
                                $orders = $statement1->fetchAll();
                                $statement1->closeCursor();
                                
                                $currentOrder = null;
                                $count = 0;
                                ?>
                                <?php
                                foreach($orders as $o){
                                    if($o["orderId"] != $currentOrder){
                                        $currentOrder = $o["orderId"];
                                        $total = $o["total"];
                                        $count++;
                                ?>
                                        <?php if($count != 1){
                                            echo "</table>"; 
                                        }?>
                                        <div class="row tableHeader">
                                            <div class="col"><h4 class="text-center">Order #<?php echo $currentOrder; ?></h4></div>
                                            <div class="col"><h4 class="text-center">Paid with: <?php echo $o["payment"]; ?></h4></div>
                                            <div class="col"><h4 class="text-center">Total: $<?php echo $total; ?></h4></div>
                                        </div>
                                        <table class="table table-hover text-center">
                                            <tr>
                                                <th class="w-20">Item</th>
                                                <th class="w-20">Quantity</th>
                                                <th class="w-20">Price</th>
                                            </tr>
                                <?php } ?>
                                        <tr>
                                            <td><?php echo $o["product"]; ?></td>
                                            <td><?php echo $o["quantity"]; ?></td>
                                            <td>$<?php echo $o["price"]; ?></td>
                                        </tr>
                                <?php } ?>
                                </table>
                        <?php 
                            }else{
                                $error = "Error finding previous orders.";
                            }
                            if($error != ""){
                                echo "<h5 class='text-center'>$error</h5>";
                            }
                        ?>
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
