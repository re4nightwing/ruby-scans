<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Welcome | Ruby Cons</title>
    <link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.10.0/css/all.css" integrity="sha384-AYmEC3Yw5cVb3ZcuHtOA93w35dYTsvhLPVnYs9eStHfGJvOvKxVfELGroGkvsg+p" crossorigin="anonymous"/>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="stylesheet" href="https://unpkg.com/swiper@7/swiper-bundle.min.css"/>
    <link rel="stylesheet" href="css/main.css">
    <style>
    .showcase-swiper {
        width: 100%;
        height: 60vh;
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
    .slides-per-view {
      width: 100%;
      height: 100%;
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
    }
    .popular-sec{
        background-color: #2c031057;
    }
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
    <div class="container-fluid px-0">
        <div class="swiper showcase-swiper">
            <div class="swiper-wrapper">
                <div class="swiper-slide showcase-slide">
                    <img src="https://via.placeholder.com/2100x700.png?text=Welcome" class="img-fluid" alt="">
                </div>
                <div class="swiper-slide showcase-slide">
                    <img src="https://via.placeholder.com/2100x700.png" class="img-fluid" alt="">
                </div>
                <div class="swiper-slide showcase-slide">
                    <img src="https://via.placeholder.com/2100x700.png" class="img-fluid" alt="">
                </div>
                <div class="swiper-slide showcase-slide">
                    <img src="https://via.placeholder.com/2100x700.png" class="img-fluid" alt="">
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
                    <div class="swiper-slide slides-per-slide">
                        <img src="https://via.placeholder.com/300.png" alt="">
                    </div>
                    <div class="swiper-slide slides-per-slide">
                        <img src="https://via.placeholder.com/300.png" alt="">
                    </div>
                    <div class="swiper-slide slides-per-slide">
                        <img src="https://via.placeholder.com/300.png" alt="">
                    </div>
                    <div class="swiper-slide slides-per-slide">
                        <img src="https://via.placeholder.com/300.png" alt="">
                    </div>
                    <div class="swiper-slide slides-per-slide">
                        <img src="https://via.placeholder.com/300.png" alt="">
                    </div>
                    <div class="swiper-slide slides-per-slide">
                        <img src="https://via.placeholder.com/300.png" alt="">
                    </div>
                    <div class="swiper-slide slides-per-slide">
                        <img src="https://via.placeholder.com/300.png" alt="">
                    </div>
                    <div class="swiper-slide slides-per-slide">
                        <img src="https://via.placeholder.com/300.png" alt="">
                    </div>
                    <div class="swiper-slide slides-per-slide">
                        <img src="https://via.placeholder.com/300.png" alt="">
                    </div>
                    <div class="swiper-slide slides-per-slide">
                        <img src="https://via.placeholder.com/300.png" alt="">
                    </div>
                </div>
                <!-- Add Pagination -->
                <div class="swiper-pagination swiper-pagination-custom2"></div>
            </div>
        </div>
    </section>
    <section class="content-sec">
        <div class="container-xl" id="content-container">
            <div class="row justify-content-center text-center">
            
            <?php
            //`mag_id`, `mag_title`, `mag_alt_title`, `mag_author`, `mag_genre`, `mag_type`, `mag_release`, `mag_status`, `mag_desc`, `mag_cover`
                include 'db-conn.php';
                $custom_query = "SELECT `magazine_id`, `upload_date`,`chapter_number` FROM `magazine-chapters` ORDER BY `upload_date` DESC LIMIT 20";
                foreach ($dbh->query($custom_query) as $data) {
                    $searchID = $data['magazine_id'];
                    $chapNumber = $data['chapter_number'];
                    $secondary_query = "";
                    $secondary_query = $dbh->prepare("SELECT `mag_id`, `mag_title`,`mag_release`,`mag_cover` FROM `magazine-details` WHERE `mag_id`= ? LIMIT 1"); 
                    $secondary_query->execute([$searchID]); 
                    $row = $secondary_query->fetch();
                    ?>
                    <div class="col-lg-3 col-md-4 col-sm-6 col-12 my-2">
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
                }
                $dbh = null;
            ?>
            </div>
        </div>
    </section>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
    <script src="https://unpkg.com/swiper@7/swiper-bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/vanilla-lazyload@17.5.0/dist/lazyload.min.js"></script>
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
            slidesPerView: 4,
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
                // when window width is <= 499px
                499: {
                    slidesPerView: 1
                },
                // when window width is <= 999px
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
    
</body>
</html>

