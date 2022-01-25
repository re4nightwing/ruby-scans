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
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Search Magazines | Ruby Scans</title>
    <link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.10.0/css/all.css" integrity="sha384-AYmEC3Yw5cVb3ZcuHtOA93w35dYTsvhLPVnYs9eStHfGJvOvKxVfELGroGkvsg+p" crossorigin="anonymous"/>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="stylesheet" href="https://unpkg.com/swiper@7/swiper-bundle.min.css"/>
    <link rel="stylesheet" href="css/main.css">
    <link rel="icon" type="image/png" href="img/favicon.png">
    <style>
    .showcase-swiper {
        width: 100%;
        height: 60vh;
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
    }
    .showcase-slide img{
        flex-shrink: 0;
        min-width: 100%;
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
    <div class="pageCover" style="display: none;"></div>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
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
        <div class="container-xl py-3" id="content-container">
            <h2 class="dark-bg-heading">Search Magazine</h2>
            <div class="row justify-content-center bg-light py-3">
                <div class="col mx-2">
                    <label for="name-search">Series Title:</label>
                    <input class="form-control" id="name-search" name="searchq" type="search" placeholder="Title" aria-label="Search by name" width="auto">
                </div>
                <div class="col mx-2">
                    <label for="author-search">Series Author/s:</label>
                    <input class="form-control" id="author-search" name="authorq" type="search" placeholder="Author/s" aria-label="Search by author" width="auto">
                </div>
                <div class="col mx-2">
                    <label for="year-search">Series Year:</label>
                    <input class="form-control" id="year-search" name="yearq" type="search" placeholder="Year" aria-label="Search by year" width="auto">
                </div>
                <div class="col-auto mx-2">
                    <label for="filter-btn"></label><br>
                    <button class="btn btn-primary" id="filter-btn" onclick="filterOn()">🔎 Filter</button>
                </div>
            </div>
            <div class="row justify-content-center bg-light py-3 mb-3">
                <div class="col mx-2">
                    <label for="sort-search">Sort by:</label>
                    <select class="form-select" id="sort-search" aria-label="search sort order">
                        <option value="asc" selected>Ascending</option>
                        <option value="desc">Descending</option>
                        <option value="new">Latest Release</option>
                        <option value="old">Oldest Release</option>
                        <option value="most">Most Popular</option>
                        <option value="least">Least Popular</option>
                    </select>
                </div>
                <div class="col mx-2">
                    <label for="status-search">Publish Status:</label>
                    <select class="form-select" id="status-search" aria-label="search by status">
                        <option value="all" selected>All</option>
                        <option value="Cancelled">Cancelled</option>
                        <option value="Complete">Complete</option>
                        <option value="Discontinued">Discontinued</option>
                        <option value="Hiatus">Hiatus</option>
                        <option value="Ongoing">Ongoing</option>
                    </select>
                </div>
                <div class="col mx-2">
                    <label for="type-search">Type:</label>
                    <select class="form-select" id="type-search" aria-label="search by type">
                        <option value="all" selected>All</option>
                        <option value="Doujinshi">Doujinshi</option>
                        <option value="Manga">Manga</option>
                        <option value="Manhua">Manhua</option>
                        <option value="Manhwa">Manhwa</option>
                        <option value="OEL">OEL</option>
                        <option value="One-shot">One-shot</option>
                    </select>
                </div>
                <div class="col mx-2">
                    <label for="genre-search">Genre:</label>
                    <select class="form-select" id="genre-search" aria-label="search by genre">
                        <option value="all" selected>All</option>
                        <option value="Action">Action</option>
                        <option value="Adult">Adult</option>
                        <option value="Adventure">Adventure</option>
                        <option value="Comedy">Comedy</option>
                        <option value="Doujinshi">Doujinshi</option>
                        <option value="Drama">Drama</option>
                        <option value="Ecchi">Ecchi</option>
                        <option value="Fantasy">Fantasy</option>
                        <option value="Gender Bender">Gender Bender</option>
                        <option value="Harem">Harem</option>
                        <option value="Hentai">Hentai</option>
                        <option value="Historical">Historical</option>
                        <option value="Horror">Horror</option>
                        <option value="Isekai">Isekai</option>
                        <option value="Isekai">Josei</option>
                        <option value="Isekai">Lolicon</option>
                        <option value="Martial Arts">Martial Arts</option>
                        <option value="Mature">Mature</option>
                        <option value="Mecha">Mecha</option>
                        <option value="Mystery">Mystery</option>
                        <option value="Psychological">Psychological</option>
                        <option value="Romance">Romance</option>
                        <option value="School Life">School Life</option>
                        <option value="Sci-fi">Sci-fi</option>
                        <option value="Seinen">Seinen</option>
                        <option value="Shotacon">Shotacon</option>
                        <option value="Shoujo">Shoujo</option>
                        <option value="Shoujo Ai">Shoujo Ai</option>
                        <option value="Shounen">Shounen</option>
                        <option value="Shounen Ai">Shounen Ai</option>
                        <option value="Slice of Life">Slice of Life</option>
                        <option value="Smut">Smut</option>
                        <option value="Sports">Sports</option>
                        <option value="Supernatural">Supernatural</option>
                        <option value="Tragedy">Tragedy</option>
                        <option value="Yaoi">Yaoi</option>
                        <option value="Yuri">Yuri</option>
                    </select>
                </div>
            </div>
            <div class="search-result mt-4">
                <div class="row row-cols-1 row-cols-lg-4 row-cols-md-3 row-cols-sm-2 g-4">
            <?php
                //manga title
                if(isset($_GET['searchq'])){
                    $name_query = $_GET['searchq'];
                } else{
                    $name_query = '';
                }
                if($name_query == ''){
                    $name_query = "%";
                } else{
                    ?>
                    <script>
                        $('#name-search').val("<?php echo $name_query;?>");
                    </script>
                    <?php
                }
                //manga author
                if(isset($_GET['authorq'])){
                    $author_query = $_GET['authorq'];
                } else{
                    $author_query = "%";
                }
                if($author_query == '0'){
                    $author_query = "%";
                } else{
                    ?>
                    <script>
                        $('#author-search').val("<?php if($author_query == "%"){echo '';} else{echo $author_query;}?>");
                    </script>
                    <?php
                }
                //manga year
                if(isset($_GET['yearq'])){
                    $year_query = $_GET['yearq'];
                } else{
                    $year_query = "%";
                }
                if($year_query == '0'){
                    $year_query = "%";
                } else{
                    ?>
                    <script>
                        $('#year-search').val("<?php if($year_query == "%"){echo '';} else{echo $year_query;}?>");
                    </script>
                    <?php
                }
                //manga sort
                if(isset($_GET['sortq'])){
                    $sort_query = $_GET['sortq'];
                } else{
                    $sort_query = "asc";
                }
                if($sort_query == '0'){
                    $sort_query = "asc";
                } else{
                    ?>
                    <script>
                        $('#sort-search').val("<?php echo $sort_query;?>");
                    </script>
                    <?php
                }
                //manga status
                if(isset($_GET['statusq'])){
                    $status_query = $_GET['statusq'];
                    $status_query_val = $_GET['statusq'];
                } else{
                    $status_query = "%";
                    $status_query_val = 'all';
                }
                if($status_query == 'all'){
                    $status_query = "%";
                } else{
                    ?>
                    <script>
                        $('#status-search').val("<?php echo $status_query_val;?>");
                    </script>
                    <?php
                }
                //manga type
                if(isset($_GET['typeq'])){
                    $type_query = $_GET['typeq'];
                    $type_query_val = $_GET['typeq'];
                } else{
                    $type_query = "%";
                    $type_query_val = 'all';
                }
                if($type_query == 'all'){
                    $type_query = "%";
                } else{
                    ?>
                    <script>
                        $('#type-search').val("<?php echo $type_query_val;?>");
                    </script>
                    <?php
                }
                //manga genre
                if(isset($_GET['genreq'])){
                    $genre_query = $_GET['genreq'];
                    $genre_query_val = $_GET['genreq'];
                } else{
                    $genre_query = "%";
                    $genre_query_val = 'all';
                }
                if($genre_query == 'all'){
                    $genre_query = "%";
                } else{
                    ?>
                    <script>
                        $('#genre-search').val("<?php echo $genre_query_val;?>");
                    </script>
                    <?php
                }
                include 'db-conn.php';
                //`mag_id`, `mag_title`, `mag_alt_title`, `mag_author`, `mag_genre`, `mag_type`, `mag_release`, `mag_status`, `mag_desc`, `mag_cover`, `mag_views`
                if($sort_query == 'asc'){
                    $final_query = 'SELECT * FROM `magazine-details` WHERE (`mag_title` LIKE :titlekey OR `mag_alt_title` LIKE :titlekey) AND `mag_author` LIKE :authorkey AND `mag_release` LIKE :yearkey AND `mag_status` LIKE :statuskey AND `mag_type` LIKE :typekey AND `mag_genre` LIKE :genrekey ORDER BY `mag_title` ASC LIMIT 100';
                } elseif($sort_query == 'desc'){
                    $final_query = 'SELECT * FROM `magazine-details` WHERE (`mag_title` LIKE :titlekey OR `mag_alt_title` LIKE :titlekey) AND `mag_author` LIKE :authorkey AND `mag_release` LIKE :yearkey AND `mag_status` LIKE :statuskey AND `mag_type` LIKE :typekey AND `mag_genre` LIKE :genrekey ORDER BY `mag_title` DESC LIMIT 100';
                } elseif($sort_query == 'new'){
                    $final_query = 'SELECT * FROM `magazine-details` WHERE (`mag_title` LIKE :titlekey OR `mag_alt_title` LIKE :titlekey) AND `mag_author` LIKE :authorkey AND `mag_release` LIKE :yearkey AND `mag_status` LIKE :statuskey AND `mag_type` LIKE :typekey AND `mag_genre` LIKE :genrekey ORDER BY `mag_release` DESC LIMIT 100';
                } elseif($sort_query == 'old'){
                    $final_query = 'SELECT * FROM `magazine-details` WHERE (`mag_title` LIKE :titlekey OR `mag_alt_title` LIKE :titlekey) AND `mag_author` LIKE :authorkey AND `mag_release` LIKE :yearkey AND `mag_status` LIKE :statuskey AND `mag_type` LIKE :typekey AND `mag_genre` LIKE :genrekey ORDER BY `mag_release` ASC LIMIT 100';
                } elseif($sort_query == 'most'){
                    $final_query = 'SELECT * FROM `magazine-details` WHERE (`mag_title` LIKE :titlekey OR `mag_alt_title` LIKE :titlekey) AND `mag_author` LIKE :authorkey AND `mag_release` LIKE :yearkey AND `mag_status` LIKE :statuskey AND `mag_type` LIKE :typekey AND `mag_genre` LIKE :genrekey ORDER BY `mag_views` DESC LIMIT 100';
                } elseif($sort_query == 'least'){
                    $final_query = 'SELECT * FROM `magazine-details` WHERE (`mag_title` LIKE :titlekey OR `mag_alt_title` LIKE :titlekey) AND `mag_author` LIKE :authorkey AND `mag_release` LIKE :yearkey AND `mag_status` LIKE :statuskey AND `mag_type` LIKE :typekey AND `mag_genre` LIKE :genrekey ORDER BY `mag_views` ASC LIMIT 100';
                } else{
                    $final_query = 'SELECT * FROM `magazine-details` WHERE (`mag_title` LIKE :titlekey OR `mag_alt_title` LIKE :titlekey) AND `mag_author` LIKE :authorkey AND `mag_release` LIKE :yearkey AND `mag_status` LIKE :statuskey AND `mag_type` LIKE :typekey AND `mag_genre` LIKE :genrekey ORDER BY `mag_title` ASC LIMIT 100';
                }
                
                $final_statement=$dbh->prepare($final_query);
                $final_statement->bindValue(':titlekey','%'.$name_query.'%');
                $final_statement->bindValue(':authorkey','%'.$author_query.'%');
                $final_statement->bindValue(':yearkey','%'.$year_query.'%');
                $final_statement->bindValue(':statuskey','%'.$status_query.'%');
                $final_statement->bindValue(':typekey','%'.$type_query.'%');
                $final_statement->bindValue(':genrekey','%'.$genre_query.'%');
                $final_statement->execute();
                //$final_statement->debugDumpParams();
                $result = $final_statement->fetchAll();
                if($final_statement->rowCount() > 0){
                    foreach($result as $row){
                        $genre_arr = explode(',',$row['mag_genre']);
                        $clean_genre_arr = array_filter($genre_arr);
                        $img_arr = explode('.',$row['mag_cover']);
                        ?>
                        <div class="col">
                            <div class="card h-100">
                                <a href="magazine-details.php?mag-id=<?php echo $row['mag_id'];?>">
                                    <img src="https://i.imgur.com/<?php echo $img_arr[0]."b.".$img_arr[1];?>" class="card-img-top" alt="<?php echo $row['mag_title'];?>">
                                </a>
                            <div class="card-body">
                                <h5 class="card-title"><?php echo $row['mag_title']." (".$row['mag_release'].")";?></h5>
                                <span class="badge bg-success"><?php echo $row['mag_status']?></span>
                                <p class="card-text">
                                    <?php
                                        foreach($clean_genre_arr as $genrename){
                                            echo "<a class='btn-link' href='search-manga.php?searchq=&authorq=&yearq=&sortq=asc&statusq=all&typeq=all&genreq=".$genrename."'>$genrename</a> ";
                                        }
                                    ?>
                                    <br><b>Author/s: </b><?php echo $row['mag_author']?></p>
                                <h6 class="badge rounded-pill bg-warning text-dark"><b><i><?php echo $row['mag_type']?></i></b></h6>
                            </div>
                            </div>
                        </div>
                        <?php
                    }
                } else{
                    echo "<div class='text-center mx-auto'>";
                    echo "<img src='img/detective-404.png' class='img-fluid'><br>";
                    echo "<a href='search-manga.php' class='btn btn-outline-danger mt-3'>Reset Filter</a>";
                    echo "</div>";
                }
                $dbh = null;
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

        function filterOn(){
            var searchVal = $('#name-search').val();
            var authorVal = $('#author-search').val();
            var yearVal = $('#year-search').val();
            var sortVal = $('#sort-search').val();
            var statusVal = $('#status-search').val();
            var typeVal = $('#type-search').val();
            var genreVal = $('#genre-search').val();
            $('.pageCover').fadeIn(300);
            $(".search-result").load("load-item.php", {
                searchVal: searchVal,
                authorVal: authorVal,
                yearVal: yearVal,
                sortVal: sortVal,
                statusVal: statusVal,
                typeVal: typeVal,
                genreVal: genreVal
            }, function(){
                var nextURL = ('https://ruby-scans-test.azurewebsites.net/search-manga.php?searchq='+searchVal+'&authorq='+authorVal+'&yearq='+yearVal+'&sortq='+sortVal+'&statusq='+statusVal+'&typeq='+typeVal+'&genreq='+genreVal);
                //var nextURL = ('http://localhost/test-cloud/search-manga.php?searchq='+searchVal+'&authorq='+authorVal+'&yearq='+yearVal+'&sortq='+sortVal+'&statusq='+statusVal+'&typeq='+typeVal+'&genreq='+genreVal);
                var nextTitle = $(document).find("title").text();
                var nextState = { additionalInformation: 're4nightwing' };
                window.history.pushState(nextState, nextTitle, nextURL);
                $('.pageCover').fadeOut(500);
            });
            
        }
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
