<?php
    if(isset($_GET['mag-id'])){
        $requestId = $_GET['mag-id'];
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
    <title>Magazine Details | Ruby Cons</title>
    <link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.10.0/css/all.css" integrity="sha384-AYmEC3Yw5cVb3ZcuHtOA93w35dYTsvhLPVnYs9eStHfGJvOvKxVfELGroGkvsg+p" crossorigin="anonymous"/>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="stylesheet" href="https://unpkg.com/swiper@7/swiper-bundle.min.css"/>
    <link rel="stylesheet" href="css/main.css">
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
            </div>
            <table class="table table-sm table-dark table-hover">
                <thead>
                    <tr>
                        <th scope="col">Chapter</th>
                        <th scope="col"></th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                        $stmt = $dbh->prepare("SELECT `chapter_number`, `magazine_id`,`update_date` from `magazine-chapters` WHERE `magazine_id` = ?");
                        $stmt->execute([$requestId]);
                        $data = $stmt->fetchAll();
                        foreach ($data as $row) {
                    ?>
                    <tr class="chapter" onclick="gotoPage(<?php echo $row['chapter_number'];?>)">
                        <th scope="row"><?php echo $row['chapter_number'];?></th>
                        <td><?php echo date_format(date_create($row['update_date']),"Y/m/d");?></td>
                    </tr>
                    <?php
                        }
                        $dbh=null;
                    ?>
                </tbody>
            </table>
        </div>
    </section>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
    <script src="https://unpkg.com/swiper@7/swiper-bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/vanilla-lazyload@17.5.0/dist/lazyload.min.js"></script>
    <script type="module">
        var lazyLoadInstance = new LazyLoad({threshold: 0,});
        lazyLoadInstance.update();
    </script>
    <script>
        function gotoPage(chapter){
            window.location.href = "view-chapter.php?id=<?php echo $requestId;?>&chapter="+chapter;
        }
        $(document).ready(function() {
            document.title = '<?php echo $pageTitle." | Ruby Cons";?>';
        });
    </script>
    
</body>
</html>

