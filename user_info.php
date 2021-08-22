<?php
include $_SERVER['DOCUMENT_ROOT']."./db.php";
session_start();

$rArray = $cArray = $crArray = $ccArray = Array();
$rIndex = $cIndex = 0;

$user_id = $_SESSION['user_id'];

if(empty($_SESSION)) {
    echo "<script>alert('올바르지 않은 접근 입니다.')</script>";
    echo "<meta http-equiv="."refresh"." content="."0;url=main.php"." />";
}

$sql_user = query("
SELECT UR_ID U_ID, UR_EMAIL U_EMAIL, UR_NAME U_NAME
FROM USER_INFO 
WHERE UR_ID = '$user_id'");
$user_info = $sql_user->fetch_assoc();

$sql_comment_cnt = query("SELECT COUNT(*) CNT FROM REVIEW_COMMENT WHERE UR_ID='$user_id'");
$comment_cnt = $sql_comment_cnt->fetch_assoc()['CNT'];

$sql_review_cnt = query("SELECT COUNT(*) CNT FROM REVIEW WHERE UR_ID='$user_id'");
$review_cnt = $sql_review_cnt->fetch_assoc()['CNT'];

$sql_review = query("
SELECT R.R_SEQ R_SEQ, R.UR_ID U_ID, R.R_SUBJECT R_TITLE, M.M_NAME M_TITLE, R.R_SCORE R_SCORE, R.R_REC R_REC
FROM REVIEW R, MOVIE_INFO M
WHERE R.M_SEQ = M.M_SEQ AND R.UR_ID='$user_id' 
ORDER BY R.R_SEQ DESC LIMIT 0, 5");
while($review = $sql_review->fetch_assoc()) {
    $r_seq = $review['R_SEQ'];
    $sql_co_cnt = query("SELECT * FROM REVIEW_COMMENT WHERE R_SEQ='$r_seq'");
    $r_comment = $sql_co_cnt->num_rows;
    $rArray[$rIndex++] = ['r_seq'=>$review['R_SEQ'],
        'u_id'=>$review['U_ID'],
        'm_title'=>stripslashes($review['M_TITLE']),
        'r_title'=>stripslashes($review['R_TITLE']),
        'r_score'=>$review['R_SCORE'],
        'r_rec'=>$review['R_REC'],
        'r_co'=>$r_comment];
}

$sql_comment = query("
SELECT C.UR_ID U_ID, DATE_FORMAT(C.CO_TIMESTAMP, '%Y-%m-%d') C_DATE, M.M_NAME M_TITLE, R.R_SUBJECT R_TITLE, C.R_COMMENT R_COMMENT, C.R_SEQ R_SEQ
FROM REVIEW_COMMENT C, REVIEW R, MOVIE_INFO M
WHERE C.R_SEQ = R.R_SEQ AND R.M_SEQ = M.M_SEQ AND C.UR_ID='$user_id' 
ORDER BY C.R_SEQ DESC LIMIT 0, 5");
while($comment = $sql_comment->fetch_assoc()) {
    $cArray[$cIndex++] = [
        'u_id'=>$comment['U_ID'],
        'c_date'=>$comment['C_DATE'],
        'm_title'=>stripslashes($comment['M_TITLE']),
        'r_title'=>stripslashes($comment['R_TITLE']),
        'r_comment'=>stripslashes($comment['R_COMMENT']),
        'r_seq'=>$comment['R_SEQ']];
}

$sql_r_chart = query("SELECT R.UR_ID U_ID, GI.G_NAME GENRE, COUNT(GI.G_NAME) CNT
FROM GENRE_LIST GL, GENRE_INFO GI, MOVIE_INFO M, REVIEW R
WHERE GL.G_SEQ = GI.G_SEQ AND GL.M_SEQ = M.M_SEQ AND R.M_SEQ = M.M_SEQ AND R.UR_ID='$user_id'
GROUP BY R.UR_ID, GI.G_NAME
ORDER BY CNT DESC");
while($result = $sql_r_chart->fetch_assoc()) {
    $crArray[$result['GENRE']] = [$result['CNT']];
}

$sql_c_chart = query("SELECT C.UR_ID U_ID, GI.G_NAME GENRE, COUNT(GI.G_NAME) CNT
FROM GENRE_LIST GL, GENRE_INFO GI, MOVIE_INFO M, REVIEW R, REVIEW_COMMENT C
WHERE GL.G_SEQ = GI.G_SEQ AND GL.M_SEQ = M.M_SEQ AND R.M_SEQ = M.M_SEQ AND R.R_SEQ = C.R_SEQ AND C.UR_ID='$user_id'
GROUP BY GI.G_NAME
ORDER BY CNT DESC");
while($result = $sql_c_chart->fetch_assoc()) {
    $ccArray[$result['GENRE']] = [$result['CNT']];
}

$jsonRArr = json_encode($crArray, JSON_UNESCAPED_UNICODE);
$jsonCArr = json_encode($ccArray, JSON_UNESCAPED_UNICODE);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>내 정보</title>
    <script src="https://d3js.org/d3.v7.min.js"></script>
    <script src="https://code.highcharts.com/highcharts.js"></script>
    <script src="https://code.highcharts.com/modules/exporting.js"></script>
    <script src="https://code.highcharts.com/modules/export-data.js"></script>
    <script src="https://code.highcharts.com/modules/accessibility.js"></script>
    <link rel="stylesheet" type="text/css" href="./css/userInfo.css" />
</head>
<body>
<div class="header">
    <h4><a href="./main.php">메인</a></h4>
</div>
<div class="blank"></div>
    <div>
        <table id="user_table">
            <tr>
                <th id="th_id">ID</th>
                <td id="th_id"><?php echo $user_info['U_ID'] ?></td>
            </tr>
            <tr>
                <th id="th_email">E-mail</th>
                <td id="th_email"><?php echo $user_info['U_EMAIL'] ?></td>
            </tr>
            <tr>
                <th id="th_name">이름</th>
                <td id="th_name"><?php echo $user_info['U_NAME'] ?></td>
            </tr>
            <tr>
                <th id="th_review">리뷰</th>
                <td id="th_review"><?php echo $review_cnt ?></td>
            </tr>
            <tr>
                <th id="th_co">댓글</th>
                <td id="th_co"><?php echo $comment_cnt ?></td>
            </tr>
        </table>
    </div>
    <div class="user_review">
        <h2>내 리뷰</h2>
        <table id="review_table">
            <thead>
                <th>글 번호</th>
                <th>영화 제목</th>
                <th>리뷰 제목</th>
                <th>평점</th>
                <th>추천 수</th>
                <th>댓글 수</th>
            </thead>
            <?php
            foreach($rArray as $arr) {
            ?>
            <tbody>
            <tr>
                <td><?php echo $arr['r_seq']; ?></td>
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
    <div class="user_comment">
        <h2>내 댓글</h2>
        <table id="comment_table">
            <thead>
                <th>작성자</th>
                <th>날짜</th>
                <th>영화 제목</th>
                <th>리뷰 제목</th>
                <th>댓글 내용</th>
            </thead>
            <?php
            foreach($cArray as $arr) {
                ?>
                <tbody>
                <tr>
                    <td><?php echo $arr['u_id']; ?></td>
                    <td><?php echo $arr['c_date']; ?></td>
                    <td><?php echo $arr['m_title']; ?></td>
                    <td><a href='./review.php?r_seq=<?php echo $arr['r_seq'] ?>'><?php echo $arr['r_title']; ?></a></td>
                    <td><?php echo $arr['r_comment']; ?></td>
                </tr>
                </tbody>
            <?php } ?>
        </table>
    </div>
    <div class="user_chart">
        <h2>내 통계</h2>
            <div class="chart_tabs">
                <button id="tab02">리뷰</button>
                <button id="tab03">댓글</button>
            </div>
            <div class="chart_content">
                <div class="chart02">
                    <h3>장르별 리뷰 순위</h3>
                    <svg id="reviewChart" width="800" height="400"></svg>
                </div>
                <div class="chart03 hidden">
                    <h3>장르별 댓글 순위</h3>
                    <svg id="commentChart" width="800" height="400"></svg>
                </div>
            </div>
        </div>
    <div id="comment_data" class="hidden"><?php echo $jsonCArr; ?></div>
    <div id="review_data" class="hidden"><?php echo $jsonRArr; ?></div>
    <script src="./js/userInfo.js"></script>
    <script src="./js/chart/userInfo_totChart.js"></script>
</body>
</html>