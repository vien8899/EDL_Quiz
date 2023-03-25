var user_group_frame = document.getElementById('user-group-frame');
user_group_frame.style.display = "none";
var has_unit = false;
dep_selected();
function dep_selected() {
    var _dep_id = document.getElementById( 'dep' ).value;
    var unit = document.getElementById( 'unit' );
    unit.innerHTML = ``;
    var param = {
        dep_id: _dep_id
    }
    var http = new XMLHttpRequest();
    http.open( "POST", 'controller/employee_controller.php', true );
    http.setRequestHeader( 'Content-type', 'application/x-www-form-urlencoded' );
    http.onreadystatechange = function () {
        if ( this.readyState === XMLHttpRequest.DONE && this.status === 200 ) {
            var unit_data = JSON.parse(this.responseText);
            var element = `<option value='0' >ບໍ່ລະບຸ</option>`;
            // console.log(unit_data.length);
            if(unit_data.length!=0)
                has_unit = true;
            unit_data.forEach(_unit => {
                if(unit_id==_unit.unit_id){
                    element +=`<option value='`+_unit.unit_id+`' selected >`+_unit.unit_des+`</option>`;
                }else{
                    element +=`<option value='`+_unit.unit_id+`' >`+_unit.unit_des+`</option>`;
                }
                
            });
            unit.innerHTML = element;
        }
    }
    var _param = encode( JSON.stringify( param ) );
    http.send( "get_unit_by_dep=" + _param );
}
function rd_admin_changed(value){
    if(value==1){
        user_group_frame.style.display = "block";
    }else{
        user_group_frame.style.display = "none";
    }
}
function save() {
    var _user_code = $('#user_code').val();
    var _fullname = $( '#fullname' ).val();
    var _gender = $( '#gender' ).val();
    var _dep_id = $( '#dep' ).val();
    var _username = $( '#username' ).val();
    var _password = $( '#password' ).val();
    var _unit_id = 0;
    if(has_unit){
        _unit_id = $('#unit').val();
    }
    var _technical_knowledge = $('#tech_knowledge').val();
    var _degree = $('#degree').val();
    var _position = $('#position').val();
    var confirm_password = $( '#confirm_password' ).val();
    var _address = $( '#address' ).val();
    var _user_type = document.querySelector( 'input[name="user_type"]:checked' ).value;
    var _user_group_id = 1;
    if(_user_type==1)
        _user_group_id = $('#user_group').val();
    var _date_of_birth = $( '#date_of_birth' ).val();
    var _tel = $( "#tel" ).val();
    if(_user_code == ""){
        Swal.fire( {
            icon: 'info',
            html: '<span class=phetsarath>ກະລຸນາປ້ອນ ລະຫັດພະນັກງານ !</span>'
        } );
    }else if ( _fullname == "" ) {
        Swal.fire( {
            icon: 'info',
            html: '<span class=phetsarath>ກະລຸນາປ້ອນ ຊື່ ແລະ ນາມສະກຸນ !</span>'
        } );
    }else if(_technical_knowledge==""){
        Swal.fire( {
            icon: 'info',
            html: '<span class=phetsarath>ກະລຸນາປ້ອນ ວິຊາສະເພາະ!</span>'
        } );
    }else if(_degree == ""){
        Swal.fire( {
            icon: 'info',
            html: '<span class=phetsarath>ກະລຸນາປ້ອນ ລະດັບວິຊາສະເພາະ !</span>'
        } );
    } else if ( _username == "" ) {
        Swal.fire( {
            icon: 'info',
            html: '<span class=phetsarath>ກະລຸນາປ້ອນ ຊື່ເຂົ້າໃຊ້ລະບົບ !</span>'
        } );
    } else if ( _password == "" || confirm_password == "" ) {
        Swal.fire( {
            icon: 'info',
            html: '<span class=phetsarath>ກະລຸນາປ້ອນ ລະຫັດຜ່ານ !</span>'
        } );
    } else {
        if ( _password != confirm_password ) {
            Swal.fire( {
                icon: 'info',
                html: '<span class=phetsarath>ລະຫັດຜ່ານບໍ່ກົງກັນ !</span>'
            } );
        } else {
            var param = {
                user_code:_user_code,
                fullname: _fullname,
                gender: _gender,
                dep_id: _dep_id,
                username: _username,
                password: _password,
                address: _address,
                tel: _tel,
                unit_id:_unit_id,
                technical_knowledge:_technical_knowledge,
                degree:_degree,
                position_id:_position,
                user_type: _user_type,
                date_of_birth: _date_of_birth,
                user_group_id:_user_group_id,
                url_param:_url_param

            };
            var http = new XMLHttpRequest();
            http.open( "POST", 'controller/employee_controller.php', true );
            http.setRequestHeader( 'Content-type', 'application/x-www-form-urlencoded' );
            http.onreadystatechange = function () {
                if ( this.readyState === XMLHttpRequest.DONE && this.status === 200 ) {
                    eval( this.responseText );
                    // console.log(this.responseText);
                }
            }
            var _param = encode( JSON.stringify( param ) );
            http.send( "new_employee=" + _param );
        }
    }
}

function date_changed( data ) {
    var _date = new Date( data );
    document.getElementById( "date-of-birth-lb" ).innerHTML = _date.getDate().toString().padStart( 2, "0" ) + "/" + ( _date.getMonth() + 1 ).toString().padStart( 2, "0" ) + "/" + _date.getFullYear();
}