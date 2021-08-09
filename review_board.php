<?php
include $_SERVER['DOCUMENT_ROOT']."./db.php";
$totArray = Array();
$popArray = Array();
$totIndex = 0;
$popIndex = 0;
if(!empty($_GET)) {
    if($_GET['option'] == '제목'){
        $sql_review = query("SELECT * FROM review WHERE R_SUBJECT LIKE '%".$_GET['search']."%' order by R_SEQ desc limit 0, 5");
        $sql_pop_review = query("SELECT * FROM review WHERE R_SUBJECT LIKE '%".$_GET['search']."%' AND R_REC>=5 order by R_SEQ desc limit 0, 5");
    } else {
        $sql_movie = query("SELECT M_SEQ FROM MOVIE_INFO WHERE M_NAME LIKE "."'%".$_GET['search']."%'");
        $search_seq = '(';
        while($result = $sql_movie->fetch_assoc()) {
            $search_seq = $search_seq."".$result['M_SEQ'].", ";
        }
        $search_seq = substr($search_seq, 0, -2).")";
        $sql_review = query("SELECT * FROM review WHERE M_SEQ IN ".$search_seq." order by R_SEQ desc limit 0, 5");
        $sql_pop_review = query("SELECT * FROM review WHERE M_SEQ IN ".$search_seq." AND R_REC>=5 order by R_SEQ desc limit 0, 5");
    }
} else {
    $sql_review = query("SELECT * FROM review order by R_SEQ desc limit 0, 5");
    $sql_pop_review = query("SELECT * FROM review WHERE R_REC>=5 order by R_SEQ desc limit 0, 5");
}
while($result = $sql_review->fetch_assoc()) {
    $title = $result['R_SUBJECT'];
    if(strlen($title) > 30) {
        $title = str_replace($result['R_SUBJECT'], mb_substr($result['R_SUBJECT'], 0, 30,
                'utf-8')."...", $result['R_SUBJECT']);
    }
    $sql_movie = query("SELECT M_NAME FROM MOVIE_INFO WHERE M_SEQ="."'".$result['M_SEQ']."'");
    $m_title = $sql_movie->fetch_assoc()['M_NAME'];
    $sql_co = query("SELECT * FROM review_comment WHERE R_SEQ="."'".$result['R_SEQ']."'");
    $comment = $sql_co->num_rows;
    $totArray[$totIndex++] = ['r_seq'=>$result['R_SEQ'],
                            'u_id'=>$result['UR_ID'],
                            'm_title'=>$m_title,
                            'r_title'=>$title,
                            'r_score'=>$result['R_SCORE'],
                            'r_rec'=>$result['R_REC'],
                            'r_co'=>$comment];
}
while($result = $sql_pop_review->fetch_assoc()) {
    $title = $result['R_SUBJECT'];
    if(strlen($title) > 30) {
        $title = str_replace($result['R_SUBJECT'], mb_substr($result['R_SUBJECT'], 0, 30,
                'utf-8')."...", $result['R_SUBJECT']);
    }
    $sql_movie = query("SELECT M_NAME FROM MOVIE_INFO WHERE M_SEQ="."'".$result['M_SEQ']."'");
    $m_title = $sql_movie->fetch_assoc()['M_NAME'];
    $sql_co = query("SELECT * FROM review_comment WHERE R_SEQ="."'".$result['R_SEQ']."'");
    $comment = $sql_co->num_rows;
    $popArray[$popIndex++] = ['r_seq'=>$result['R_SEQ'],
                            'u_id'=>$result['UR_ID'],
                            'm_title'=>$m_title,
                            'r_title'=>$title,
                            'r_score'=>$result['R_SCORE'],
                            'r_rec'=>$result['R_REC'],
                            'r_co'=>$comment];
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>리뷰 게시판</title>
    <link rel="stylesheet" type="text/css" href="./css/reviewBoard.css">
</head>
<body>
    <h1>리뷰 게시판</h1>
    <div class="board">
        <select id="option_search">
            <option>제목</option>
            <option>영화</option>
        </select>
        <input id="input_search">
        <button id="btn_search">검색</button>
    </div>
    <div class="board_tabs">
        <div class="tabs">
            <button id="tab01">전체</button>
            <button id="tab02">인기</button>
        </div>
        <div class="board01 ">
            <h3>전체 리뷰</h3>
            <table>
                <thead>
                <tr>
                    <th width="70">글 번호</th>
                    <th width="120">작성자</th>
                    <th width="200">영화 제목</th>
                    <th width="500">리뷰 제목</th>
                    <th width="50">평점</th>
                    <th width="70">추천 수</th>
                    <th width="70">댓글 수</th>
                </tr>
                </thead>
                <?php
                    foreach($totArray as $arr) {
                ?>
                <tbody>
                <tr>
                    <td><?php echo $arr['r_seq'] ?></td>
                    <td><?php echo $arr['u_id'] ?></td>
                    <td><?php echo $arr['m_title'] ?></td>
                    <td><?php echo $arr['r_title'] ?></td>
                    <td><?php echo $arr['r_score'] ?></td>
                    <td><?php echo $arr['r_rec'] ?></td>
                    <td><?php echo $arr['r_co'] ?></td>
                </tr>
                </tbody>
                <?php } ?>
            </table>
        </div>
        <div class="board02 hidden">
            <h3>인기 리뷰</h3>
            <table>
                <thead>
                <tr>
                    <th width="70">글 번호</th>
                    <th width="120">작성자</th>
                    <th width="200">영화 제목</th>
                    <th width="500">리뷰 제목</th>
                    <th width="50">평점</th>
                    <th width="70">추천 수</th>
                    <th width="70">댓글 수</th>
                </tr>
                </thead>
                <?php
                foreach($popArray as $arr) {
                ?>
                <tbody>
                <tr>
                    <td><?php echo $arr['r_seq'] ?></td>
                    <td><?php echo $arr['u_id'] ?></td>
                    <td><?php echo $arr['m_title'] ?></td>
                    <td><?php echo $arr['r_title'] ?></td>
                    <td><?php echo $arr['r_score'] ?></td>
                    <td><?php echo $arr['r_rec'] ?></td>
                    <td><?php echo $arr['r_co'] ?></td>
                </tr>
                </tbody>
                <?php } ?>
            </table>
        </div>
        <button>리뷰 작성</button>
    </div>
    <script src="./js/reviewBoard.js"></script>
</body>
</html>