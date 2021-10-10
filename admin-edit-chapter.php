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
    <title>Edit Chapters | SlayerScans</title>
</head>
<body>
    <?php
        if(isset($_POST['submit-form'])){
            include 'db-conn.php';

            $chapNum = $_POST['chapterNum'];
            $magId = $_POST['magazineName'];
            $imgLink1 = $_POST['imageLink1'];
            $imgLink2 = $_POST['imageLink2'];


            $sql = "INSERT INTO `magazine-chapters` (`chapter_number`, `magazine_id`, `img_links_1`, `img_links_2`, `upload_date`, `update_date`) VALUES (?,?,?,?,now(), now())";
            $stmt= $dbh->prepare($sql);
            try{
                $stmt->execute([$chapNum,$magId,$imgLink1,$imgLink2]);
                ?>
                    <script>
                        alert("New Record Added Successfully!");
                        window.location.href = "admin-show-chapters.php?searchMag=<?php echo $magId;?>";
                    </script>
                <?php
            } catch (Exception $e){
                $dbh->rollback();
                throw $e;
            }
            $dbh = null;
        } else if(isset($_POST['update-form'])){
            include 'db-conn.php';

            $chapNum = $_POST['chapterNum'];
            $magId = $_POST['hiddenMagName'];
            $imgLink1 = $_POST['imageLink1'];
            $imgLink2 = $_POST['imageLink2'];

            $sql = "UPDATE `magazine-chapters` SET `img_links_1` = ?, `img_links_2` = ?, `update_date` = now() WHERE `chapter_number`=? AND `magazine_id`=?";
            $stmt= $dbh->prepare($sql);
            try{
                $stmt->execute([$imgLink1,$imgLink2,$chapNum,$magId]);
                ?>
                    <script>
                        alert("Record Updated Successfully!");
                        window.location.href = "admin-show-chapters.php?searchMag=<?php echo $magId;?>";
                    </script>
                <?php
            } catch (Exception $e){
                $dbh->rollback();
                throw $e;
            }
            $dbh = null;
        }
    ?>
    <div class="bg-img"></div>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container-fluid">
            <a class="navbar-brand" href="admin-dashboard.php">SlayerScans</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <li class="nav-item">
                        <a class="nav-link" aria-current="page" href="admin-dashboard.php">Dashboard</a>
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
            <!-- `chapter_number`, `magazine_id`, `img_links_1`, `img_links_2`, `upload_date`, `update_date` -->
            <form class="text-light text-start p-4" action="admin-edit-chapter.php" method="POST" style="background-color: #0f0f199e;">
                <div class="mb-3">
                    <label for="chapterNum" class="form-label">Chapter Number:</label>
                    <input type="number" step="0.01" min="0" class="form-control" maxlength="4" id="chapterNum" name="chapterNum" placeholder="1/1.2">
                </div>
                <div class="mb-3">
                    <label for="magazineName" class="form-label">Magazine ID:</label>
                    <select class="form-select" id="magazineName" name="magazineName">
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
                <input type="text" id="hiddenMagName" name="hiddenMagName" hidden>
                <div class="mb-3">
                    <label for="imageLink1" class="form-label">Image Link 1:(comma separated values)(put only the file name form the image link): <i>Ex: https://i.imgur.com/zvz5t2x.jpg => zvz5t2x.jpg</i></label>
                    <textarea class="form-control" id="imageLink1" name="imageLink1" maxlength="500" rows="4" placeholder="zvz5t2x.jpg,zvz5t2x.jpg,zvz5t2x.jpg"></textarea>
                </div>
                <div class="mb-3">
                    <label for="imageLink2" class="form-label">Image Link 2:(comma separated values)(put only the file name form the image link): <i>Ex: https://i.imgur.com/zvz5t2x.jpg => zvz5t2x.jpg</i></label>
                    <textarea class="form-control" id="imageLink2" name="imageLink2" maxlength="500" rows="4" placeholder="zvz5t2x.jpg,zvz5t2x.jpg,zvz5t2x.jpg"></textarea>
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
                try{
                    $requestId = $_GET['id'];
                    $requestChap = $_GET['chap'];
                } catch(Exception $e){
                    ?>
                    <script>
                        alert("<?php echo "Edit=>";throw $e;?>");
                        window.location.href = "admin-show-chapters.php";
                    </script>
                    <?php
                }
                $stmt = $dbh->prepare("SELECT * from `magazine-chapters` WHERE `chapter_number`= ? AND `magazine_id`= ? LIMIT 1"); 
                $stmt->execute([$requestChap,$requestId]); 
                $row = $stmt->fetch();
                if($row != null){
                    ?>
                    <script>
                       $('#chapterNum').val("<?php echo $row['chapter_number'];?>");
                       $('#magazineName').val("<?php echo $row['magazine_id'];?>");
                       $('#hiddenMagName').val("<?php echo $row['magazine_id'];?>");
                       $('#imageLink1').val("<?php echo $row['img_links_1'];?>");
                       $('#imageLink2').val("<?php echo $row['img_links_2'];?>");
                       $('#add-btn').removeClass('btn-primary');
                       $('#add-btn').addClass('btn-info');
                       $('#add-btn').prop('value','Update');
                       $('#add-btn').prop('name','update-form');
                       $('#chapterNum').prop('readonly', true);
                       $('#magazineName').prop('disabled', true);
                    </script>
                    <?php
                } else{
                    ?>
                    <script>
                        alert("There is no magazine under that ID");
                        window.location.href = "admin-show-chapters.php";
                    </script>
                    <?php
                }
            } else if($_GET['edit'] == 'delete'){
                try{
                    $requestId = $_GET['id'];
                    $requestChap = $_GET['chap'];
                } catch(Exception $e){
                    ?>
                    <script>
                        alert("<?php echo "Delete=>";throw $e;?>");
                        window.location.href = "admin-show-chapters.php";
                    </script>
                    <?php
                }
                $stmt = $dbh->prepare("DELETE FROM `magazine-chapters` WHERE `chapter_number`= ? AND `magazine_id`= ?");
                try{
                    $stmt->execute([$requestChap, $requestId]);
                    ?>
                    <script>
                        alert("Record Deleted Successfully!");
                        window.location.href = "admin-show-chapters.php?searchMag=<?php echo $magId;?>";
                    </script>
                    <?php
                } catch(PDOException $e){
                    echo $stmt . "<br>" . $e->getMessage();
                }
            } else{
                ?>
                <script>
                    alert("Invalid Path!");
                    window.location.href = "admin-show-chapters.php";
                </script>
                <?php
            }
            $dbh = null;
        } 
    ?>
    <script>
        $('form').keyup(function(){
            if($('#chapterNum').val() != "" && $('#magazineName option:selected').val() != '0'  && ($('#imageLink1').val() != "" || $('#imageLink2').val() != "")){
                $('#add-btn').attr('disabled', false);
            } else{
                $('#add-btn').attr('disabled', true);
            }
        });
        $('form').click(function(){
            if($('#chapterNum').val() != "" && $('#magazineName option:selected').val() != '0'  && ($('#imageLink1').val() != "" || $('#imageLink2').val() != "")){
                $('#add-btn').attr('disabled', false);
            } else{
                $('#add-btn').attr('disabled', true);
            }
        });
    </script>
</body>
</html>