<?php
    if(isset($_COOKIE['lgUsr'])){  
        if($_COOKIE['lgUsr']=="" || $_COOKIE['lgUsr'] != 'admin'){
            header('Location: admin-logout.php');
        }
    } else{
        header('Location: admin-logout.php');
    }
    
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="stylesheet" href="css/admin.css">
    <title>Dashboard | SlayerScans</title>
</head>
<body>
    <div class="bg-img"></div>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container-fluid">
            <a class="navbar-brand" href="#">SlayerScans</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <li class="nav-item">
                        <a class="nav-link active" aria-current="page" href="#">Dashboard</a>
                    </li>
                </ul>
                <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
                    <li class="nav-item">
                        <a class="nav-link" href="index.php" target="_blank">Site Link</a>
                    </li>
                    <li class="nav-item">
                        <a class="btn btn-warning" href="admin-logout.php">Log Out</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
    <div class="content-setion">
        <div class="container text-center py-5">
            <h1 class="text-light">Admin Dashboard</h1>
            <div class="row justify-content-center mt-5">
                <div class="col-lg-4 col-md-6 col-11 px-3 my-2">
                    <div class="card w-100 h-100">
                        <div class="card-body">
                            <h5 class="card-title">Magazine</h5>
                            <h6 class="card-subtitle mb-2 text-muted">Details of the Magazine</h6>
                            <p class="card-text">Use the link below to add a new magazin, update current magazine details or to delete a magazine.</p>
                            <a href="admin-show-magazines.php" class="card-link btn btn-success">Edit Magazines</a>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6 col-11 px-3 my-2">
                    <div class="card w-100 h-100">
                        <div class="card-body">
                            <h5 class="card-title">Magazine Chapters</h5>
                            <h6 class="card-subtitle mb-2 text-muted">Chapter Details of the Magazine</h6>
                            <p class="card-text">Use the link below to add a new magazin chapter, update current magazine chapters or to delete a magazine chapter.</p>
                            <a href="admin-show-chapters.php" class="card-link btn btn-success">Edit Chapters</a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row justify-content-center mt-5">
                <div class="col-lg-4 col-md-6 col-11 px-3 my-2">
                    <div class="card w-100 h-100">
                        <div class="card-body">
                            <h5 class="card-title">User Details</h5>
                            <h6 class="card-subtitle mb-2 text-muted">Details of the signed up users</h6>
                            <p class="card-text">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Aperiam, quae?</p>
                            <a href="admin-show-magazines.php" class="card-link btn btn-success">More Details</a>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6 col-11 px-3 my-2">
                    <div class="card w-100 h-100">
                        <div class="card-body">
                            <h5 class="card-title">Messages/Requests</h5>
                            <h6 class="card-subtitle mb-2 text-muted">Messages/Requests from users</h6>
                            <p class="card-text">Lorem ipsum dolor sit amet consectetur, adipisicing elit. Distinctio, aspernatur!</p>
                            <a href="admin-show-chapters.php" class="card-link btn btn-success">More Details</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <footer class="bg-light text-dark py-2" style="border-radius: 0 50px 0 0;">
        <h6 class="m-0 ps-3">Designed & Developed by <a class="btn btn-info" href="https://re4nightwing.github.io/" target="_blank" style="border-radius: 20px;">re4nightwing</a></h6>
    </footer>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
</body>
</html>