<?php
include $_SERVER['DOCUMENT_ROOT']."./db.php";

echo "<br>";

if(!isset($_POST['id'])) { ?>
    <script>alert("유효하지 않은 접근입니다.");</script>
    <meta http-equiv="refresh" content="0;url=main.php" />
<?php }

$id = $_POST['id'];
$pw = $_POST['pw'];
$rpw = $_POST['rpw'];
$name = $_POST['name'];
$email = $_POST['email'];
$emadress = $_POST['emadress'];
$id_chk = $_POST['id_check'];
$pw_chk = $_POST['pw_check'];
$email_chk = $_POST['email_check'];

$sql = query("SELECT * FROM USER_INFO WHERE UR_ID='$id'");
if(preg_match("/[^a-zA-Z0-9]/", $id)) {
    ?>
    <script>alert("영문자, 숫자 외의 문자는 사용할 수 없습니다.")</script>
    <?php
    $id_chk = false;
} else if(strlen($id) < 4 || strlen($id) > 13) {
    ?>
    <script>alert("ID의 길이는 4 ~ 13자 이어야 합니다.")</script>
    <?php
    $id_chk = false;
} else if(!(preg_match("/[a-zA-z]/", $id))) {
    ?>
    <script>alert("영문자 또는 영문자+숫자 조합을 사용해야 합니다.")</script>
    <?php
    $id_chk = false;
} else if($sql->num_rows){ ?>
    <script>alert("중복된 ID 입니다.");</script>
<?php
    $id_chk = false;
} else { ?>
    <script>alert("사용 가능한 ID 입니다.");</script>
<?php
    $id_chk = true;
} ?>
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
<script>
    document.submit_form.submit();
</script>