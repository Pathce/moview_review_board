<?php
include $_SERVER['DOCUMENT_ROOT']."./db.php";

$c_seq = $_GET['c_seq'];

$sql = query("DELETE FROM REVIEW_COMMENT WHERE CO_SEQ=".$c_seq);

?>
<script type="text/javascript">history.back();</script>