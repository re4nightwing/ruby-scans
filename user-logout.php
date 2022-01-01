<?php
    session_start();
    if(isset($_SESSION["email"])){
        unset($_SESSION["email"]);
        unset($_SESSION["user_uid"]);
        session_destroy();
    }
?>
<script>
    alert("You have logged out successfully!");
    window.location.href = "index.php";
</script>