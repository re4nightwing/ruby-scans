<?php
    if(isset($_POST['login-submit'])){
        $usrName = $_POST['username'];
        $pswd = $_POST['password'];
        if($usrName == 'admin' && $pswd == 'root'){
            setcookie("lgUsr",'admin', time() + (3600 * 24 * 10), "/");
            ?>
            <script>
                alert('Logged In!');
                window.location.href = "admin-dashboard.php";
            </script>
            <?php
        } else{
            ?>
            <script>
                alert('Invalid Log In');
                window.location.href = "admin.php";
            </script>
            <?php
        }
    }
?>
<?php
    if(isset($_COOKIE['lgUsr'])) {
        if($_COOKIE['lgUsr'] == 'admin'){
            header("Location: admin-dashboard.php");
        }
    }
?>
<!DOCTYPE html> 
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel | SlayerScans</title>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Open+Sans&display=swap');
        body{
            position: relative;
            background-color: #210708;
        }
        .login-box{
            text-align: center;
            background-color: #fff;
            padding: 3rem 4rem;
            position: absolute;
            top: 50%;
            right: 50%;
            transform: translate(50%,50%);
            border-radius: 20px;
            border: 2px solid #000;
            font-family: 'Open Sans', sans-serif;
        }
        .success-text{
            color: #43bd48;
        }
        .error-text{
            color: #ff0000;
        }
    </style>
</head>
<body>
    <div class="login-box">
        <h1>Admin Login</h1>
        <form action="admin.php" method="POST">
            <h4>Username</h4>
            <input type="text" name="username">
            <h4>Password</h4>
            <input type="password" name="password"></br></br>
            <button type="submit" name="login-submit">Login</button>
        </form>
        <b><p id="result"></p></b>
    </div>
</body>
</html>