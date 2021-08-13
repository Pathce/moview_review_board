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

    <!-- include libraries(jQuery, bootstrap) -->
    <link href="http://netdna.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.css" rel="stylesheet">
    <script src="http://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.js"></script>
    <script src="http://netdna.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.js"></script>

    <!-- include summernote css/js-->
    <link href="http://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.8/summernote.css" rel="stylesheet">
    <script src="http://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.8/summernote.js"></script>

    <!-- include summernote-ko-KR -->
    <script src="lang/summernote-ko-KR.js"></script>

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
            <form id="postForm" action="review_write_ok.php" method="post">
                <table>
                    <tbody>
                    <tr>
                        <td id="td"><input name="r_title" rows="1" cols="55" placeholder="리뷰 제목" maxlength="100" required></td>
                    </tr>
                    <tr>
                        <td id="td"><input name="m_title" id="mtitle" rows="1" cols="55" placeholder="영화 제목" maxlength="100" required></td>
                    </tr>
                    <tr>
                        <td id="td"><input name="r_score" id="in_score" placeholder="평점" required></td>
                    </tr>
                    <tr>
                        <td id="summer_td"><textarea id="summernote" name="contents"></textarea></td>
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
<script src="./js/review_write.js"></script>
</body>
</html>