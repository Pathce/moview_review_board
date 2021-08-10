<?php include $_SERVER['DOCUMENT_ROOT']."./db.php"; ?>
<?php
if(empty($_POST)) {
    echo "<script>alert('올바르지 않은 접근 입니다.')</script>";
    echo "<meta http-equiv="."refresh"." content="."0;url=signin.php"." />";
}

$id = stripcslashes($_POST['id']);
$pw = stripcslashes($_POST['pw']);
$rpw = stripcslashes($_POST['rpw']);
$name = stripcslashes($_POST['name']);
$email = $_POST['email'];
$emadress = $_POST['emadress'];
$id_chk = $_POST['id_check'];
$pw_chk = $_POST['pw_check'];
$email_chk = $_POST['email_check'];

$mail = stripcslashes($email."@".$emadress);

?>
<link rel="stylesheet" href="./css/signin.css" />
<form name="submit_form" class="hidden" action="signin.php" method="post">
    <input name="id_check" value="<?php echo $id_chk; ?>">
    <input name="pw_check" value="<?php echo $pw_chk; ?>">
    <input name="email_check" value="<?php echo $email_chk; ?>">
    <input name="id" value="<?php echo $id; ?>">
    <input name="pw" value="<?php echo $pw; ?>">
    <input name="rpw" value="<?php echo $rpw; ?>">
    <input name="name" value="<?php echo $name; ?>">
    <input name="email" value="<?php echo $email; ?>">
    <input name="emadress" value="<?php echo $emadress; ?>">
</form>
<?php

if($id_chk && $email_chk && $pw_chk){
    $sql = query("INSERT INTO USER_INFO(UR_ID, UR_PW, UR_NAME, UR_EMAIL) VALUES('$id', '$pw', '$name', '$mail')");
    echo "<script>alert('회원가입 되었습니다.');</script>";
    echo "<meta http-equiv='refresh' content='0;url=main.php' />";
} else if(!($id_chk && $email_chk)) { ?>
    <script>
        alert("ID, EMAIL 중복 검사를 해주십시오.");
        document.submit_form.submit();
    </script>
<?php } else { ?>
    <script>
        alert("PW가 일치하지 않습니다.");
        document.submit_form.submit();
    </script>
<?php } ?>
