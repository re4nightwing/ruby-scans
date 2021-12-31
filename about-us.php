<?php
session_start();

$login_status = 0;
$user_mail = 0;
$user_id = 0;
if(isset($_SESSION["email"]) && isset($_SESSION['user_uid'])){
    $user_mail = $_SESSION["email"];
    $user_id = $_SESSION['user_uid'];
    $login_status = 1;

    if(isset($_POST['msg-submit'])){
        $msg_heading = $_POST['msg-heading'];
        $msg_body = $_POST['msg-body'];
        $data = array(
            'secret' => "0x9818Df50a8dBE7E56327d2A5FD6C8091A71ae185",
            'response' => $_POST['h-captcha-response']
        );
        $verify = curl_init();
        curl_setopt($verify, CURLOPT_URL, "https://hcaptcha.com/siteverify");
        curl_setopt($verify, CURLOPT_POST, true);
        curl_setopt($verify, CURLOPT_POSTFIELDS, http_build_query($data));
        curl_setopt($verify, CURLOPT_RETURNTRANSFER, true);
        $response = curl_exec($verify);
        // var_dump($response);
        $responseData = json_decode($response);
        if($responseData->success) {
            include 'db-conn.php';
            $sql = "INSERT INTO `user_msgs`(`msg_by`, `msg_heading`, `msg_body`, `msg_type`) VALUES (?,?,?,?)";
            $stmt= $dbh->prepare($sql);
            try{
                $stmt->execute([$user_mail, $msg_heading, $msg_body, 1]);
                ?>
                <script>
                    alert("Mail sent successfully!");
                </script>
                <?php
            } catch(Exception $e){
                $dbh->rollback();
                throw $e;
            } finally{
                $dbh = null;
            }
        } else{
            ?>
            <script>
                alert("Please fill the Captcha to send!");
                window.location.href = "about-us.php?hcaptcha=failed";
            </script>
            <?php 
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
    <title>About Us | Ruby Scans</title>
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
        .profile-card{
            overflow: hidden;
            border-radius: 50px;
            height: 20rem;
            display: flex;
            justify-content: center;
            align-items: center;
            position: relative;
            border: 2px solid #fff;
        }
        .profile-card .abs-content{
            position: absolute;
            top: 80%;
            left: 50%;
            transform: translateX(-50%);
            font-weight: bold;
            text-align: center;
        }
        .profile-card .abs-social{
            position: absolute;
            top: 2%;
            left: 50%;
            transform: translateX(-50%);
            opacity: 0;
            transition: .4s ease-out;
        }
        .profile-card:hover .abs-social{
            opacity: 1;
        }
        .profile-card .abs-social a{
            color: #ed053b;
            font-size: 20px;
            transition: .4s ease-out;
        }
        .profile-card .abs-social a:hover{
            color: #fff;
        }
        .profile-card img{
            min-height: 100%;
            min-width: 100%;
            flex-shrink: 0;
        }
        .ruby {
            color: #ed053b;
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
            <div class="text-center">
                <h1>Meet the <span class="ruby">Team</span></h1>
            </div>
            <div class="row row-cols-1 row-cols-lg-4 row-cols-md-3 row-cols-sm-2 g-4 justify-content-around mt-5">
                <div class="col profile-card mx-2 shadow-sm">
                    <img src="https://i0.wp.com/thenerddaily.com/wp-content/uploads/2018/08/Reasons-To-Watch-Anime.jpg" alt="">
                    <div class="abs-content">
                        <h5>John Doe</h5>
                        <h6>Member</h6>
                    </div>
                    <div class="abs-social">
                        <a href="https://www.facebook.com/r10sac/"><i class="fab fa-facebook"></i></a>&nbsp;&nbsp;&nbsp;
                        <a href="https://twitter.com/IEEER10SAC"><i class="fab fa-twitter"></i></a>&nbsp;&nbsp;&nbsp;
                        <a href="https://www.instagram.com/ieeer10sac/"><i class="fab fa-instagram"></i></a>&nbsp;&nbsp;&nbsp;
                    </div>
                </div>
                <div class="col profile-card mx-2 shadow-sm">
                    <img src="https://i0.wp.com/thenerddaily.com/wp-content/uploads/2018/08/Reasons-To-Watch-Anime.jpg" alt="">
                    <div class="abs-content">
                        <h5>John Doe</h5>
                        <h6>Member</h6>
                    </div>
                    <div class="abs-social">
                        <a href="https://www.facebook.com/r10sac/"><i class="fab fa-facebook"></i></a>&nbsp;&nbsp;&nbsp;
                        <a href="https://twitter.com/IEEER10SAC"><i class="fab fa-twitter"></i></a>&nbsp;&nbsp;&nbsp;
                        <a href="https://www.instagram.com/ieeer10sac/"><i class="fab fa-instagram"></i></a>&nbsp;&nbsp;&nbsp;
                    </div>
                </div>
                <div class="col profile-card mx-2 shadow-sm">
                    <img src="https://i0.wp.com/thenerddaily.com/wp-content/uploads/2018/08/Reasons-To-Watch-Anime.jpg" alt="">
                    <div class="abs-content">
                        <h5>John Doe</h5>
                        <h6>Member</h6>
                    </div>
                    <div class="abs-social">
                        <a href="https://www.facebook.com/r10sac/"><i class="fab fa-facebook"></i></a>&nbsp;&nbsp;&nbsp;
                        <a href="https://twitter.com/IEEER10SAC"><i class="fab fa-twitter"></i></a>&nbsp;&nbsp;&nbsp;
                        <a href="https://www.instagram.com/ieeer10sac/"><i class="fab fa-instagram"></i></a>&nbsp;&nbsp;&nbsp;
                    </div>
                </div>
                <div class="col profile-card mx-2 shadow-sm">
                    <img src="https://i0.wp.com/thenerddaily.com/wp-content/uploads/2018/08/Reasons-To-Watch-Anime.jpg" alt="">
                    <div class="abs-content">
                        <h5>John Doe</h5>
                        <h6>Member</h6>
                    </div>
                    <div class="abs-social">
                        <a href="https://www.facebook.com/r10sac/"><i class="fab fa-facebook"></i></a>&nbsp;&nbsp;&nbsp;
                        <a href="https://twitter.com/IEEER10SAC"><i class="fab fa-twitter"></i></a>&nbsp;&nbsp;&nbsp;
                        <a href="https://www.instagram.com/ieeer10sac/"><i class="fab fa-instagram"></i></a>&nbsp;&nbsp;&nbsp;
                    </div>
                </div>
                <div class="col profile-card mx-2 shadow-sm">
                    <img src="https://i0.wp.com/thenerddaily.com/wp-content/uploads/2018/08/Reasons-To-Watch-Anime.jpg" alt="">
                    <div class="abs-content">
                        <h5>John Doe</h5>
                        <h6>Member</h6>
                    </div>
                    <div class="abs-social">
                        <a href="https://www.facebook.com/r10sac/"><i class="fab fa-facebook"></i></a>&nbsp;&nbsp;&nbsp;
                        <a href="https://twitter.com/IEEER10SAC"><i class="fab fa-twitter"></i></a>&nbsp;&nbsp;&nbsp;
                        <a href="https://www.instagram.com/ieeer10sac/"><i class="fab fa-instagram"></i></a>&nbsp;&nbsp;&nbsp;
                    </div>
                </div>
            </div>
            <section id="contact-us" class="mt-5">
                <div class="text-center">
                    <h1>Contact <span class="ruby">Us</span></h1>
                </div>
                <div class="row justify-content-around">
                    <div class="col-lg-5 col-md-6 col-sm-10 col-11 text-center mt-5">
                        <h2>Contact Form</h2>
                        <form action="about-us.php?mail=send" method="POST" id="msg-form">
                            <div class="mb-3">
                                <label for="mailheading" class="form-label">Message Heading:</label>
                                <input type="text" class="form-control" id="mailheading" name="msg-heading" maxlength="200" placeholder="Heading here">
                            </div>
                            <div class="mb-3">
                                <label for="mailbody" class="form-label">Message Body:</label>
                                <textarea class="form-control" id="mailbody" name="msg-body" rows="4" maxlength="500" placeholder="Join the team/ submit your work/ give us feedback"></textarea>
                            </div>
                            <div class="h-captcha" data-sitekey="4f31e0fb-93ca-4815-84e4-45db33257a45"></div>
                            <?php 
                            if($login_status){
                                echo "<button type='submit' id='msg-btn' name='msg-submit' class='btn btn-primary' disabled>Submit</button>";
                            } else{
                                echo "<a class='btn btn-primary' data-bs-toggle='modal' data-bs-target='#exampleModal'>Submit</a>";
                            }
                            ?>
                        </form>
                    </div>
                    <div class="col-lg-5 col-11  mt-5">
                        <div class="text-center">
                            <h2>Join the Ruby Scans Team</h2>
                        </div>
                        <div class="text-start">
                            <p>We are looking for,</p>
                            <ul>
                                <li>Translators (Chinese, Korean)</li>
                                <li>Raw Providers</li>
                                <li>Proofreaders</li>
                                <li>Cleaners</li>
                                <li>Re-Drawers</li>
                                <li>Typesetters</li>
                                <li>Quality-Checkers</li>
                            </ul>
                            <P>In order to join with us, either put a message using the contact form mentioning <strong>your email</strong> and <strong>discord ID</strong> (eg: re4nightwing#8603). One of our members will contact you as soon as possible.</P>
                            <p>Other than that you can contact one of our members by joining our <a href="https://discord.gg/UJprcX8WXA" class="link-warning">discord server <i class="fab fa-discord"></i></a>.</p>
                        </div>
                    </div>
                </div>
            </section>
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

        var userStatus = '<?php echo $login_status;?>';
        if(userStatus == '1'){
            $('#user-profile').removeClass('disabled');
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
        <?php
            if($login_status){
        ?>
        $('#msg-form').keyup(function(){
            if($('#usermail').val() != "" && $('#mailheading').val() != "" && $('#mailbody').val() != ""){
                $('#msg-btn').attr('disabled', false);
            } else{
                $('#msg-btn').attr('disabled', true);
            }
        });
        $('#msg-form').click(function(){
            if($('#usermail').val() != "" && $('#mailheading').val() != "" && $('#mailbody').val() != ""){
                $('#msg-btn').attr('disabled', false);
            } else{
                $('#msg-btn').attr('disabled', true);
            }
        });
        $("#msg-form").submit(function(event) {
            var hcaptchaVal = $('[name=h-captcha-response]').val();
            if (hcaptchaVal === "") {
                event.preventDefault();
                alert("Please complete the hCaptcha");
            }
        });
        <?php
            }
        ?>
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