<?php include $_SERVER['DOCUMENT_ROOT']."./db.php"; ?>
<!DOCTYPE html>
<head>
    <meta charset="UTF-8">
    <title>영화 리뷰</title>
    <link rel="stylesheet" type="text/css" href="./css/review.css"
</head>
<body>
    <?php
        $r_seq = $_GET['r_seq'];
        $cur_seq = (int)$r_seq;
        $r_sql = query("SELECT * FROM review WHERE R_SEQ='".$r_seq."'");
        $review = $r_sql->fetch_array();

        $m_seq = $review['M_SEQ'];
        $m_sql = query("SELECT M_NAME FROM movie_info WHERE M_SEQ='".$m_seq."'");
        $movie = $m_sql->fetch_array();

        $pre_seq = (string)($cur_seq - 1);
        $next_seq = (string)($cur_seq + 1);
        $pre_sql = query("SELECT * FROM review WHERE R_SEQ='".$pre_seq."'");
        $pre_review = $pre_sql->fetch_array();
        $next_sql = query("SELECT * FROM review WHERE R_SEQ='".$next_seq."'");
        $next_review = $next_sql->fetch_array();
    ?>
    <div id="review_read">
        <h2><?php echo $review['R_SUBJECT']; ?></h2>
        <h3><?php echo $movie['M_NAME']; ?></h3>
        <div id="score">
            <?php echo $review['R_SCORE']; ?>
        </div>
        <div id="user_info">
            <?php echo $review['UR_ID']; ?>
            <?php echo $review['R_TIMESTAMP']; ?>
        </div>
        <div id="review_content">
            <?php echo $review['R_CONTENT']; ?>
        </div>
        <div id="edit_review">
            <button>수정하기</button>
            <button>삭제하기</button>
        </div>
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
