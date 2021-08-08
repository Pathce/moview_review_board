<?php
    include $_SERVER['DOCUMENT_ROOT']."./db.php";
    $uid = $_GET['userid'];
    $sql = query("SELECT * FROM USER_INFO WHERE UR_ID='".$uid."'");
    $member = $sql->fetch_array();
    if ($member == 0) {
?>
    <div style="font-family: 'malgun gothic'";>
        <?php echo $uid; ?>는 사용 가능한 ID 입니다.
    </div>
    <?php
    } else {
    ?>
    <div style="font-family: 'malgun gothic'; color: red;">
        <?php echo $uid; ?> 중복된 ID 입니다.
    </div>
<?php
    }
?>
    <button value="닫기" onclick="window.close()">닫기</button>
<script></script>
