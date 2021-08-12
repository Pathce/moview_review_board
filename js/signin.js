const i_id = document.querySelector('#uid');
const i_pw = document.querySelector('#upw');
const i_rpw = document.querySelector('#r_upw');
const e_id = document.querySelector('#uemail_id');
const e_adr = document.querySelector('#uemail_adr');
const eql = document.querySelector('#eql');
const n_eql = document.querySelector('#n_eql');

const HIDDEN_CLASSNAME = 'hidden';

chkPw();

function chkId() {
    document.querySelector('#id_check').value = false;
    document.querySelector('#id_chk_ok').classList.add(HIDDEN_CLASSNAME);
    document.querySelector('#id_chk_fail').classList.remove(HIDDEN_CLASSNAME);
}

function chkPw() {
    let pw = i_pw.value;
    let rpw = i_rpw.value;
    if (pw !== "" && pw === rpw) {
        eql.classList.remove(HIDDEN_CLASSNAME);
        n_eql.classList.add(HIDDEN_CLASSNAME);
        document.querySelector('#pw_check').value = true;
        console.log(document.querySelector('#pw_check').value);
    } else {
        eql.classList.add(HIDDEN_CLASSNAME);
        n_eql.classList.remove(HIDDEN_CLASSNAME);
        document.querySelector('#pw_check').value = false;
        console.log(document.querySelector('#pw_check').value);
    }
}

function chkEmail() {
    document.querySelector('#email_check').value = false;
    document.querySelector('#email_chk_ok').classList.add(HIDDEN_CLASSNAME);
    document.querySelector('#email_chk_fail').classList.add(HIDDEN_CLASSNAME);
}

i_id.addEventListener('keyup', chkId);

i_pw.addEventListener('keyup', chkPw);
i_rpw.addEventListener('keyup', chkPw);

e_id.addEventListener('keyup', chkEmail);
e_adr.addEventListener('click', chkEmail);