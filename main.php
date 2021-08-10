<?php include $_SERVER['DOCUMENT_ROOT']."./db.php"; ?>
<!DOCTYPE html>
<?php
session_start();

$totArray = $popArray = Array();
$popIndex = $totIndex = 0;

$sql_review = query("
SELECT R.R_SEQ R_SEQ, R.UR_ID U_ID, R.R_SUBJECT R_TITLE, M.M_NAME M_TITLE, R.R_SCORE R_SCORE, R.R_REC R_REC
FROM REVIEW R, MOVIE_INFO M
WHERE R.M_SEQ = M.M_SEQ 
ORDER BY R.R_SEQ DESC LIMIT 0, 5");
$sql_pop_review = query("
SELECT R.R_SEQ R_SEQ, R.UR_ID U_ID, R.R_SUBJECT R_TITLE, M.M_NAME M_TITLE, R.R_SCORE R_SCORE, R.R_REC R_REC
FROM REVIEW R, MOVIE_INFO M
WHERE R.M_SEQ = M.M_SEQ AND R_REC >= 5 
ORDER BY R_SEQ DESC LIMIT 0, 5");

while($review = $sql_review->fetch_assoc()) {
    $r_seq = $review['R_SEQ'];
    $sql_comment = query("SELECT * FROM REVIEW_COMMENT WHERE R_SEQ='$r_seq'");
    $r_comment = $sql_comment->num_rows;
    $totArray[$totIndex++] = [
            'r_seq'=>$review['R_SEQ'],
            'u_id'=>$review['U_ID'],
            'm_title'=>stripslashes($review['M_TITLE']),
            'r_title'=>stripslashes($review['R_TITLE']),
            'r_score'=>$review['R_SCORE'],
            'r_rec'=>$review['R_REC'],
            'r_co'=>$r_comment
    ];
}

while($review = $sql_pop_review->fetch_assoc()) {
    $r_seq = $review['R_SEQ'];
    $sql_comment = query("SELECT * FROM REVIEW_COMMENT WHERE R_SEQ='$r_seq'");
    $r_comment = $sql_comment->num_rows;
    $popArray[$popIndex++] = [
            'r_seq'=>$review['R_SEQ'],
            'u_id'=>$review['U_ID'],
            'm_title'=>stripslashes($review['M_TITLE']),
            'r_title'=>stripslashes($review['R_TITLE']),
            'r_score'=>$review['R_SCORE'],
            'r_rec'=>$review['R_REC'],
            'r_co'=>$r_comment
    ];
}
?>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>메인</title>
    <link rel="stylesheet" type="text/css" href="./css/main.css?after" />
</head>
<body>
    <div class="header">
        <form class="login" name="login_form">
            <div class="login_info">
                <?php
                if(!isset($_SESSION['user_id']) || !isset($_SESSION['user_name'])) {
                    echo "<p>로그인을 해 주세요. <a href='index.php'>로그인</a> | <a href='signin.php'>회원가입</a></p>";
                } else {
                    $user_id = $_SESSION['user_id'];
                    $user_name = $_SESSION['user_name'];
                    echo "<p><a href='user_info.php?user_id=".$user_id."'><strong>$user_name</strong></a>($user_id)님 환영합니다.";
                    echo "<a href='logout.php'>로그아웃</a></p>";
                }
                ?>
            </div>
        </form>
    </div>
    <hr />
    <div>
        <table id="movie_poster_list">
            <tbody>
            <tr>
                <td><a href="#"><img id="img_m1" src="./img/movie1.jpg" alt="movie_img1"/></a></td>
                <td><a href="#"><img id="img_m2" src="./img/movie2.jpg" alt="movie_img2"/></a></td>
                <td><a href="#"><img id="img_m3" src="./img/movie3.jpg" alt="movie_img3"/></a></td>
                <td><a href="#"><img id="img_m4" src="./img/movie4.jpg" alt="movie_img4"/></a></td>
                <td><a href="#"><img id="img_m5" src="./img/movie5.jpg" alt="movie_img5"/></a></td>
            </tr>
            <tr>
                <td><a href="#"><img id="img_m6" src="./img/movie6.jpg" alt="movie_img6"/></a></td>
                <td><a href="#"><img id="img_m7" src="./img/movie7.jpg" alt="movie_img7"/></a></td>
                <td><a href="#"><img id="img_m8" src="./img/movie8.jpg" alt="movie_img8"/></a></td>
                <td><a href="#"><img id="img_m9" src="./img/movie9.jpg" alt="movie_img9"/></a></td>
                <td><a href="#"><img id="img_m10" src="./img/movie10.jpg" alt="movie_img10"/></a></td>
            </tr>
            </tbody>
        </table>
    </div>
    <div class="review_container">
        <div class="review_tabs">
            <div id="tab001" class="clicked">
                <div id="eff1" class="eff-1"></div>
                <a href="#">인기</a>
            </div>
            <div id="tab002" class="non_clicked">
                <div id="eff2" class="eff-2"></div>
                <a href="#">전체</a>
            </div>
            <select id="option_search">
                <option>제목</option>
                <option>영화</option>
            </select>
            <input id="input_search"/>
            <button id="btn_search">검색</button>
            <div>
                <a href="review_board.php"><button>리뷰 게시판</button></a>
            </div>
        </div>
        <div class="tab_content">
            <div class="tab-1 ">
                <table class="review_list pop">
                    <thead>
                    <tr>
                        <th width="100">글 번호</th>
                        <th width="120">작성자</th>
                        <th width="200">영화 제목</th>
                        <th width="800">리뷰 제목</th>
                        <th width="50">평점</th>
                        <th width="100">추천 수</th>
                        <th width="100">댓글 수</th>
                    </tr>
                    </thead>
                    <?php
                    foreach($popArray as $arr) {
                        ?>
                        <tbody>
                        <tr>
                            <td><?php echo $arr['r_seq']; ?></td>
                            <td><?php echo $arr['u_id']; ?></td>
                            <td><?php echo $arr['m_title']; ?></td>
                            <td><a href='./review.php?r_seq=<?php echo $arr['r_seq'] ?>'><?php echo $arr['r_title']; ?></a></td>
                            <td><?php echo $arr['r_score']; ?></td>
                            <td><?php echo $arr['r_rec']; ?></td>
                            <td><?php echo $arr['r_co']; ?></td>
                        </tr>
                        </tbody>
                    <?php } ?>
                </table>
            </div>
            <div class="tab-2 hidden">
                <table class="review_list">
                    <thead>
                    <tr>
                        <th width="100">글 번호</th>
                        <th width="120">작성자</th>
                        <th width="200">영화 제목</th>
                        <th width="800">리뷰 제목</th>
                        <th width="50">평점</th>
                        <th width="100">추천 수</th>
                        <th width="100">댓글 수</th>
                    </tr>
                    </thead>
                    <?php
                    foreach($totArray as $arr) {
                        ?>
                        <tbody>
                        <tr>
                            <td><?php echo $arr['r_seq']; ?></td>
                            <td><?php echo $arr['u_id']; ?></td>
                            <td><?php echo $arr['m_title']; ?></td>
                            <td><a href='./review.php?r_seq=<?php echo $arr['r_seq'] ?>'><?php echo $arr['r_title']; ?></a></td>
                            <td><?php echo $arr['r_score']; ?></td>
                            <td><?php echo $arr['r_rec']; ?></td>
                            <td><?php echo $arr['r_co']; ?></td>
                        </tr>
                        </tbody>
                    <?php } ?>
                </table>
            </div>
        </div>
    </div>
    <div class="boundary"></div>
    <div class="chart">
        <button>종합 통계</button>
        <div class="date_line_graph">
            <h1>날짜 별 꺾은선 그래프 들어갈 자리</h1>
        </div>
        <div class="date_circle_graph">
            <input>
            <button>검색</button>
            <table>
                <thead>
                <tr>
                    <th width="50">순위</th>
                    <th width="120">단어</th>
                    <th width="100">횟수</th>
                </tr>
                </thead>
                <tbody>
                <tr>
                    <td>1</td>
                    <td>피곤해</td>
                    <td>100</td>
                </tr>
                </tbody>
            </table>
            <h1>날짜 별 원형 그래프 들어갈 자리</h1>
        </div>
    </div>
    <div class="footer">

    </div>
    <script src="./js/main.js"></script>
</body>
</html>