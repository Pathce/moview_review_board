<?php
include $_SERVER['DOCUMENT_ROOT']."./db.php";

$mrank_array = $dateArray = Array();
$mrank_index = $dateIndex = 0;

$sql_avg = query("
SELECT M.M_NAME TITLE, AVG(R.R_SCORE) R_AVG
FROM REVIEW R, MOVIE_INFO M
WHERE R.M_SEQ = M.M_SEQ
GROUP BY M.M_NAME
ORDER BY R_AVG DESC;");
$sql_date_chart = query("
SELECT DATE_FORMAT(R.R_TIMESTAMP, '%Y-%m-%d') R_DATE, GI.G_NAME G_NAME, COUNT(GI.G_NAME) CNT
FROM GENRE_LIST GL, GENRE_INFO GI, MOVIE_INFO M, REVIEW R
WHERE GL.G_SEQ = GI.G_SEQ AND GL.M_SEQ = M.M_SEQ AND R.M_SEQ = M.M_SEQ
GROUP BY G_NAME, R_DATE 
ORDER BY G_NAME, R_DATE DESC");

while($result = $sql_avg->fetch_assoc()) {
    $mrank_array[$mrank_index++] = [
            'title'=>$result['TITLE'],
            'r_avg'=>$result['R_AVG']
    ];
}
while($result = $sql_date_chart->fetch_assoc()) {
    $dateArray[$dateIndex++] = [
        "genre"=>$result['G_NAME'],
        "date"=>$result['R_DATE'],
        "cnt"=>$result['CNT']
    ];
}
//
//foreach($dateArray as $result) {
//    print_r($result);
//    echo "<br>";
//}

$json_mrank = json_encode($mrank_array, JSON_UNESCAPED_UNICODE);
?>
<!DOCTYPE html>
<head>
    <meta charset="UTF-8">
    <script src="https://d3js.org/d3.v7.min.js"></script>
    <script src="https://code.highcharts.com/highcharts.js"></script>
    <link rel="stylesheet" href="./css/stat.css">
    <title>통계</title>
</head>
<body>
<div class="header">
    <h4><a href="./main.php">메인</a></h4>
</div>
<div class="blank"></div>
<h1>종합 통계</h1>
    <table id="movie_poster_list">
        <td><a href="#"><img id="img_m1" src="./img/movie1.jpg" alt="movie_img1" width="200"/></a></td>
        <td><a href="#"><img id="img_m2" src="./img/movie2.jpg" alt="movie_img2" width="200"/></a></td>
        <td><a href="#"><img id="img_m3" src="./img/movie3.jpg" alt="movie_img3" width="200"/></a></td>
    </table>
<div class="chart_area">
    <div class="movie_rec_rank">
        <svg id="rec_rank_chart" width="800" height="500"></svg>
    </div>
    <div id="container"></div>
    <div class="genre_date_rank">
        <svg id="genre_date_chart" width="800" height="500"></svg>
    </div>
</div>
</body>
<div id="movie_rec_rank" class="hidden"><?php echo $json_mrank; ?></div>
<script src="./js/chart/statChart.js"></script>
</html>