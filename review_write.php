<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    echo "<script>alert('로그인 후 이용 가능합니다.');";
    echo "window.location.replace('index.php');</script>";
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>리뷰 작성</title>
    <link rel="stylesheet" type="text/css" href="./css/review_write.css" />
</head>
<body>
    <div class="header">
        <h4><a href="./main.php">메인</a></h4>
    </div>
    <div class="blank"></div>
    <div class="review_write">
        <h2>리뷰 작성</h2>
        <div id="write_area">
            <form action="review_write_ok.php" method="post">
                <table>
                    <tbody>
                    <tr>
                        <td><input name="r_title" rows="1" cols="55" placeholder="리뷰 제목" maxlength="100" required></td>
                    </tr>
                    <tr>
                        <td><input name="m_title" id="mtitle" rows="1" cols="55" placeholder="영화 제목" maxlength="100" required></td>
                    </tr>
                    <tr>
                        <td><input name="r_score" id="in_score" placeholder="평점" required></td>
                    </tr>
                    <tr>
                        <td></td>
                    </tr>
                    <tr>
                        <td id="content"><textarea name="r_content" id="ucontent" placeholder="내용" required></textarea></td>
                    </tr>
                    </tbody>
                </table>
                <div class="btn_sub">
                    <a href="./review_board.php"><button id="btn_cancel" type="button">작성취소</button></a>
                    <button id="btn_write" type="submit">작성하기</button>
                </div>
            </form>
        </div>
    </div>
</body>
</html>