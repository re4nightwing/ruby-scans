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
    <title>Users | SlayerScans</title>
</head>
<body>
    <div class="bg-img"></div>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container-fluid">
            <a class="navbar-brand" href="admin.php">SlayerScans</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <li class="nav-item">
                        <a class="nav-link" aria-current="page" href="admin.php">Dashboard</a>
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
            <h1 class="text-light">User Details</h1>
            <table class="table table table-light table-striped">
                <thead>
                    <tr>
                        <th scope="col">User email</th>
                        <th scope="col">Username</th>
                        <th scope="col">Last Sign In</th>
                        <th scope="col">WishList</th>
                        <th scope="col">BoughtList</th>
                        <th scope="col">Ruby Count</th>
                        <th scope="col">Coupon Code</th>
                        <th scope="col">Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
            //`user_mail`, `user_name`, `user_pswd`, `signed_date`, `access_token`, `user_list`, `user_bought`, `ruby_count`, `coupon_code`

                        include 'db-conn.php';
                        $custom_query = 'SELECT * from `user_details`';
                        foreach ($dbh->query($custom_query) as $row) {
                    ?>
                    <tr>
                        <th scope="row"><?php echo $row['user_mail'];?></th>
                        <td><?php echo $row['user_name'];?></td>
                        <td><?php echo $row['signed_date'];?></td>
                        <td><?php echo $row['user_list'];?></td>
                        <td><?php echo $row['user_bought'];?></td>
                        <td><?php echo $row['ruby_count'];?></td>
                        <td><?php echo $row['coupon_code'];?></td>
                        <td>
                            <a href="admin-edit-user.php?id=<?php echo $row['user_mail'];?>&edit=delete" class="btn btn-danger">Delete</a>
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
    <script>
        $(function(){
            $('tr td a').click(function(){
                var redir_link = $(this).attr('href');
                var txt;
                var r = confirm("You sure?");
                if (r == true) {
                    window.location.href = redir_link;
                } else {
                    return false;
                }
                return false;
            });
        });
    </script>
</body>
</html>