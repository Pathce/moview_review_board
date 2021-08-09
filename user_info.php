<?php
include $_SERVER['DOCUMENT_ROOT']."./db.php";
session_start();

$rArray = $cArray = Array();
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
    $sql_co_cnt = query("SELECT COUNT(*) FROM REVIEW_COMMENT WHERE R_SEQ='$r_seq'");
    $r_comment = $sql_co_cnt->num_rows;
    $rArray[$rIndex++] = ['r_seq'=>$review['R_SEQ'],
        'u_id'=>$review['U_ID'],
        'm_title'=>$review['M_TITLE'],
        'r_title'=>$review['R_TITLE'],
        'r_score'=>$review['R_SCORE'],
        'r_rec'=>$review['R_REC'],
        'r_co'=>$r_comment];
}

$sql_comment = query("
SELECT C.UR_ID U_ID, DATE_FORMAT(C.CO_TIMESTAMP, '%Y-%m-%d') C_DATE, M.M_NAME M_TITLE, R.R_SUBJECT R_TITLE, C.R_COMMENT R_COMMENT
FROM REVIEW_COMMENT C, REVIEW R, MOVIE_INFO M
WHERE C.R_SEQ = R.R_SEQ AND R.M_SEQ = M.M_SEQ AND C.UR_ID='$user_id' 
ORDER BY C.R_SEQ DESC LIMIT 0, 5");
while($comment = $sql_review->fetch_assoc()) {
    $r_seq = $comment['R_SEQ'];
    $cArray[$cIndex++] = ['r_seq'=>$comment['R_SEQ'],
        'u_id'=>$comment['U_ID'],
        'c_date'=>$comment['C_DATE'],
        'm_title'=>$comment['M_TITLE'],
        'r_title'=>$comment['R_TITLE'],
        'r_comment'=>$comment['R_COMMENT']];
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>내 정보</title>
    <link rel="stylesheet" type="text/css" href="./css/userInfo.css" />
</head>
<body>
    <div>
        <fieldset>
            <legend>내 정보</legend>
            <table>
                <tr>
                    <th>ID</th>
                    <td><?php echo $user_info['U_ID'] ?></td>
                </tr>
                <tr>
                    <th>E-mail</th>
                    <td><?php echo $user_info['U_EMAIL'] ?></td>
                </tr>
                <tr>
                    <th>이름</th>
                    <td><?php echo $user_info['U_NAME'] ?></td>
                </tr>
                <tr>
                    <th>리뷰</th>
                    <td><?php echo $review_cnt ?></td>
                </tr>
                <tr>
                    <th>댓글</th>
                    <td><?php echo $comment_cnt ?></td>
                </tr>
            </table>
        </fieldset>
    </div>
    <div>
        <h2>내 리뷰</h2>
        <table>
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
                <td><?php echo $arr['r_title']; ?></td>
                <td><?php echo $arr['r_score']; ?></td>
                <td><?php echo $arr['r_rec']; ?></td>
                <td><?php echo $arr['r_co']; ?></td>
            </tr>
            </tbody>
            <?php } ?>
        </table>
    </div>
    <div>
        <h2>내 댓글</h2>
        <table>
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
                    <td><?php echo $arr['r_title']; ?></td>
                    <td><?php echo $arr['c_comment']; ?></td>
                </tr>
                </tbody>
            <?php } ?>
        </table>
    </div>
    <div>
        <h2>내 통계</h2>
        <div class="user_chart">
            <div class="chart_tabs">
                <button id="tab01">전체</button>
                <button id="tab02">리뷰</button>
                <button id="tab03">댓글</button>
            </div>
            <div class="chart_content">
                <div class="chart01 ">
                    전체 차트
                </div>
                <div class="chart02 hidden">
                    리뷰 차트
                </div>
                <div class="chart03 hidden">
                    댓글 차트
                </div>
            </div>
        </div>
    </div>
    <script src="./js/userInfo.js"></script>
</body>
</html>