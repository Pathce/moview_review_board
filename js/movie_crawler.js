const { Builder, By, Key, until, promise } = require("selenium-webdriver");
const chrome = require("selenium-webdriver/chrome");

// chrome 옵션 설정
const options = new chrome.Options();
options.addArguments("--headless");
options.addArguments("--no-sandbox");
options.addArguments("--disable-dev-shm-usage");

// MySQL 연결 설정
const mysql = require("mysql");
const { alertIsPresent } = require("selenium-webdriver/lib/until");
var connection = mysql.createConnection({
    host: "127.0.0.1",
    user: "root",
    password: "",
    database: "review_board",
});

(async function() {
    let driver = await new Builder()
        .forBrowser("chrome")
        .setChromeOptions(options)
        .build();

    let url = "https://movie.naver.com/movie/running/current.naver";

    connection.connect();

    let movie_url = [];
    let movie_title = [];
    let movie_img = [];

    try {
        // 시작주소 : 구글 '크롤러' 검색 결과
        await driver.get(url);

        let userAgent = await driver.executeScript("return navigator.userAgent;");

        console.log(`[userAgnet] ${userAgent}`);

        let movie = await driver.findElements(By.xpath("//*[@id=\"content\"]/div[1]/div[1]/div[3]/ul/li"));

        for(let i = 0; i < 10; i++) {
            movie_url.push(await movie[i].findElement(By.xpath("./div/a")).getAttribute('href'));
            movie_title.push(await movie[i].findElement(By.xpath("./div/a/img")).getAttribute("alt"));
        }

    } catch(e) {
        console.error(e);
    } finally {
    }

    console.log(movie_url);
    console.log(movie_title);

    async function crawl(url) {
        try {
            // 시작주소 : 구글 '크롤러' 검색 결과
            await driver.get(url);

            let m_img = (await driver.findElement(By.xpath("//*[@id=\"content\"]/div[1]/div[2]/div[2]/a/img")).getAttribute("src"));

            return m_img;

        } catch(e) {
            console.error(e);
        } finally {
        }
    }
    function crawlEnd() {
        driver.quit(), 1000;
    }

    for(let i = 0; i < 10; i ++) {
        movie_img.push(await crawl(movie_url[i]));
    }

    console.log(movie_img);

    await connection.query("DELETE FROM MOVIE_POSTER");

    for(let i = 0; i < 10; i ++) {
        connection.query(
            `INSERT INTO MOVIE_POSTER(movie_name, poster_url) VALUES ('${movie_title[i]}', '${movie_img[i]}')`
        );
    }

    connection.end();
    await crawlEnd();
})();