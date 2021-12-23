<?php
    session_start();
    if(isset($_POST['mail']) && isset($_POST['id']) && isset($_POST['mangaId']) && isset($_POST['isVirgin']) && isset($_POST['type'])){
        $user_mail = $_POST['mail'];
        $user_id = $_POST['id'];
        $item_id = $_POST['mangaId'];
        $is_virgin = $_POST['isVirgin'];
        $action_type = $_POST['type'];

        if($action_type == "buy"){
            include 'db-conn.php';
            $has_wished = $_POST['hasWished'];
            if($has_wished){
                $stmt = $dbh->prepare("SELECT * FROM `user_details` WHERE `user_mail`=? LIMIT 1"); 
                $stmt->execute([$user_mail]); 
                $row = $stmt->fetch();
                if ($stmt->rowCount() > 0) {
                    $wishlist_str = $row['user_list'];
                    $new_wishlist_str = "";
                    $wishlist_arr = explode(',',$wishlist_str);
                    $arr_len = count($wishlist_arr);
                    for($i = 0; $i<$arr_len; $i++){
                        if($wishlist_arr[$i] == $item_id || $wishlist_arr[$i] == ""){
                            unset($wishlist_arr[$i]);
                        }
                    }
                    $new_wishlist_arr = array_values($wishlist_arr);
                    foreach($new_wishlist_arr as $book){
                        $new_wishlist_str = $new_wishlist_str.$book.",";
                    }
                    if($new_wishlist_str == "," || $new_wishlist_str == ''){
                        $sql = "UPDATE `user_details` SET `user_list` = NULL WHERE `user_mail`=?";
                    } else{
                        $sql = "UPDATE `user_details` SET `user_list` = ? WHERE `user_mail`=?";
                    }
                    $stmt= $dbh->prepare($sql);
                    try{
                        if($new_wishlist_str == "," || $new_wishlist_str == ''){
                            $stmt->execute([$user_mail]);
                        } else{
                            $stmt->execute([$new_wishlist_str, $user_mail]);
                        }
                    } catch (Exception $e){
                        $dbh->rollback();
                        throw $e;
                    }
                }
            }
            $stmt = $dbh->prepare("SELECT * FROM `user_details` WHERE `user_mail`=? LIMIT 1"); 
            $stmt->execute([$user_mail]); 
            $row = $stmt->fetch();
            if ($stmt->rowCount() > 0) {
                if($row['ruby_count'] >= 3){
                    if($is_virgin == 0){
                        $sql = "UPDATE `user_details` SET `user_bought` = ?, `ruby_count` = `ruby_count`-3 WHERE `user_mail`=?";
                    } else{
                        $sql = "UPDATE `user_details` SET `user_bought` = CONCAT(`user_bought`,',', ?), `ruby_count` = `ruby_count`-3 WHERE `user_mail`=?";
                    }
                    $stmt= $dbh->prepare($sql);
                    try{
                        $stmt->execute([$item_id, $user_mail]);
                        $_SESSION['bought'] = true;
                        ?>
                            <script>
                                //alert("Purchase successfully!");
                                location.reload();
                            </script>
                        <?php
                    } catch (Exception $e){
                        $dbh->rollback();
                        throw $e;
                    }
                } else{
                    ?>
                    <script>
                        alert("Your ruby count is not enough. Buy or win some rubies to purchase!");
                    </script>
                    <?php
                }
            }
            $dbh = null;
        } elseif($action_type == "bookmark"){
            include 'db-conn.php';
            if($is_virgin == 0){
                $sql = "UPDATE `user_details` SET `user_list` = ? WHERE `user_mail`=?";
            } else{
                $sql = "UPDATE `user_details` SET `user_list` = CONCAT(`user_list`,',', ?) WHERE `user_mail`=?";
            }
            $stmt= $dbh->prepare($sql);
            try{
                $stmt->execute([$item_id, $user_mail]);
                $_SESSION['wish'] = true;
                ?>
                    <script>
                        //showWishToast();
                        location.reload();
                    </script>
                <?php
            } catch (Exception $e){
                $dbh->rollback();
                throw $e;
            }
            $dbh = null;
        } elseif($action_type == "unbookmark"){
            include 'db-conn.php';

            $stmt = $dbh->prepare("SELECT * FROM `user_details` WHERE `user_mail`=? LIMIT 1"); 
            $stmt->execute([$user_mail]); 
            $row = $stmt->fetch();
            if ($stmt->rowCount() > 0) {
                $wishlist_str = $row['user_list'];
                $new_wishlist_str = "";
                $wishlist_arr = explode(',',$wishlist_str);
                $arr_len = count($wishlist_arr);
                for($i = 0; $i<$arr_len; $i++){
                    if($wishlist_arr[$i] == $item_id || $wishlist_arr[$i] == ""){
                        unset($wishlist_arr[$i]);
                    }
                }
                $new_wishlist_arr = array_values($wishlist_arr);
                foreach($new_wishlist_arr as $book){
                    $new_wishlist_str = $new_wishlist_str.$book.",";
                }
                if($new_wishlist_str == "," || $new_wishlist_str == ''){
                    $sql = "UPDATE `user_details` SET `user_list` = NULL WHERE `user_mail`=?";
                } else{
                    $sql = "UPDATE `user_details` SET `user_list` = ? WHERE `user_mail`=?";
                }
                $stmt= $dbh->prepare($sql);
                try{
                    if($new_wishlist_str == "," || $new_wishlist_str == ''){
                        $stmt->execute([$user_mail]);
                    } else{
                        $stmt->execute([$new_wishlist_str, $user_mail]);
                    }
                    $_SESSION['unwish'] = true;
                    ?>
                        <script>
                            //showUnwishToast();
                            location.reload();
                        </script>
                    <?php
                } catch (Exception $e){
                    $dbh->rollback();
                    throw $e;
                }
                $dbh = null;
            }
        }
    }
?>