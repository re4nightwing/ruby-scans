<?php
session_start();

$login_status = 0;
$user_mail = 0;
$user_id = 0;
if(isset($_SESSION["email"]) && isset($_SESSION['user_uid'])){
    $user_mail = $_SESSION["email"];
    $user_id = $_SESSION['user_uid'];
    $login_status = 1;
}
$status_list = ['Cancelled','Complete','Discontinued','Hiatus','Ongoing'];
$type_list = ['Doujinshi','Manga','Manhua','Manhwa','OEL','One-shot'];
$genre_list = ['Action','Adult','Adventure','Comedy','Doujinshi','Drama','Ecchi','Fantasy','Gender Bender','Harem','Hentai','Historical','Horror','Isekai','Josei','Lolicon','Martial Arts','Mature','Mecha','Mystery','Psychological','Romance','School Life','Sci-fi','Seinen','Shotacon','Shoujo','Shoujo Ai','Shounen','Shounen Ai','Slice of Life','Smut','Sports','Supernatural','Tragedy','Yaoi','Yuri'];
$img_arr = array('https://i.pinimg.com/236x/fb/dc/34/fbdc3447025a9195a22f21e8b4530e6f.jpg',
    'https://i.pinimg.com/originals/54/a5/33/54a533689895222755ad678e7c7be409.jpg',
    'https://i.pinimg.com/736x/80/19/cc/8019ccf004a628d323ebe5458c8044d8.jpg',
    'https://i.pinimg.com/736x/8d/38/c5/8d38c5a3dbc10caeefa8618ee3be775f.jpg',
    'https://i.pinimg.com/originals/1b/51/87/1b5187559e86841d39277f07753f5a7e.jpg',
    'https://i.pinimg.com/236x/a1/de/14/a1de1480d603e4a3c6e1566cc40e7ae7.jpg',
    'https://i.pinimg.com/236x/c2/d6/40/c2d640c431f6861bd1880985d835d31b.jpg',
    'https://i.pinimg.com/236x/67/bf/37/67bf37932edb6c3bc510b79e40d06152.jpg',
    'https://i.pinimg.com/236x/c2/8e/b9/c28eb99d15cddc36fbe8bdba1ff6151e.jpg');
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title> Categories | Ruby Scans</title>
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
        .img-card{
            position: relative;
            width: 100%;
            background-position: center center;
            background-size: cover;
            height: 18rem;
            border-radius: 5px;
            box-shadow: 0 0 8px #fff;
            -webkit-transition: all 0.6s cubic-bezier(0.165, 0.84, 0.44, 1);
            transition: all 0.6s cubic-bezier(0.165, 0.84, 0.44, 1);
        }
        .img-card::after {
            content: "";
            border-radius: 5px;
            position: absolute;
            z-index: -1;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            box-shadow: 4px 4px 8px #c0c0c0;
            opacity: 0;
            -webkit-transition: all 0.6s cubic-bezier(0.165, 0.84, 0.44, 1);
            transition: all 0.6s cubic-bezier(0.165, 0.84, 0.44, 1);
        }
        .img-card:hover{
            -webkit-transform: scale(1.1, 1.1);
            transform: scale(1.1, 1.1);
        }
        .img-card:hover::after {
            opacity: 1;
        }
        .img-card-text{
            position: absolute;
            height: 100%;
            width: 100%;
            text-decoration: none;
            backdrop-filter: blur(4px);
            border-radius: 5px;
        }
        .img-card-text h5{
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%,-50%);
            color: #fff;
            font-weight: bold;
            text-shadow: 2px 2px 4px #000;
            width: 100%;
            text-align: center;
        }
        .sub-topic-cate{
            display: inline-block;
            padding: 5px 40px 5px 20px;
            border-radius: 0px 50px 50px 0px;
            background-color: #d3d3d3;
            transform: translateX(-.75rem);
            box-shadow: 2px 2px 4px #4e4e4e;
            margin-bottom: 2rem;
        }
    </style>
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
                <h1>Categories</h1>
            </div>
            <hr style="background-color: #ed053b; width: 5%; height: 4px;" class="mx-auto mb-4">
            <div class="text-start">
                <h2 class="sub-topic-cate">Status</h2>
            </div>
            
            <div class="row justify-content-center">
                <?php
                foreach($status_list as $val){
                    $index = array_rand($img_arr);
                    $img_url = $img_arr[$index];
                ?>
                <div class="col-xl-2 col-lg-3 col-md-4 col-sm-6 col-11 px-2 py-1">
                    <a href="search-manga.php?searchq=&authorq=&yearq=&sortq=asc&statusq=<?php echo $val;?>&typeq=all&genreq=all">
                        <div class="img-card" style="background: url(<?php echo $img_url;?>) center center;">
                            <div class="img-card-text">
                                <h5><?php echo $val;?></h5>
                            </div>
                        </div>
                    </a>
                </div>
                <?php
                }
                ?>
            </div>

            <div class="text-start mt-5">
                <h2 class="sub-topic-cate">Type</h2>
            </div>
            
            <div class="row justify-content-around">
                <?php
                foreach($type_list as $val){
                    $index = array_rand($img_arr);
                    $img_url = $img_arr[$index];
                ?>
                <div class="col-xl-2 col-lg-3 col-md-4 col-sm-6 col-11 px-2 py-1 mx-2 mb-3">
                    <a href="search-manga.php?searchq=&authorq=&yearq=&sortq=asc&statusq=all&typeq=<?php echo $val;?>&genreq=all">
                        <div class="img-card" style="background: url(<?php echo $img_url;?>) center center;">
                            <div class="img-card-text">
                                <h5><?php echo $val;?></h5>
                            </div>
                        </div>
                    </a>
                </div>
                <?php
                }
                ?>
            </div>

            <div class="text-start mt-5">
                <h2 class="sub-topic-cate">Genre</h2>
            </div>
            
            <div class="row justify-content-around">
                <?php
                foreach($genre_list as $val){
                    $index = array_rand($img_arr);
                    $img_url = $img_arr[$index];
                ?>
                <div class="col-xl-2 col-lg-3 col-md-4 col-sm-6 col-11 px-2 py-1 mx-2 mb-3">
                    <a href="search-manga.php?searchq=&authorq=&yearq=&sortq=asc&statusq=all&typeq=all&genreq=<?php echo $val;?>">
                        <div class="img-card" style="background: url(<?php echo $img_url;?>) center center;">
                            <div class="img-card-text">
                                <h5><?php echo $val;?></h5>
                            </div>
                        </div>
                    </a>
                </div>
                <?php
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