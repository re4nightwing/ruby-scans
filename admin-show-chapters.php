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
    <title>Magazines Chapters | SlayerScans</title>
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
            <h1 class="text-light">Magazine Details</h1>
            <form action="admin-show-chapters.php" method="GET">
                <div class="mb-3">
                    <label for="searchMag" class="form-label text-light">Magazine Type:</label>
                    <select class="form-select" id="searchMag" name="searchMag">
                        <option selected value="0">Select Type</option>
                        <?php
                        include 'db-conn.php';
                        $custom_query = 'SELECT `mag_id`,`mag_title` from `magazine-details`';
                        foreach ($dbh->query($custom_query) as $row) {
                            $temp = $row['mag_id'];
                            $tempTitle = $row['mag_title'];
                            echo "<option selected value='$temp'>$tempTitle</option>";
                        }
                        ?>
                    </select>
                </div>
                <input type="submit" class="btn btn-success" value="Search">
            </form>
            <a href="admin-edit-chapter.php" class="btn btn-primary btn-lg my-3">Add New</a>
            <?php
            if (isset($_GET['searchMag'])) {
                //`chapter_number`, `magazine_id`, `img_links_1`, `img_links_2`, `upload_date`, `update_date`
                $requestId = $_GET['searchMag'];

                $stmt = $dbh->prepare("SELECT * from `magazine-chapters` WHERE `magazine_id` = ?");
                $stmt->execute([$requestId]);
                $data = $stmt->fetchAll();
            ?>
                <table class="table table table-light table-striped">
                    <thead>
                        <tr>
                            <th scope="col">Title ID</th>
                            <th scope="col">Chapter</th>
                            <th scope="col">Upload Date</th>
                            <th scope="col">Updated on</th>
                            <th scope="col">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        foreach ($data as $row) {
                        ?>
                            <tr>
                                <th scope="row"><?php echo $row['magazine_id']; ?></th>
                                <td><?php echo $row['chapter_number']; ?></td>
                                <td><?php echo $row['upload_date']; ?></td>
                                <td><?php echo $row['update_date']; ?></td>
                                <td>
                                    <a href="admin-edit-chapter.php?id=<?php echo $row['magazine_id']; ?>&chap=<?php echo $row['chapter_number']; ?>&edit=edit" class="btn btn-success">Edit</a>
                                    <a href="admin-edit-chapter.php?id=<?php echo $row['magazine_id']; ?>&chap=<?php echo $row['chapter_number']; ?>&edit=delete" class="btn btn-danger">Delete</a>
                                </td>
                            </tr>
                    <?php
                        }
                    }
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