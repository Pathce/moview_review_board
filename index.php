<!DOCTYPE html>
<?php session_start(); ?>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>로그인</title>
</head>
<body>
    <h1>로그인</h1>
    <hr />
    <?php if(!isset($_SESSION['user_id']) || !isset($_SESSION['user_name'])) { ?>
    <?php
        } else {
        $user_id = $_SESSION['user_id'];
        $user_name = $_SESSION['user_name'];
        echo "<p><strong>($user_name)님은 이미 로그인하고 있습니다.</strong>";
        echo "<a href=\'main.php\'>[돌아가기]</a>";
        echo "<a href=\'logout.php\'>[로그아웃]</a></p>";
    } ?>
</body>
</html>