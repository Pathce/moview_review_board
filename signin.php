<?php
include $_SERVER['DOCUMENT_ROOT']."./db.php";

$id_check = false;
$pw_check = false;
$email_check = false;
$id = $pw = $name = $rpw = $email = "";
$emadress = "example.com";

if(!empty($_POST)) {
    $id_check = $_POST['id_check'];
    $pw_check = $_POST['pw_check'];
    $email_check = $_POST['email_check'];
    $id = $_POST['id'];
    $pw = $_POST['pw'];
    $rpw = $_POST['rpw'];
    $name = $_POST['name'];
    $email = $_POST['email'];
    $emadress = $_POST['emadress'];
}

print_r($id_check);
echo "<br>";
print_r($pw_check);
echo "<br>";
print_r($email_check);
echo "<br>";
?>
<!DOCTYPE html>
<head lang="en">
    <meta charset="UTF-8">
    <title>회원가입</title>
    <link rel="stylesheet" type="text/css" href="./css/signin.css" />
</head>
<body>
<div class="signin_container">
    <h1>회원가입</h1>
    <form method="post" name="signin_form" action="signin_ok.php">
        <table>
            <tr>
                <th>ID</th>
                <td colspan="2"><input type="text" name="id" id="uid" required placeholder="ID" value='<?php echo $id; ?>'></td>
                <td><button type="submit" id="btn_id_chk" formaction="id_chk.php" formmethod="post">확인</button></td>
                <input class="hidden" id="id_check" name="id_check" value=<?php echo $id_check; ?>>
                <td id="id_chk_ok" <?php if(!$id_check) echo 'class="hidden"'; ?>>사용 가능한 ID 입니다.</td>
            </tr>
            <tr>
                <th>PW</th>
                <td colspan="2"><input type="password" name="pw" id="upw" required placeholder="PW" value='<?php echo $pw; ?>'></td>
            </tr>
            <tr>
                <th>PW 확인</th>
                <td colspan="2"><input type="password" name="rpw" id="r_upw" required placeholder="PW 확인" value='<?php echo $rpw; ?>'></td>
                <td id="eql" class="hidden">사용 가능합니다.</td>
                <td id="n_eql" class="">비밀번호가 일치하지 않습니다.</td>
                <input class="hidden" id="pw_check" name="pw_check" value=<?php echo $pw_check; ?>>
            </tr>
            <tr>
                <th>NAME</th>
                <td colspan="2"><input type="text" name="name" id="uname" required placeholder="이름" value='<?php echo $name; ?>'></td>
            </tr>
            <tr>
                <th>EMAIL</th>
                <td>
                    <input type="text" name="email" id="uemail_id" required placeholder="이메일" value='<?php echo $email; ?>'>
                    @
                    <select name="emadress" id="uemail_adr">
                        <option value="example.com" <?php if($emadress == 'example.com') echo "SELECTED"; ?>>example.com</option>
                        <option value="naver.com" <?php if($emadress == 'naver.com') echo "SELECTED"; ?>>naver.com</option>
                        <option value="google.com" <?php if($emadress == 'google.com') echo "SELECTED"; ?>>google.com</option>
                    </select>
                </td>
                <td><button type="submit" id="btn_email_chk" formaction="email_chk.php" formmethod="post">확인</button></td>
                <input class="hidden" id="email_check" name="email_check" value='<?php echo $email_check; ?>'>
                <td id="email_chk_ok" <?php if(!$email_check || $email_check=="false") echo 'class="hidden"'; ?>>사용 가능한 Email 입니다.</td>
            </tr>
        </table>
        <input id="btn_signin" type="submit" value="회원가입" >
        <button id="btn_cancel" type="button">취소</button>
    </form>
</div>
    <script src="./js/signin.js"></script>
</body>
</html>