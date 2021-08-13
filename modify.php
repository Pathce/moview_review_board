<?php
include $_SERVER['DOCUMENT_ROOT']."./db.php";
    $r_seq = $_GET['r_seq'];
    $sql = query("
        SELECT R.R_SUBJECT R_TITLE, R.R_CONTENT R_CONTENT, M.M_NAME M_TITLE, R.R_SCORE R_SCORE
        FROM REVIEW R, MOVIE_INFO M
        WHERE R_SEQ='$r_seq' AND R.M_SEQ = M.M_SEQ");
    $review = $sql->fetch_assoc();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>리뷰 수정</title>

    <!-- include libraries(jQuery, bootstrap) -->
    <link href="http://netdna.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.css" rel="stylesheet">
    <script src="http://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.js"></script>
    <script src="http://netdna.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.js"></script>

    <!-- include summernote css/js-->
    <link href="http://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.8/summernote.css" rel="stylesheet">
    <script src="http://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.8/summernote.js"></script>

    <!-- include summernote-ko-KR -->
    <script src="lang/summernote-ko-KR.js"></script>

    <link rel="stylesheet" type="text/css" href="./css/modify.css" />
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
        <form id="postForm" action="modify_ok.php?r_seq=<?php echo $r_seq; ?>" method="post">
            <div id="in_title">
                <textarea name="r_title" id="utitle" rows="1" cols="55" placeholder="리뷰 제목" maxlength="100" rows="1" required><?php echo $review['R_TITLE']; ?></textarea>
            </div>
            <div class="wi_line"></div>
            <div id="in_name">
                <textarea name="m_title" id="mtitle" rows="1" cols="55" placeholder="영화 제목" maxlength="100" rows="1" required><?php echo $review['M_TITLE']; ?></textarea>
            </div>
            <div class="wi_line"></div>
            <div class="in_score">
                <textarea name="r_score" id="in_score" placeholder="평점" rows="1"><?php echo $review['R_SCORE']; ?></textarea>
            </div>
            <div id="in_content">
                <textarea id="summernote" name="contents"><?php echo $review['R_CONTENT']; ?></textarea>
            </div>
            <div class="btn_sub">
                <button id="btn_submit" type="submit">작성</button>
                <a href="./review.php?r_seq=<?php echo $r_seq; ?>"><button id="btn_cancel" type="button">취소</button><a/>
            </div>
        </form>
    </div>
</div>
<script src="./js/modify.js"></script>
</body>
</html>
