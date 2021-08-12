<?php
include $_SERVER['DOCUMENT_ROOT']."./db.php";

$r_seq = $_GET['r_seq'];
$sql_c = query("DELETE FROM REVIEW_COMMENT WHERE R_SEQ=$r_seq");
$sql = query("DELETE FROM REVIEW WHERE R_SEQ=$r_seq");
?>
<script type="text/javascript">alert("삭제되었습니다.");</script>
<meta http-equiv="refresh" content="0 url=./review_board.php" />
