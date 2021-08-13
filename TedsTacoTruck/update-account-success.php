<?php
//Start the session
session_start();
if(empty($_SESSION["userLogin"])){
    ?>
    <script>
        window.location.replace("login.php");
    </script>
<?php };?>
<?php
	$error = $success = "";
	require_once("connect-db.php");
	if($_SERVER["REQUEST_METHOD"] == "POST"){
		function test_input($data){
			$data = trim($data);
			$data = stripslashes($data);
			$data = htmlspecialchars($data);
			return $data;
		}
		$userid = test_input($_POST["userid"]);
		$useraddress = test_input($_POST["useraddress"]);
		$usercity = test_input($_POST["usercity"]);
		$userstate = test_input($_POST["userstate"]);
		$userzip = test_input($_POST["userzip"]);
		
		$sql = "update account 
				set address = :useraddress,
				city = :usercity,
				state = :userstate,
				zip = :userzip,
				where accountid = :accountid";
		$statement1 = $db->prepare($sql);
		$statement1->bindValue(":userid", $userid);
		$statement1->bindValue(":useraddress", $useraddress);
		$statement1->bindValue(":usercity", $usercity);
		$statement1->bindValue(":userstate", $userstate);
		$statement1->bindValue(":userzip", $userzip);
        
        $success = "Successfuly updated billing information.";
	}else{
		$error = "Error finding database.";
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
                        <h2>Update Page</h2>
                    </div>
                </div>
				<div class="row">
					<div class="col">
						<?php
							if($error != ""){
								echo "$error";
							}else{
								echo "$success";
                                echo "<br><br>";
								echo "<a href='my-account.php'><button type='submit' class='btn btn-primary'>Manage Account</button></a>";
                                echo "<br><br>";
								echo "<a href='view-cart.php'><button type='submit' class='btn btn-primary'>View Cart</button></a>";
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
