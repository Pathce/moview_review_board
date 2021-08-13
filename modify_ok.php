<?php
include $_SERVER['DOCUMENT_ROOT']."./db.php";

$r_seq = $_GET['r_seq'];
$r_title = addslashes($_POST['r_title']);
$m_title = addslashes($_POST['m_title']);
$r_score = $_POST['r_score'];
$r_content = addslashes($_POST['contents']);

$sql_movie = query("SELECT M_SEQ FROM MOVIE_INFO WHERE M_NAME='$m_title'");
$m_seq = $sql_movie->fetch_assoc()['M_SEQ'];

$sql_review = query("UPDATE REVIEW 
SET M_SEQ="."$m_seq".", R_SUBJECT='$r_title', R_CONTENT='$r_content', R_SCORE=".$r_score."
WHERE R_SEQ="."$r_seq");
?>

<script type="text/javascript">alert("수정되었습니다.");</script>
<meta http-equiv="refresh" content="0 url=./review.php?r_seq=<?php echo $r_seq ?>">
