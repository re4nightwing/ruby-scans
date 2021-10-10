<?php
    if(isset($_GET['id']) && isset($_GET['chapter'])){
        $requestId = $_GET['id'];
        $requestChap = $_GET['chapter'];
    } else{
        header('Location: index.php');
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Magazine Chapter | Ruby Cons</title>
    <link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.10.0/css/all.css" integrity="sha384-AYmEC3Yw5cVb3ZcuHtOA93w35dYTsvhLPVnYs9eStHfGJvOvKxVfELGroGkvsg+p" crossorigin="anonymous"/>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="stylesheet" href="https://unpkg.com/swiper@7/swiper-bundle.min.css"/>
    <link rel="stylesheet" href="css/main.css">
    <style>
    </style>
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-black">
        <div class="container-fluid">
            <a class="navbar-brand" href="#"><img src="img/ruby-cons_long-icon.png" height="40px" alt=""></a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <li class="nav-item">
                        <a class="nav-link active" aria-current="page" href="#">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">Categories</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">Get Rubies</a>
                    </li>
                    <li class="nav-item dropdown disabled">
                        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="fas fa-user"></i> Profile
                        </a>
                        <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                            <li><a class="dropdown-item" href="#">Profile</a></li>
                            <li><a class="dropdown-item" href="#">Read List</a></li>
                        </ul>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            Contact Us
                        </a>
                        <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                            <li><a class="dropdown-item" href="#">About Us</a></li>
                            <li><a class="dropdown-item" href="#">Join Discord</a></li>
                            <li><hr class="dropdown-divider"></li>
                            <li><a class="dropdown-item" href="#">Publish Your Work</a></li>
                        </ul>
                    </li>
                    
                </ul>
                <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
                    <li class="nav-item me-1">
                        <form class="d-flex">
                            <input class="form-control me-2" type="search" placeholder="Type Title, author or genre" aria-label="Search" width="auto">
                            <button class="btn btn-outline-success" type="submit">Search</button></br>
                        </form>
                    </li>
                    <li class="nav-item">
                        <button class="btn btn-primary" type="submit">Sign In</button></br>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
    <section class="content-sec">
        <div class="container-xl text-center" id="content-container">
            <?php
            //`chapter_number`, `magazine_id`, `img_links_1`, `img_links_2`, `upload_date`, `update_date`

                include 'db-conn.php';
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
                        echo "<img class='img-fluid my-1' src='https://i.imgur.com/$thumbnail[0]h.$thumbnail[1]'>";
                        echo "</div>";
                    }
                    $c++;
                }
                foreach ($imageLinks2List as $link){
                    if($link != null){
                        $thumbnail = explode('.',$link);
                        echo "<div class='col-12'>";
                        echo "<img class='img-fluid lazy my-1' src='https://via.placeholder.com/225×350.png'  data-src='https://i.imgur.com/$thumbnail[0]h.$thumbnail[1]'>";
                        echo "</div>";
                    }
                }
            ?>
        </div>
    </section>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
    <script src="https://unpkg.com/swiper@7/swiper-bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/vanilla-lazyload@17.5.0/dist/lazyload.min.js"></script>
    <script type="module">
        var lazyLoadInstance = new LazyLoad({thresholds: "200% 0px",});
        lazyLoadInstance.update();
    </script>
    <script>
        function gotoPage(chapter){
            window.location.href = "view-chapter.php?id=<?php echo $requestId;?>&chapter="+chapter;
        }
    </script>
    
</body>
</html>

