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
    <title>Edit Magazines | SlayerScans</title>
</head>
<body>
    <?php
        if(isset($_POST['submit-form'])){
            include 'db-conn.php';

            $id = $_POST['magazineID'];
            $title = $_POST['magazineTitle'];
            $altTitle = $_POST['magazineAltTitle'];
            $author = $_POST['magazineAuthor'];
            $genre = $_POST['magazineGenre'];
            $type = $_POST['magazineType'];
            $release = $_POST['magazineYear'];
            $status = $_POST['magazineStatus'];
            $desc = $_POST['magazineDesc'];
            $cover = $_POST['magazineCover'];

            $sql = "INSERT INTO `magazine-details` (`mag_id`, `mag_title`, `mag_alt_title`, `mag_author`, `mag_genre`, `mag_type`, `mag_release`, `mag_status`, `mag_desc`, `mag_cover`) VALUES (?,?,?,?,?,?,?,?,?,?)";
            $stmt= $dbh->prepare($sql);
            try{
                $stmt->execute([$id,$title,$altTitle,$author,$genre,$type,$release,$status,$desc,$cover]);
                ?>
                    <script>
                        alert("New Record Added Successfully!");
                        window.location.href = "admin-show-magazines.php";
                    </script>
                <?php
            } catch (Exception $e){
                ?>
                    <script>
                        alert("Error occured while executing the query.");
                        window.location.href = "admin-show-magazines.php";
                    </script>
                <?php
            }
            $dbh = null;
        } else if(isset($_POST['update-form'])){
            include 'db-conn.php';

            $id = $_POST['magazineID'];
            $title = $_POST['magazineTitle'];
            $altTitle = $_POST['magazineAltTitle'];
            $author = $_POST['magazineAuthor'];
            $genre = $_POST['magazineGenre'];
            $type = $_POST['magazineType'];
            $release = $_POST['magazineYear'];
            $status = $_POST['magazineStatus'];
            $desc = $_POST['magazineDesc'];
            $cover = $_POST['magazineCover'];

            $sql = "UPDATE `magazine-details` SET `mag_title` = ?, `mag_alt_title` = ?, `mag_author` = ?, `mag_genre` = ?, `mag_type` = ?, `mag_release` = ?, `mag_status` = ?, `mag_desc` = ?, `mag_cover` = ? WHERE `mag_id`=?";
            $stmt= $dbh->prepare($sql);
            try{
                $stmt->execute([$title,$altTitle,$author,$genre,$type,$release,$status,$desc,$cover,$id]);
                ?>
                    <script>
                        alert("Record Updated Successfully!");
                        window.location.href = "admin-show-magazines.php";
                    </script>
                <?php
            } catch (Exception $e){
                ?>
                    <script>
                        alert("Error occured while executing the query.");
                        window.location.href = "admin-show-magazines.php";
                    </script>
                <?php
            }
            $dbh = null;
        }
    ?>
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
            <h1 class="text-light">Add/Edit Magazine</h1>
            <!-- //`mag_id`, `mag_title`, `mag_alt_title`, `mag_author`, `mag_genre`, `mag_type`, `mag_release`, `mag_status`, `mag_desc`, `mag_cover` -->
            <form class="text-light text-start p-4" action="admin-edit-magazine.php" method="POST" style="background-color: #0f0f199e;">
                <div class="mb-3">
                    <label for="magazineID" class="form-label">Magazine ID:</label>
                    <input type="text" class="form-control" maxlength="6" id="magazineID" name="magazineID" placeholder="xxx111">
                </div>
                <div class="mb-3">
                    <label for="magazineTitle" class="form-label">Magazine Title:</label>
                    <input type="text" class="form-control" maxlength="150" id="magazineTitle" name="magazineTitle">
                </div>
                <div class="mb-3">
                    <label for="magazineAltTitle" class="form-label">Magazine Alternative Names:</label>
                    <input type="text" class="form-control" maxlength="150" id="magazineAltTitle" name="magazineAltTitle">
                </div>
                <div class="mb-3">
                    <label for="magazineAuthor" class="form-label">Magazine Author/s(saparate by commas):</label>
                    <input type="text" class="form-control" maxlength="100" id="magazineAuthor" name="magazineAuthor" placeholder="sussywussybaka,fishfucker69">
                </div>
                <div class="mb-3">
                    <label for="magazineGenre" class="form-label">Magazine Genre/s(saparate by commas):</label>
                    <input type="text" class="form-control" maxlength="200" id="magazineGenre" name="magazineGenre" placeholder="Action,Adult,Adventure,Comedy,Doujinshi">
                    <p>Action, Adult, Adventure, Comedy, Doujinshi, Drama, Ecchi, Fantasy, Gender Bender, Harem, Hentai, Historical, Horror, Isekai, Josei, Lolicon, Martial Arts, Mature, Mecha, Mystery, Psychological, Romance, School Life, Sci-fi, Seinen, Shotacon, Shoujo, Shoujo Ai, Shounen, Shounen Ai, Slice of Life, Smut, Sports, Supernatural, Tragedy, Yaoi, Yuri</p>
                </div>
                <div class="mb-3">
                    <label for="magazineType" class="form-label">Magazine Type:</label>
                    <select class="form-select" id="magazineType" name="magazineType">
                        <option selected value="0">Select Type</option>
                        <option value="Doujinshi">Doujinshi</option>
                        <option value="Manga">Manga</option>
                        <option value="Manhua">Manhua</option>
                        <option value="Manhwa">Manhwa</option>
                        <option value="OEL">OEL</option>
                        <option value="One-shot">One-shot</option>
                    </select>
                </div>
                <div class="mb-3">
                    <label for="magazineYear" class="form-label">Magazine Release Year:</label>
                    <input type="number" class="form-control" maxlength="4" id="magazineYear" name="magazineYear">
                </div>
                <div class="mb-3">
                    <label for="magazineStatus" class="form-label">Magazine Status:</label>
                    <select class="form-select" id="magazineStatus" name="magazineStatus">
                        <option selected value="0">Select Status</option>
                        <option value="Cancelled">Cancelled</option>
                        <option value="Complete">Complete</option>
                        <option value="Discontinued">Discontinued</option>
                        <option value="Hiatus">Hiatus</option>
                        <option value="Ongoing">Ongoing</option>
                    </select>
                </div>
                <div class="mb-3">
                    <label for="magazineDesc" class="form-label">Magazine Description:</label>
                    <textarea class="form-control" id="magazineDesc" name="magazineDesc" maxlength="500" rows="4"></textarea>
                </div>
                <div class="mb-3">
                    <label for="magazineCover" class="form-label">Magazine Cover(put only the file name form the image link): <i>Ex: https://i.imgur.com/zvz5t2x.jpg => zvz5t2x.jpg</i></label>
                    <input type="text" class="form-control" maxlength="50" id="magazineCover" name="magazineCover" placeholder="zvz5t2x.jpg">
                </div>
                <input type="submit" id="add-btn" class="btn btn-primary" name="submit-form" value="Submit" disabled>
            </form>
        </div>
    </div>
    <footer class="bg-light text-dark py-2" style="border-radius: 0 50px 0 0;">
        <h6 class="m-0 ps-3">Designed & Developed by <a class="btn btn-info" href="https://re4nightwing.github.io/" target="_blank" style="border-radius: 20px;">re4nightwing</a></h6>
    </footer>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
    <?php
        if(isset($_GET['edit'])){
            include 'db-conn.php';
            if($_GET['edit'] == 'edit'){
                $requestId = $_GET['id'];
                $stmt = $dbh->prepare("SELECT * from `magazine-details` WHERE `mag_id`= ? LIMIT 1"); 
                $stmt->execute([$requestId]); 
                $row = $stmt->fetch();
                if($row != null){
                    ?>
                    <script>
                       $('#magazineID').val("<?php echo $row['mag_id'];?>");
                       $('#magazineTitle').val("<?php echo $row['mag_title'];?>");
                       $('#magazineAltTitle').val("<?php echo $row['mag_alt_title'];?>");
                       $('#magazineAuthor').val("<?php echo $row['mag_author'];?>");
                       $('#magazineGenre').val("<?php echo $row['mag_genre'];?>");
                       $('#magazineType').val("<?php echo $row['mag_type'];?>");
                       $('#magazineYear').val("<?php echo $row['mag_release'];?>");
                       $('#magazineStatus').val("<?php echo $row['mag_status'];?>");
                       $('#magazineDesc').val(`<?php echo $row['mag_desc'];?>`);
                       $('#magazineCover').val("<?php echo $row['mag_cover'];?>");
                       $('#add-btn').removeClass('btn-primary');
                       $('#add-btn').addClass('btn-info');
                       $('#add-btn').prop('value','Update');
                       $('#add-btn').prop('name','update-form');
                       $('#magazineID').prop('readonly', true);
                    </script>
                    <?php
                } else{
                    ?>
                    <script>
                        alert("There is no magazine under that ID");
                        window.location.href = "admin-show-magazines.php";
                    </script>
                    <?php
                }
            } else if($_GET['edit'] == 'delete'){
                $requestId = $_GET['id'];
                $stmt = $dbh->prepare("DELETE FROM `magazine-details` WHERE `mag_id`= ?");
                try{
                    $stmt->execute([$requestId]);
                    ?>
                    <script>
                        alert("Record Deleted Successfully!");
                        window.location.href = "admin-show-magazines.php";
                    </script>
                    <?php
                } catch(PDOException $e){
                    ?>
                    <script>
                        alert("Failed to delete the entry.");
                        window.location.href = "admin-show-magazines.php";
                    </script>
                    <?php
                }
            } else{
                ?>
                <script>
                    alert("Invalid Path!");
                    window.location.href = "admin-show-magazines.php";
                </script>
                <?php
            }
            $dbh = null;
        } 
    ?>



    <script>
        $('form').keyup(function(){
            if($('#magazineID').val() != "" && $('#magazineTitle').val() != "" && $('#magazineAltTitle').val() != "" && $('#magazineAuthor').val() != "" && $('#magazineGenre').val() != "" && $('#magazineType option:selected').val() != '0'  && $('#magazineYear').val().length == 4 && $('#magazineStatus option:selected').val() != '0' && $('#magazineDesc').val() != "" && $('#magazineCover').val() != ""){
                $('#add-btn').attr('disabled', false);
            } else{
                $('#add-btn').attr('disabled', true);
            }
        });
        $('form').click(function(){
            if($('#magazineID').val() != "" && $('#magazineTitle').val() != "" && $('#magazineAltTitle').val() != "" && $('#magazineAuthor').val() != "" && $('#magazineGenre').val() != "" && $('#magazineType option:selected').val() != '0'  && $('#magazineYear').val().length == 4 && $('#magazineStatus option:selected').val() != '0' && $('#magazineDesc').val() != "" && $('#magazineCover').val() != ""){
                $('#add-btn').attr('disabled', false);
            } else{
                $('#add-btn').attr('disabled', true);
            }
        });
    </script>
</body>
</html>