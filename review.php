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
    <script src="./js/review.js"></script>
</head>
<body>
    <div id="review_read">
        <h2><a href="./review_board.php">리뷰 게시판</a></h2>
        <h2><?php echo stripslashes($review['R_SUBJECT']); ?></h2>
        <h3><?php echo stripslashes($movie['M_NAME']); ?></h3>
        <div id="score">
            <?php echo $review['R_SCORE']; ?>
        </div>
        <div id="user_info">
            <?php echo "작성자 : ".$review['UR_ID']; ?>
        </div>
        <div id="write_date">
            <?php echo $r_date." "; ?>
            <?php echo $r_time; ?>
        </div>
        <div id="review_content">
            <?php echo stripslashes($review['R_CONTENT']); ?>
        </div>
        <div id="rec">
            <?php echo $review['R_REC']; ?>
        </div>
        <div id="movie_rec">
            <a href="./recommendation.php?r_seq=<?php echo $review['R_SEQ'] ?>">
                <button id="btn_rec">⭐추천하기</button>
            </a>
        </div>
        <?php
        session_start();
        if($_SESSION && $review['UR_ID'] == $_SESSION['user_id']) {
        ?>
            <div id="edit_review">
                <a href="modify.php?r_seq=<?php echo $review['R_SEQ'] ?>"><button id="btn_modify">수정하기</button></a>
                <a href="delete.php?r_seq=<?php echo $review['R_SEQ'] ?>"><button id="btn_remove">삭제하기</button></a>
        <?php
        } else {
            echo "<div></div>";
        }
        ?>
    </div>
    <div id="pre_review">
        이전 <a<?php
        if($pre_review) {
            echo " href='./review.php?r_seq=".$pre_review['R_SEQ']."'>".stripslashes($pre_review['R_SUBJECT']);
        } else {
            ?>>게시물이 존재하지 않습니다.
        <?php }
        ?></a>
    </div>
    <div id="next_review">
        다음 <a<?php
        if($next_review) {
            echo " href='./review.php?r_seq=".$next_review['R_SEQ']."'>".stripslashes($next_review['R_SUBJECT']);
        } else {
            ?>>게시물이 존재하지 않습니다.
        <?php }
        ?></a>
    </div>
    <div id="comment">
        <h3>댓글 목록</h3>
        <div id="comment_list">
            <?php
            foreach($cArray as $comment) {
                ?><div>
                <div><?php echo $comment['u_id']; ?></div>
                <div><?php echo stripslashes($comment['c_comment']); ?></div>
                <div><?php echo $comment['c_date']; ?></div>
                <?php
                if(isset($_SESSION) && $_SESSION['user_id'] == $comment['u_id']) { ?>
                <p><a href="./delete_co.php?c_seq=<?php echo $comment['c_seq'] ?>">삭제</a></p>
                <?php }?>
                </div>
                <?php
            }
            ?>
        </div>
        <div id="co_write">
            <form action="comment_ok.php?r_seq=<?php echo $r_seq ?>" method="post">
                <textarea name="content"></textarea>
                <button id="btn_c_write">작성</button>
            </form>
        </div>
    </div>
    </div>
</body>
</html>
