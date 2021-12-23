<?php
include 'db-conn.php';
if(isset($_POST['selection']) && isset($_POST['mail']) && isset($_POST['id'])){
    $sendMail = $_POST['mail'];
    $stmt = $dbh->prepare("SELECT * FROM `user_details` WHERE `user_mail`=? LIMIT 1"); 
    $stmt->execute([$sendMail]); 
    $row = $stmt->fetch();
    if ($stmt->rowCount() > 0) {
        if($_POST['id'] == $row['access_token']){
            $items = array("heads", "tails");
            $randToss = $items[array_rand($items)];
            if($_POST['selection'] == $randToss){
                echo "<h4>You Won.</h4>";
                $stmt = $dbh->prepare("UPDATE `user_details` SET `ruby_count`=`ruby_count`+5, `toss_time`=now() WHERE `user_mail`=?");
                try{
                    $stmt->execute([$_POST['mail']]);
                    $dbh = null;
                    ?>
                    <script>
                        alert("Congratulations!\nYou have Won! 5 rubies have been added to your account.");
                        location.reload();
                    </script>
                    <?php
                } catch(Exception $e){
                    ?>
                    <script>
                        alert("Something went wrong. Please try again!\nCode:TOSS_UPDATE_001");
                        location.reload();
                    </script>
                    <?php
                }   
            } else{
                echo "<h4>It was $randToss. You Lost. Better Luck next time!</h4>";
                $stmt = $dbh->prepare("UPDATE `user_details` SET `toss_time`=now() WHERE `user_mail`=?");
                try{
                    $stmt->execute([$_POST['mail']]);
                    $dbh = null;
                    ?>
                    <script>
                        alert("You Lost!\nIt was <?php echo $randToss;?>.\nBetter Luck next time!");
                        location.reload();
                    </script>
                    <?php
                } catch(Exception $e){
                    ?>
                    <script>
                        alert("Something went wrong. Please try again!\nCode:TOSS_UPDATE_001");
                        location.reload();
                    </script>
                    <?php
                }
            }
        } else{
            ?>
            <script>
                alert("Invalid Input.\nCode:TOSS_UID_001");
                window.location.href = "user-logout.php";
            </script>
            <?php
        }
    } else{
        $dbh = null;
        ?>
        <script>
            alert("Invalid Input.\nCode:TOSS_MAIL_001");
            window.location.href = "user-logout.php";
        </script>
        <?php
    }
}

?>