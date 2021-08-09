<?php include $_SERVER['DOCUMENT_ROOT']."./db.php"; ?>
<?php
if(empty($_POST)) {
    echo "<script>alert('올바르지 않은 접근 입니다.')</script>";
    echo "<meta http-equiv="."refresh"." content="."0;url=signin.php"." />";
}
// id, pw, rpw, name, email, emadress

echo "<br>";

$email = $_POST['email']."@".$_POST['emadress'];
$sql_id = query("SELECT * FROM USER_INFO WHERE UR_ID="."'".$_POST['id']."'");
$chk_userid = $sql_id->fetch_assoc();
$sql_email = query("SELECT * FROM USER_INFO WHERE UR_EMAIL="."'".$email."'");
$chk_useremail = $sql_email->fetch_assoc();
$cnt = 0;

if(isset($chk_userid)) {
    if($_POST['id'] == $chk_userid['UR_ID']){
        echo "사용중인 ID 입니다.";
        echo "<br>";
        $cnt++;
    }
}
if(isset($chk_useremail)) {
    if($email == $chk_useremail['UR_EMAIL']){
        echo "사용중인 EMAIL 입니다.";
        echo "<br>";
        $cnt++;
    }
}
if($_POST['pw'] != $_POST['rpw']) {
    echo "비밀번호가 일치하지 않습니다.";
    echo "<br>";
    $cnt++;
}
if($cnt == 0) {
//    $sql = query();

    echo "회원가입";
    echo "<div>";
    echo "<a href='index.php'><button>확인</button></a>";
    echo "</div>";
}

?>