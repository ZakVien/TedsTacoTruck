<?php
//Start the session
session_start();

if(empty($_SESSION["adminLogin"])){
    ?>
    <script>
        window.location.replace("login.php");
    </script>
<?php };?>
<?php
	$error = $success = $emptyFields = "";
	require_once("connect-db.php");
	if($_SERVER["REQUEST_METHOD"] == "POST"){
		function test_input($data){
			$data = trim($data);
			$data = stripslashes($data);
			$data = htmlspecialchars($data);
			return $data;
		}
		
		$itemname = test_input($_POST["itemname"]);
		$itemdesc = test_input($_POST["itemdesc"]);
		$itemprice = test_input($_POST["itemprice"]);
        
        if(empty($itemname) || empty($itemdesc) || empty($itemprice)){
            $emptyFields = "Please fill in all fields properly.";
        }else{
		
            $sql = "insert into products (product, price, description) values (:itemname, :itemprice, :itemdesc)";

            $statement1 = $db->prepare($sql);
            $statement1->bindValue(":itemname", $itemname);
            $statement1->bindValue(":itemdesc", $itemdesc);
            $statement1->bindValue(":itemprice", $itemprice);

            if($statement1->execute()){
                $success = "Successfully added $itemname to menu.";
                unset($_POST["itemname"]);
                unset($_POST["itemdesc"]);
                unset($_POST["itemprice"]);
            }else{
                $error = "Error adding item.";
            }
        }
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
				<div class="row justify-content-center">
					<div class="col-6">
						<form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
							<div class="form-group">
								<label for="itemname">Name</label>
								<input type="text" class="form-control" name="itemname" value="<?php if(isset($_POST["itemname"])) echo $_POST["itemname"]; ?>" placeholder="Item Name" required>
							</div>
							<div class="form-group">
								<label for="itemdesc">Description</label>
                                <textarea name="itemdesc" class="form-control" placeholder="Item description..." required><?php if(isset($_POST["itemdesc"])) echo $_POST["itemdesc"]; ?></textarea>
							</div>
							<div class="form-group">
								<label for="itemprice">Price</label>
								<input type="num" class="form-control" name="itemprice" value="<?php if(isset($_POST["itemprice"])) echo $_POST["itemprice"]; ?>" placeholder="9.99" required>
							</div>
                            <div class="text-center">
                                <button name="add" type="submit" class="btn btn-primary w-100">Add</button>
                            </div>
						</form>
                        <h5 class="text-center">
                        <?php if($emptyFields != ""){
                                echo "<div class='alert alert-warning'>" . $emptyFields . "</div>";
                            }else if($error != ""){
                                echo "<div class='alert alert-danger'>" . $error . "</div>";
                            }else if($success != ""){
                                echo "<div class='alert alert-success'>" . $success . "</div>";
                            }
                        ?>
                        </h5>
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
