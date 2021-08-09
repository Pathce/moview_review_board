<?php
include $_SERVER['DOCUMENT_ROOT']."./db.php";
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
?>
<!DOCTYPE html>
<head>
    <meta charset="UTF-8">
    <title>영화 리뷰</title>
    <link rel="stylesheet" type="text/css" href="./css/review.css"
</head>
<body>
    <div id="review_read">
        <h2><?php echo $review['R_SUBJECT']; ?></h2>
        <h3><?php echo $movie['M_NAME']; ?></h3>
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
            <?php echo $review['R_CONTENT']; ?>
        </div>
        <div id="movie_rec">
            <button id="btn_rec">⭐추천하기</button>
        </div>
        <?php
        session_start();
        if($_SESSION && $review['UR_ID'] == $_SESSION['user_id']) {
            echo "<div id=".'edit_review'.">
                    <a href='modify.php?r_seq=";
            echo $review['R_SEQ']."'>";
            echo "<button id='btn_modify'>수정하기</button></a>";
            echo "<a href='delete.php?r_seq=".$review['R_SEQ'];
            echo "'><button id='btn_remove'>삭제하기</button></a>
                </div>";
        } else {
            echo "<div></div>";
        }
        ?>
        <div id="pre_review">
            이전 <a<?php
                    if($pre_review) {
                        echo " href='./review.php?r_seq=".$pre_review['R_SEQ']."'>".$pre_review['R_SUBJECT'];
                    } else {
                        echo ">"."게시물이 존재하지 않습니다.";
                    }
                ?></a>
        </div>
        <div id="next_review">
            다음 <a<?php
            if($next_review) {
                echo " href='./review.php?r_seq=".$next_review['R_SEQ']."'>".$next_review['R_SUBJECT'];
            } else {
                echo ">"."게시물이 존재하지 않습니다.";
            }
            ?></a>
        </div>
    </div>
</body>
</html>
