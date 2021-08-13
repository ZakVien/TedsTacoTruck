<?php
//Start the session
session_start();
unset($_SESSION["adminLogin"]);
unset($_SESSION["userLogin"]);
?>
<?php
    $error = $success = $emptyFields = $_SESSION["adminLogin"] = $_SESSION["userLogin"] = "";
    if($_SERVER["REQUEST_METHOD"] == "POST"){
        require_once("connect-db.php");
        function test_input($data){
            $data = trim($data);
            $data = stripslashes($data);
            $data = htmlspecialchars($data);
            return $data;
        }

        $userusername = test_input($_POST["userusername"]);
        $userpassword = test_input($_POST["userpassword"]);
        if(empty($userusername) || empty($userpassword)){
            $emptyFields = "Please fill in all fields properly.";
        }else{
            $sql = "select * from users where username = :userusername and password = :userpassword";

            $statement1 = $db->prepare($sql);
            $statement1->bindValue(":userusername", $userusername);
            $statement1->bindValue(":userpassword", $userpassword);

            if($statement1->execute()){
                $usersFound = $statement1->fetchAll();
                $statement1->closeCursor();
                foreach($usersFound as $u){
                    if($u["isAdmin"] == "1"){
                        $_SESSION["adminLogin"] = $u["userID"];
                        ?>
                        <script>
                            window.location.replace("admin.php");
                        </script>
                        <?php
                    }else{
                        $_SESSION["userLogin"] = $u["userID"];
                        ?>
                        <script>
                            window.location.replace("index.php");
                        </script>
                        <?php
                    }
                }
            }
            $error = "Incorrect username or password. <br><br>
                Please try again or <a href='create-account.php'>create an account.</a>";
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
                        <h3>Log in</h3>
                    </div>
                </div>
                <div class="row justify-content-center text-center">
                    <div class="col-4">
                        <form method="post" action="<?php echo $_SERVER['PHP_SELF'];?>" class="text-center">
                            <div class="form-group">
                                <label for="userusername">Username:</label>
                                <input type="text" name="userusername" value="<?php if(isset($_POST["userusername"])) echo $_POST["userusername"];?>" required>
                            </div>
                            <div class="form-group">
                                <label for="userpassword">Password:</label>
                                <input type="password" name="userpassword" value="<?php if(isset($_POST["userpassword"])) echo $_POST["userpassword"];?>" required>
                            </div>
                            <button type="submit" class="btn btn-primary">Log In</button>
                        </form>
                        <a href="create-account.php"><button class="btn btn-secondary">Create Account</button></a>
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
