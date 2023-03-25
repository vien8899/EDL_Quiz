function toggle(){
    if(show_frame==true){
        show_frame = false;
    }else{
        show_frame = true;
    }
    if(show_frame){
        document.getElementById('pwd-btn').hidden = true;
        document.getElementById('pwd-form').hidden = false;
    }else{
        document.getElementById('pwd-btn').hidden = false;
        document.getElementById('pwd-form').hidden = true;
    }
}
function change_password(user_id){
    var old_pwd = document.getElementById('old_pwd').value;
    var new_pwd = document.getElementById('new_pwd').value;
    if(old_pwd!='' && new_pwd!=''){
        var param = {
            'user_id':user_id,
            'old_pwd':old_pwd,
            'new_pwd':new_pwd
        };
        var http = new XMLHttpRequest();
            http.open( "POST", 'controller/personal_info_controller.php', true );
            http.setRequestHeader( 'Content-type', 'application/x-www-form-urlencoded' );
            http.onreadystatechange = function () {
                if ( this.readyState === XMLHttpRequest.DONE && this.status === 200 ) {
                    eval( this.responseText );
                    // console.log(this.responseText);
                }
            }
        var _param = JSON.stringify( param );
        http.send( "change_pwd=" + _param );
    }else{
        Swal.fire({icon:'info',html:'<span class=phetsarath>ກະລຸນາປ້ອນຂໍ້ມູນໃຫ້ຄົບຖ້ວນ!</span>'});
    }
}