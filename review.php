<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>내 정보</title>
    <link rel="stylesheet" type="text/css" href="./css/review.css" />
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
        <h1><a href="./reviewBoard.php">리뷰 게시판</a></h1>
        <h4>리뷰 쓰기</h4>
        <div id="write_area">
            <form action="write_ok.php" method="post">
                <div id="in_title">
                    <textarea name="title" id="utitle" rows="1" cols="55" placeholder="리뷰 제목" maxlength="100" required></textarea>
                </div>
                <div class="wi_line"></div>
                <div id="in_name">
                    <textarea name="movie_title" id="mtitle" rows="1" cols="55" placeholder="영화 제목" maxlength="100" required></textarea>
                </div>
                <div class="wi_line"></div>
                <div class="in_score">
                    평점 들어갈 자리
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