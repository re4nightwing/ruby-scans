<?php
    if (isset($_COOKIE['lgUsr'])) {
        unset($_COOKIE['lgUsr']); 
        setcookie('lgUsr', null, -1, '/'); 
    }
    ?>
    <script>
        window.location.href = "admin.php";
    </script>