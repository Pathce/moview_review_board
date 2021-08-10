<?php include $_SERVER['DOCUMENT_ROOT']."./db.php"; ?>
<!DOCTYPE html>
<head lang="en">
    <meta charset="UTF-8">
    <title>회원가입</title>
    <link rel="stylesheet" type="text/css" href="./css/signin.css" />
</head>
<body>
    <form method="post" name="signin_form" action="signin_ok.php">
        <fieldset>
            <legend>Sign In</legend>
            <table>
                <tr>
                    <th>ID</th>
                    <td> : <input type="text" name="id" id="uid" required></td>
                    <td><button type="submit" id="btn_id_chk" formaction="id_chk.php" formmethod="post">확인</button></td>
                </tr>
                <tr>
                    <th>PW</th>
                    <td> : <input type="password" name="pw" id="upw" required></td>
                </tr>
                <tr>
                    <th>PW 확인</th>
                    <td> : <input type="password" name="rpw" id="r_upw" required></td>
                    <td id="eql" class="hidden">사용 가능합니다.</td>
                    <td id="n_eql" class="">비밀번호가 일치하지 않습니다.</td>
                </tr>
                <tr>
                    <th>NAME</th>
                    <td> : <input type="text" name="name" id="uname" required></td>
                </tr>
                <tr>
                    <th>EMAIL</th>
                    <td> :
                        <input type="text" name="email" id="uemail_id" required>
                        @
                        <select name="emadress" id="uemail_adr">
                            <option value="example.com">example.com</option>
                            <option value="naver.com">naver.com</option>
                            <option value="google.com">google.com</option>
                        </select>
                    </td>
                    <td><button type="submit" formaction="email_chk.php" formmethod="post">확인</button></td>
                </tr>
            </table>
            <input type="submit" value="전송" >
        </fieldset>
    </form>
    <script src="./js/signin.js"></script>
</body>
</html>