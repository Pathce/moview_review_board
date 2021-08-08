<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>내 정보</title>
    <link rel="stylesheet" type="text/css" href="./css/userInfo.css" />
</head>
<body>
    <div>
        <div>ID : ID</div>
        <div>E-mail : example@sample.com</div>
        <div>리뷰 : 0</div>
        <div>댓글 : 0</div>
    </div>
    <div>
        <h2>내 리뷰</h2>
        <table>
            <thead>
                <td>글 번호</td>
                <td>영화 제목</td>
                <td>리뷰 제목</td>
                <td>평점</td>
                <td>추천 수</td>
                <td>댓글 수</td>
            </thead>
        </table>
    </div>
    <div>
        <h2>내 댓글</h2>
        <table>
            <thead>
                <td>작성자</td>
                <td>날짜</td>
                <td>영화 제목</td>
                <td>리뷰 제목</td>
                <td>댓글 내용</td>
            </thead>
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