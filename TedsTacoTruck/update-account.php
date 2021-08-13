<?php
//Start the session
session_start();
if(empty($_SESSION["userLogin"])){
    ?>
    <script>
        window.location.replace("login.php");
    </script>
<?php
    }else{
        $userId = $_SESSION["userLogin"];
    }
;?>
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
                        <h2>Update Billing Information</h2>
                    </div>
                </div>
				<div class="row">
					<div class="col">
                        <?php
                                $error = $success = "";
                                require_once("connect-db.php");
                                function test_input($data){
                                    $data = trim($data);
                                    $data = stripslashes($data);
                                    $data = htmlspecialchars($data);
                                    return $data;
                                }
                                
                                $sql = "select * from users where userid = :userId";
                                $statement1 = $db->prepare($sql);
                                $statement1->bindValue(":userId", $userId);
                                if($statement1->execute()){
                                    $userInfo = $statement1->fetchAll();
                                    $statement1->closeCursor();
                                }else{
                                    $error = "Error finding database.";
                                }
                        
                            foreach($userInfo as $u){
                        ?>
						<form action="update-account-success.php" method="post">
							<div class="form-group">
								<label for="useraddress">Street Address</label>
								<input type="text" class="form-control" name="useraddress" value="<?php echo $u['address'] ?>" required>
							</div>
							<div class="form-group">
								<label for="usercity">City</label>
								<input type="text" class="form-control" name="usercity" value="<?php echo $u["city"] ?>" required>
							</div>
							<div class="form-group">
								<label for="userstate">State</label>
								<select class="form-control" name="userstate">
                                    <option value="<?php echo $u["state"]; ?>" selected="selected"><?php echo $u["state"]; ?></option>
                                    <option value="" disabled>Choose...</option>
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
							<div class="form-group">
								<label for="userzip">ZIP</label>
								<input type="num" class="form-control" name="userzip" value="<?php echo $u["zip"] ?>" required>
							</div>
							<input type="hidden" name="userid" value="<?php echo $userId; ?>">
							<button class="btn btn-primary" type="submit">Submit</button>
						</form>
                        <?php } //end foreach 
                        if($error != ""){
                            echo "<h5>$error</h5>";
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
