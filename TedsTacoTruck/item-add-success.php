<?php
//Start the session
session_start();

if(empty($_SESSION["adminLogin"])){
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
                        <h2>Item Add Page</h2>
                    </div>
                </div>
                <div class="row text-center">
                    <div class="col-md">
                        <h4><a href="view-all-orders.php"><button class="btn btn-info">View All Orders</button></a></h4>
                    </div>
                    <div class="col-md">
                        <h4><a href="item-admin.php"><button class="btn btn-info">Modify Menu</button></a></h4>
                    </div>
                    <div class="col-md">
                        <h4><a href="item-add.php"><button class="btn btn-info">Add New Item</button></a></h4>
                    </div>
                </div>
                <br>
				<div class="row text-center">
					<div class="col">
						<?php if($error != ""){
							echo "<h5>$error</h5>";
						}else{
							echo "<h5>$success</h5>";
                            echo "<br>";
							echo "<a href='item-add.php'><button class='btn btn-success' type='submit'>Add Another</button></a>";
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
