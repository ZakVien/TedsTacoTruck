<?php
session_start();
?>
<!DOCTYPE html>
<html>

<head>
    <!-- Global site tag (gtag.js) - Google Analytics -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=G-M0ZGGV6DXR"></script>
    <script>
     window.dataLayer = window.dataLayer || [];
    
     function gtag() {
       dataLayer.push(arguments);
     }
     gtag('js', new Date());
    
     gtag('config', 'G-M0ZGGV6DXR');
    
    </script>
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
                        <h2>Ted's Home Page</h2>
                    </div>
                </div>
                <div class="row">
                    <div class="col-7">
                        <p>Ted's Tasty Taco Truck has been driving down the streets of your neighborhood for the past 4 years and Ted is looking forward to another 4 more years. Since Ted's kitchen is in his truck, you can rest assured that your food will be as fresh as can be.</p>
                        <p>Ted takes his truck to his mechanic once per month to ensure everything is in tip-top shape. This prevents breakdowns outside your house. As much as we know that you'd love a taco truck outside your house, we're confident that you won't appreciate the crowd that comes with a stationary taco truck. </p>
                        <p>Now that you've read a bit about Ted and his taco truck, feel free to peruse our menu. Be warned that an account is required to place an order online.</p>
                        <p>If you don't like tacos, then Ted's "nacho" type.</p>
                    </div>
                    <div class="col-5">
                        <img src="images/tacotruck.jpg" alt="Ted's taco truck." class="img-fluid border rounded">
                        <caption>Ted's first taco truck, before he painted it.</caption>
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
