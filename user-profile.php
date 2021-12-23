<?php
    session_start();
    $login_status = 0;

    if(isset($_SESSION["email"]) && isset($_SESSION['user_uid'])){
        $user_mail = $_SESSION["email"];
        $user_id = $_SESSION['user_uid'];
        $login_status = 1;

        include 'db-conn.php';
        $stmt = $dbh->prepare("SELECT * FROM `user_details` WHERE `user_mail`=? LIMIT 1"); 
        $stmt->execute([$user_mail]); //`user_mail`, `user_name`, `user_pswd`, `signed_date`, `access_token`, `user_list`, `user_bought`, `ruby_count`, `toss_time`, `blackjack_time`
        $row = $stmt->fetch();
        if ($stmt->rowCount() > 0) {
            $user_name = $row['user_name'];
            $user_last_log = $row['signed_date'];
            $user_wish_list = $row['user_list'];
            $user_bought_list = $row['user_bought'];
            $user_ruby_count = $row['ruby_count'];

            $user_wish_list_arr = array();
            $user_bought_list_arr = array();
            $user_has_wished = 1;
            $user_has_bought = 1;

            if(is_null($user_wish_list)){
                $user_has_wished = 0;
            } else{
                $user_wish_list_arr = explode(',',$user_wish_list);
            }
            if(is_null($user_bought_list)){
                $user_has_bought = 0;
            } else{
                $user_bought_list_arr = explode(',',$user_bought_list);
            }
        } else{
            ?>
            <script>
                alert("Error occured Please login again");
                window.location.href = "user-logout.php";
            </script>
            <?php
        }
    } else{
        header('Location: user-logout.php');
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Profile | Ruby Scans</title>
    <link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.10.0/css/all.css" integrity="sha384-AYmEC3Yw5cVb3ZcuHtOA93w35dYTsvhLPVnYs9eStHfGJvOvKxVfELGroGkvsg+p" crossorigin="anonymous"/>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="stylesheet" href="https://unpkg.com/swiper@7/swiper-bundle.min.css"/>
    <link rel="stylesheet" href="css/main.css">
    <link rel="icon" type="image/png" href="img/favicon.png">
    <style>
        h2{
            font-family: 'Oswald', sans-serif;
            font-size: 1.8rem;
        }
        .img-circle {
            border-radius: 50%;
        }
        .profile-user-img {
            border: 3px solid #adb5bd;
            margin: 0 auto;
            padding: 3px;
            width: 100px;
        }
        .abs-bought{
            position: absolute;
            bottom: 0;
            left: 0;
            width: 100%;
            text-align: center;
        }
        .card{
            overflow: hidden;
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
                        <a class="nav-link" href="#">Categories</a>
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
        <div class="container-fluid text-center" id="content-container">
            <div class="col-lg-10 col-md-11 col-12 mx-auto">
                <div class="text-start"><h2>Profile</h2></div>
                <div class="row justify-content-around">
                    <div class="col-lg-3 my-2">
                        <div class="card card-primary card-outline">
                            <div class="card-body box-profile">
                                <div class="text-center">
                                    <img class="profile-user-img img-fluid img-circle" src="img/guts.jpg" alt="User profile picture">
                                </div>

                                <h3 class="profile-username text-center"><?php echo $user_name;?></h3>

                                <p class="text-muted text-center"><?php echo $user_mail;?></p>

                                <ul class="list-group list-group-unbordered mb-3">
                                    <li class="list-group-item">
                                        <b>Total Rubies: </b> <span class="float-right"><?php echo $user_ruby_count;?></span>
                                    </li>
                                    <li class="list-group-item">
                                        <b>Last Login: </b> <span class="float-right"><?php echo $user_last_log;?></span>
                                    </li>
                                </ul>
                                <div class="d-grid">
                                    <a href="deactivate-acc.php" class="btn btn-danger">Delete Account</a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-9 my-2">
                        <div class="card" id="full-user-list">
                            <div class="card-header p-2">
                                <ul class="nav nav-pills">
                                <li class="nav-item"><a class="nav-link active" href="#all" data-toggle="tab" onclick="changePane(this)">All</a></li>
                                <li class="nav-item"><a class="nav-link" href="#purchased" data-toggle="tab" onclick="changePane(this)">Purchased</a></li>
                                <li class="nav-item"><a class="nav-link" href="#wishlist" data-toggle="tab" onclick="changePane(this)">Wishlist</a></li>
                                </ul>
                            </div>
                            <div class="card-body">
                                <div class="tab-content">
                                    <div class="tab-pane active" id="all">
                                        <div class="row justify-content-around">
                                        
                                        <?php 
                                            if($user_has_bought){
                                                foreach($user_bought_list_arr as $manga){
                                                    $secondary_query = $dbh->prepare("SELECT `mag_id`, `mag_title`,`mag_release`,`mag_cover`,`mag_type`,`mag_status`,`mag_genre`,`mag_author` FROM `magazine-details` WHERE `mag_id`= ? LIMIT 1"); 
                                                    $secondary_query->execute([$manga]); 
                                                    $row = $secondary_query->fetch();
                                                    if ($secondary_query->rowCount() > 0) {
                                                        $genre_arr = explode(',',$row['mag_genre']);
                                                        $clean_genre_arr = array_filter($genre_arr);
                                                        ?>
                                            <div class="col-xxl-6 col-xl-7 col-lg-8 col-md-10">
                                                <div class="card mb-3 mx-auto" style="max-width: 540px;">
                                                    <div class="row g-0">
                                                        <div class="col-md-4">
                                                            <a href="magazine-details.php?mag-id=<?php echo $row['mag_id'];?>">
                                                                <img src="https://i.imgur.com/<?php echo $row['mag_cover'];?>" class="img-fluid rounded-start" alt="<?php echo $row['mag_title'];?>">
                                                            </a>
                                                        </div>
                                                        <div class="col-md-8" style="position: relative;">
                                                            <div class="card-body">
                                                                <h5 class="card-title"><?php echo $row['mag_title']." (".$row['mag_release'].") ";?></h5>
                                                                <p class="card-text"><span class="badge bg-warning text-dark"><?php echo $row['mag_status'];?></span> <span class="badge bg-info text-dark"><?php echo $row['mag_type'];?></span></p>
                                                                <p>Author/s: <?php echo $row['mag_author'];?></p>
                                                                <p class="card-text"><small class="text-muted">
                                                                <?php
                                                                    foreach($clean_genre_arr as $genrename){
                                                                        echo "<a class='btn-link' href='search-manga.php?searchq=&authorq=&yearq=&sortq=asc&statusq=all&typeq=all&genreq=".$genrename."'>$genrename</a> ";
                                                                    }
                                                                ?>
                                                                </small></p>
                                                                <a href="magazine-details.php?mag-id=<?php echo $row['mag_id'];?>" class="btn btn-success">View More</a>
                                                                <div class="abs-bought bg-secondary text-light">You owns this series</div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                                        <?php
                                                    }
                                                }
                                            }
                                            if($user_has_wished){
                                                foreach($user_wish_list_arr as $manga){
                                                    $secondary_query = $dbh->prepare("SELECT `mag_id`, `mag_title`,`mag_release`,`mag_cover`,`mag_type`,`mag_status`,`mag_genre`,`mag_author` FROM `magazine-details` WHERE `mag_id`= ? LIMIT 1"); 
                                                    $secondary_query->execute([$manga]); 
                                                    $row = $secondary_query->fetch();
                                                    if ($secondary_query->rowCount() > 0) {
                                                        $genre_arr = explode(',',$row['mag_genre']);
                                                        $clean_genre_arr = array_filter($genre_arr);
                                                        ?>
                                            <div class="col-xxl-6 col-xl-7 col-lg-8 col-md-10">
                                                <div class="card mb-3 mx-auto" style="max-width: 540px;">
                                                    <div class="row g-0">
                                                        <div class="col-md-4">
                                                            <a href="magazine-details.php?mag-id=<?php echo $row['mag_id'];?>">
                                                                <img src="https://i.imgur.com/<?php echo $row['mag_cover'];?>" class="img-fluid rounded-start" alt="<?php echo $row['mag_title'];?>">
                                                            </a>
                                                        </div>
                                                        <div class="col-md-8">
                                                            <div class="card-body">
                                                                <h5 class="card-title"><?php echo $row['mag_title']." (".$row['mag_release'].") ";?></h5>
                                                                <p class="card-text"><span class="badge bg-warning text-dark"><?php echo $row['mag_status'];?></span> <span class="badge bg-info text-dark"><?php echo $row['mag_type'];?></span></p>
                                                                <p>Author/s: <?php echo $row['mag_author'];?></p>
                                                                <p class="card-text"><small class="text-muted">
                                                                <?php
                                                                    foreach($clean_genre_arr as $genrename){
                                                                        echo "<a class='btn-link' href='search-manga.php?searchq=&authorq=&yearq=&sortq=asc&statusq=all&typeq=all&genreq=".$genrename."'>$genrename</a> ";
                                                                    }
                                                                ?>
                                                                </small></p>
                                                                <a href="magazine-details.php?mag-id=<?php echo $row['mag_id'];?>" class="btn btn-success">View More</a>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                                        <?php
                                                    }
                                                }
                                            }
                                            if(!($user_has_bought || $user_has_wished)){
                                                echo "<div class='text-start ps-0'>";
                                                echo "<img src='img/yato-empty.png' class='img-fluid'>";
                                                echo "</div>";
                                            }
                                        ?>
                                        </div>
                                    </div>
                                    <div class="tab-pane" id="purchased">
                                        <div class="row justify-content-around">
                                        <?php 
                                            if($user_has_bought){
                                                foreach($user_bought_list_arr as $manga){
                                                    $secondary_query = $dbh->prepare("SELECT `mag_id`, `mag_title`,`mag_release`,`mag_cover`,`mag_type`,`mag_status`,`mag_genre`,`mag_author` FROM `magazine-details` WHERE `mag_id`= ? LIMIT 1"); 
                                                    $secondary_query->execute([$manga]); 
                                                    $row = $secondary_query->fetch();
                                                    if ($secondary_query->rowCount() > 0) {
                                                        $genre_arr = explode(',',$row['mag_genre']);
                                                        $clean_genre_arr = array_filter($genre_arr);
                                                        ?>
                                            <div class="col-xxl-6 col-xl-7 col-lg-8 col-md-10">
                                                <div class="card mb-3 mx-auto" style="max-width: 540px;">
                                                    <div class="row g-0">
                                                        <div class="col-md-4">
                                                            <a href="magazine-details.php?mag-id=<?php echo $row['mag_id'];?>">
                                                                <img src="https://i.imgur.com/<?php echo $row['mag_cover'];?>" class="img-fluid rounded-start" alt="<?php echo $row['mag_title'];?>">
                                                            </a>
                                                        </div>
                                                        <div class="col-md-8">
                                                            <div class="card-body">
                                                                <h5 class="card-title"><?php echo $row['mag_title']." (".$row['mag_release'].") ";?></h5>
                                                                <p class="card-text"><span class="badge bg-warning text-dark"><?php echo $row['mag_status'];?></span> <span class="badge bg-info text-dark"><?php echo $row['mag_type'];?></span></p>
                                                                <p>Author/s: <?php echo $row['mag_author'];?></p>
                                                                <p class="card-text"><small class="text-muted">
                                                                <?php
                                                                    foreach($clean_genre_arr as $genrename){
                                                                        echo "<a class='btn-link' href='search-manga.php?searchq=&authorq=&yearq=&sortq=asc&statusq=all&typeq=all&genreq=".$genrename."'>$genrename</a> ";
                                                                    }
                                                                ?>
                                                                </small></p>
                                                                <a href="magazine-details.php?mag-id=<?php echo $row['mag_id'];?>" class="btn btn-success">View More</a>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                                        <?php
                                                    }
                                                }
                                            } else{
                                                echo "<div class='text-start ps-0'>";
                                                echo "<img src='img/yato-empty.png' class='img-fluid'>";
                                                echo "</div>";
                                            }
                                        ?>
                                        </div>
                                    </div>
                                    <div class="tab-pane" id="wishlist">
                                        <div class="row justify-content-around">
                                        <?php 
                                            if($user_has_wished){
                                                foreach($user_wish_list_arr as $manga){
                                                    $secondary_query = $dbh->prepare("SELECT `mag_id`, `mag_title`,`mag_release`,`mag_cover`,`mag_type`,`mag_status`,`mag_genre`,`mag_author` FROM `magazine-details` WHERE `mag_id`= ? LIMIT 1"); 
                                                    $secondary_query->execute([$manga]); 
                                                    $row = $secondary_query->fetch();
                                                    if ($secondary_query->rowCount() > 0) {
                                                        $genre_arr = explode(',',$row['mag_genre']);
                                                        $clean_genre_arr = array_filter($genre_arr);
                                                        ?>
                                            <div class="col-xxl-6 col-xl-7 col-lg-8 col-md-10">
                                                <div class="card mb-3 mx-auto" style="max-width: 540px;">
                                                    <div class="row g-0">
                                                        <div class="col-md-4">
                                                            <a href="magazine-details.php?mag-id=<?php echo $row['mag_id'];?>">
                                                                <img src="https://i.imgur.com/<?php echo $row['mag_cover'];?>" class="img-fluid rounded-start" alt="<?php echo $row['mag_title'];?>">
                                                            </a>
                                                        </div>
                                                        <div class="col-md-8">
                                                            <div class="card-body">
                                                                <h5 class="card-title"><?php echo $row['mag_title']." (".$row['mag_release'].") ";?></h5>
                                                                <p class="card-text"><span class="badge bg-warning text-dark"><?php echo $row['mag_status'];?></span> <span class="badge bg-info text-dark"><?php echo $row['mag_type'];?></span></p>
                                                                <p>Author/s: <?php echo $row['mag_author'];?></p>
                                                                <p class="card-text"><small class="text-muted">
                                                                <?php
                                                                    foreach($clean_genre_arr as $genrename){
                                                                        echo "<a class='btn-link' href='search-manga.php?searchq=&authorq=&yearq=&sortq=asc&statusq=all&typeq=all&genreq=".$genrename."'>$genrename</a> ";
                                                                    }
                                                                ?>
                                                                </small></p>
                                                                <a href="magazine-details.php?mag-id=<?php echo $row['mag_id'];?>" class="btn btn-success">View More</a>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                                        <?php
                                                    }
                                                }
                                            } else{
                                                echo "<div class='text-start ps-0'>";
                                                echo "<img src='img/yato-empty.png' class='img-fluid'>";
                                                echo "</div>";
                                            }
                                        ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <?php 
        $dbh=null;
        include 'footer.php';
    ?>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
    <script src="https://unpkg.com/swiper@7/swiper-bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/vanilla-lazyload@17.5.0/dist/lazyload.min.js"></script>
    <script type="module">
        var lazyLoadInstance = new LazyLoad({thresholds: "200% 0px",});
        lazyLoadInstance.update();
    </script>
    <script>
        function logoutFunc(){
            window.location.href = "user-logout.php";
        }

        function changePane(paneid){
            $( ".nav-link" ).removeClass('active');
            $(paneid).addClass('active');

            $( ".tab-pane" ).removeClass('active');
            $(paneid.hash).addClass('active');
        }

        if(window.location.hash) {
            var elem;
            var curr_hash = window.location.hash;
            if(curr_hash == '#all'){
                elem = document.querySelector("#full-user-list > div.card-header.p-2 > ul > li:nth-child(1) > a");
                changePane(elem);
            } else if(curr_hash == '#purchased'){
                elem = document.querySelector("#full-user-list > div.card-header.p-2 > ul > li:nth-child(2) > a");
                changePane(elem);
            } else if(curr_hash == '#wishlist'){
                elem = document.querySelector("#full-user-list > div.card-header.p-2 > ul > li:nth-child(3) > a");
                changePane(elem);
            }
        }
    </script>
    <?php
        if($login_status){
            ?>
            <script>
                $('#user-profile').removeClass('disabled');
            </script>
            <?php
        }
    ?>
    
</body>
</html>