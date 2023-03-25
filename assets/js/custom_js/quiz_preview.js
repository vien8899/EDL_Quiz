var quiz_data;
Swal.fire( {
    html: '<h2 class="phetsarath">ກະລຸນາລໍຖ້າ !</h2><h4 class="phetsarath">ກໍາລັງໂຫຼດຂໍ້ມູນ</h4>',
    timer: 300,
    allowOutsideClick: false,
    didOpen: () => {
        Swal.showLoading()
    }
}).then( () => {
    //load success
    load_quiz_data();
    // load_question();
    // load_ans();
    // load_button();
    load_questions();
});
Swal.stopTimer();
var http = new XMLHttpRequest();
http.open( "POST", 'controller/quiz_preview_controller.php', true );
http.setRequestHeader( 'Content-type', 'application/x-www-form-urlencoded' );
http.onreadystatechange = function () {
    if ( this.readyState === XMLHttpRequest.DONE && this.status === 200 ) {
        // console.log(this.responseText);
        var res = JSON.parse(this.responseText);
        var quiz_data = JSON.stringify(res);
        var quiz_data_encode = CryptoJS.AES.encrypt( quiz_data, "view_quiz" ).toString();
        sessionStorage.setItem( "quiz_data", quiz_data_encode );
        Swal.resumeTimer();
    }
}
var _param = encode( JSON.stringify( param ) );
http.send( "load_exam_data=" + _param );


function load_quiz_data(){
    var quiz_data_encode = sessionStorage.getItem("quiz_data");
    quiz_data = JSON.parse(CryptoJS.AES.decrypt(quiz_data_encode,"view_quiz").toString( CryptoJS.enc.Utf8 ));
    // var question_lb = document.getElementById("question_label");
    var score = document.getElementById("score");
    score.innerHTML = " (ຄະແນນເຕັມ "+quiz_data.total_score+" ຄະແນນ)";
    // question_lb.innerHTML = "ຄໍາຖາມທີ່ "+(quiz_data.selection_index+1)+" (+ "+quiz_data.questions[quiz_data.selection_index].full_point+" ຄະແນນ)";
    // console.log(quiz_data);
}
// function load_question() {
//     var quest_body = document.getElementById( "quest_body" );
//     quest_body.innerHTML = ``;
//     var questions = quiz_data.questions;
//     var question_title = document.createElement( 'div' );
//     question_title.className = "quest-title phetsarath";
//     var question_des = document.createElement( 'div' );
//     question_des.className = "quest-des phetsarath";
//     question_title.innerHTML = decodeHTMLEntities( questions[ parseInt( quiz_data.selection_index ) ].question_title );
//     question_des.innerHTML = decodeHTMLEntities( questions[ parseInt( quiz_data.selection_index ) ].question_des );
//     quest_body.appendChild( question_title );
//     quest_body.appendChild( question_des );
// }
// function load_ans() {
//     var lb_score = document.getElementById( "lb_score" );
//     var answer = document.getElementById( "ans" );
//     answer.innerHTML = ``;
//     var question = quiz_data.questions[ quiz_data.selection_index ];
//     var ans_box = document.createElement( "div" );
//     ans_box.className = "ans-box";
//     ans_box.innerHTML = ``;
//     if ( parseInt( question.question_type ) == 0 ) {
//         // 0 choice
//         question.ans_choice.forEach( _choice => {
//             var choice = document.createElement( "div" );
//             choice.className = "form-check";
//             choice.innerHTML = `<input class="form-check-input choice-inp" type="radio" name="choice" id="choice` + _choice.choice_index + `" >
//                                 <label class="form-check-label phetsarath" for="choice`+ _choice.choice_index + `">` + _choice.choice + `</label>`;
//             ans_box.appendChild( choice );
//         } );
//         answer.appendChild( ans_box );
//     } else if ( parseInt( question.question_type ) == 1 ) {
//         // 1 multiple choice
//         question.ans_choice.forEach( _choice => {
//             var choice = document.createElement( "div" );
//             choice.className = "form-check";
//             choice.innerHTML = `<input class="form-check-input choice-inp" type="checkbox" name="choice" id="choice` + _choice.choice_index + `" >
//                                 <label class="form-check-label phetsarath" for="choice`+ _choice.choice_index + `">` + _choice.choice + `</label>`;
//             ans_box.appendChild( choice );
//         } );
//         answer.appendChild( ans_box );
//     }
// }
// function load_button() {
//     var question_btn = document.getElementById( "question_btn" );
//     question_btn.innerHTML = "";
//     var questions = quiz_data.questions;
//     var act_class = "";
//     var action = "";
//     // var disable_previous = false;
//     // var disable_next = false;
//     // if ( quiz_data.selection_index == ( quiz_data.questions.length - 1 ) ) {
//     //     disable_next = true;
//     // }
//     questions.forEach( quest => {
//         if ( parseInt( quiz_data.selection_index ) == 0 && parseInt( quest.question_rang ) == 0 ) {
//             act_class = "active";
//             // disable_previous = true;
//         } else if ( parseInt( quiz_data.selection_index ) == parseInt( quest.question_rang ) ) {
//             act_class = "active";
//         } else {
//             act_class = "";
//             action = `onclick="question_num_selected(` + quest.question_rang + `)"`;
//         }

//         var quest_element = document.createElement( 'div' );
//         quest_element.className = "ques-num";
//         quest_element.id = 'quest' + quest.question_rang;
//         quest_element.innerHTML = `<div ` + action + ` class="quest-btn ` + act_class + `">` + ( parseInt( quest.question_rang ) + 1 ) + `</div>`;
//         question_btn.appendChild( quest_element );
//     } );
//     // var btn_previous = document.getElementById( "btn_prevoius" );
//     // var btn_next = document.getElementById( "btn_next" );
//     // btn_previous.disabled = disable_previous;
//     // btn_next.disabled = disable_next;
// }
function load_questions(){
    var quest_content = document.getElementById("quest_content");
    quest_content.innerHTML = ``;
    var questions = quiz_data.questions;
    questions.forEach((quest,index)=>{
        var title = document.createElement("div");
        title.className = "title";
        var question_title = document.createElement("div");
        question_title.className = "quest-title";
        var quest_number = document.createElement("span");
        quest_number.className = "quest-number";
        quest_number.innerHTML = (index+1)+". ";
        var quest_des = document.createElement("span");
        quest_des.className = "quest-des phetsarath";
        quest_des.innerHTML = decodeHTMLEntities(quest.question_title);
        var quest_full_point = document.createElement("span");
        quest_full_point.className = "quest-full-score phetsarath center";
        quest_full_point.innerHTML = `&#160;<button type="button" class="btn btn-warning" onclick="update_score('`+quest.quiz_question_id+`',`+quest.full_point+`,'`+index+`')">` +`(+ `+ quest.full_point+` ຄະແນນ) <i class="fas fa-pencil-alt"></i></button>
                                        <button type="button" class="btn btn-danger" onclick="del_quiz('`+quest.quiz_question_id+`','`+index+`')">
                                        <i class="fas fa-trash-alt"></i></button>`;
        question_title.appendChild(quest_number);
        question_title.appendChild(quest_des);
        question_title.appendChild(quest_full_point);
        title.appendChild(question_title);
        quest_content.appendChild(title);
        if(quest.question_des !=""){
            var quest_body = document.createElement("div");
            quest_body.className = "quest-body phetsarath";
            quest_body.innerHTML = decodeHTMLEntities(quest.question_des);
            quest_content.appendChild(quest_body);
        }
        if(parseInt(quest.question_type)==0){
            var ans_box = document.createElement( "div" );
            ans_box.className = "ans-box";
            ans_box.innerHTML = ``;
            quest.ans_choice.forEach( _choice => {
                var choice = document.createElement( "div" );
                choice.className = "form-check";
                choice.innerHTML = `<input class="form-check-input choice-inp" type="radio" name="choice" id="choice` + _choice.choice_index +index+ `" >
                                    <label class="form-check-label phetsarath" for="choice`+ _choice.choice_index +index+ `">` + _choice.choice + `</label>`;
                ans_box.appendChild( choice );
            } );
            quest_content.appendChild(ans_box);
        }
        if(parseInt(quest.question_type)==1){
            var ans_box = document.createElement( "div" );
            ans_box.className = "ans-box";
            ans_box.innerHTML = ``;
            quest.ans_choice.forEach( _choice => {
                var choice = document.createElement( "div" );
                choice.className = "form-check";
                choice.innerHTML = `<input class="form-check-input choice-inp" type="checkbox" name="choice" id="choice` + _choice.choice_index +index+ `" >
                <label class="form-check-label phetsarath" for="choice`+ _choice.choice_index +index+ `">` + _choice.choice + `</label>`;
                ans_box.appendChild( choice );
            } );
            quest_content.appendChild(ans_box);
        }
    });
}
// function question_num_selected( quest_num ) {
//     goto_quest( quest_num );
// }
// function goto_quest( quest_num ) {
//     quiz_data.selection_index = quest_num;
//     var _quiz_data = JSON.stringify( quiz_data );
//     var quiz_data_encoded = CryptoJS.AES.encrypt( _quiz_data, "view_quiz" ).toString();
//     sessionStorage.setItem( "quiz_data", quiz_data_encoded);
//     load_quiz_data();
//     load_question();
//     load_ans();
//     load_button();
// }
function del_quiz(quiz_question_id,index){
    Swal.fire({
        title: '<div class="phetsarath">ຢືນຢັນບໍ່ ?</div>',
        html: "<div class='phetsarath'>ທ່ານຕ້ອງການລຶບຄໍາຖາມນີ້ແມ່ນບໍ່</div>",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: '<div class="phetsarath">ຕົກລົງ</div>',
        cancelButtonText:'<div class="phetsarath">ຍົກເລີກ</div>'
    }).then((result) => {
        if (result.isConfirmed) {
            var http = new XMLHttpRequest();
            http.open( "POST", 'controller/quiz_preview_controller.php', true );
            http.setRequestHeader( 'Content-type', 'application/x-www-form-urlencoded' );
            http.onreadystatechange = function () {
                if ( this.readyState === XMLHttpRequest.DONE && this.status === 200 ) {
                    // console.log(this.responseText);
                    var res = JSON.parse(this.responseText);
                    if(res.success){
                        quiz_data.total_score = quiz_data.total_score - quiz_data.questions[index].full_point;
                        quiz_data.questions.splice(index,1);
                        quiz_data = JSON.stringify( quiz_data);
                        var quiz_data_encode = CryptoJS.AES.encrypt( quiz_data, "view_quiz" ).toString();
                        sessionStorage.setItem( "quiz_data", quiz_data_encode );
                        Swal.fire('<span class=phetsarath>ລຶບຂໍ້ມູນສໍາເລັດ!</span>', '', 'success');
                        load_quiz_data();
                        load_questions();
                    }else{
                        Swal.fire('<span class=phetsarath>ເກີດຂໍ້ຜິດພາດລະຫວ່າງການລຶບຂໍ້ມູນ!</span>', '', 'error')
                    }
                }
            }
            var param = {
                "quiz_question_id":quiz_question_id
            };
            var _param = encode( JSON.stringify( param ) );
            http.send( "delete_quiz_question=" + _param );
        }
    });
}
async function update_score(quiz_question_id,full_point,index){
    const { value: score } = await Swal.fire({
        title: '<div class="phetsarath">ກະລຸນາປ້ອນຄະແນນ</div>',
        input: 'number',
        inputPlaceholder: 'Full Score',
        inputValue:full_point,
        inputAttributes: {
          maxlength: 10,
          autocapitalize: 'off',
          autocorrect: 'off'
        }
      });
      
      if (score) {
        var http = new XMLHttpRequest();
        http.open( "POST", 'controller/quiz_preview_controller.php', true );
        http.setRequestHeader( 'Content-type', 'application/x-www-form-urlencoded' );
        http.onreadystatechange = function () {
            if ( this.readyState === XMLHttpRequest.DONE && this.status === 200 ) {
                // console.log(this.responseText);
                var res = JSON.parse(this.responseText);
                if(res.success){
                    quiz_data.total_score = parseInt(quiz_data.total_score) - parseInt(quiz_data.questions[index].full_point);
                    quiz_data.total_score = parseInt(quiz_data.total_score) + parseInt(score);
                    quiz_data.questions[index].full_point = score;
                    quiz_data = JSON.stringify( quiz_data);
                    var quiz_data_encode = CryptoJS.AES.encrypt( quiz_data, "view_quiz" ).toString();
                    sessionStorage.setItem( "quiz_data", quiz_data_encode );
                    load_quiz_data();
                    load_questions();
                }else{
                    Swal.fire('<span class=phetsarath>ເກີດຂໍ້ຜິດພາດລະຫວ່າງການລຶບຂໍ້ມູນ!</span>', '', 'error')
                }
            }
        }
        var param = {
            "quiz_question_id":quiz_question_id,
            "user_id":user_id,
            "full_point":score
        };
        var _param = encode( JSON.stringify( param ) );
        http.send( "update_score=" + _param );
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