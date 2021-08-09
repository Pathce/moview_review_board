<?php include $_SERVER['DOCUMENT_ROOT']."./db.php"; ?>
<?php
    if (!isset($_POST['user_id']) || !isset($_POST['user_pw'])) {
        header("Content-Type: text/html; charset=UTF-8");
        echo "<script>alert('아이디 또는 비밀번호가 빠졌거나 잘못된 접근입니다.');";
        echo "window.location.replace('index.php');</script>";
        exit;
    }
    $user_id = $_POST['user_id'];
    $user_pw = $_POST['user_pw'];
    $sql = query("SELECT * FROM user_info WHERE UR_ID='$user_id' and UR_PW='$user_pw'");
    $member = $sql->fetch_assoc();
    if(!isset($member)) {
        header("Content-Type: text/html; charset=UTF-8");
        echo "<script>alert('아이디 또는 비밀번호가 잘못되었습니다.');";
        echo "window.location.replace('./index.php');</script>";
    }
    session_start();
    $_SESSION['user_id'] = $user_id;
    $_SESSION['user_name'] = $member['UR_NAME'];
?>
<meta http-equiv="refresh" content="0;url=main.php" />