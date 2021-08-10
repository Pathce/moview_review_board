const i_id = document.querySelector('#uid');
const i_pw = document.querySelector('#upw');
const i_rpw = document.querySelector('#r_upw');
const i_name = document.querySelector('#uname');
const e_id = document.querySelector('#uemail_id');
const e_adr = document.querySelector('#uemail_adr');
const eql = document.querySelector('#eql');
const n_eql = document.querySelector('#n_eql');

const HIDDEN_CLASSNAME = 'hidden';

chkPw();

function chkPw() {
    let pw = i_pw.value;
    let rpw = i_rpw.value;
    if (pw !== "" && pw === rpw) {
        eql.classList.remove(HIDDEN_CLASSNAME);
        n_eql.classList.add(HIDDEN_CLASSNAME);
    } else {
        eql.classList.add(HIDDEN_CLASSNAME);
        n_eql.classList.remove(HIDDEN_CLASSNAME);
    }
}

i_pw.addEventListener('keyup', chkPw);
i_rpw.addEventListener('keyup', chkPw);