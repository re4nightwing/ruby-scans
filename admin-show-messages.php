<?php
    if(isset($_COOKIE['lgUsr'])){  
        if($_COOKIE['lgUsr']=="" || $_COOKIE['lgUsr'] != 'admin'){
            header('Location: admin-logout.php');
        }
    } else{
        header('Location: admin-logout.php');
    }
    if(isset($_POST['submit-message'])){
        include 'db-conn.php';
        $msg_id = $_POST['msg-id'];
        $msg_status = $_POST['msg-status'];
        if($msg_status == 0){
            $sql = "UPDATE `user_msgs` SET `seen_status` = '1' WHERE `msg_id` = ?";
        } elseif($msg_status == 1){
            $sql = "UPDATE `user_msgs` SET `seen_status` = '0' WHERE `msg_id` = ?;";
        }
        $stmt= $dbh->prepare($sql);
        try{
            $stmt->execute([$msg_id,]);
            ?>
                <script>
                    window.location.replace("admin-show-messages.php#<?php echo $msg_id."-msg"; ?>");
                </script>
            <?php
        } catch (Exception $e){
            $dbh->rollback();
            throw $e;
        }
        $dbh = null;
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
    <title>Messages | SlayerScans</title>
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
            <div class="text-center text-light">
                <h1>User Messages</h1>
            </div>
            <ul class="nav nav-tabs" id="myTab" role="tablist">
                <li class="nav-item" role="presentation">
                    <button class="nav-link active" id="chap-error" data-bs-toggle="tab" data-bs-target="#chapter-error" type="button" role="tab" aria-controls="chapter-error" aria-selected="true">Chapter Errors</button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="user-msgs" data-bs-toggle="tab" data-bs-target="#user-messages" type="button" role="tab" aria-controls="user-messages" aria-selected="false">User Messages</button>
                </li>
            </ul>
            <div class="tab-content" id="myTabContent">
                <div class="tab-pane fade show active" id="chapter-error" role="tabpanel" aria-labelledby="chap-error">
                <?php
                    include 'db-conn.php';
                    $query = 'SELECT * FROM `user_msgs`WHERE `msg_type`=0 ORDER BY `date` DESC;';
                    foreach ($dbh->query($query) as $row) {
                        ?>
                        <div class="card mx-5 my-3" id="<?php echo $row['msg_id']."-msg"; ?>">
                            <h5 class="card-header"><?php echo $row['msg_heading']; ?></h5>
                            <div class="card-body">
                                <h5 class="card-title"><?php echo $row['date']; ?> <span class="badge bg-success"><?php echo "ID: ".$row['msg_id']; ?></span></h5>
                                <p class="card-text"><?php echo $row['msg_body']; ?></p>
                                <p><i>by <?php echo $row['msg_by']; ?></i></p>
                                <form action="admin-show-messages.php#<?php echo $row['msg_id']."-msg"; ?>" method="POST">
                                    <input type="hidden" name="msg-id" value="<?php echo $row['msg_id']; ?>">
                                    <input type="hidden" name="msg-status" value="<?php echo $row['seen_status']; ?>">
                                    <?php if($row['seen_status'] == 0){
                                        echo "<button type='submit' name='submit-message' class='btn btn-primary'>Mark as Read</a>";
                                    } else{
                                        echo "<button type='submit' name='submit-message' class='btn btn-secondary'>Mark as Unread</a>";
                                    }
                                    ?>
                                    
                                </form>
                            </div>
                        </div>
                        <?php
                    }
                ?>
                </div>
                <div class="tab-pane fade" id="user-messages" role="tabpanel" aria-labelledby="user-msgs">
                <?php
                    $query = 'SELECT * FROM `user_msgs`WHERE `msg_type`=1 ORDER BY `date` DESC;';
                    foreach ($dbh->query($query) as $row) {
                        ?>
                        <div class="card mx-5 my-3" id="<?php echo $row['msg_id']."-msg"; ?>">
                            <h5 class="card-header"><?php echo $row['msg_heading']; ?></h5>
                            <div class="card-body">
                                <h5 class="card-title"><?php echo $row['date']; ?> <span class="badge bg-success"><?php echo "ID: ".$row['msg_id']; ?></span></h5>
                                <p class="card-text"><?php echo $row['msg_body']; ?></p>
                                <p><i>by <?php echo $row['msg_by']; ?></i></p>
                                <form action="admin-show-messages.php#<?php echo $row['msg_id']."-msg"; ?>" method="POST">
                                    <input type="hidden" name="msg-id" value="<?php echo $row['msg_id']; ?>">
                                    <input type="hidden" name="msg-status" value="<?php echo $row['seen_status']; ?>">
                                    <?php if($row['seen_status'] == 0){
                                        echo "<button type='submit' name='submit-message' class='btn btn-primary'>Mark as Read</a>";
                                    } else{
                                        echo "<button type='submit' name='submit-message' class='btn btn-secondary'>Mark as Unread</a>";
                                    }
                                    ?>
                                    
                                </form>
                            </div>
                        </div>
                        <?php
                    }
                    $dbh = null;
                ?>
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