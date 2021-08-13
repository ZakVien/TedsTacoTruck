<?php
//Start the session
session_start();
?>
<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <meta class="form-control" name="viewport" content="width=device-width,initial-scale=1">
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
                        <h2>Create Account Page</h2>
                    </div>
                </div>
				<div class="row">
					<div class="col">
						<?php
							if($_SERVER["REQUEST_METHOD"] == "POST"){
                                $message = "";
                                require_once("connect-db.php");
								function test_input($data){
									$data = trim($data);
									$data = stripslashes($data);
									$data = htmlspecialchars($data);
									return $data;
								}
                                
								$userusername = test_input($_POST["userusername"]);
								$userpassword = test_input($_POST["userpassword"]);
								$userpasswordconfirm = test_input($_POST["userpasswordconfirm"]);
                                $userfirst = test_input($_POST["userfirst"]);
                                $userlast = test_input($_POST["userlast"]);
								$useremail = test_input($_POST["useremail"]);
								$useraddress = test_input($_POST["useraddress"]);
								$usercity = test_input($_POST["usercity"]);
								$userstate = $_POST["userstate"];
								$userzip = test_input($_POST["userzip"]);
								
								if($userpassword === $userpasswordconfirm){
								
                                    $sql = "insert into users 
                                    (username, password, email, first, last, address, city, state, zip) 
                                    values 
                                    (:userusername, :userpassword, :useremail, :userfirst, :userlast, :useraddress, :usercity, :userstate, :userzip)";

                                    $statement1 = $db->prepare($sql);

                                    $statement1->bindValue(":userusername", $userusername);
                                    $statement1->bindValue(":userpassword", $userpassword);
                                    $statement1->bindValue(":useremail", $useremail);
                                    $statement1->bindValue(":userfirst", $userfirst);
                                    $statement1->bindValue(":userlast", $userlast);
                                    $statement1->bindValue(":useraddress", $useraddress);
                                    $statement1->bindValue(":usercity", $usercity);
                                    $statement1->bindValue(":userstate", $userstate);
                                    $statement1->bindValue(":userzip", $userzip);

                                    if($statement1->execute()){
                                        $message = "Account successfully created.";
                                    }else{
                                        $message = "Error creating account.";
                                    } ?>
                                    <div class="text-center">
                                        <h5><?php echo $message; ?></h5>
                                        <div>
                                            <a href='login.php'><button class='btn btn-primary w-50'>Log in</button></a>
                                        </div>
                                        <br>
                                        <div>
                                            <a href='menu.php'><button class='btn btn-warning w-50'>View Menu</button></a>
                                        </div>
                                    </div><?php
                                }
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
