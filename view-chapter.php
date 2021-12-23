<?php
    session_start();
    $login_status = 0;

    if(isset($_SESSION["email"]) && isset($_SESSION['user_uid'])){
        $user_mail = $_SESSION["email"];
        $user_id = $_SESSION['user_uid'];
        $login_status = 1;
    } else{
        header('Location: user-logout.php');
    }

    if(isset($_GET['id']) && isset($_GET['chapter'])){
        $requestId = $_GET['id'];
        $requestChap = $_GET['chapter'];
        include 'db-conn.php';
        $sql = "UPDATE `magazine-details` SET `mag_views` = `mag_views`+1 WHERE `mag_id`=?";
        $stmt= $dbh->prepare($sql);
        try{
            $stmt->execute([$requestId]);
        } catch (Exception $e){
            $dbh->rollback();
            throw $e;
        }

        $custom_query = 'SELECT `mag_title` from `magazine-details` WHERE `mag_id`= ?';
        $stmt = $dbh->prepare($custom_query);
        $stmt->execute([$requestId]);
        $row = $stmt->fetch();
        if ($stmt->rowCount() > 0) {
            $magazine_title = $row['mag_title'];
            $pageTitle = "Chapter $requestChap | $magazine_title";
            $url_id = $magazine_title . "<" . $requestChap;
        } else{
            header('Location: user-logout.php');
        }

        $custom_query = 'SELECT `chapter_number` FROM `magazine-chapters` WHERE `magazine_id`=? ORDER BY `chapter_number` DESC';
        $stmt = $dbh->prepare($custom_query);
        $stmt->execute([$requestId]);
        if ($stmt->rowCount() > 0) {
            $data = $stmt->fetchAll();
        } else{
            header('Location: user-logout.php');
        }

        $stmt = $dbh->prepare("SELECT `user_bought`,`user_list` FROM `user_details` WHERE `user_mail`=? LIMIT 1"); 
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
        } else{
            ?>
            <script>
                alert("Error occured Please login again");
                window.location.href = "user-logout.php";
            </script>
            <?php
        }
        $has_bought = 0;
        foreach($user_list as $id){
            if($id == $requestId){
                $has_bought = 1;
                break;
            }
        }
        if(!($has_bought)){
            ?>
            <script>
                alert("Invalid Link");
                window.location.href = "magazine-details.php?mag-id=<?php echo $requestId;?>";
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
    <title>Chapter | Ruby Scans</title>
    <link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.10.0/css/all.css" integrity="sha384-AYmEC3Yw5cVb3ZcuHtOA93w35dYTsvhLPVnYs9eStHfGJvOvKxVfELGroGkvsg+p" crossorigin="anonymous"/>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="stylesheet" href="https://unpkg.com/swiper@7/swiper-bundle.min.css"/>
    <link rel="stylesheet" href="css/main.css">
    <link rel="icon" type="image/png" href="img/favicon.png">
    <style>
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
        <div class="container-xl text-center pt-3 pb-0" id="content-container">
            <div class="row justify-content-center bg-light py-3 mb-3">
                <div class="col">
                    <a href="magazine-details.php?mag-id=<?php echo $requestId;?>" class="btn btn-outline-secondary">📔 <?php echo $magazine_title;?></a>
                </div>
                <div class="col">
                    <button type="button" class="btn btn-outline-primary" data-bs-toggle="modal" data-bs-target="#chapterModal">📚 View Chapters</button>
                </div>
            </div>
            <?php
            //`chapter_number`, `magazine_id`, `img_links_1`, `img_links_2`, `upload_date`, `update_date`

                
                $custom_query = 'SELECT * from `magazine-chapters` WHERE `chapter_number`= ? AND `magazine_id`= ?';
                $stmt = $dbh->prepare($custom_query);
                $stmt->execute([$requestChap,$requestId]);
                $row = $stmt->fetch();
                $imageLinks1 = $row['img_links_1'];
                $imageLinks2 = $row['img_links_2'];
                $imageLinks1List = explode(',',$imageLinks1);
                $imageLinks2List = explode(',',$imageLinks2);
                $c=0;
                foreach ($imageLinks1List as $link){
                    if($c>0){
                        $thumbnail = explode('.',$link);
                        echo "<div class='col-12'>";
                        echo "<img class='img-fluid lazy my-1' src='https://via.placeholder.com/225×350.png'  data-src='https://i.imgur.com/$thumbnail[0]h.$thumbnail[1]'>";
                        echo "</div>";
                    } else{
                        $thumbnail = explode('.',$link);
                        echo "<div class='col-12'>";
                        echo "<img class='img-fluid my-1' src='https://i.imgur.com/$thumbnail[0].$thumbnail[1]'>";
                        echo "</div>";
                    }
                    $c++;
                }
                foreach ($imageLinks2List as $link){
                    if($link != null){
                        $thumbnail = explode('.',$link);
                        echo "<div class='col-12'>";
                        echo "<img class='img-fluid lazy my-1' src='https://via.placeholder.com/225×350.png'  data-src='https://i.imgur.com/$thumbnail[0].$thumbnail[1]'>";
                        echo "</div>";
                    }
                }
            ?>
            <div class="row justify-content-center bg-light py-3 mt-3">
                <div class="col">
                    <p class="text-muted">Not loading images? Let us know!</p>
                    <form action="magazine-details.php?mag-id=<?php echo $requestId;?>" method="POST">
                        <input type="hidden" name="report_id" value="<?php echo $requestId;?>">
                        <input type="hidden" name="report_chap" value="<?php echo $requestChap;?>">
                        <input type="hidden" name="report_name" value="<?php echo $magazine_title;?>">
                        <button type="submit" id="<?php echo $requestId."-".$requestChap;?>" name="report-magazine" class="btn btn-outline-danger">🚨 Report this Chapter 🚨</button>
                    </form>
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
    <div class="modal fade" id="chapterModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="staticBackdropLabel"><?php echo $magazine_title." Chapters";?></h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="row justify-content-center text-center">
                    <?php
                        foreach($data as $chapterNo){
                            if($requestChap == $chapterNo['chapter_number']){
                                echo "<div class='col-lg-3 col-md-4 col-sm-6 col-6 my-2'>";
                                echo "<a href='view-chapter.php?id=".$requestId."&chapter=".$chapterNo['chapter_number']."' class='btn btn-primary'>".$chapterNo['chapter_number']."</a>";
                                echo "</div>";
                            } else{
                                echo "<div class='col-lg-3 col-md-4 col-sm-6 col-6 my-2'>";
                                echo "<a href='view-chapter.php?id=".$requestId."&chapter=".$chapterNo['chapter_number']."' class='btn btn-outline-primary'>".$chapterNo['chapter_number']."</a>";
                                echo "</div>";
                            }
                        }
                    ?>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
            </div>
        </div>
    </div>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
    <script src="https://unpkg.com/swiper@7/swiper-bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/vanilla-lazyload@17.5.0/dist/lazyload.min.js"></script>
    <script type="module">
        var lazyLoadInstance = new LazyLoad({thresholds: "200% 0px",});
        lazyLoadInstance.update();
    </script>
    <?php
        if($login_status){
            ?>
            <script>
                function logoutFunc(){
                    window.location.href = "user-logout.php";
                }
                $('#user-profile').removeClass('disabled');
                $(document).ready(function() {
                    document.title = '<?php echo $pageTitle." | Ruby Scans";?>';
                });
            </script>
            <?php
        }
    ?>
    <script>
        /**
        *  RECOMMENDED CONFIGURATION VARIABLES: EDIT AND UNCOMMENT THE SECTION BELOW TO INSERT DYNAMIC VALUES FROM YOUR PLATFORM OR CMS.
        *  LEARN WHY DEFINING THESE VARIABLES IS IMPORTANT: https://disqus.com/admin/universalcode/#configuration-variables    */
        
        var disqus_config = function () {
        this.page.url = window.location.href;  // Replace PAGE_URL with your page's canonical URL variable
        this.page.identifier = '<?php echo $url_id;?>'; // Replace PAGE_IDENTIFIER with your page's unique identifier variable
        };
    
        (function() { // DON'T EDIT BELOW THIS LINE
        var d = document, s = d.createElement('script');
        s.src = 'https://ruby-scans.disqus.com/embed.js';
        s.setAttribute('data-timestamp', +new Date());
        (d.head || d.body).appendChild(s);
        })();
    </script>
    <noscript>Please enable JavaScript to view the <a href="https://disqus.com/?ref_noscript">comments powered by Disqus.</a></noscript>
</body>
</html>