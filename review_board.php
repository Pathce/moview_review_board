<?php
include $_SERVER['DOCUMENT_ROOT']."./db.php";
$totArray = Array();
$popArray = Array();
$totIndex = 0;
$popIndex = 0;
if(!empty($_GET)) {
    if($_GET['option'] == '제목'){
        $sql_review = query("
            SELECT R.R_SEQ R_SEQ, R.UR_ID U_ID, R.R_SUBJECT R_TITLE, M.M_NAME M_TITLE, R.R_SCORE R_SCORE, R.R_REC R_REC
            FROM REVIEW R, MOVIE_INFO M
            WHERE R.M_SEQ = M.M_SEQ AND R.R_SUBJECT LIKE '%".$_GET['search']."%'
            ORDER BY R.R_SEQ DESC LIMIT 0, 20");
        $sql_pop_review = query("
            SELECT R.R_SEQ R_SEQ, R.UR_ID U_ID, R.R_SUBJECT R_TITLE, M.M_NAME M_TITLE, R.R_SCORE R_SCORE, R.R_REC R_REC
            FROM REVIEW R, MOVIE_INFO M
            WHERE R.M_SEQ = M.M_SEQ AND R.R_SUBJECT LIKE '%".$_GET['search']."%' AND R_REC >= 5 
            ORDER BY R_SEQ DESC LIMIT 0, 20");
    } else {
        $sql_review = query("
            SELECT R.R_SEQ R_SEQ, R.UR_ID U_ID, R.R_SUBJECT R_TITLE, M.M_NAME M_TITLE, R.R_SCORE R_SCORE, R.R_REC R_REC
            FROM REVIEW R, MOVIE_INFO M
            WHERE R.M_SEQ = M.M_SEQ AND M.M_NAME LIKE '%".$_GET['search']."%'
            ORDER BY R.R_SEQ DESC LIMIT 0, 20");
        $sql_pop_review = query("
            SELECT R.R_SEQ R_SEQ, R.UR_ID U_ID, R.R_SUBJECT R_TITLE, M.M_NAME M_TITLE, R.R_SCORE R_SCORE, R.R_REC R_REC
            FROM REVIEW R, MOVIE_INFO M
            WHERE R.M_SEQ = M.M_SEQ AND M.M_NAME LIKE '%".$_GET['search']."%' AND R_REC >= 5 
            ORDER BY R_SEQ DESC LIMIT 0, 20");
    }
} else {
    $sql_review = query("
            SELECT R.R_SEQ R_SEQ, R.UR_ID U_ID, R.R_SUBJECT R_TITLE, M.M_NAME M_TITLE, R.R_SCORE R_SCORE, R.R_REC R_REC
            FROM REVIEW R, MOVIE_INFO M
            WHERE R.M_SEQ = M.M_SEQ
            ORDER BY R.R_SEQ DESC LIMIT 0, 20");
    $sql_pop_review = query("
            SELECT R.R_SEQ R_SEQ, R.UR_ID U_ID, R.R_SUBJECT R_TITLE, M.M_NAME M_TITLE, R.R_SCORE R_SCORE, R.R_REC R_REC
            FROM REVIEW R, MOVIE_INFO M
            WHERE R.M_SEQ = M.M_SEQ AND R_REC >= 5 
            ORDER BY R_SEQ DESC LIMIT 0, 20");
}

$sql_review = query("
            SELECT R.R_SEQ R_SEQ, R.UR_ID U_ID, R.R_SUBJECT R_TITLE, M.M_NAME M_TITLE, R.R_SCORE R_SCORE, R.R_REC R_REC
            FROM REVIEW R, MOVIE_INFO M
            WHERE R.M_SEQ = M.M_SEQ AND R.R_SUBJECT LIKE '%".$_GET['search']."%'
            ORDER BY R.R_SEQ DESC LIMIT 0, 20");
$sql_pop_review = query("
            SELECT R.R_SEQ R_SEQ, R.UR_ID U_ID, R.R_SUBJECT R_TITLE, M.M_NAME M_TITLE, R.R_SCORE R_SCORE, R.R_REC R_REC
            FROM REVIEW R, MOVIE_INFO M
            WHERE R.M_SEQ = M.M_SEQ AND R.R_SUBJECT LIKE '%".$_GET['search']."%' AND R_REC >= 5 
            ORDER BY R_SEQ DESC LIMIT 0, 20");

if(!empty($sql_review)){
    while ($review = $sql_review->fetch_assoc()) {
        $r_seq = $review['R_SEQ'];
        $sql_comment = query("SELECT COUNT(*) FROM REVIEW_COMMENT WHERE R_SEQ='$r_seq'");
        $r_comment = $sql_comment->num_rows;
        $totArray[$totIndex++] = ['r_seq'=>$review['R_SEQ'],
            'u_id'=>$review['U_ID'],
            'm_title'=>$review['M_TITLE'],
            'r_title'=>$review['R_TITLE'],
            'r_score'=>$review['R_SCORE'],
            'r_rec'=>$review['R_REC'],
            'r_co'=>$r_comment];
    }
}
if(!empty($sql_pop_review)){
    while ($review = $sql_pop_review->fetch_assoc()) {
        $r_seq = $review['R_SEQ'];
        $sql_comment = query("SELECT COUNT(*) FROM REVIEW_COMMENT WHERE R_SEQ='$r_seq'");
        $r_comment = $sql_comment->num_rows;
        $popArray[$popIndex++] = ['r_seq'=>$review['R_SEQ'],
            'u_id'=>$review['U_ID'],
            'm_title'=>$review['M_TITLE'],
            'r_title'=>$review['R_TITLE'],
            'r_score'=>$review['R_SCORE'],
            'r_rec'=>$review['R_REC'],
            'r_co'=>$r_comment];
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>리뷰 게시판</title>
    <link rel="stylesheet" type="text/css" href="./css/reviewBoard.css">
</head>
<body>
    <h1>리뷰 게시판</h1>
    <div class="board">
        <select id="option_search">
            <option>제목</option>
            <option>영화</option>
        </select>
        <input id="input_search">
        <button id="btn_search">검색</button>
    </div>
    <div class="board_tabs">
        <div class="tabs">
            <button id="tab01">전체</button>
            <button id="tab02">인기</button>
        </div>
        <div class="board01 ">
            <h3>전체 리뷰</h3>
            <table>
                <thead>
                <tr>
                    <th width="70">글 번호</th>
                    <th width="120">작성자</th>
                    <th width="200">영화 제목</th>
                    <th width="500">리뷰 제목</th>
                    <th width="50">평점</th>
                    <th width="70">추천 수</th>
                    <th width="70">댓글 수</th>
                </tr>
                </thead>
                <?php
                    foreach($totArray as $arr) {
                ?>
                <tbody>
                <tr>
                    <td><?php echo $arr['r_seq'] ?></td>
                    <td><?php echo $arr['u_id'] ?></td>
                    <td><?php echo $arr['m_title'] ?></td>
                    <td><a href='./review.php?r_seq=<?php echo $arr['r_seq'] ?>'><?php echo $arr['r_title'] ?><a/></td>
                    <td><?php echo $arr['r_score'] ?></td>
                    <td><?php echo $arr['r_rec'] ?></td>
                    <td><?php echo $arr['r_co'] ?></td>
                </tr>
                </tbody>
                <?php } ?>
            </table>
        </div>
        <div class="board02 hidden">
            <h3>인기 리뷰</h3>
            <table>
                <thead>
                <tr>
                    <th width="70">글 번호</th>
                    <th width="120">작성자</th>
                    <th width="200">영화 제목</th>
                    <th width="500">리뷰 제목</th>
                    <th width="50">평점</th>
                    <th width="70">추천 수</th>
                    <th width="70">댓글 수</th>
                </tr>
                </thead>
                <?php
                foreach($popArray as $arr) {
                ?>
                <tbody>
                <tr>
                    <td><?php echo $arr['r_seq'] ?></td>
                    <td><?php echo $arr['u_id'] ?></td>
                    <td><?php echo $arr['m_title'] ?></td>
                    <td><?php echo $arr['r_title'] ?></td>
                    <td><?php echo $arr['r_score'] ?></td>
                    <td><?php echo $arr['r_rec'] ?></td>
                    <td><?php echo $arr['r_co'] ?></td>
                </tr>
                </tbody>
                <?php } ?>
            </table>
        </div>
        <a href="review_write.php"><button>리뷰 작성</button><a/>
    </div>
    <script src="./js/reviewBoard.js"></script>
</body>
</html>