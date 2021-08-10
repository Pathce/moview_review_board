<?php
include $_SERVER['DOCUMENT_ROOT']."./db.php";
session_start();

if(empty($_SESSION) || empty($_POST)) {
    echo "<script>alert('올바르지 않은 접근 입니다.')</script>";
    echo "<meta http-equiv="."refresh"." content="."0;url=review_board.php"." />";
}

$u_id = $_SESSION['user_id'];
$r_seq = $_GET['r_seq'];
$content = addslashes($_POST['content']);

$sql = query("INSERT INTO REVIEW_COMMENT(R_SEQ, R_COMMENT, UR_ID)
VALUES("."$r_seq".", '$content', '$u_id')");
?>
<meta http-equiv="refresh" content="0 url=./review.php?r_seq=<?php echo $r_seq ?>">
