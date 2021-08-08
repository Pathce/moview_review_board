const btn_chkpw = document.querySelector('#btn-chkpw');

function chkpw() {
    let upw = document.querySelector('#upw').value;
    let urpw = document.querySelector('#urpw').value;
    if (upw === urpw && upw.length > 7 && upw.length < 14) {
        alert('사용 가능한 비밀번호 입니다.');
    } else {
        alert('비밀번호 길이가 맞지 않거나 일치하지 않습니다.');
    }
}

btn_chkpw.addEventListener('click', chkpw);