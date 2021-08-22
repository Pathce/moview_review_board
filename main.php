<?php include $_SERVER['DOCUMENT_ROOT']."./db.php"; ?>
<!DOCTYPE html>
<?php
session_start();

$totArray = $popArray = $dateArray = $posterArray = Array();
$popIndex = $totIndex = $dateIndex = $posterIndex = 0;

$sql_review = query("
SELECT R.R_SEQ R_SEQ, R.R_TIMESTAMP R_TIMESTAMP, R.UR_ID U_ID, R.R_SUBJECT R_TITLE, M.M_NAME M_TITLE, R.R_SCORE R_SCORE, R.R_REC R_REC
FROM REVIEW R, MOVIE_INFO M
WHERE R.M_SEQ = M.M_SEQ 
ORDER BY R.R_SEQ DESC LIMIT 0, 5");
$sql_pop_review = query("
SELECT R.R_SEQ R_SEQ, R.R_TIMESTAMP R_TIMESTAMP, R.UR_ID U_ID, R.R_SUBJECT R_TITLE, M.M_NAME M_TITLE, R.R_SCORE R_SCORE, R.R_REC R_REC
FROM REVIEW R, MOVIE_INFO M
WHERE R.M_SEQ = M.M_SEQ AND R_REC >= 5 
ORDER BY R_SEQ DESC LIMIT 0, 5");
$sql_date_chart = query("
SELECT DATE_FORMAT(R.R_TIMESTAMP, '%Y-%m-%d') R_DATE, GI.G_NAME G_NAME, COUNT(GI.G_NAME) CNT
FROM GENRE_LIST GL, GENRE_INFO GI, MOVIE_INFO M, REVIEW R
WHERE GL.G_SEQ = GI.G_SEQ AND GL.M_SEQ = M.M_SEQ AND R.M_SEQ = M.M_SEQ
GROUP BY G_NAME, R_DATE 
ORDER BY G_NAME, R_DATE DESC");
$sql_poster = query("
SELECT *
FROM MOVIE_POSTER");

while($review = $sql_review->fetch_assoc()) {
    $r_seq = $review['R_SEQ'];
    $sql_comment = query("SELECT * FROM REVIEW_COMMENT WHERE R_SEQ='$r_seq'");
    $r_comment = $sql_comment->num_rows;
    $totArray[$totIndex++] = [
            'r_seq'=>$review['R_SEQ'],
            'r_timestamp'=>$review['R_TIMESTAMP'],
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
            'r_timestamp'=>$review['R_TIMESTAMP'],
            'u_id'=>$review['U_ID'],
            'm_title'=>stripslashes($review['M_TITLE']),
            'r_title'=>stripslashes($review['R_TITLE']),
            'r_score'=>$review['R_SCORE'],
            'r_rec'=>$review['R_REC'],
            'r_co'=>$r_comment
    ];
}
while($result = $sql_date_chart->fetch_assoc()) {
    $dateArray[$dateIndex++] = [
            "genre"=>$result['G_NAME'],
            "date"=>$result['R_DATE'],
            "cnt"=>$result['CNT']
    ];
}
while($result = $sql_poster->fetch_assoc()) {
    $posterArray[$posterIndex++] = [
            "movie_name"=>$result['movie_name'],
            "poster_url"=>$result['poster_url']
    ];
}
$json_date_data = json_encode($dateArray, JSON_UNESCAPED_UNICODE);
?>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>메인</title>
    <script src="https://d3js.org/d3.v7.min.js"></script>
    <script src="https://code.highcharts.com/highcharts.js"></script>
    <link rel="stylesheet" type="text/css" href="./css/main.css?after" />
</head>
<body>
    <div class="header">
        <form class="login" name="login_form">
            <div class="login_info">
                <p id="title">Movie Review</p>
                <?php
                if(!isset($_SESSION['user_id']) || !isset($_SESSION['user_name'])) {
                    echo "<p class='user_login'>로그인을 해 주세요. <a href='index.php'>로그인</a> | <a href='signin.php'>회원가입</a></p>";
                } else {
                    $user_id = $_SESSION['user_id'];
                    $user_name = $_SESSION['user_name'];
                    echo "<p class='user_login'><a href='user_info.php?user_id=".$user_id."'>$user_name</a>($user_id)님 환영합니다. ";
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
            <tr><td><h2>상영중 영화 포스터</h2></td></tr>
            <tr>
                <td><a href="#"><img id="img_m1" src="<?php echo $posterArray[0]['poster_url'] ?>" alt="<?php echo $posterArray[0]['movie_name'] ?>"/></a></td>
                <td><a href="#"><img id="img_m2" src="<?php echo $posterArray[1]['poster_url'] ?>" alt="<?php echo $posterArray[1]['movie_name'] ?>"/></a></td>
                <td><a href="#"><img id="img_m3" src="<?php echo $posterArray[2]['poster_url'] ?>" alt="<?php echo $posterArray[2]['movie_name'] ?>"/></a></td>
                <td><a href="#"><img id="img_m4" src="<?php echo $posterArray[3]['poster_url'] ?>" alt="<?php echo $posterArray[3]['movie_name'] ?>"/></a></td>
                <td><a href="#"><img id="img_m5" src="<?php echo $posterArray[4]['poster_url'] ?>" alt="<?php echo $posterArray[4]['movie_name'] ?>"/></a></td>
            </tr>
            <tr>
                <td><a href="#"><img id="img_m6" src="<?php echo $posterArray[5]['poster_url'] ?>" alt="<?php echo $posterArray[5]['movie_name'] ?>"/></a></td>
                <td><a href="#"><img id="img_m7" src="<?php echo $posterArray[6]['poster_url'] ?>" alt="<?php echo $posterArray[6]['movie_name'] ?>"/></a></td>
                <td><a href="#"><img id="img_m8" src="<?php echo $posterArray[7]['poster_url'] ?>" alt="<?php echo $posterArray[7]['movie_name'] ?>"/></a></td>
                <td><a href="#"><img id="img_m9" src="<?php echo $posterArray[8]['poster_url'] ?>" alt="<?php echo $posterArray[8]['movie_name'] ?>"/></a></td>
                <td><a href="#"><img id="img_m10" src="<?php echo $posterArray[9]['poster_url'] ?>" alt="<?php echo $posterArray[9]['movie_name'] ?>"/></a></td>
            </tr>
            </tbody>
        </table>
    </div>
    <div class="review_container">
        <div class="review_tabs">
            <div><h2>최근 리뷰</h2></div>
            <div id="tab001" class="clicked">
                <div id="eff1" class="eff-1"></div>
                <a>인기</a>
            </div>
            <div id="tab002" class="non_clicked">
                <div id="eff2" class="eff-2"></div>
                <a>전체</a>
            </div>
            <select id="option_search">
                <option>제목</option>
                <option>영화</option>
            </select>
            <input id="input_search" placeholder="검색어 입력"/>
            <button id="btn_search">검색</button>
            <a href="review_board.php"><button id="btn_review_board">리뷰 게시판</button></a>
        </div>
        <div class="tab_content">
            <div class="tab-1 ">
                <table class="review_list pop">
                    <thead>
                    <tr>
                        <th width="200">작성일시</th>
                        <th width="150">작성자</th>
                        <th width="280">영화 제목</th>
                        <th width="800">리뷰 제목</th>
                        <th width="100">평점</th>
                        <th width="150">추천 수</th>
                        <th width="150">댓글 수</th>
                    </tr>
                    </thead>
                    <?php
                    foreach($popArray as $arr) {
                        ?>
                        <tbody>
                        <tr>
                            <td><?php echo $arr['r_timestamp']; ?></td>
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
                        <th width="200">작성일시</th>
                        <th width="150">작성자</th>
                        <th width="280">영화 제목</th>
                        <th width="800">리뷰 제목</th>
                        <th width="100">평점</th>
                        <th width="150">추천 수</th>
                        <th width="150">댓글 수</th>
                    </tr>
                    </thead>
                    <?php
                    foreach($totArray as $arr) {
                        ?>
                        <tbody>
                        <tr>
                            <td><?php echo $arr['r_timestamp']; ?></td>
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
        <a href="stat.php"><button id="btn_tot_chart">종합 통계</button></a>
        <div class="date_line_graph">
            <h1>장르별 리뷰 수</h1>
            <div id="review_date_chart"></div>
        </div>
    </div>
    <div class="footer">

    </div>
    <div id="date_data" class="hidden"><?php echo $json_date_data; ?></div>
    <script src="./js/main.js"></script>
    <script src="./js/chart/mainChart.js"></script>
</body>
</html>