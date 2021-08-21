<?php
include $_SERVER['DOCUMENT_ROOT']."./db.php";
$totArray = Array();
$totIndex = 0;
$option = "";
$search = "";

$user_id = "";
if(isset($_SESSION['user_id'])) {
    $user_id = $_SESSION['user_id'];
}

if(isset($_GET['search'])) {
    $option = $_GET['option'];
    $search = $_GET['search'];
    if($_GET['option'] == '제목'){
        $sql_review = query("
            SELECT R.R_SEQ R_SEQ, R.UR_ID U_ID, R.R_SUBJECT R_TITLE, M.M_NAME M_TITLE, R.R_SCORE R_SCORE, R.R_REC R_REC, R.R_TIMESTAMP R_TIMESTAMP
            FROM REVIEW R, MOVIE_INFO M
            WHERE R.M_SEQ = M.M_SEQ AND R.R_SUBJECT LIKE '%".$_GET['search']."%'
            ORDER BY R.R_SEQ DESC");
    } else {
        $sql_review = query("
            SELECT R.R_SEQ R_SEQ, R.UR_ID U_ID, R.R_SUBJECT R_TITLE, M.M_NAME M_TITLE, R.R_SCORE R_SCORE, R.R_REC R_REC, R.R_TIMESTAMP R_TIMESTAMP
            FROM REVIEW R, MOVIE_INFO M
            WHERE R.M_SEQ = M.M_SEQ AND M.M_NAME LIKE '%".$_GET['search']."%'
            ORDER BY R.R_SEQ DESC");
    }
} else {
    $sql_review = query("
            SELECT R.R_SEQ R_SEQ, R.UR_ID U_ID, R.R_SUBJECT R_TITLE, M.M_NAME M_TITLE, R.R_SCORE R_SCORE, R.R_REC R_REC, R.R_TIMESTAMP R_TIMESTAMP
            FROM REVIEW R, MOVIE_INFO M
            WHERE R.M_SEQ = M.M_SEQ
            ORDER BY R.R_SEQ DESC");
}

if(!empty($sql_review)){
    while ($review = $sql_review->fetch_assoc()) {
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
}

if(isset($_GET['page'])){
    $page = $_GET['page'];
} else {
    $page = 1;
}
$row_num = count($totArray);
$list = 10;
$block_cnt = 5;
$block_num = ceil($page / $block_cnt);
$block_start = (($block_num - 1) * $block_cnt) + 1;
$block_end = $block_start + $block_cnt - 1;
$tot_page = ceil($row_num / $list);
if($block_end > $tot_page) {
    $block_end = $tot_page;
}
$tot_block = ceil($tot_page / $block_cnt);
$start_num = ($page-1) * $list;
if($row_num - $start_num < $list) {
    $end_num = $row_num;
} else {
    $end_num = $start_num + $list;
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
<div class="header">
    <h4><a href="./main.php">메인</a></h4>
</div>
<div class="blank"></div>
    <div class="board01">
        <h1>리뷰 게시판</h1>
        <div class="board">
            <select id="option_search">
                <option>제목</option>
                <option>영화</option>
            </select>
            <input id="input_search">
            <button id="btn_search">검색</button>
        </div>
        <div id="table_container">
            <table id="review_table">
                <thead>
                <tr>
                    <th width="100">작성일자</th>
                    <th width="70">작성자</th>
                    <th width="160">영화 제목</th>
                    <th width="440">리뷰 제목</th>
                    <th width="80">평점</th>
                    <th width="80">추천 수</th>
                    <th width="80">댓글 수</th>
                </tr>
                </thead>
                <?php
                //            foreach($totArray as $arr) {
                for($i = $start_num; $i < $end_num; $i++){
                    $arr = $totArray[$i];
                    ?>
                    <tbody>
                    <tr <?php
                    if($user_id == $arr['u_id']) {
                        echo "id='user'";
                    }
                    ?>>
                        <td><?php echo $arr['r_timestamp'] ?></td>
                        <td><?php echo $arr['u_id'] ?></td>
                        <td><?php echo $arr['m_title'] ?></td>
                        <td id="content"><a href='./review.php?r_seq=<?php echo $arr['r_seq'] ?>'><?php echo $arr['r_title'] ?><a/></td>
                        <td><?php echo $arr['r_score'] ?></td>
                        <td><?php echo $arr['r_rec'] ?></td>
                        <td><?php echo $arr['r_co'] ?></td>
                    </tr>
                    </tbody>
                <?php } ?>
            </table>
        </div>
        <div id="page_num">
            <ul>
                <?php
                if($page <= 1){ ?>
                    <li class="'fo_re">처음</li>
                <?php } else { ?>
                    <li><a href="?option=<?php echo $option; ?>&&search=<?php echo $search; ?>&&page=1">처음</a></li>
                <?php }
                if($page <= 1){} else { ?>
                    <li><a href="?option=<?php echo $option; ?>&&search=<?php echo $search; ?>&&page=<?php echo $page-1; ?>">이전</a></li>
                <?php }
                for($i = $block_start; $i <= $block_end; $i++) {
                    if($page == $i) { ?>
                        <li class="fo_re">[<?php echo $i; ?>]</li>
                    <?php } else { ?>
                        <li><a href="?option=<?php echo $option; ?>&&search=<?php echo $search; ?>&&page=<?php echo $i; ?>">[<?php echo $i; ?>]</a></li>
                    <?php }
                }
                if($block_num >= $tot_block) {
                } else {
                    $next = $page + 1; ?>
                    <li><a href="?option=<?php echo $option; ?>&&search=<?php echo $search; ?>&&page=<?php echo $next; ?>">다음</a></li>
                <?php }
                if($page >= $tot_page) { ?>
                    <li class="fo_re">마지막</li>
                <?php } else { ?>
                    <li><a href="?option=<?php echo $option; ?>&&search=<?php echo $search; ?>&&page=<?php echo $tot_page; ?>">마지막</a></li>
                <?php }
                ?>
            </ul>
        </div>
        <div class="review_write">
            <a href="review_write.php"><button id="btn_write">리뷰 작성</button></a>
        </div>
    </div>
<script src="./js/reviewBoard.js"></script>
</body>
</html>