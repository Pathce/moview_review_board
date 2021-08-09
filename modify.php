<?php
include $_SERVER['DOCUMENT_ROOT']."./db.php";
    $r_seq = $_GET['r_seq'];
    $sql = query("
SELECT R.R_SEQ R_SEQ, R.R_SUBJECT R_TITLE, M.M_NAME M_TITLE, R.R_SCORE R_SCORE, R.R_TIMESTAMP R_DATE, R.R_REC R_REC
FROM REVIEW R, MOVIE_INFO M
WHERE R_SEQ='$r_seq' AND R.M_SEQ = M.M_SEQ");
    print_r($sql->fetch_assoc());
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>리뷰 수정</title>
    <link rel="stylesheet" type="text/css" href="./css/review_write.css" />
</head>
<body>
<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    echo "<script>alert('로그인 후 이용 가능합니다.');";
    echo "window.location.replace('index.php');</script>";
}
?>
<div class="review_write">
    <h1><a href="./review_board.php">리뷰 게시판</a></h1>
    <h4>리뷰 수정</h4>
    <div id="write_area">
        <form action="modify_ok.php?r_seq=<?php echo $r_seq; ?>" method="post">
            <div id="in_title">
                <input name="title" id="utitle" rows="1" cols="55" placeholder="리뷰 제목" maxlength="100" required>
            </div>
            <div class="wi_line"></div>
            <div id="in_name">
                <input name="movie_title" id="mtitle" rows="1" cols="55" placeholder="영화 제목" maxlength="100" required>
            </div>
            <div class="wi_line"></div>
            <div class="in_score">
                <input name="movie_score" id="in_score" placeholder="평점">
            </div>
            <div class="wi_line"></div>
            <div id="in_content">
                <textarea name="content" id="ucontent" placeholder="내용" required></textarea>
            </div>
            <div class="btn_sub">
                <button type="submit">작성하기</button>
            </div>
        </form>
    </div>
</div>
<script src="./js/review.js"></script>
</body>
</html>
