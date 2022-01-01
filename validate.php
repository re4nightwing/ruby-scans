<?php
    if(isset($_POST['login-email']) && isset($_POST['login-password']) && isset($_POST['page_url']) ){
        $login_email = $_POST['login-email'];
        $login_pswd = $_POST['login-password'];
        $redirect_url = $_POST['page_url'];
        include 'db-conn.php';
        $stmt = $dbh->prepare("SELECT * FROM `user_details` WHERE `user_mail`=? LIMIT 1"); 
        $stmt->execute([$login_email]); 
        $row = $stmt->fetch();
        if ($stmt->rowCount() > 0) {
            if(password_verify($login_pswd, $row['user_pswd'])){
                session_start();
                $_SESSION["email"] = $login_email;
                $_SESSION["user_uid"] = uniqid('user_');
                $_SESSION["user_list"] = "";
                $_SESSION["wish_list"] = "";
                $sql = "UPDATE `user_details` SET `access_token` = ? WHERE `user_mail`=?";
                $stmt= $dbh->prepare($sql);
                try{
                    $stmt->execute([$_SESSION['user_uid'], $_SESSION['email']]);
                    $_SESSION['user_logged'] = true;
                    ?>
                        <script>
                            //alert("Welcome back!\nYou have logged in successfully!");
                            window.location.href = "<?php echo $redirect_url;?>";
                        </script>
                    <?php
                } catch (Exception $e){
                    $dbh->rollback();
                    throw $e;
                }
                $dbh = null;
            } else{
                $dbh = null;
                ?>
                <script>
                    alert("Invalid Password!");
                    window.location.href = "index.php?logged=fail";
                </script>
                <?php
            }
        } else {
            $dbh = null;
            ?>
            <script>
                alert("Invalid Email Address!");
                window.location.href = "index.php?logged=fail";
            </script>
            <?php
        }
    } else if( isset($_POST['sign-user']) && isset($_POST['sign-email']) && isset($_POST['sign-pswd']) && isset($_POST['sign-pswd2']) ){
        $sign_email = $_POST['sign-email'];
        $sign_pswd = $_POST['sign-pswd'];
        $sign_user = $_POST['sign-user'];
        $sign_confirm = $_POST['sign-pswd2'];
        $hashed_pswd = password_hash($sign_confirm, PASSWORD_DEFAULT);
        $data = array(
            'secret' => "0x9818Df50a8dBE7E56327d2A5FD6C8091A71ae185",
            'response' => $_POST['h-captcha-response']
        );
        $verify = curl_init();
        curl_setopt($verify, CURLOPT_URL, "https://hcaptcha.com/siteverify");
        curl_setopt($verify, CURLOPT_POST, true);
        curl_setopt($verify, CURLOPT_POSTFIELDS, http_build_query($data));
        curl_setopt($verify, CURLOPT_RETURNTRANSFER, true);
        $response = curl_exec($verify);
        // var_dump($response);
        $responseData = json_decode($response);
        if($responseData->success) {
            if(password_verify($sign_pswd, $hashed_pswd)){
                include 'db-conn.php';
    
                $stmt = $dbh->prepare("SELECT * FROM `user_details` WHERE `user_mail`=? LIMIT 1"); 
                $stmt->execute([$sign_email]); 
                $row = $stmt->fetch();
                if ($stmt->rowCount() > 0) {
                    $dbh = null;
                    ?>
                    <script>
                        alert("This email already has an Account!");
                        window.location.href = "index.php?sign=failed";
                    </script>
                    <?php
                } else{
                   $sql = "INSERT INTO `user_details`(`user_mail`, `user_name`, `user_pswd`, `signed_date`, `access_token`) VALUES (?,?,?,now(),'NULL')";
                    $stmt= $dbh->prepare($sql);
                    try{
                        $stmt->execute([$sign_email,$sign_user,$hashed_pswd]);
                        ?>
                            <script>
                                alert("Welcome to Ruby Scans!\nYou have signed in Successfully! Login using created credentials.");
                                window.location.href = "index.php";
                            </script>
                        <?php
                    } catch (Exception $e){
                        $dbh->rollback();
                        throw $e;
                    }
                    $dbh = null; 
                }
            } else{
                ?>
                <script>
                    alert("Password doesn't match. Please try again!");
                    window.location.href = "index.php?sign=failed";
                </script>
                <?php
            }
        }else {
            ?>
            <script>
                alert("Please fill the hCaptcha to register!");
                window.location.href = "index.php?hcaptcha=failed";
            </script>
            <?php 
        }
    } else{
        ?>
            <script>
                alert("ඔයා වරදක් කරනවා මචං!");
                window.location.href = "index.php?forced=attempted";
            </script>
        <?php
    }
?>