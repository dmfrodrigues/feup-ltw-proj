function signup_check(){
    let pwd     = document.getElementById('pwd'    ).value;
    let rpt_pwd = document.getElementById('rpt_pwd').value;
    if(pwd != rpt_pwd) return false;
    return true;
}