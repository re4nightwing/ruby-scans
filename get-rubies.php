<?php
session_start();

$login_status = 0;
$user_mail = 0;
$user_id = 0;
if(isset($_SESSION["email"]) && isset($_SESSION['user_uid'])){
    $user_mail = $_SESSION["email"];
    $user_id = $_SESSION['user_uid'];
    $login_status = 1;

    include 'db-conn.php';
    $stmt = $dbh->prepare("SELECT * FROM `user_details` WHERE `user_mail`=? LIMIT 1"); 
    $stmt->execute([$_SESSION['email']]); 
    $row = $stmt->fetch();
    if ($stmt->rowCount() > 0) {
        $wish_list_check = 1;
        $user_list_check = 1;
        $_SESSION['user_list'] = $row['user_bought'];
        $_SESSION['wish_list'] = $row['user_list'];
        if(is_null($_SESSION['user_list'])){
            $user_list_check = 0;
        } else{
            $user_list = explode(',',$_SESSION['user_list']);
        }
        if(is_null($_SESSION['wish_list'])){
            $wish_list_check = 0;
        } else{
            $wish_list = explode(',',$_SESSION['wish_list']);
        }
    } else{
        ?>
        <script>
            alert("Error occured Please login again");
            window.location.href = "user-logout.php";
        </script>
        <?php
    }

    $stmt = $dbh->prepare("SELECT * FROM `user_details` WHERE `user_mail`=? LIMIT 1"); 
    $stmt->execute([$user_mail]); 
    $row = $stmt->fetch();
    if ($stmt->rowCount() > 0) {
        $used_codes = $row['coupon_code'];
        $used_codes_arr = explode(',',$used_codes);

        $lastToss = $row['toss_time'];
        if(is_null($lastToss)){
            $lastTossOut = "Play now!";
            $tosscheck = 1;
        } else{
            $now = new DateTime();
            $lastTossObj = datetime::createfromformat('Y-m-d H:i:s',$lastToss);
            $future_date = datetime::createfromformat('Y-m-d H:i:s',$lastToss);
            $future_date->modify('+1 day');
            
            $interval = $future_date->diff($now);
            if($interval->invert == 1){
                $lastTossOut = $interval->format("%a days, %h hours, %i minutes");
                $tosscheck = 0;
            } else{
                $lastTossOut = "Play now!";
                $tosscheck = 1;
            }
        }

        $lastBJ = $row['blackjack_time'];
        if(is_null($lastBJ)){
            $lastBJOut = "Play now!";
            $bjcheck = 1;
        } else{
            $now = new DateTime();
            $lastBJObj = datetime::createfromformat('Y-m-d H:i:s',$lastBJ);
            $future_date = datetime::createfromformat('Y-m-d H:i:s',$lastBJ);
            $future_date->modify('+1 day');
            
            $interval = $future_date->diff($now);
            if($interval->invert == 1){
                $lastBJOut = $interval->format("%a days, %h hours, %i minutes");
                $bjcheck = 0;
            } else{
                $lastBJOut = "Play now!";
                $bjcheck = 1;
            }
        }
    } else{
        $dbh = null;
        ?>
        <script>
            alert("Error occured Please login again");
            window.location.href = "user-logout.php";
        </script>
        <?php
    }
    if($login_status){
        if(isset($_POST['submit-coupon'])){
            $coupon_code = $_POST['coupon-code'];
            $stripped_code = str_replace(' ', '', $coupon_code);
            $stmt = $dbh->prepare("SELECT * FROM `coupon_code` WHERE `coupon_code` LIKE ? LIMIT 1"); 
            $stmt->execute([$stripped_code]); 
            $row = $stmt->fetch();
            if ($stmt->rowCount() > 0) {
                $code_has_used = 0;
                if($stripped_code == $row['coupon_code']){
                    foreach($used_codes_arr as $used_code){
                        if($used_code == $row['coupon_id']){
                            $code_has_used = 1;
                            ?>
                            <script>
                                alert("You have already used this Coupon Code!");
                                window.location.href = "get-rubies.php";
                            </script>
                            <?php
                            break;
                        }
                    }
                    if(!$code_has_used){
                        $coup_id = $row['coupon_id'];
                        $coup_val = (int)$row['coupon_value'];
                        $stmt = $dbh->prepare("UPDATE `user_details` SET `ruby_count`=`ruby_count`+?, `coupon_code`=CONCAT(COALESCE(coupon_code, ''), ?, ',') WHERE `user_mail`=?");
                        try{
                            $stmt->execute([$coup_val, $coup_id, $user_mail]); 
                            ?>
                                <script>
                                    alert("<?php echo "Code: $stripped_code claimed! $coup_val rubies added to the account."?>");
                                    window.location.href = "get-rubies.php";
                                </script>
                            <?php
                        } catch (Exception $e){
                            $dbh->rollback();
                            throw $e;
                        }
                    }
                }
            }
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Get Rubies | Ruby Scans</title>
    <link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.10.0/css/all.css" integrity="sha384-AYmEC3Yw5cVb3ZcuHtOA93w35dYTsvhLPVnYs9eStHfGJvOvKxVfELGroGkvsg+p" crossorigin="anonymous"/>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="stylesheet" href="https://unpkg.com/swiper@7/swiper-bundle.min.css"/>
    <link rel="stylesheet" href="css/main.css">
    <link rel="icon" type="image/png" href="img/favicon.png">
    <style>
        h1{
            font-family: 'Oswald', sans-serif;
        }
        .ruby{
            color: #ed053b;
        }
        .slidecontainer {
            width: 100%;
        }

        .slider {
            -webkit-appearance: none;
            width: 100%;
            height: 25px;
            background: #d3d3d3;
            outline: none;
            opacity: 0.7;
            -webkit-transition: .2s;
            transition: opacity .2s;
            border-radius: 20px;
        }

        .slider:hover {
            opacity: 1;
        }

        .slider::-webkit-slider-thumb {
            -webkit-appearance: none;
            appearance: none;
            width: 25px;
            height: 25px;
            background: #ed053b;
            cursor: pointer;
            border-radius: 20px;
        }

        .slider::-moz-range-thumb {
            width: 25px;
            height: 25px;
            background: #ed053b;
            cursor: pointer;
            border-radius: 20px;
        }
        .game-card{
            background: #fff;
            border-radius: 4px;
        }
    </style>
    <script src="https://js.hcaptcha.com/1/api.js" async defer></script>
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-black">
        <div class="container-fluid">
            <a class="navbar-brand" href="index.php"><img src="img/ruby-cons_long-icon.png" height="40px" alt=""></a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <li class="nav-item">
                        <a class="nav-link active" aria-current="page" href="index.php">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="categories.php">Categories</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="get-rubies.php">Get Rubies</a>
                    </li>
                    <li class="nav-item dropdown disabled" id="user-profile">
                        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="fas fa-user"></i> Profile
                        </a>
                        <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                            <li><a class="dropdown-item" href="user-profile.php">Profile</a></li>
                            <li><a class="dropdown-item" href="user-profile.php#wishlist">Wish List</a></li>
                        </ul>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            Contact Us
                        </a>
                        <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                            <li><a class="dropdown-item" href="about-us.php">About Us</a></li>
                            <li><a class="dropdown-item" href="https://discord.gg/UJprcX8WXA" target="_blank">Join Discord <i class="fab fa-discord"></i></a></li>
                            <li><hr class="dropdown-divider"></li>
                            <li><a class="dropdown-item" href="about-us.php#contact-us">Publish Your Work</a></li>
                        </ul>
                    </li>
                    
                </ul>
                <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
                    <li class="nav-item me-1">
                        <form class="d-flex" method="GET" action="search-manga.php">
                            <input class="form-control me-2" name="searchq" type="search" placeholder="Type Title, author or genre" aria-label="Search" width="auto">
                            <input name="authorq" type="hidden" value="0">
                            <input name="yearq" type="hidden" value="0">
                            <input name="sortq" type="hidden" value="asc">
                            <input name="statusq" type="hidden" value="all">
                            <input name="typeq" type="hidden" value="all">
                            <input name="genreq" type="hidden" value="all">
                            <button class="btn btn-outline-success" type="submit">Search</button></br>
                        </form>
                    </li>
                    <li class="nav-item">
                        <?php
                            if($login_status){
                                echo "<button class='btn btn-warning' onclick='logoutFunc()'>Log Out</button>";
                            } else{
                                echo "<button class='btn btn-primary' data-bs-toggle='modal' data-bs-target='#exampleModal'>Sign In</button>";
                            }
                        ?>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
    <section class="content-sec">
        <div class="container-xl" id="content-container">
            <div class="text-center mb-5">
                <h1>Get <span class="ruby">Rubies</span></h1>
                <p>Play games to win rubies</p>
            </div>
            <div class="row justify-content-center">
                <div class="col-md-6 col-11 mb-4">
                    <form id="coupon-form" action="get-rubies.php" method="POST">
                        <div class="input-group input-group-lg">
                            <span class="input-group-text" id="inputGroup-sizing-lg">Coupon Code: </span>
                            <input type="text" class="form-control" id="coupon-code-form" name="coupon-code" aria-label="Enter Coupon Code"  aria-describedby="inputGroup-sizing-lg">
                            <?php
                                if($login_status){
                                    echo "<button class='btn btn-primary' type='submit' name='submit-coupon' id='button-addon2' disabled>Claim</button>";
                                } else{
                                    echo "<button class='btn btn-primary' type='button' id='button-addon2' data-bs-toggle='modal' data-bs-target='#exampleModal'>Claim</button>";
                                }
                            ?>
                        </div>
                        <div id="inputGroup-sizing-lg" class="form-text text-light text-center">Use your coupon codes to claim free rubies</div>
                    </form>
                </div>
                
            </div>
            <div class="row justify-content-around text-center">
                <div class="col-lg-3 col-md-5 col-11 p-4 my-3 game-card shadow-sm">
                    <img src="img/coin-toss.png" class="img-fluid mb-4" width="100px" height="100px" alt="">
                    <h3>Toss a Coin</h3>
                    <p>Play a simple coin toss to win 5 rubies daily.</p>
                    <div class="loaderImg1" style="display: none;">
                        <img src="img/loadin.gif" class="img-fluid" width="50px" alt="">
                    </div>
                    <?php
                        if($login_status){
                            ?>
                            <div class="toss-content">
                                <h5>Next Round:</h5>
                                <h6><span class="badge rounded-pill bg-info text-dark"><?php echo $lastTossOut;?></span></h6>
                                <?php
                                    if($tosscheck){
                                        echo "<button class='btn btn-success' id='toss' onclick='gotoGame(this.id)'>Play</button>";
                                    } else{
                                        echo "<button class='btn btn-success' disabled>Play</button>";
                                    }
                                ?>
                                
                            </div>
                            <?php
                        } else{
                            echo "<button class='btn btn-success' data-bs-toggle='modal' data-bs-target='#exampleModal'>Play</button>";
                        }
                    ?>
                </div>
                <div class="col-lg-3 col-md-5 col-11 p-4 my-3 game-card shadow-sm">
                    <img src="img/BlackJack.png" class="img-fluid mb-4" width="100px" height="100px" alt="">
                    <h3>BlackJack</h3>
                    <p>Play a simple BlackJack to win 5 rubies daily.</p>
                    <div class="loaderImg2" style="display: none;">
                        <img src="img/loadin.gif" class="img-fluid" width="50px" alt="">
                    </div>
                    <?php
                        if($login_status){
                            ?>
                            <div class="bj-content">
                                <h5>Next Round:</h5>
                                <h6><span class="badge rounded-pill bg-info text-dark"><?php echo $lastBJOut?></span></h6>
                                <?php
                                    if($bjcheck){
                                        echo "<button class='btn btn-success' id='blackjack' onclick='gotoGame(this.id)'>Play</button>";
                                    } else{
                                        echo "<button class='btn btn-success' disabled>Play</button>";
                                    }
                                ?>
                            </div>
                            <?php
                        } else{
                            echo "<button class='btn btn-success' data-bs-toggle='modal' data-bs-target='#exampleModal'>Play</button>";
                        }
                    ?>
                </div>
                <div class="col-lg-3 col-md-5 col-11 p-4 my-3 game-card shadow-sm">
                    <img src="img/slots.png" class="img-fluid mb-4" width="100px" height="100px" alt="">
                    <h3>Slots</h3>
                    <h4>Coming Soon!</h4>
                </div>
                <div class="col-lg-8 col-md-11 col-12 p-4 my-4 game-card shadow-sm">
                    <img src="img/ruby.png" class="img-fluid mb-4" width="100px" height="100px" alt="">
                    <h3>Buy Rubies</h3>
                    <p>Click below to buy Rubies and help us to keep the servers up and running.</p>
                    <?php
                        if($login_status){
                            ?>
                            <div class="slidecontainer">
                                <input type="range" min="1" max="100" value="50" class="slider" id="myRange">
                                <div class="col-auto">
                                    <p class=""><b>Rubies: <span id="rubyCount"></span> = Cost: <span id="rubyPrice"></span> USD</b></p> 
                                </div>
                            </div>
                            <form method="post" action="https://sandbox.payhere.lk/pay/checkout">   
                                <input type="hidden" name="merchant_id" value="1215538">
                                <input type="hidden" name="return_url" value="https://ruby-cons.uc.r.appspot.com/get-rubies.php">
                                <input type="hidden" name="cancel_url" value="https://ruby-cons.uc.r.appspot.com<?php echo $_SERVER['PHP_SELF']; ?>">
                                <input type="hidden" name="notify_url" value="https://ruby-cons.uc.r.appspot.com/notify-rubies.php">  
                                <input type="hidden" name="order_id" id="orderID" value="ItemNo12345">
                                <input type="hidden" name="items" value="Ruby purchase">
                                <input type="hidden" name="currency" value="USD">
                                <input type="hidden" name="amount" id="orderValue" value="1000">  
                                <input type="hidden" name="first_name" value="<?php echo $user_mail;?>">
                                <input type="hidden" name="last_name" value="none">
                                <input type="hidden" name="email" value="<?php echo $user_mail;?>">
                                <input type="hidden" name="phone" value="0711234567">
                                <input type="hidden" name="address" value="No.1, Galle Road">
                                <input type="hidden" name="city" value="Colombo">
                                <input type="hidden" name="country" value="Sri Lanka"> 
                                <input type="submit" class="btn btn-lg btn-primary" value="Buy Now">   
                            </form>
                            <?php
                        } else{
                            echo "<button class='btn btn-lg btn-primary' data-bs-toggle='modal' data-bs-target='#exampleModal'>Buy Rubies</button>";
                        }
                    ?>
                    
                </div>
            </div>
        </div>
    </section>
    <?php
        include 'footer.php';
    ?>
    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="row content-justify-center">
                    <div class="col-12">
                        <ul class="nav nav-tabs" id="myTab" role="tablist">
                            <li class="nav-item" role="presentation">
                                <button class="nav-link active" id="home-tab" data-bs-toggle="tab" data-bs-target="#home" type="button" role="tab" aria-controls="home" aria-selected="true">Login</button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button class="nav-link" id="profile-tab" data-bs-toggle="tab" data-bs-target="#profile" type="button" role="tab" aria-controls="profile" aria-selected="false">Sign In</button>
                            </li>
                        </ul>
                        <div class="tab-content" id="myTabContent">
                            <div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">
                                <form id="login-form" action="validate.php" method="POST">
                                    <div class="mb-3">
                                        <label for="loginInputEmail1" class="form-label">Email address</label>
                                        <input type="email" name="login-email" class="form-control" id="loginInputEmail1" aria-describedby="emailHelp" maxlength="200">
                                        <div id="emailHelp" class="form-text">We'll never share your email with anyone else.</div>
                                    </div>
                                    <input type="hidden" name="page_url" value="<?php echo (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";?>">
                                    <div class="mb-3">
                                        <label for="loginInputPassword1" class="form-label">Password</label>
                                        <input type="password" name="login-password" class="form-control" id="loginInputPassword1" maxlength="22">
                                    </div>
                                    <button type="submit" class="btn btn-success" id="login-btn" disabled>Login</button>
                                </form>
                            </div>
                            <div class="tab-pane fade" id="profile" role="tabpanel" aria-labelledby="profile-tab">
                                <form id="sign-form" action="validate.php" method="POST">
                                    <div class="mb-3">
                                        <label for="signInputText1" class="form-label">Username</label>
                                        <input type="text" name="sign-user" class="form-control" id="signInputText1" maxlength="100">
                                    </div>
                                    <div class="mb-3">
                                        <label for="signInputEmail1" class="form-label">Email address</label>
                                        <input type="email" name="sign-email" class="form-control" id="signInputEmail1" aria-describedby="emailHelp" maxlength="200">
                                        <div id="emailHelp" class="form-text">We'll never share your email with anyone else.</div>
                                    </div>
                                    <div class="mb-3">
                                        <label for="signInputPassword1" class="form-label">Password</label>
                                        <input type="password" name="sign-pswd" class="form-control" id="signInputPassword1" maxlength="22">
                                        <div id="emailHelp" class="form-text">Password length should be between 8 and 22 characters. Password should contain at least one number and one special character.</div>
                                    </div>
                                    <div class="mb-3">
                                        <label for="signInputPassword2" class="form-label">Confirm Password</label>
                                        <input type="password" name="sign-pswd2" class="form-control" id="signInputPassword2" maxlength="22">
                                    </div>
                                    <div class="h-captcha" data-sitekey="4f31e0fb-93ca-4815-84e4-45db33257a45"></div>
                                    <button type="submit" class="btn btn-success" id="sign-btn" disabled>Sign In</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
            </div>
        </div>
    </div>
    <div class="position-fixed bottom-0 end-0 p-3" style="z-index: 11">
        <div id="loginToast" class="toast" role="alert" aria-live="assertive" aria-atomic="true">
            <div class="toast-header">
            <img src="img/favicon.png" class="rounded me-2" height="15px" alt="...">
            <strong class="me-auto">Ruby Scans</strong>
            <small>Just Now</small>
            <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
            </div>
            <div class="toast-body">
                User logged in successfully!
            </div>
        </div>
    </div>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
    <script src="https://unpkg.com/swiper@7/swiper-bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/vanilla-lazyload@17.5.0/dist/lazyload.min.js"></script>
    <script>
        
        <?php 
        if($login_status){
        ?>
        const d = new Date();
        var slider = document.getElementById("myRange");
        var rubyOutput = document.getElementById("rubyCount");
        var costOutput = document.getElementById("rubyPrice");
        var orderid = document.getElementById("orderID");
        var orderprice = document.getElementById("orderValue");
        rubyOutput.innerHTML = slider.value;
        costOutput.innerHTML = slider.value/10;
        orderid.value = "<?php echo $user_mail;?>/"+slider.value;
        orderprice.value = slider.value/10;

        slider.oninput = function() {
            rubyOutput.innerHTML = this.value;
            costOutput.innerHTML = slider.value/10;
            orderid.value = "<?php echo $user_mail;?>/"+slider.value;
            orderprice.value = slider.value/10;
        }
        <?php
        }
        ?>

        var userStatus = '<?php echo $login_status;?>';
        if(userStatus == '1'){
            $('#user-profile').removeClass('disabled');
        }

        function gotoGame(page){
            if(page=='toss'){
                console.log("toss");
                var htmlText = "<div class='row justify-content-center'><div class='col-sm-4 col-12'><button class='btn btn-info' id='heads' onClick='getToss(this.id)'>Heads</button></div><div class='col-sm-4 col-12'><button class='btn btn-info' id='tails' onClick='getToss(this.id)'>Tails</button></div></div>";
                $('.toss-content').html(htmlText);
            } else if(page == 'blackjack'){
                console.log("BlackJack");
                startBlackJack();
            } else if(page == 'buyruby'){
                alert('rich kid');
            } else{
                alert('Invalid Input!');
                location.reload();
            }
        }

        function startBlackJack(){
            var userMail = '<?php echo $user_mail;?>';
            var userId = '<?php echo $user_id;?>';
            if(userMail != '0' || userId != '0'){
                $('.loaderImg2').fadeIn(300);
                $(".bj-content").load("blackjack-game.php", {
                round: 1,
                mail: userMail,
                id: userId
                }, function(){
                    $('.loaderImg2').fadeOut(500);
                });
            }
        }

        function nextRound(action){
            const actionArr = action.split("-");
            var nextAction = "";
            var nextRound = "";
            var dealer = $("input[name=dealer]").val();
            var player = $("input[name=player]").val();
            if(actionArr[0] == 'hit'){
                nextAction = "hit";
            } else if(actionArr[0] == 'stand'){
                nextAction = "stand";
            } else if(actionArr[0] == 'forfeit'){
                nextAction = "forfeit";
            } else{
                alert("This can't be");
            }
            if(actionArr[1] == '2'){
                nextRound = 2;
            } else if(actionArr[1] == '3'){
                nextRound = 3;
            } else{
                alert("This can't be");
            }
            var userMail = '<?php echo $user_mail;?>';
            var userId = '<?php echo $user_id;?>';
            if(userMail != '0' || userId != '0'){
                $('.loaderImg2').fadeIn(300);
                $(".bj-content").load("blackjack-game.php", {
                round: nextRound,
                action: nextAction,
                dealerdata: dealer,
                playerdata: player,
                mail: userMail,
                id: userId
                }, function(){
                    $('.loaderImg2').fadeOut(500);
                });
            }
        }

        function getToss(coin){
            if(coin == 'heads' || coin == 'tails'){
                var userSelection = coin;
                var userMail = '<?php echo $user_mail;?>';
                var userId = '<?php echo $user_id;?>';
                if(userMail != '0' || userId != '0'){
                    $('.loaderImg1').fadeIn(300);
                    $(".toss-content").load("toss-coin-game.php", {
                    selection: userSelection,
                    mail: userMail,
                    id: userId
                    }, function(){
                        $('.loaderImg1').fadeOut(500);
                    });
                }
            }
            
        }

        function logoutFunc(){
            window.location.href = "user-logout.php";
        }

        var regularExpression = /^(?=.*[0-9])(?=.*[!@#$%^&*])[a-zA-Z0-9!@#$%^&*]{6,16}$/;
        $('#login-form').keyup(function(){
            if($('#loginInputEmail1').val() != "" && $('#loginInputPassword1').val() != ""){
                $('#login-btn').attr('disabled', false);
            } else{
                $('#login-btn').attr('disabled', true);
            }
        });
        $('#login-form').click(function(){
            if($('#loginInputEmail1').val() != "" && $('#loginInputPassword1').val() != ""){
                $('#login-btn').attr('disabled', false);
            } else{
                $('#login-btn').attr('disabled', true);
            }
        });
        $('#sign-form').keyup(function(){
            if($('#signInputText1').val() != "" && $('#signInputEmail1').val() != "" && $('#signInputPassword1').val() != "" && $('#signInputPassword2').val() != "" && ($('#signInputPassword1').val() == $('#signInputPassword2').val()) && $('#signInputPassword1').val().length >= 8 && $('#signInputPassword1').val().length <= 22 && regularExpression.test($('#signInputPassword1').val()) ){
                $('#sign-btn').attr('disabled', false);
            } else{
                $('#sign-btn').attr('disabled', true);
            }
        });
        $('#sign-form').click(function(){
            if($('#signInputText1').val() != "" && $('#signInputEmail1').val() != "" && $('#signInputPassword1').val() != "" && $('#signInputPassword2').val() != "" && ($('#signInputPassword1').val() == $('#signInputPassword2').val()) && $('#signInputPassword1').val().length >= 8 && $('#signInputPassword1').val().length <= 22 && regularExpression.test($('#signInputPassword1').val()) ){
                $('#sign-btn').attr('disabled', false);
            } else{
                $('#sign-btn').attr('disabled', true);
            }
        });
        $('#coupon-form').keyup(function(){
            if($('#coupon-code-form').val() != ""){
                $('#button-addon2').attr('disabled', false);
            } else{
                $('#button-addon2').attr('disabled', true);
            }
        });
        $('#coupon-form').click(function(){
            if($('#coupon-code-form').val() != ""){
                $('#button-addon2').attr('disabled', false);
            } else{
                $('#button-addon2').attr('disabled', true);
            }
        });
    </script>
    <script>
        var loginToast = document.getElementById('loginToast');
        function showLoginToast(){
            var toast = new bootstrap.Toast(loginToast)
            toast.show()
        }
    </script>
    <?php
    if(isset($_SESSION['user_logged'])){
        if($_SESSION['user_logged']){
            ?>
            <script>
                showLoginToast();
            </script>
            <?php
            $_SESSION['user_logged'] = false;
            unset($_SESSION['user_logged']);
        }
    }
    ?>
</body>
</html>