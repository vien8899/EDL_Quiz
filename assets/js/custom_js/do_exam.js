
var exam_data;
$( document ).ready( function () {

    load_exam_data();
    // console.log(exam_data);
    var subj_name = exam_data.quiz_title;
    $( "#subj_name" ).html( subj_name );
    load_button();
    load_question();
    load_ans();
} );
function load_exam_data() {
    var exam_data_encoded = sessionStorage.getItem( "exam_data" );
    exam_data = JSON.parse( CryptoJS.AES.decrypt( exam_data_encoded, "exam" ).toString( CryptoJS.enc.Utf8 ) );
}
function load_button() {
    var question_btn = document.getElementById( "question_btn" );
    question_btn.innerHTML = "";
    var questions = exam_data.user_ans;
    var act_class = "";
    var action = "";
    var disable_previous = false;
    var disable_next = false;
    if ( exam_data.selection_index == ( exam_data.user_ans.length - 1 ) ) {
        disable_next = true;
    }
    questions.forEach( quest => {
        if ( parseInt( exam_data.selection_index ) == 0 && parseInt( quest.question_rang ) == 0 ) {
            act_class = "active";
            disable_previous = true;
        } else if ( parseInt( exam_data.selection_index ) == parseInt( quest.question_rang ) ) {
            act_class = "active";
        } else {
            act_class = "";
            action = `onclick="question_num_selected(` + quest.question_rang + `)"`;
        }

        var quest_element = document.createElement( 'div' );
        quest_element.className = "ques-num";
        quest_element.id = 'quest' + quest.question_rang;
        quest_element.innerHTML = `<div ` + action + ` class="quest-btn ` + act_class + `">` + ( parseInt( quest.question_rang ) + 1 ) + `</div>`;
        question_btn.appendChild( quest_element );
    } );
    var btn_previous = document.getElementById( "btn_prevoius" );
    var btn_next = document.getElementById( "btn_next" );
    btn_previous.disabled = disable_previous;
    btn_next.disabled = disable_next;
}
function load_question() {
    var quest_body = document.getElementById( "quest_body" );
    quest_body.innerHTML = ``;
    var questions = exam_data.user_ans;
    var question_title = document.createElement( 'div' );
    question_title.className = "quest-title phetsarath";
    var question_des = document.createElement( 'div' );
    question_des.className = "quest-des phetsarath";
    question_title.innerHTML = decodeHTMLEntities( questions[ parseInt( exam_data.selection_index ) ].question_title );
    question_des.innerHTML = decodeHTMLEntities( questions[ parseInt( exam_data.selection_index ) ].question_des );
    quest_body.appendChild( question_title );
    quest_body.appendChild( question_des );
}
function load_ans() {
    var lb_score = document.getElementById( "lb_score" );
    var answer = document.getElementById( "ans" );
    answer.innerHTML = ``;
    var question = exam_data.user_ans[ exam_data.selection_index ];
    lb_score.innerHTML = `(+ ` + question.full_point + ` ຄະແນນ)`;
    var ans_box = document.createElement( "div" );
    ans_box.className = "ans-box";
    ans_box.innerHTML = ``;
    if ( parseInt( question.question_type ) == 0 ) {
        // 0 choice

        question.ans_choice.forEach( _choice => {
            var choice = document.createElement( "div" );
            var checked = "";
            if ( _choice.is_selected == 1 ) {
                checked = "checked";
            }
            choice.className = "form-check";
            choice.innerHTML = `<input class="form-check-input choice-inp" type="radio" name="choice" id="choice` + _choice.choice_index + `" value="` + _choice.rang + `" ` + checked + `>
                                <label class="form-check-label phetsarath" for="choice`+ _choice.choice_index + `">` + _choice.choice + `</label>`;
            ans_box.appendChild( choice );
        } );
        answer.appendChild( ans_box );
    } else if ( parseInt( question.question_type ) == 1 ) {
        // 1 multiple choice
        var checked_ans = 0;
        question.ans_choice.forEach(_choice=>{
            if(_choice.is_selected == 1){
                checked_ans +=1;
            }
        });
        question.ans_choice.forEach( _choice => {
            var choice = document.createElement( "div" );
            var checked = "";
            var disabled = "";
            if ( _choice.is_selected == 1 ) {
                checked = "checked";
            }else{
                if(checked_ans==question.correct_ans.length){
                    disabled = "disabled";
                }
            }
            choice.className = "form-check";
            choice.innerHTML = `<input onchange=cb_changed('choice` + question.quiz_question_id + `') class="form-check-input choice-inp" type="checkbox" name="choice" id="choice` +question.quiz_question_id+`_`+ _choice.choice_index + `" value="` + _choice.rang + `" ` + checked +` `+disabled+ `>
                                <label class="form-check-label phetsarath" for="choice`+ question.quiz_question_id+`_`+ _choice.choice_index + `">` + _choice.choice + `</label>`;
            ans_box.appendChild( choice );
        } );
        answer.appendChild( ans_box );
    } else {
        //2 text answer
        var answer_des = "";
        if ( question.ans != "" ) {
            answer_des = question.ans;
        } else if ( question.show_ques_content == 1 ) {
            answer_des = question.question_des;
        }
        var ans_inp = document.createElement( "div" );
        ans_inp.innerHTML = `<textarea name="txt_answer_des" id="txt_answer_des" class="phetsarath txt_answer_des" rows="3">` + answer_des + `</textarea>`;
        answer.appendChild( ans_inp );
        CKEDITOR.replace( 'txt_answer_des', {
            height: 200,
            language: 'en'
        } );
        CKEDITOR.disableAutoInline = true;
    }
}
function next_quest() {
    var target_num = parseInt( exam_data.selection_index ) + 1;
    save_ans();
    goto_quest( target_num );
}
function previous_quest() {
    var target_num = parseInt( exam_data.selection_index ) - 1;
    save_ans();
    goto_quest( target_num );
}

function cb_changed(chb_id){
    var question = exam_data.user_ans[ exam_data.selection_index ];
    var checked_num = 0;
    question.ans_choice.forEach(ans=>{
        var id = chb_id+'_'+ans.choice_index;
        if(document.getElementById(id).checked){
            checked_num +=1;
        }
    });
    if(checked_num>=question.correct_ans.length){
        question.ans_choice.forEach(ans=>{
            var id = chb_id+'_'+ans.choice_index;
            if(document.getElementById(id).checked==false){
                document.getElementById(id).disabled = true;
            }
        });
    }else{
        question.ans_choice.forEach(ans=>{
            var id = chb_id+'_'+ans.choice_index;
            if(document.getElementById(id).checked==false){
                document.getElementById(id).disabled = false;
            }
        });
    }
}
function save_ans() {
    var question = exam_data.user_ans[ exam_data.selection_index ];
    var ans_choice = question.ans_choice;
    var question_type = parseInt( question.question_type );
    var not_update = false;
    if ( question_type == 0 ) {
        not_update = false;
        var _ans = $( 'input[name="choice"]:checked' )[ 0 ];
        if ( _ans != undefined ) {
            //clear old selected answer
            ans_choice.forEach( _choice => {
                if ( question.ans_choice[ _choice.rang ].is_selected == 1 &&
                    question.ans_choice[ _choice.rang ].rang == _ans.value ) {
                    not_update = true;
                } else {
                    question.ans_choice[ _choice.rang ].is_selected = 0;
                }
            } );
            if ( !not_update ) {
                question.ans = "[" + ans_choice[ _ans.value ].choice_index + "]";
                question.ans_choice[ _ans.value ].is_selected = 1;
                if ( question.correct_ans[ 0 ] == parseInt( ans_choice[ _ans.value ].choice_index ) ) {
                    question.point = question.full_point;
                } else {
                    question.point = 0;
                }
                exam_data.user_ans[ exam_data.selection_index ] = question;
                var param = {
                    ans_choice: question.ans_choice,
                    answer: question.ans,
                    point: question.point,
                    quiz_quest_id: question.quiz_question_id,
                    test_number: question.test_number
                }
                update_ans( param, exam_data );
            }
        }
    } else if ( question_type == 1 ) {
        not_update = true;
        var _ans = $( 'input[name="choice"]:checked' );
        if ( _ans.length != 0 ) {
            //clear old selected answer
            var old_ans = [];
            ans_choice.forEach( _choice => {
                if ( question.ans_choice[ _choice.rang ].is_selected == 1 ) {
                    old_ans.push( _choice.choice_index );
                }
                question.ans_choice[ _choice.rang ].is_selected = 0;
            } );
            var ans_data = [];
            //set selected
            _ans.each( function () {
                var checked_index = parseInt( $( this )[ 0 ].value );
                question.ans_choice[ checked_index ].is_selected = 1;
                ans_data.push( question.ans_choice[ checked_index ].choice_index );
            } );
            if(old_ans.length==ans_data.length){
                ans_data.forEach(ans_value=>{
                    if(!old_ans.includes(ans_value)){
                        not_update = false;
                    }
                });
            }else{
                not_update = false;
            }
            if(!not_update){
                var correct_ans = question.correct_ans;
                var correct_num = 0;
                ans_data.forEach(ans_value=>{
                    if(correct_ans.includes(ans_value)){
                        correct_num += 1;
                    }
                });
                var point = 0;
                if(correct_num!=0){
                    point=(correct_num*question.full_point)/correct_ans.length;
                }
                question.point = point;
                exam_data.user_ans[ exam_data.selection_index ] = question;
                var param = {
                    ans_choice: question.ans_choice,
                    answer: question.ans,
                    point: question.point,
                    quiz_quest_id: question.quiz_question_id,
                    test_number: question.test_number
                }
                update_ans( param, exam_data );
            }

        }else{
            var old_ans = [];
            ans_choice.forEach( _choice => {
                if ( question.ans_choice[ _choice.rang ].is_selected == 1 ) {
                    old_ans.push( _choice.choice_index );
                }
                question.ans_choice[ _choice.rang ].is_selected = 0;
            } );
            if(old_ans.length!=0){
                question.point = 0;
                exam_data.user_ans[ exam_data.selection_index ] = question;
                var param = {
                    ans_choice: question.ans_choice,
                    answer: question.ans,
                    point: question.point,
                    quiz_quest_id: question.quiz_question_id,
                    test_number: question.test_number
                }
                update_ans( param, exam_data );
            }
        }
    } else {
        var ans = CKEDITOR.instances.txt_answer_des.getData();

        if ( ans != "" ) {
            if ( question.ans != ans ) {
                question.ans = ans;
                var param = {
                    ans_choice: question.ans_choice,
                    answer: question.ans,
                    point: question.point,
                    quiz_quest_id: question.quiz_question_id,
                    test_number: question.test_number
                }
                update_ans( param, exam_data );
            }
        }
    }
}
function question_num_selected( quest_num ) {
    save_ans();
    goto_quest( quest_num );
}
function goto_quest( quest_num ) {
    exam_data.selection_index = quest_num;
    var _exam_data = JSON.stringify( exam_data );
    var exam_data_encoded = CryptoJS.AES.encrypt( _exam_data, "exam" ).toString();
    sessionStorage.setItem( "exam_data", exam_data_encoded );
    load_exam_data();
    var subj_name = exam_data.quiz_title;
    $( "#subj_name" ).html( subj_name );
    load_button();
    load_question();
    load_ans();
}
function update_ans( param, exam_data_update ) {
    var error = false;
    Swal.fire( {
        html: '<h2 class="phetsarath">ກະລຸນາລໍຖ້າ !</h2><h4 class="phetsarath">ກໍາລັງບັນທຶກຂໍ້ມູນ</h4>',
        timer: 300,
        allowOutsideClick: false,
        didOpen: () => {
            Swal.showLoading()
        }
    } ).then( () => {
        if ( error ) {
            load_exam_data();
            Swal.fire( { icon: 'error', html: '<span class=phetsarath>ບໍ່ສາມາດບັນທຶກຄໍາຕອບ<br>ກະລຸນາຕິດຕໍ່ຫາຜູ້ຄຸມລະບົບ!</span>' } );
        } else {
            var _exam_data = JSON.stringify( exam_data_update );
            var exam_data_encoded = CryptoJS.AES.encrypt( _exam_data, "exam" ).toString();
            sessionStorage.setItem( "exam_data", exam_data_encoded );
            load_exam_data();
        }
    } );
    Swal.stopTimer();
    var http = new XMLHttpRequest();
    http.open( "POST", 'controller/do_exam_controller.php', true );
    http.setRequestHeader( 'Content-type', 'application/x-www-form-urlencoded' );
    http.onreadystatechange = function () {
        if ( this.readyState === XMLHttpRequest.DONE && this.status === 200 ) {
            var res = JSON.parse( this.responseText );
            if ( res.success ) {
                var exam_data = JSON.stringify( res.exam_data );
                var exam_data_encoded = CryptoJS.AES.encrypt( exam_data, "exam" ).toString();
                sessionStorage.setItem( "update_ans", exam_data_encoded );
            } else {
                error = true;
            }
            Swal.resumeTimer();
        }
    }
    var _param = encode( JSON.stringify( param ) );
    http.send( "update_ans=" + _param );
}
function timeout_submit() {
    Swal.fire( {
        title: '<strong class="phetsarath">ເວລາສອບເສັງໝົດກໍານົດແລ້ວ</strong>',
        html:
            '<div class="phetsarath">ລະບົບຈະບັນທຶກຄໍາຕອບໃຫ້ທ່ານແບບອັດຕະໂນມັດ</div>',
        focusConfirm: true,
        allowOutsideClick: false,
        confirmButtonText: '<div class="phetsarath">ຕົກລົງ</div>'
    } ).then( ( result ) => {
        if(result.isConfirmed){
            submit();
        }
    } );
}
function btn_submit_clicked(){
    Swal.fire({
        title: '<strong class="phetsarath">ທ່ານຕ້ອງການສົ່ງຄໍາຕອບແມ່ນບໍ່ ?</strong>',
        html: '<div class="phetsarath">ຫາກທ່ານກົດຕົກລົງ, ທ່ານຈະບໍ່ສາມາດແກ້ໄຂຂໍ້ມູນໄດ້ອີກ ລະບົບຈະສົ່ງຄໍາຕອບຂອງທ່ານທັງໝົດໂດຍອັດຕະໂນມັດ</div>',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: '<div class="notosans">ຕົກລົງ</div>',
        cancelButtonText:'<div class="notosans">ຍົກເລີກ</div>'
    }).then((result) => {
        if (result.isConfirmed) {
          submit();
        }
    });
}
function submit() {
    var question = exam_data.user_ans[ exam_data.selection_index ];
    var ans_choice = question.ans_choice;
    var question_type = parseInt( question.question_type );
    var not_update = true;
    var param = '';
    if ( question_type == 0 ) {
        var _ans = $( 'input[name="choice"]:checked' )[ 0 ];
        if ( _ans != undefined ) {
            //clear old selected answer
            ans_choice.forEach( _choice => {
                if ( question.ans_choice[ _choice.rang ].is_selected == 1 &&
                    question.ans_choice[ _choice.rang ].rang == _ans.value ) {
                } else {
                    not_update = false;
                    question.ans_choice[ _choice.rang ].is_selected = 0;
                }
            } );
            if ( !not_update ) {
                question.ans = "[" + ans_choice[ _ans.value ].choice_index + "]";
                question.ans_choice[ _ans.value ].is_selected = 1;
                if ( question.correct_ans[ 0 ] == parseInt( ans_choice[ _ans.value ].choice_index ) ) {
                    question.point = question.full_point;
                } else {
                    question.point = 0;
                }
                exam_data.user_ans[ exam_data.selection_index ] = question;
                param = {
                    ans_choice: question.ans_choice,
                    answer: question.ans,
                    point: question.point,
                    quiz_quest_id: question.quiz_question_id,
                    test_number: question.test_number
                }
            }
        }
    } else if ( question_type == 1 ) {
        not_update = true;
        var _ans = $( 'input[name="choice"]:checked' );
        if ( _ans.length != 0 ) {
            //clear old selected answer
            var old_ans = [];
            ans_choice.forEach( _choice => {
                if ( question.ans_choice[ _choice.rang ].is_selected == 1 ) {
                    old_ans.push( _choice.choice_index );
                }
                question.ans_choice[ _choice.rang ].is_selected = 0;
            } );
            var ans_data = [];
            //set selected
            _ans.each( function () {
                var checked_index = parseInt( $( this )[ 0 ].value );
                question.ans_choice[ checked_index ].is_selected = 1;
                ans_data.push( question.ans_choice[ checked_index ].choice_index );
            } );
            if(old_ans.length==ans_data.length){
                ans_data.forEach(ans_value=>{
                    if(!old_ans.includes(ans_value)){
                        not_update = false;
                    }
                });
            }else{
                not_update = false;
            }
            if(!not_update){
                var correct_ans = question.correct_ans;
                var correct_num = 0;
                ans_data.forEach(ans_value=>{
                    if(correct_ans.includes(ans_value)){
                        correct_num += 1;
                    }
                });
                var point = 0;
                if(correct_num!=0){
                    point=(correct_num*question.full_point)/correct_ans.length;
                }
                question.point = point;
                exam_data.user_ans[ exam_data.selection_index ] = question;
                var param = {
                    ans_choice: question.ans_choice,
                    answer: question.ans,
                    point: question.point,
                    quiz_quest_id: question.quiz_question_id,
                    test_number: question.test_number
                }
            }

        }else{
            var old_ans = [];
            ans_choice.forEach( _choice => {
                if ( question.ans_choice[ _choice.rang ].is_selected == 1 ) {
                    old_ans.push( _choice.choice_index );
                }
                question.ans_choice[ _choice.rang ].is_selected = 0;
            } );
            if(old_ans.length!=0){
                not_update = false;
                question.point = 0;
                exam_data.user_ans[ exam_data.selection_index ] = question;
                var param = {
                    ans_choice: question.ans_choice,
                    answer: question.ans,
                    point: question.point,
                    quiz_quest_id: question.quiz_question_id,
                    test_number: question.test_number
                }
            }
        }
    } else {
        var ans = CKEDITOR.instances.txt_answer_des.getData();

        if ( ans != "" ) {
            if ( question.ans != ans ) {
                question.ans = ans;
                param = {
                    ans_choice: question.ans_choice,
                    answer: question.ans,
                    point: question.point,
                    quiz_quest_id: question.quiz_question_id,
                    test_number: question.test_number
                }
                not_update = false;
            }
        }
    }
    if ( not_update ) {
        Swal.fire({
            title: '<div class="phetsarath">ສົ່ງຄໍາຕອບສໍາເລັດ</div>',
            icon: 'success',
            html:'<div class="phetsarath">ບົດເສັງຂອງທ່ານໄດ້ສົ່ງສໍາເລັດແລ້ວ</div>'
        }).then(()=>{
            sessionStorage.clear();
            window.location.href = "./main";
        });
    } else {
        var error = false;
        Swal.fire( {
            html: '<h2 class="phetsarath">ກະລຸນາລໍຖ້າ !</h2><h4 class="phetsarath">ກໍາລັງບັນທຶກຂໍ້ມູນ</h4>',
            timer: 300,
            allowOutsideClick: false,
            didOpen: () => {
                Swal.showLoading()
            }
        } ).then( () => {
            if ( error ) {
                load_exam_data();
                Swal.fire( { icon: 'error', html: '<span class=phetsarath>ບໍ່ສາມາດບັນທຶກຄໍາຕອບ<br>ກະລຸນາຕິດຕໍ່ຫາຜູ້ຄຸມລະບົບ!</span>' } );
            } else {
                Swal.fire({
                    title: '<div class="phetsarath">ສົ່ງຄໍາຕອບສໍາເລັດ</div>',
                    icon: 'success',
                    html:'<div class="phetsarath">ບົດເສັງຂອງທ່ານໄດ້ສົ່ງສໍາເລັດແລ້ວ</div>'
                }).then(()=>{
                    sessionStorage.clear();
                    window.location.href = "./main";
                });
            }
        });
        Swal.stopTimer();
        var http = new XMLHttpRequest();
        http.open( "POST", 'controller/do_exam_controller.php', true );
        http.setRequestHeader( 'Content-type', 'application/x-www-form-urlencoded' );
        http.onreadystatechange = function () {
            if ( this.readyState === XMLHttpRequest.DONE && this.status === 200 ) {
                var res = JSON.parse( this.responseText );
                if ( res.success ) {
                    var exam_data = JSON.stringify( res.exam_data );
                    var exam_data_encoded = CryptoJS.AES.encrypt( exam_data, "exam" ).toString();
                    sessionStorage.setItem( "update_ans", exam_data_encoded );
                } else {
                    error = true;
                }
                Swal.resumeTimer();
            }
        }
        var _param = encode( JSON.stringify( param ) );
        http.send( "update_ans=" + _param );
    }
}
function decodeHTMLEntities( text ) {
    var entities = [
        [ 'amp', '&' ],
        [ 'apos', '\'' ],
        [ '#x27', '\'' ],
        [ '#x2F', '/' ],
        [ '#39', '\'' ],
        [ '#47', '/' ],
        [ 'lt', '<' ],
        [ 'gt', '>' ],
        [ 'nbsp', ' ' ],
        [ 'quot', '"' ]
    ];

    for ( var i = 0, max = entities.length; i < max; ++i )
        text = text.replace( new RegExp( '&' + entities[ i ][ 0 ] + ';', 'g' ), entities[ i ][ 1 ] );
    return text;
}
function encode( text ) {
    return text
        .replace( /&/g, "#amp;" )
        .replace( /"/g, "#quot;" )
        .replace( /\+/g, "#plus;" )
        .replace( /'/g, "#039;" );
}