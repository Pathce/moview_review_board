const i_id = document.querySelector('#uid');
const i_pw = document.querySelector('#upw');
const i_rpw = document.querySelector('#r_upw');
const i_name = document.querySelector('#uname');
const e_id = document.querySelector('#uemail_id');
const e_adr = document.querySelector('#uemail_adr');

const btn_idchk = document.querySelector('#btn_id_chk');

function chkPw() {
    let pw = i_pw.value;
    let rpw = i_rpw.value;

    console.log("keydown");
}

i_pw.addEventListener('keydown', chkPw);
i_rpw.addEventListener('keydown', chkPw);