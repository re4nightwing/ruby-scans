<?php
session_start();
$login_status = 0;
$user_list = array();
$wish_list = array();
if(isset($_SESSION["email"]) && isset($_SESSION['user_uid'])){
    $login_status = 1;
    
    include 'db-conn.php';
    $stmt = $dbh->prepare("SELECT * FROM `user_details` WHERE `user_mail`=? LIMIT 1"); 
    $stmt->execute([$_SESSION['email']]); 
    $row = $stmt->fetch();
    if ($stmt->rowCount() > 0) {
        $dbh = null;
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
        $dbh = null;
        ?>
        <script>
            alert("Error occured Please login again");
            window.location.href = "user-logout.php";
        </script>
        <?php
    }
}
$category_list = ['Action','Adult','Adventure','Comedy','Doujinshi','Drama','Ecchi','Fantasy','Gender Bender','Harem','Hentai','Historical','Horror','Isekai','Josei','Lolicon','Martial Arts','Mature','Mecha','Mystery','Psychological','Romance','School Life','Sci-fi','Seinen','Shotacon','Shoujo','Shoujo Ai','Shounen','Shounen Ai','Slice of Life','Smut','Sports','Supernatural','Tragedy','Yaoi','Yuri'];
$category_class = array("bg-primary", "bg-secondary", "bg-info text-dark", "bg-light text-dark", "bg-dark");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Welcome | Ruby Scans</title>
    <link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.10.0/css/all.css" integrity="sha384-AYmEC3Yw5cVb3ZcuHtOA93w35dYTsvhLPVnYs9eStHfGJvOvKxVfELGroGkvsg+p" crossorigin="anonymous"/>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="stylesheet" href="https://unpkg.com/swiper@7/swiper-bundle.min.css"/>
    <link rel="stylesheet" href="css/main.css">
    <link rel="icon" type="image/png" href="img/favicon.png">
    <style>
    .showcase-swiper {
        width: 100%;
        height: 33.33vw;
    }
    .swiper-wrapper {
        height: auto !important;
    }

    .showcase-slide {
        text-align: center;
        font-size: 18px;
        background: #fff;

        /* Center slide text vertically */
        display: -webkit-box;
        display: -ms-flexbox;
        display: -webkit-flex;
        display: flex;
        -webkit-box-pack: center;
        -ms-flex-pack: center;
        -webkit-justify-content: center;
        justify-content: center;
        -webkit-box-align: center;
        -ms-flex-align: center;
        -webkit-align-items: center;
        align-items: center;
        overflow: hidden;
    }
    .showcase-slide img{
        flex-shrink: 0;
        width: 100%;
        min-height: 100%
    }
    .slides-per-view {
      width: 100%;
      height: auto;
    }

    .slides-per-slide {
        text-align: center;
        font-size: 18px;
        background: #ffffff47;
        backdrop-filter: blur(5px);
        -webkit-backdrop-filter: blur(5px);
      /* Center slide text vertically */
        display: -webkit-box;
        display: -ms-flexbox;
        display: -webkit-flex;
        display: flex;
        -webkit-box-pack: center;
        -ms-flex-pack: center;
        -webkit-justify-content: center;
        justify-content: center;
        -webkit-box-align: center;
        -ms-flex-align: center;
        -webkit-align-items: center;
        align-items: center;
        height: 300px;
        transition: 0.4s ease-out;
    }
    .slides-per-slide img{
        transition: 0.4s ease-out;
    }
    .slides-per-slide:hover img{
        filter: grayscale(.7);
        transform: scale(1.2);
        box-shadow: 0 0 8px #000;
    }
    .slides-per-slide:hover .abs-slide-content{
        opacity: 1;
    }
    .popular-sec{
        background-color: #2c031057;
    }
    .abs-slide-content{
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%,-50%);
        width: 100%;
        text-align: center;
        opacity: 0;
        transition: 0.4s ease-out;
    }
    .abs-slide-content h4{
        text-shadow: 2px 2px 4px #000;
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
    <div class="container-fluid px-0">
        <div class="swiper showcase-swiper">
            <div class="swiper-wrapper">
                <div class="swiper-slide showcase-slide">
                    <img src="img/s1.jpg" class="" alt="">
                </div>
                <div class="swiper-slide showcase-slide">
                    <img src="img/s2.jpg" class="" alt="">
                </div>
                <div class="swiper-slide showcase-slide">
                    <img src="img/s3.jpg" class="" alt="">
                </div>
                <div class="swiper-slide showcase-slide">
                    <img src="img/s4.jpg" class="" alt="">
                </div>
            </div>
            <!-- Add Pagination -->
            <div class="swiper-pagination swiper-pagination-custom1" style="bottom: 0; top: auto;"></div>
            <!-- Add Arrows -->
            <div class="swiper-button-next"></div>
            <div class="swiper-button-prev"></div>
        </div>
    </div>
    <section class="popular-sec py-5">
        <div class="container-xl">
            <h2 class="dark-bg-heading">Most Popular</h2>
            <div class="swiper slides-per-view">
                <div class="swiper-wrapper">
                    <?php
                        include 'db-conn.php';
                        $custom_query = "SELECT * FROM `magazine-details` WHERE `mag_views`!=0 ORDER BY `magazine-details`.`mag_views` DESC LIMIT 10";
                        foreach ($dbh->query($custom_query) as $data) {
                            ?>
                            <div class="swiper-slide slides-per-slide">
                                <a href="magazine-details.php?mag-id=<?php echo $data['mag_id'];?>">
                                <img src="https://i.imgur.com/<?php echo $data['mag_cover'];?>" alt="">
                                <div class="abs-slide-content">
                                    <h4 class="text-light"><?php echo $data['mag_title']?></h4>
                                    <span class="badge bg-primary"><?php echo $data['mag_status'];?></span>
                                </div>
                                </a>
                            </div>
                            <?php
                        }
                    ?>
                </div>
                <!-- Add Pagination -->
                <div class="swiper-pagination swiper-pagination-custom2"></div>
            </div>
        </div>
    </section>
    <section class="content-sec">
        <div class="container-xl" id="content-container">
            <div class="row justify-content-center text-center">
            <!-- ss -->
            <div class="col-xl-8 col-12">
                <h2 class="dark-bg-heading text-center mb-4">Recent Releases</h2>
                <div class="row justify-content-center">
                    <?php
                    //`mag_id`, `mag_title`, `mag_alt_title`, `mag_author`, `mag_genre`, `mag_type`, `mag_release`, `mag_status`, `mag_desc`, `mag_cover`
                    
                    $custom_query = "SELECT `magazine_id`, `upload_date`,`chapter_number` FROM `magazine-chapters` ORDER BY `upload_date` DESC LIMIT 15";
                    foreach ($dbh->query($custom_query) as $data) {
                        $searchID = $data['magazine_id'];
                        $chapNumber = $data['chapter_number'];
                        $has_bought = 0;
                        foreach($user_list as $id){
                            if($id == $searchID){
                                $has_bought = 1;
                                break;
                            }
                        }
                        $secondary_query = "";
                        $secondary_query = $dbh->prepare("SELECT `mag_id`, `mag_title`,`mag_release`,`mag_cover` FROM `magazine-details` WHERE `mag_id`= ? LIMIT 1"); 
                        $secondary_query->execute([$searchID]); 
                        $row = $secondary_query->fetch();
                        if($has_bought){
                        ?>
                        <div class="col-lg-4 col-md-4 col-sm-6 col-12 my-2">
                            <a href="view-chapter.php?id=<?php echo $row['mag_id'];?>&chapter=<?php echo $chapNumber;?>">
                                <div class="mag-card mx-auto rounded shadow-sm">
                                    <img src="https://via.placeholder.com/225×350.png" data-src="https://i.imgur.com/<?php echo $row['mag_cover'];?>" class="lazy img-fluid" alt="">
                                    <div class="mag-text">
                                        <h5><?php echo $row['mag_title'];?> <span>(<?php echo $row['mag_release'];?>)</span></h5>
                                    </div>
                                    <div class="mag-chapter">
                                        <h4><span class="badge bg-danger">Chapter: <?php echo $chapNumber;?></span></h4>
                                    </div>
                                </div>
                            </a>
                        </div>
                        <?php
                        } else{
                            ?>
                            <div class="col-lg-4 col-md-4 col-sm-6 col-12 my-2">
                                <a href="magazine-details.php?mag-id=<?php echo $searchID;?>">
                                    <div class="mag-card mx-auto rounded shadow-sm">
                                        <img src="https://via.placeholder.com/225×350.png" data-src="https://i.imgur.com/<?php echo $row['mag_cover'];?>" class="lazy img-fluid" alt="">
                                        <div class="mag-text">
                                            <h5><?php echo $row['mag_title'];?> <span>(<?php echo $row['mag_release'];?>)</span></h5>
                                        </div>
                                        <div class="mag-chapter">
                                            <h4><span class="badge bg-danger">Chapter: <?php echo $chapNumber;?></span></h4>
                                        </div>
                                    </div>
                                </a>
                            </div>
                            <?php
                        }
                    }
                    $dbh = null;
                    ?>
                </div>
            </div>
            
            <!-- ss -->
                <div class="col-xl-4 col-12 mt-4">
                    <div class="row justify-content-around">
                        <div class="col-xl-12 col-md-6 col-11 my-2">
                            <iframe src="https://discord.com/widget?id=737401246763319399&theme=dark" width="350" height="500" allowtransparency="true" frameborder="0" sandbox="allow-popups allow-popups-to-escape-sandbox allow-same-origin allow-scripts"></iframe>
                        </div>
                        <div class="col-xl-10 col-md-6 col-11">
                            <?php
                                foreach ($category_list as $item){
                                    echo "<a href='search-manga.php?searchq=&authorq=&yearq=&sortq=asc&statusq=all&typeq=all&genreq=".$item."' class='h5 mx-2'><span class='badge ".$category_class[array_rand($category_class)]." my-2'>$item</span></a>";
                                }
                            ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <?php
        include 'footer.php';
    ?>
    <div class="modal fade" id="exampleModal1" tabindex="-1" aria-labelledby="exampleModal1Label" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModal1Label">Read Manga</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    Wanna read?
                    <input type="hidden" class="form-control" id="recipient-name">
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary">Buy It</button>
                    <button type="button" class="btn btn-primary">Add to Wishlist</button>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
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
                                    <input type="hidden" name="page_url" value="index.php">
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
        
        var exampleModal1 = document.getElementById('exampleModal1')
        exampleModal1.addEventListener('show.bs.modal', function (event) {
            var button = event.relatedTarget;
            var recipient = button.getAttribute('data-bs-whatever');

            var modalTitle = exampleModal1.querySelector('.modal-title');
            var modalBodyInput = exampleModal1.querySelector('.modal-body input');

            modalTitle.textContent = 'Read ' + recipient;
            modalBodyInput.value = recipient;
        });
    </script>
    <script type="module">
        var swiper = new Swiper('.showcase-swiper', {
            autoplay: {
                delay: 2500,
                disableOnInteraction: true,
            },
            pagination: {
                el: '.swiper-pagination-custom1',
                type: 'progressbar',
            },
            navigation: {
                nextEl: '.swiper-button-next',
                prevEl: '.swiper-button-prev',
            },
        });
        var swiper = new Swiper('.slides-per-view', {
            slidesPerView: 1,
            spaceBetween: 0,
            pagination: {
                el: '.swiper-pagination-custom2',
                clickable: true,
            },
            autoplay: {
                delay: 2500,
                disableOnInteraction: true,
            },
            breakpoints: {
                499: {
                    slidesPerView: 1
                },
                768: {
                    slidesPerView: 2
                },
                992:{
                    slidesPerView: 3
                },
                1400:{
                    slidesPerView: 4
                }
            }
        });
        var lazyLoadInstance = new LazyLoad({thresholds: "200% 0px",});
        lazyLoadInstance.update();
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