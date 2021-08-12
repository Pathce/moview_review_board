<!DOCTYPE html>
<?php session_start(); ?>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>로그인</title>
    <link rel="stylesheet" href="./css/index.css" >
</head>
<body>
<div class="login_container">
    <h1>로그인</h1>
    <?php if(!isset($_SESSION['user_id']) || !isset($_SESSION['user_name'])) { ?>
        <form id="login_form" method="post" action="login_ok.php">
            <p><input id="input_id" type="text" name="user_id" placeholder="ID"/></p>
            <p><input id="input_pw" type="password" name="user_pw" placeholder="PW" /></p>
            <p><input id="login_submit" type="submit" value="로그인" /><a href="main.php"><button id="login_cancel" type="button">취소</button></a></p>
            <p><a id="sign_up" href="signin.php">회원가입</a></p>
        </form>
        <?php
    } else {
        $user_id = $_SESSION['user_id'];
        $user_name = $_SESSION['user_name'];
        echo "<p><strong>($user_name)님은 이미 로그인하고 있습니다.</strong>";
        echo "<a href='main.php'>[돌아가기]</a>";
        echo "<a href='logout.php'>[로그아웃]</a></p>";
    } ?>
</div>
</body>
</html>