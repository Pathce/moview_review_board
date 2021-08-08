const btn_chkid = document.querySelector('#btn_chkid');

function chkid() {
    if (id = document.querySelector('#uid').value) {
        url = "chkid.php?userid=" + id;
        window.open(url, "chkid", "width=500, height=300");
    } else {
        alert("아이디를 입력하십시오.");
    }
}

btn_chkid.addEventListener('click', chkid);