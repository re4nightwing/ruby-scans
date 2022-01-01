<?php
    session_start();
    $login_status = 0;
    $user_list = array();
    $wish_list = array();

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
    }
    if(isset($_GET['mag-id'])){
        $magazine_id_disqus = $_GET['mag-id'];
        $has_bought = 0;
        $has_wished = 0;
        $requestId = $_GET['mag-id'];
        foreach($user_list as $id){
            if($id == $requestId){
                $has_bought = 1;
                break;
            }
        }
        foreach($wish_list as $id){
            if($id == $requestId){
                $has_wished = 1;
                break;
            }
        }
    } else{
        ?>
        <script>
            window.location.href = "index.php";
        </script>
        <?php
    }
    if(isset($_POST['report-magazine'])){
        $chapId = $_POST['report_id'];
        $chapNum = $_POST['report_chap'];
        $chapName = substr($_POST['report_name'], 0,150);
        $sql = "INSERT INTO `user_msgs`(`msg_by`, `msg_heading`, `msg_body`, `msg_type`) VALUES (?,?,?,?)";
        $stmt= $dbh->prepare($sql);
        $stmt->execute([$user_mail, "$chapName Chapter Report", "Reported an issue on magazine $chapId chapter $chapNum.", 0]);
        $dbh = null;
    } else{
        $dbh = null;
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Magazine Details | Ruby Scans</title>
    <link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.10.0/css/all.css" integrity="sha384-AYmEC3Yw5cVb3ZcuHtOA93w35dYTsvhLPVnYs9eStHfGJvOvKxVfELGroGkvsg+p" crossorigin="anonymous"/>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="stylesheet" href="https://unpkg.com/swiper@7/swiper-bundle.min.css"/>
    <link rel="stylesheet" href="css/main.css">
    <link rel="icon" type="image/png" href="img/favicon.png">
    <style>
        tr td{
            text-align: end;
            padding-right: 1rem !important;
        }
        tr th{
            padding-left: 1rem !important;
        }
        .chapter{
            cursor: pointer;
        }
        .chapter-count{
            margin-top: 4rem;
            height: 500px;
            overflow-y: scroll;
        }
    </style>
    <script src="https://js.hcaptcha.com/1/api.js" async defer></script>
</head>
<body>
    <div class="pageCover" style="display: none;"></div>
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
            <?php
            //`mag_id`, `mag_title`, `mag_alt_title`, `mag_author`, `mag_genre`, `mag_type`, `mag_release`, `mag_status`, `mag_desc`, `mag_cover`

                include 'db-conn.php';
                $custom_query = 'SELECT * from `magazine-details` WHERE `mag_id`= ?';
                $stmt = $dbh->prepare($custom_query);
                $stmt->execute([$requestId]);
                $row = $stmt->fetch();
                $pageTitle=$row['mag_title']." (".$row['mag_release'].")";
            ?>
            <div class="row justify-content-center text-center">
                <h2 class="dark-bg-heading px-5 mb-4"><?php echo $row['mag_title'];?>(<?php echo $row['mag_release'];?>)</h2>
                <div class="col-lg-3 col-md-4 col-sm-6 col-12 my-2">
                    <div class="mx-auto">
                        <img src="https://i.imgur.com/<?php echo $row['mag_cover'];?>" class="img-fluid rounded shadow" alt="">
                    </div>
                </div>
                <div class="col-lg-8 col-md-7 col-sm-6 col-12 my-2 text-start">
                    <h5>Name:<strong> <?php echo $row['mag_title'];?></strong></h5>
                    <h5>Alt. Name/s:<strong> <?php echo $row['mag_alt_title'];?></strong></h5>
                    <h5>Author/s:<strong> <?php echo $row['mag_author'];?></strong></h5>
                    <h5>Genre/s:<strong> <?php echo $row['mag_genre'];?></strong></h5>
                    <h5>Type:<strong> <?php echo $row['mag_type'];?></strong></h5>
                    <h5>Release Year:<strong> <?php echo $row['mag_release'];?></strong></h5>
                    <h5>Status:<strong> <?php echo $row['mag_status'];?></strong></h5>
                    <h5>Description:</h5>
                    <p><?php echo $row['mag_desc'];?></p>
                </div>
                <div class="col-md-8 col-11 my-2">
                    <div class="row justify-content-around">
                        <div class="col-sm-6 col-8 my-2">
                            <span id="demo"></span>
                            <?php
                                if($login_status){
                                    if($has_bought){
                                        echo "<button class='btn btn-secondary btn-lg' disabled>Owns 💸</button>";
                                    } else{
                                        echo "<button class='btn btn-success btn-lg' id='$requestId' onclick='buyThis(this.id)'>Buy Now 💎</button>";
                                    }
                                } else{
                                    echo "<button class='btn btn-success btn-lg' data-bs-toggle='modal' data-bs-target='#exampleModal'>Buy Now 💎</button>";
                                }
                            ?>
                        </div>
                        <div class="col-sm-6 col-8 my-2">
                            <?php
                                if($login_status){
                                    if($has_bought){
                                        echo "<button class='btn btn-secondary btn-lg' disabled>Add to Wishlist 📜</button>";
                                    } elseif($has_wished){
                                        echo "<button class='btn btn-danger btn-lg' id='$requestId' onclick='unbookThis(this.id)'>Remove from Wishlist 📜</button>";
                                    } else{
                                        echo "<button class='btn btn-info btn-lg' id='$requestId' onclick='bookThis(this.id)'>Add to Wishlist 📜</button>";
                                    }
                                } else{
                                    echo "<button class='btn btn-info btn-lg' data-bs-toggle='modal' data-bs-target='#exampleModal'>Add to Wishlist 📜</button>";
                                }
                                
                            ?>
                        </div>
                    </div>
                </div>
            </div>
            <div class="chapter-count text-center">
                <h2>Chapters</h2>
                <div class="container-fluid mt-4">
                    <div class="row row-cols-1 row-cols-sm-2 row-cols-md-4 g-2 g-lg-3 justify-content-center">
                    <?php
                        $stmt = $dbh->prepare("SELECT `chapter_number`, `magazine_id`,`update_date` from `magazine-chapters` WHERE `magazine_id` = ?");
                        $stmt->execute([$requestId]);
                        $data = $stmt->fetchAll();
                        foreach ($data as $row) {
                            if($login_status){
                                if($has_bought){
                                    ?>
                                    <div class="col">
                                        <button type="button" class="btn btn-outline-light fw-bolder" onclick="gotoPage(<?php echo $row['chapter_number'];?>)"><?php echo "Chapter ".$row['chapter_number'];?><br><?php echo date_format(date_create($row['update_date']),"Y/m/d");?></button>
                                    </div>
                                    <?php
                                } else{
                                    ?>
                                    <div class="col">
                                        <button type="button" class="btn btn-outline-light fw-bolder" data-bs-toggle='modal' data-bs-target='#exampleModal1' ><?php echo "Chapter ".$row['chapter_number'];?><br><?php echo date_format(date_create($row['update_date']),"Y/m/d");?></button>
                                    </div>
                                    <?php
                                }
                            } else{
                                ?>
                                <div class="col">
                                    <button type="button" class="btn btn-outline-light fw-bolder" data-bs-toggle='modal' data-bs-target='#exampleModal'><?php echo "Chapter ".$row['chapter_number'];?><br><?php echo date_format(date_create($row['update_date']),"Y/m/d");?></button>
                                </div>
                                <?php
                            }
                        }
                        $dbh=null;
                    ?>
                    </div>
                </div>
            </div>
        </div>
        <div class="container-xl p-0 m-0 mx-auto">
            <div id="disqus_thread" class="bg-dark py-4 px-3"></div>
        </div>
    </section>
    <?php
        include 'footer.php';
    ?>
    <div class="modal fade" id="exampleModal1" tabindex="-1" aria-labelledby="exampleModal1Label" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModal1Label">Read Manga <?php echo $pageTitle;?></h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p>Wanna read <?php echo $pageTitle;?> ?</p>
                <p>Only <b>3 rubies!</b></p>
                <input type="hidden" class="form-control" id="recipient-name">
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" onclick="buyThis('<?php echo $requestId;?>')">Buy It</button>
                <?php
                    if($has_wished){
                        echo "<button type='button' class='btn btn-danger' id='$requestId' onclick='unbookThis(this.id)'>Remove from Wishlist</button>";
                    } else{
                        echo "<button type='button' class='btn btn-primary' id='$requestId' onclick='bookThis(this.id)'>Add to Wishlist</button>";
                    }
                ?>

                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" id="btn-close-modal">Close</button>
            </div>
            </div>
        </div>
    </div>
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
        <div id="wishLiveToast" class="toast" role="alert" aria-live="assertive" aria-atomic="true">
            <div class="toast-header">
            <img src="img/favicon.png" class="rounded me-2" height="15px" alt="...">
            <strong class="me-auto">Ruby Scans</strong>
            <small>Just Now</small>
            <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
            </div>
            <div class="toast-body">
                <?php echo "<b>".$pageTitle."</b> was added to your <b>wishlist</b> successfully!";?>
            </div>
        </div>
    </div>
    <div class="position-fixed bottom-0 end-0 p-3" style="z-index: 11">
        <div id="buyLiveToast" class="toast" role="alert" aria-live="assertive" aria-atomic="true">
            <div class="toast-header">
            <img src="img/favicon.png" class="rounded me-2" height="15px" alt="...">
            <strong class="me-auto">Ruby Scans</strong>
            <small>Just Now</small>
            <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
            </div>
            <div class="toast-body">
                <?php echo "<b>".$pageTitle."</b> <b>purchased</b> successfully!";?>
            </div>
        </div>
    </div>
    <div class="position-fixed bottom-0 end-0 p-3" style="z-index: 11">
        <div id="unwishLiveToast" class="toast" role="alert" aria-live="assertive" aria-atomic="true">
            <div class="toast-header">
            <img src="img/favicon.png" class="rounded me-2" height="15px" alt="...">
            <strong class="me-auto">Ruby Scans</strong>
            <small>Just Now</small>
            <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
            </div>
            <div class="toast-body">
                <?php echo "<b>".$pageTitle."</b> removed from your wishlist!";?>
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
    <script type="module">
        var lazyLoadInstance = new LazyLoad({threshold: 0,});
        lazyLoadInstance.update();
    </script>
    <?php
        if($login_status){
            ?>
            <script>
                $('#user-profile').removeClass('disabled');
                function buyThis(mangaId){
                    if (confirm("Do you want to buy <?php echo $pageTitle;?> for 3 rubies?")) {
                        buyNow(mangaId);
                    }
                }

                function bookThis(mangaId){
                    $('#btn-close-modal').click();
                    var hasBooked = '<?php echo $wish_list_check;?>';
                    var userMail = '<?php echo $user_mail;?>';
                    var userId = '<?php echo $user_id;?>';
                    if(userMail != '0' || userId != '0'){
                        $('.pageCover').fadeIn(300);
                        $("#demo").load("add-item.php", {
                        mail: userMail,
                        id: userId,
                        mangaId: mangaId,
                        isVirgin: hasBooked,
                        type: "bookmark"
                        }, function(){
                            $('.pageCover').fadeOut(500);
                        });
                    }
                }

                function unbookThis(mangaId){
                    $('#btn-close-modal').click();
                    var hasBooked = '<?php echo $wish_list_check;?>';
                    var userMail = '<?php echo $user_mail;?>';
                    var userId = '<?php echo $user_id;?>';
                    if(userMail != '0' || userId != '0'){
                        $('.pageCover').fadeIn(300);
                        $("#demo").load("add-item.php", {
                        mail: userMail,
                        id: userId,
                        mangaId: mangaId,
                        isVirgin: hasBooked,
                        type: "unbookmark"
                        }, function(){
                            $('.pageCover').fadeOut(500);
                        });
                    }
                }

                function buyNow(mangaId){
                    $('#btn-close-modal').click();
                    var hasBought = '<?php echo $user_list_check;?>';
                    var hasWished = '<?php echo $has_wished;?>';
                    var userMail = '<?php echo $user_mail;?>';
                    var userId = '<?php echo $user_id;?>';
                    if(userMail != '0' || userId != '0'){
                        $('.pageCover').fadeIn(300);
                        $("#demo").load("add-item.php", {
                        mail: userMail,
                        id: userId,
                        mangaId: mangaId,
                        isVirgin: hasBought,
                        type: "buy",
                        hasWished: hasWished
                        }, function(){
                            $('.pageCover').fadeOut(500);
                        });
                    }
                }
            </script>
            <?php
        }
    ?>
    <script>
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

        var exampleModal1 = document.getElementById('exampleModal1')
        exampleModal1.addEventListener('show.bs.modal', function (event) {
            var button = event.relatedTarget;
            var recipient = button.getAttribute('data-bs-whatever');

            var modalBodyInput = exampleModal1.querySelector('.modal-body input');
            modalBodyInput.value = recipient;
        });

        function logoutFunc(){
            window.location.href = "user-logout.php";
        }
        function gotoPage(chapter){
            window.location.href = "view-chapter.php?id=<?php echo $requestId;?>&chapter="+chapter;
        }

        $(document).ready(function() {
            document.title = '<?php echo $pageTitle." | Ruby Scans";?>';
        });
    </script>
    <script>
        /**
        *  RECOMMENDED CONFIGURATION VARIABLES: EDIT AND UNCOMMENT THE SECTION BELOW TO INSERT DYNAMIC VALUES FROM YOUR PLATFORM OR CMS.
        *  LEARN WHY DEFINING THESE VARIABLES IS IMPORTANT: https://disqus.com/admin/universalcode/#configuration-variables    */
        
        var disqus_config = function () {
        this.page.url = window.location.href;  // Replace PAGE_URL with your page's canonical URL variable
        this.page.identifier = '<?php echo $magazine_id_disqus;?>'; // Replace PAGE_IDENTIFIER with your page's unique identifier variable
        };
    
        (function() { // DON'T EDIT BELOW THIS LINE
        var d = document, s = d.createElement('script');
        s.src = 'https://ruby-scans.disqus.com/embed.js';
        s.setAttribute('data-timestamp', +new Date());
        (d.head || d.body).appendChild(s);
        })();
    </script>
    <noscript>Please enable JavaScript to view the <a href="https://disqus.com/?ref_noscript">comments powered by Disqus.</a></noscript>
    <script>
        var toastLiveWish = document.getElementById('wishLiveToast');
        var toastLiveUnwish = document.getElementById('unwishLiveToast');
        var toastLiveBuy = document.getElementById('buyLiveToast');
        var loginToast = document.getElementById('loginToast');
        function showWishToast(){
            var toast = new bootstrap.Toast(toastLiveWish)
            toast.show()
        }
        function showBuyToast(){
            var toast = new bootstrap.Toast(toastLiveBuy)
            toast.show()
        }
        function showUnwishToast(){
            var toast = new bootstrap.Toast(toastLiveUnwish)
            toast.show()
        }
        function showLoginToast(){
            var toast = new bootstrap.Toast(loginToast)
            toast.show()
        }
    </script>
    <?php
    if(isset($_SESSION['wish'])){
        if($_SESSION['wish']){
            ?>
            <script>
                showWishToast();
            </script>
            <?php
            $_SESSION['wish'] = false;
            unset($_SESSION['wish']);
        }
    }
    if(isset($_SESSION['unwish'])){
        if($_SESSION['unwish']){
            ?>
            <script>
                showUnwishToast();
            </script>
            <?php
            $_SESSION['unwish'] = false;
            unset($_SESSION['unwish']);
        }
    }
    if(isset($_SESSION['bought'])){
        if($_SESSION['bought']){
            ?>
            <script>
                showBuyToast();
            </script>
            <?php
            $_SESSION['bought'] = false;
            unset($_SESSION['bought']);
        }
    }
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