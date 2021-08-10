<?php
include $_SERVER['DOCUMENT_ROOT']."./db.php";

$r_seq = $_GET['r_seq'];

$sql = query("UPDATE REVIEW
SET R_REC = R_REC + 1
WHERE R_SEQ='$r_seq'");
?>

<script type="text/javascript">alert("수정되었습니다.");</script>
<meta http-equiv="refresh" content="0 url=./review.php?r_seq=<?php echo $r_seq ?>">