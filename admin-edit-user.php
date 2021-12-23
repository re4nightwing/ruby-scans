<?php
if(isset($_GET['id']) && isset($_GET['edit'])){
    $req_id = $_GET['id'];
    $req_edit = $_GET['edit'];

    if($req_edit == 'delete'){
        include 'db-conn.php';
        $stmt = $dbh->prepare("DELETE FROM `user_details` WHERE `user_mail`= ?");
        try{
            $stmt->execute([$req_id]);
            ?>
            <script>
                alert("Record Deleted Successfully!");
                window.location.href = "admin-show-users.php";
            </script>
            <?php
        } catch(PDOException $e){
            ?>
            <script>
                alert("Failed to delete the entry.");
                window.location.href = "admin-show-users.php";
            </script>
            <?php
        }
        $dbh = null;
    }
}