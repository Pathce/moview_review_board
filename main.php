<?php include $_SERVER['DOCUMENT_ROOT']."./db.php"; ?>
<!DOCTYPE html>
<?php session_start(); ?>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>메인</title>
    <link rel="stylesheet" type="text/css" href="./css/main.css" />
</head>
<body>
    <div class="header">
        <form class="login" name="login_form">
            <div class="login_info">
                <?php
                if(!isset($_SESSION['user_id']) || !isset($_SESSION['user_name'])) {
                    echo "<p>로그인을 해 주세요. <a href='index.php'>로그인</a> | <a href='signin.php'>회원가입</a></p>";
                } else {
                    $user_id = $_SESSION['user_id'];
                    $user_name = $_SESSION['user_name'];
                    echo "<p><a href='user_info.php?user_id=".$user_id."'><strong>$user_name</strong></a>($user_id)님 환영합니다.";
                    echo "<a href='logout.php'>로그아웃</a></p>";
                }
                ?>
            </div>
        </form>
    </div>
    <hr />
    <div>
        <table id="movie_poster_list">
            <tbody>
            <tr>
                <td><img src="./img/movie1.jpg" alt="movie_img1"/></td>
                <td><img src="./img/movie2.jpg" alt="movie_img2"/></td>
                <td><img src="./img/movie3.jpg" alt="movie_img3"/></td>
                <td><img src="./img/movie4.jpg" alt="movie_img4"/></td>
                <td><img src="./img/movie5.jpg" alt="movie_img5"/></td>
            </tr>
            <tr>
                <td><img src="./img/movie6.jpg" alt="movie_img6"/></td>
                <td><img src="./img/movie7.jpg" alt="movie_img7"/></td>
                <td><img src="./img/movie8.jpg" alt="movie_img8"/></td>
                <td><img src="./img/movie9.jpg" alt="movie_img9"/></td>
                <td><img src="./img/movie10.jpg" alt="movie_img10"/></td>
            </tr>
            </tbody>
        </table>
    </div>
    <div class="review_container">
        <div class="review_tabs">
            <div id="tab001" class="clicked">
                <div id="eff1" class="eff-1"></div>
                <a href="#">인기</a>
            </div>
            <div id="tab002" class="non_clicked">
                <div id="eff2" class="eff-2"></div>
                <a href="#">전체</a>
            </div>
            <select id="search_certria">
                <option>제목</option>
                <option>영화</option>
            </select>
            <input />
            <a href="review_write.php"><button id="search_btn">검색</button></a>
        </div>
        <div class="tab_content">
            <div class="tab-1 ">
                <table class="review_list pop">
                    <thead>
                    <tr>
                        <th width="100">글 번호</th>
                        <th width="120">작성자</th>
                        <th width="200">영화 제목</th>
                        <th width="800">리뷰 제목</th>
                        <th width="50">평점</th>
                        <th width="100">추천 수</th>
                        <th width="100">댓글 수</th>
                    </tr>
                    </thead>
                    <?php
                    // REVIEW 테이블에서 R_SEQ를 기준으로 내림차순해서 5개 까지 표시
                    $sql_review = query("SELECT * FROM review WHERE R_REC>=5 order by R_SEQ desc limit 0, 5");
                    while($review = $sql_review->fetch_array()) {
                        $title = $review['R_SUBJECT'];
                        if(strlen($title) > 30) {
                            $title = str_replace($review['R_SUBJECT'], mb_substr($review['R_SUBJECT'], 0, 30,
                                    'utf-8')."...", $review['R_SUBJECT']);
                        }
                        ?>
                        <tbody>
                        <tr>
                            <td><?php echo $review['R_SEQ']; ?></td>
                            <td><?php echo $review['UR_ID'] ?></td>
                            <td><?php echo $review['M_SEQ'] ?></td>
                            <td><a href="./review.php?r_seq=<?php echo $review['R_SEQ']; ?>"><?php echo $review['R_SUBJECT'] ?></a></td>
                            <td><?php echo $review['R_SCORE'] ?></td>
                            <td><?php echo $review['R_REC'] ?></td>
                            <td><?php echo '0' ?></td>
                        </tr>
                        </tbody>
                    <?php }?>
                </table>
            </div>
            <div class="tab-2 hidden">
                <table class="review_list">
                    <thead>
                    <tr>
                        <th width="100">글 번호</th>
                        <th width="120">작성자</th>
                        <th width="200">영화 제목</th>
                        <th width="800">리뷰 제목</th>
                        <th width="50">평점</th>
                        <th width="100">추천 수</th>
                        <th width="100">댓글 수</th>
                    </tr>
                    </thead>
                    <?php
                    // REVIEW 테이블에서 R_SEQ를 기준으로 내림차순해서 5개 까지 표시
                    $sql = query("SELECT * FROM review order by R_SEQ desc limit 0, 5");
                    while($review = $sql->fetch_array()) {
                        $title = $review['R_SUBJECT'];
                        if(strlen($title) > 30) {
                            $title = str_replace($review['R_SUBJECT'], mb_substr($review['R_SUBJECT'], 0, 30,
                            'utf-8')."...", $review['R_SUBJECT']);
                        }
                    ?>
                    <tbody>
                    <tr>
                        <td><?php echo $review['R_SEQ']; ?></td>
                        <td><?php echo $review['UR_ID'] ?></td>
                        <td><?php echo $review['M_SEQ'] ?></td>
                        <td><?php echo $review['R_SUBJECT'] ?></td>
                        <td><?php echo $review['R_SCORE'] ?></td>
                        <td><?php echo $review['R_REC'] ?></td>
                        <td><?php echo '0' ?></td>
                    </tr>
                    </tbody>
                    <?php }?>
                </table>
            </div>
        </div>
    </div>
    <div class="boundary"></div>
    <div class="chart">
        <button>종합 통계</button>
        <div class="date_line_graph">
            <h1>날짜 별 꺾은선 그래프 들어갈 자리</h1>
        </div>
        <div class="date_circle_graph">
            <input>
            <button>검색</button>
            <table>
                <thead>
                <tr>
                    <th width="50">순위</th>
                    <th width="120">단어</th>
                    <th width="100">횟수</th>
                </tr>
                </thead>
                <tbody>
                <tr>
                    <td>1</td>
                    <td>피곤해</td>
                    <td>100</td>
                </tr>
                </tbody>
            </table>
            <h1>날짜 별 원형 그래프 들어갈 자리</h1>
        </div>
    </div>
    <div class="footer">

    </div>
    <script src="./js/main.js"></script>
</body>
</html>