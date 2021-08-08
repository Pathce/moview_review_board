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
                    <td><input type="button" value="ID 확인" id="btn_chkid"></td>
                </tr>
                <tr>
                    <th>PW</th>
                    <td> : <input type="password" name="pw" id="upw" required></td>
                    <td id="pw_comment">(8자 이상 13자 이하)</td>
                </tr>
                <tr>
                    <th>PW 확인</th>
                    <td> : <input type="password" name="rpw" id="urpw" required></td>
                    <td><input type="button" value="PW 확인" id="btn-chkpw" ></td>
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
                            <option value="naver.com">naver.com</option>
                            <option value="google.com">google.com</option>
                        </select>
                    </td>
                </tr>
            </table>
            <input type="submit" value="전송" >
        </fieldset>
    </form>
    <script src="./js/chkid.js"></script>
    <script src="./js/chkpw.js"></script>
</body>
</html>