<?php
include $_SERVER['DOCUMENT_ROOT']."./db.php";
session_start();

if(empty($_SESSION)) {
    echo "<script>alert('올바르지 않은 접근 입니다.')</script>";
    echo "<meta http-equiv="."refresh"." content="."0;url=main.php"." />";
}

$u_id = $_SESSION['user_id'];
$r_title = $_POST['r_title'];
$m_title = $_POST['m_title'];
$r_score = $_POST['r_score'];
$r_content = $_POST['r_content'];

$sql = query("SELECT * FROM MOVIE_INFO WHERE M_NAME="."'".$m_title."'");
if($sql->num_rows) {
    $m_seq = $sql->fetch_assoc()['M_SEQ'];
    $sql = query("INSERT INTO REVIEW(M_SEQ, R_SUBJECT, R_CONTENT, UR_ID, R_SCORE, R_REC) 
VALUES(".$m_seq.", "."'".$r_title."', "."'".$r_content."', "."'".$u_id."', ".$r_score.", "."0)");
    echo "<script>
    alert('리뷰가 등록되었습니다.');
    location.href='./review_board.php';
    </script>";
} else {
    echo "<script>
    alert('Error');
    history.back();
    </script>";
}