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
                    <div class="col-6 mx-auto">
						<form action="create-account-success.php" method="post">
							<div class="form-row">
                                <div class="col">
                                    <label for="userusername">Username</label>
                                    <input type="text" class="form-control" name="userusername" value="<?php if(isset($_POST["userusername"])) echo $_POST["userusername"]; ?>" required>
                                </div>
							</div>
							<div class="form-row">
                                <div class="col">
                                    <label for="userpassword">Password</label>
                                    <input type="password" class="form-control" name="userpassword" value="<?php if(isset($_POST["userpassword"])) echo $_POST["userpassword"]; ?>" required>
                                </div>
                                <div class="col">
                                    <label for="userpasswordconfirm">Confirm Password</label>
                                    <input type="password" class="form-control" name="userpasswordconfirm" value="<?php if(isset($_POST["userpasswordconfirm"])) echo $_POST["userpasswordconfirm"]; ?>" required>
                                </div>
							</div>
							<div class="form-row">
								<label for="useremail">Email Address</label>
								<input type="email" class="form-control" name="useremail" value="<?php if(isset($_POST["useremail"])) echo $_POST["useremail"]; ?>" required>
							</div>
							<div class="form-row">
                                <div class="col">
                                    <label for="userfirst">First Name</label>
                                    <input type="text" class="form-control" name="userfirst" value="<?php if(isset($_POST["userfirst"])) echo $_POST["userfirst"]; ?>" required>
                                </div>
                                <div class="col">
                                    <label for="userlast">Last Name</label>
                                    <input type="text" class="form-control" name="userlast" value="<?php if(isset($_POST["userlast"])) echo $_POST["userlast"]; ?>" required>
                                </div>
							</div>
							<div class="form-row">
								<label for="useraddress">Street Address</label>
								<input type="text" class="form-control" name="useraddress" value="<?php if(isset($_POST["useraddress"])) echo $_POST["useraddress"]; ?>" required>
							</div>
							<div class="form-row">
                                <div class="col">
                                    <label for="usercity">City</label>
                                    <input type="text" class="form-control" name="usercity" value="<?php if(isset($_POST["usercity"])) echo $_POST["usercity"]; ?>" required>
                                </div>
                                <div class="col">
                                    <label for="userstate">State</label>
                                    <select class="form-control" name="userstate" required>
                                        <option selected disabled value="">Choose...</option><option value="" disabled>Choose...</option>
                                        <option value="AL">AL</option>
                                        <option value="AK">AK</option>
                                        <option value="AZ">AZ</option>
                                        <option value="AR">AR</option>
                                        <option value="CA">CA</option>
                                        <option value="CO">CO</option>
                                        <option value="CT">CT</option>
                                        <option value="DE">DE</option>
                                        <option value="DC">DC</option>
                                        <option value="FL">FL</option>
                                        <option value="GA">GA</option>
                                        <option value="HI">HI</option>
                                        <option value="ID">ID</option>
                                        <option value="IL">IL</option>
                                        <option value="IN">IN</option>
                                        <option value="IA">IA</option>
                                        <option value="KS">KS</option>
                                        <option value="KY">KY</option>
                                        <option value="LA">LA</option>
                                        <option value="ME">ME</option>
                                        <option value="MD">MD</option>
                                        <option value="MA">MA</option>
                                        <option value="MI">MI</option>
                                        <option value="MN">MN</option>
                                        <option value="MS">MS</option>
                                        <option value="MO">MO</option>
                                        <option value="MT">MT</option>
                                        <option value="NE">NE</option>
                                        <option value="NV">NV</option>
                                        <option value="NH">NH</option>
                                        <option value="NJ">NJ</option>
                                        <option value="NM">NM</option>
                                        <option value="NY">NY</option>
                                        <option value="NC">NC</option>
                                        <option value="ND">ND</option>
                                        <option value="OH">OH</option>
                                        <option value="OK">OK</option>
                                        <option value="OR">OR</option>
                                        <option value="PA">PA</option>
                                        <option value="RI">RI</option>
                                        <option value="SC">SC</option>
                                        <option value="SD">SD</option>
                                        <option value="TN">TN</option>
                                        <option value="TX">TX</option>
                                        <option value="UT">UT</option>
                                        <option value="VT">VT</option>
                                        <option value="VA">VA</option>
                                        <option value="WA">WA</option>
                                        <option value="WV">WV</option>
                                        <option value="WI">WI</option>
                                        <option value="WY">WY</option>
                                    </select>
                                </div>
                                <div class="col">
                                    <label for="userzip">ZIP</label>
                                    <input type="num" class="form-control" name="userzip" value="<?php if(isset($_POST["userzip"])) echo $_POST["userzip"]; ?>" required>
                                </div>
							</div>
                            <br>
                            <div class="text-center">
                                <button class="btn btn-primary w-100" type="submit">Submit</button>
                            </div>
						</form>
                    </div>
                </div>
				<div class="row">
					<div class="col">
						<?php
							if($_SERVER["REQUEST_METHOD"] == "POST"){
                                $error = $success = "";
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
                                        $success = "Account successfully created.";
                                    }else{
                                        $error = "Error creating account.";
                                    }
                                    if($error != "") {
                                        echo "$error";
                                    }else{
                                        echo "$success";
                                        echo "<br>";
                                        echo "<a href='login.php'><button class='btn btn-primary'>Log in</button></a>";
                                    }
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
