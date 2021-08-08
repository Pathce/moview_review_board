<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>리뷰 게시판</title>
    <link rel="stylesheet" type="text/css" href="./css/reviewBoard.css">
</head>
<body>
    <div class="board">
        <select id="search_certria">
            <option>제목</option>
            <option>영화</option>
        </select>
        <input>
        <button>검색</button>
    </div>
    <div class="board_tabs">
        <div class="tabs">
            <button id="tab01">전체</button>
            <button id="tab02">인기</button>
        </div>
        <div class="board01 ">
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
                <tbody>
                <tr>
                    <td>1</td>
                    <td>user</td>
                    <td>review title</td>
                    <td>movie title</td>
                    <td>0</td>
                    <td>0</td>
                    <td>0</td>
                </tr>
                </tbody>
            </table>
        </div>
        <div class="board02 hidden">
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
                <tbody>
                <tr>
                    <td>2</td>
                    <td>user2</td>
                    <td>review title2</td>
                    <td>movie title2</td>
                    <td>10</td>
                    <td>1</td>
                    <td>2</td>
                </tr>
                </tbody>
            </table>
        </div>
        <button>리뷰 작성</button>
    </div>
    <script src="./js/reviewBoard.js"></script>
</body>
</html>