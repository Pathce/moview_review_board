<?php
    include $_SERVER['DOCUMENT_ROOT']."./db.php";
    session_start();

    $rArray = $cArray = Array();
    $rIndex = $cIndex = 0;

    if(empty($_SESSION)) {
        echo "<script>alert('올바르지 않은 접근 입니다.')</script>";
        echo "<meta http-equiv="."refresh"." content="."0;url=main.php"." />";
    }

    $sql_user = query("SELECT * FROM USER_INFO WHERE UR_ID="."'".$_SESSION['user_id']."'");
    $user = $sql_user->fetch_assoc();
    $user_id = $user['UR_ID'];
    $sql_review_cnt = query("SELECT * FROM REVIEW WHERE UR_ID="."'".$user_id."'");
    $sql_comment_cnt = query("SELECT * FROM REVIEW_COMMENT WHERE UR_ID="."'".$user_id."'");
    $sql_review = query("SELECT * FROM REVIEW WHERE UR_ID="."'".$user_id."' ORDER BY R_SEQ DESC LIMIT 0, 5");
    $sql_comment = query("SELECT * FROM REVIEW_COMMENT WHERE UR_ID="."'".$user_id."' ORDER BY R_SEQ DESC LIMIT 0, 5");

    while($review = $sql_review->fetch_assoc()) {
        $sql_movie = query("SELECT M_NAME FROM MOVIE_INFO WHERE M_SEQ=" . "'" . $review['M_SEQ'] . "'");
        $m_title = $sql_movie->fetch_assoc()['M_NAME'];
        $title = $review['R_SUBJECT'];
        if (mb_strlen($title) > 30) {
            $title = str_replace($review['R_SUBJECT'], mb_substr($review['R_SUBJECT'], 0, 30,
                    'utf-8') . "...", $review['R_SUBJECT']);
        }
        $sql_r_comment = query("SELECT * FROM review_comment WHERE R_SEQ=" . "'" . $review['R_SEQ'] . "'");
        $r_comment = $sql_r_comment->num_rows;

        $rArray[$rIndex++] = ['r_seq'=>$review['R_SEQ'],
                            'm_title'=>$m_title,
                            'r_title'=>$title,
                            'r_score'=>$review['R_SCORE'],
                            'r_rec'=>$review['R_REC'],
                            'r_co'=>$r_comment];
    }

    while($comment = $sql_comment->fetch_assoc()) {
        $review = query("SELECT UR_ID, R_SUBJECT, DATE_FORMAT(R_TIMESTAMP, '%Y-%m-%d %H:%i:%s') AS R_DATE FROM REVIEW WHERE R_SEQ=" . "'" . $comment['R_SEQ'] . "'");
        $r_user = $review['UR_ID'];
        $r_date = $review['R_DATE'];
        $r_title = $review['R_SUBJECT'];
        $m_title = query("SELECT M_NAME FROM MOVIE_INFO WHERE M_SEQ=" . "'" . $comment['R_SEQ'] . "'")['M_NAME'];

        $cArray[$cIndex++] = ['u_id'=>$r_user,
                              'r_date'=>$r_date,
                              'm_title'=>$m_title,
                              'r_title'=>$r_title,
                              'c_content'=>$comment['R_COMMENT']];
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>내 정보</title>
    <link rel="stylesheet" type="text/css" href="./css/userInfo.css" />
</head>
<body>
    <div>
        <fieldset>
            <legend>내 정보</legend>
            <table>
                <tr>
                    <th>ID</th>
                    <td><?php echo $user_id ?></td>
                </tr>
                <tr>
                    <th>E-mail</th>
                    <td><?php echo $user['UR_EMAIL'] ?></td>
                </tr>
                <tr>
                    <th>이름</th>
                    <td><?php echo $user['UR_NAME'] ?></td>
                </tr>
                <tr>
                    <th>리뷰</th>
                    <td><?php echo "$sql_review_cnt->num_rows" ?></td>
                </tr>
                <tr>
                    <th>댓글</th>
                    <td><?php echo "$sql_comment_cnt->num_rows" ?></td>
                </tr>
            </table>
        </fieldset>
    </div>
    <div>
        <h2>내 리뷰</h2>
        <table>
            <thead>
                <th>글 번호</th>
                <th>영화 제목</th>
                <th>리뷰 제목</th>
                <th>평점</th>
                <th>추천 수</th>
                <th>댓글 수</th>
            </thead>
            <?php
            foreach($rArray as $arr) {
            ?>
            <tbody>
            <tr>
                <td><?php echo $arr['r_seq']; ?></td>
                <td><?php echo $arr['m_title']; ?></td>
                <td><?php echo $arr['r_title']; ?></td>
                <td><?php echo $arr['r_score']; ?></td>
                <td><?php echo $arr['r_rec']; ?></td>
                <td><?php echo $arr['r_co']; ?></td>
            </tr>
            </tbody>
            <?php } ?>
        </table>
    </div>
    <div>
        <h2>내 댓글</h2>
        <table>
            <thead>
                <th>작성자</th>
                <th>날짜</th>
                <th>영화 제목</th>
                <th>리뷰 제목</th>
                <th>댓글 내용</th>
            </thead>
            <?php
            foreach($cArray as $arr) {
                ?>
                <tbody>
                <tr>
                    <td><?php echo $arr['u_id']; ?></td>
                    <td><?php echo $arr['r_date']; ?></td>
                    <td><?php echo $arr['m_title']; ?></td>
                    <td><?php echo $arr['r_title']; ?></td>
                    <td><?php echo $arr['c_content']; ?></td>
                </tr>
                </tbody>
            <?php } ?>
        </table>
    </div>
    <div>
        <h2>내 통계</h2>
        <div class="user_chart">
            <div class="chart_tabs">
                <button id="tab01">전체</button>
                <button id="tab02">리뷰</button>
                <button id="tab03">댓글</button>
            </div>
            <div class="chart_content">
                <div class="chart01 ">
                    전체 차트
                </div>
                <div class="chart02 hidden">
                    리뷰 차트
                </div>
                <div class="chart03 hidden">
                    댓글 차트
                </div>
            </div>
        </div>
    </div>
    <script src="./js/userInfo.js"></script>
</body>
</html>