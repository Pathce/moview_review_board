<?php include $_SERVER['DOCUMENT_ROOT']."./db.php"; ?>
<!DOCTYPE html>
<head lang="en">
    <meta charset="UTF-8">
    <title>회원가입</title>
    <link rel="stylesheet" type="text/css" href="./css/signin.css" />
</head>
<body>
    <?php
        $id = $pw = $rpw = $name = $email = "";

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $id = $_POST['id'];
            $pw = $_POST['pw'];
            $rpw = $_POST['rpw'];
            $name = $_POST['name'];
            $email = $_POST['email'];
        }
    ?>
    <form method="post" name="signin_form" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>">
        <fieldset>
            <legend>Sign In</legend>
            <table>
                <tr>
                    <th>ID</th>
                    <td> : <input type="text" name="id" id="uid" required></td>
                    <td><input type="button" value="ID 확인" id="btn_chkid"></td>
                </tr>
                <tr>
                    <th>PW</th>
                    <td> : <input type="password" name="pw" id="upw" required></td>
                </tr>
                <tr>
                    <th>PW 확인</th>
                    <td> : <input type="password" name="rpw" id="urpw" required></td>
                </tr>
                <tr>
                    <th>NAME</th>
                    <td> : <input type="text" name="name" id="uname" required></td>
                </tr>
                <tr>
                    <th>EMAIL</th>
                    <td> : <input type="text" name="email" id="uemail" required></td>
                </tr>
            </table>
            <input type="submit" value="전송" >
        </fieldset>
    </form>
    <?php
    echo "<h2>입력된 회원 정보</h2>";
    echo "ID : ".$id."<br>";
    echo "PW : ".$pw."<br>";
    echo "PW 확인 : ".$rpw."<br>";
    echo "이름 : ".$name."<br>";
    echo "email : ".$email."<br>";
    ?>
    <script src="./js/chkid.js"></script>
</body>
</html>