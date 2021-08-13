<?php
include $_SERVER['DOCUMENT_ROOT']."./db.php";
session_start();
$r_seq = $_GET['r_seq'];
$cur_seq = (int)$r_seq;
$r_sql = query("SELECT * FROM review WHERE R_SEQ='".$r_seq."'");
$review = $r_sql->fetch_assoc();
$r_date = query("SELECT DATE_FORMAT(R_TIMESTAMP, '%Y-%m-%d') AS DATE FROM review");
$r_date = $r_date->fetch_assoc()['DATE'];
$r_time = query("SELECT DATE_FORMAT(R_TIMESTAMP, '%h:%i:%s') AS TIME FROM review");
$r_time = $r_time->fetch_assoc()['TIME'];

$m_seq = $review['M_SEQ'];
$m_sql = query("SELECT M_NAME FROM movie_info WHERE M_SEQ='".$m_seq."'");
$movie = $m_sql->fetch_assoc();

$pre_seq = (string)($cur_seq - 1);
$next_seq = (string)($cur_seq + 1);
$pre_sql = query("SELECT * FROM review WHERE R_SEQ='".$pre_seq."'");
$pre_review = $pre_sql->fetch_assoc();
$next_sql = query("SELECT * FROM review WHERE R_SEQ='".$next_seq."'");
$next_review = $next_sql->fetch_assoc();

$sql_comment = query("SELECT * FROM REVIEW_COMMENT WHERE R_SEQ=$r_seq");
$cArray = Array();
$cIndex = 0;

if(!empty($sql_comment)) {
    while($comment = $sql_comment->fetch_assoc()) {
        $cArray[$cIndex++] = [
                "u_id"=>$comment['UR_ID'],
                "c_date"=>$comment['CO_TIMESTAMP'],
                "c_comment"=>$comment['R_COMMENT'],
                "c_seq"=>$comment['CO_SEQ']
        ];
    }
}
?>
<!DOCTYPE html>
<head>
    <meta charset="UTF-8">
    <title>영화 리뷰</title>
    <link rel="stylesheet" type="text/css" href="./css/review.css">
    <script src="https://code.jquery.com/jquery-3.6.0.js"
            integrity="sha256-H+K7U5CnXl1h5ywQfKtSj8PCmoN9aaq30gDh27Xc0jk="
            crossorigin="anonymous"></script>
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"
            integrity="sha256-T0Vest3yCU7pafRw9r+settMBX6JkKN06dqBnpQ8d30="
            crossorigin="anonymous"></script>
</head>
<body>
<div class="header">
    <h4><a href="./main.php">메인</a></h4>
</div>
<div class="blank"></div>
    <div id="review_read">
        <h2><a href="./review_board.php">리뷰 게시판</a></h2>
        <table>
            <thead>
            <td id="review_title">
                <?php echo $review['R_SUBJECT']; ?>
            </td>
            </thead>
            <tbody>
            <tr>
                <td id="movie_title"><?php echo $movie['M_NAME']; ?></td>
            </tr>
            <tr>
                <td id="score"><?php echo $review['R_SCORE']; ?></td>
            </tr>
            <tr>
                <td id="user_info"><?php echo "작성자 : ".$review['UR_ID']; ?></td>
            </tr>
            <tr>
                <td id="write_date">
                    <?php echo $r_date." "; ?>
                    <?php echo $r_time; ?>
                </td>
            </tr>
            <tr>
                <td id="review_content"><?php echo ($review['R_CONTENT']); ?></td>
            </tr>
            </tbody>
        </table>
        <div id="movie_rec">
            <a href="./recommendation.php?r_seq=<?php echo $review['R_SEQ'] ?>">
                <button id="btn_rec">⭐ <?php echo $review['R_REC']; ?></button>
            </a>
        </div>
        <div id="edit_review">
        <?php
        session_start();
        if($_SESSION && $review['UR_ID'] == $_SESSION['user_id']) {
        ?>
                <a href="modify.php?r_seq=<?php echo $review['R_SEQ'] ?>"><button id="btn_modify">수정하기</button></a>
                <a><button id="btn_remove">삭제하기</button></a>
        <?php } ?>
        </div>
        <div id="review_etc">
            <div id="pre_review">
                이전 <a<?php
                if($pre_review) {
                    echo " href='./review.php?r_seq=".$pre_review['R_SEQ']."'>".$pre_review['R_SUBJECT'];
                } else {
                ?>>게시물이 존재하지 않습니다.
                    <?php }
                    ?></a>
            </div>
            <div id="next_review">
                다음 <a<?php
                if($next_review) {
                    echo " href='./review.php?r_seq=".$next_review['R_SEQ']."'>".$next_review['R_SUBJECT'];
                } else {
                ?>>게시물이 존재하지 않습니다.
                    <?php }
                    ?></a>
            </div>
        </div>
    <div id="comment">
        <h3>댓글</h3>
        <div id="co_write">
            <form action="comment_ok.php?r_seq=<?php echo $r_seq ?>" method="post">
                <textarea name="content"></textarea>
                <button id="btn_c_write">작성</button>
            </form>
        </div>
        <div id="comment_list">
            <?php
            foreach($cArray as $comment) {
                ?><div id="co">
                <div id="co_id"><?php echo $comment['u_id']; ?></div>
                <div id="co_content"><?php echo $comment['c_comment']; ?></div>
                <div id="co_date"><?php echo $comment['c_date']; ?></div>
                <?php
                if(isset($_SESSION) && $_SESSION['user_id'] == $comment['u_id']) { ?>
                    <a href="./delete_co.php?c_seq=<?php echo $comment['c_seq'] ?>"><p id="co_delete">삭제</p></a>
                <?php }?>
                </div>
                <?php
            }
            ?>
        </div>
    </div>
    </div>
<div id="r_seq_value" class="hidden"><?php echo $review['R_SEQ'] ?></div>
</body>
<script src="./js/review.js"></script>
</html>
