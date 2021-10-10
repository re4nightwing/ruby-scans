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
    <title>Magazines | SlayerScans</title>
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
                        <a class="nav-link" aria-current="page" href="#">Dashboard</a>
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
            <h1 class="text-light">Magazine Details</h1>
            <a href="admin-edit-magazine.php" class="btn btn-primary my-3">Add New</a>
            <table class="table table table-light table-striped">
                <thead>
                    <tr>
                        <th scope="col">ID</th>
                        <th scope="col">Title</th>
                        <th scope="col">Alt Title</th>
                        <th scope="col">Author</th>
                        <th scope="col">Genre</th>
                        <th scope="col">Type</th>
                        <th scope="col">Release year</th>
                        <th scope="col">Status</th>
                        <th scope="col">Cover</th>
                        <th scope="col">Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
            //`mag_id`, `mag_title`, `mag_alt_title`, `mag_author`, `mag_genre`, `mag_type`, `mag_release`, `mag_status`, `mag_desc`, `mag_cover`

                        include 'db-conn.php';
                        $custom_query = 'SELECT * from `magazine-details`';
                        foreach ($dbh->query($custom_query) as $row) {
                    ?>
                    <tr>
                        <th scope="row"><?php echo $row['mag_id'];?></th>
                        <td><?php echo $row['mag_title'];?></td>
                        <td><?php echo $row['mag_alt_title'];?></td>
                        <td><?php echo $row['mag_author'];?></td>
                        <td><?php echo $row['mag_genre'];?></td>
                        <td><?php echo $row['mag_type'];?></td>
                        <td><?php echo $row['mag_release'];?></td>
                        <td><?php echo $row['mag_status'];?></td>
                        <td><?php echo $row['mag_cover'];?></td>
                        <td>
                            <a href="admin-edit-magazine.php?id=<?php echo $row['mag_id'];?>&edit=edit" class="btn btn-success">Edit</a>
                            <a href="admin-edit-magazine.php?id=<?php echo $row['mag_id'];?>&edit=delete" class="btn btn-danger">Delete</a>
                        </td>
                    </tr>
                    <?php 
                        }
                        $dbh = null;
                    ?>
                </tbody>
            </table>
        </div>
    </div>
    <footer class="bg-light text-dark py-2" style="border-radius: 0 50px 0 0;">
        <h6 class="m-0 ps-3">Designed & Developed by <a class="btn btn-info" href="https://re4nightwing.github.io/" target="_blank" style="border-radius: 20px;">re4nightwing</a></h6>
    </footer>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
</body>
</html>