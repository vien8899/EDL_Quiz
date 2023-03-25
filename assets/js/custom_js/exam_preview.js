var exam_data;
Swal.fire( {
    html: '<h2 class="phetsarath">ກະລຸນາລໍຖ້າ !</h2><h4 class="phetsarath">ກໍາລັງໂຫຼດຂໍ້ມູນ</h4>',
    timer: 300,
    allowOutsideClick: false,
    didOpen: () => {
        Swal.showLoading()
    }
}).then( () => {
    load_exam_data();
    load_ans_data()
});
Swal.stopTimer();
var http = new XMLHttpRequest();
http.open( "POST", 'controller/exam_preview_controller.php', true );
http.setRequestHeader( 'Content-type', 'application/x-www-form-urlencoded' );
http.onreadystatechange = function () {
    if ( this.readyState === XMLHttpRequest.DONE && this.status === 200 ) {
        // console.log(this.responseText);
        var res = JSON.parse(this.responseText);
        var data = JSON.stringify(res);
        var exam_data_encode = CryptoJS.AES.encrypt( data, "view_exam" ).toString();
        sessionStorage.setItem( "exam_data", exam_data_encode );
        Swal.resumeTimer();
    }
}
var _param = encode( JSON.stringify( param ) );
http.send( "load_ans_data=" + _param );
function load_exam_data(){
    var exam_data_encode = sessionStorage.getItem("exam_data");
    exam_data = JSON.parse(CryptoJS.AES.decrypt(exam_data_encode,"view_exam").toString( CryptoJS.enc.Utf8 ));
    var test_info = document.getElementById("test_number");
    test_info.innerHTML = exam_data.test_number+`-`+exam_data.fullname;
    var quiz_title = document.getElementById('quiz_title');
    quiz_title.innerHTML = exam_data.quiz_title;
    // var score = document.getElementById("score");
    // score.innerHTML = " (ຄະແນນເຕັມ "+quiz_data.total_score+" ຄະແນນ)";
}
function load_ans_data(){
    var quest_content = document.getElementById("quest_content");
    quest_content.innerHTML = ``;
    var questions = exam_data.ans_data;
    questions.forEach((quest,index) => {
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
        question_title.appendChild(quest_number);
        question_title.appendChild(quest_des);
        title.appendChild(question_title);
        quest_content.appendChild(title);
        if(quest.question_des !="" && parseInt(quest.question_type)!=2){
            var quest_body = document.createElement("div");
            quest_body.className = "quest-body phetsarath";
            quest_body.innerHTML = decodeHTMLEntities(quest.question_des);
            quest_content.appendChild(quest_body);
        }
        if(parseInt(quest.question_type)==0){
            var ans_box = document.createElement( "div" );
            ans_box.className = "ans-box";
            ans_box.innerHTML = ``;
            var ans_choice = JSON.parse(decodeHTMLEntities(quest.ans_choice));
            // console.log(ans_choice);
            ans_choice.forEach( _choice => {
                var selected = "disabled readonly";
                if(_choice.is_selected){
                    selected = `onclick="return false;" checked `;
                }
                var choice = document.createElement( "div" );
                choice.className = "form-check";
                choice.innerHTML = `<input class="form-check-input choice-inp" type="radio" name="choice`+index+`" id="choice` + _choice.choice_index +index+ `" `+ selected +`>
                                    <label class="form-check-label phetsarath" for="choice`+ _choice.choice_index +index+ `">` + _choice.choice + `</label>`;
                ans_box.appendChild( choice );
            } );
            quest_content.appendChild(ans_box);

        }
        if(parseInt(quest.question_type)==1){
            var ans_box = document.createElement( "div" );
            ans_box.className = "ans-box";
            ans_box.innerHTML = ``;
            var ans_choice = JSON.parse(quest.ans_choice);
            ans_choice.forEach( _choice => {
                var selected = "disabled readonly";
                if(_choice.is_selected){
                    selected = `onclick="return false;" checked`;
                }
                var choice = document.createElement( "div" );
                choice.className = "form-check";
                choice.innerHTML = `<input class="form-check-input choice-inp" type="checkbox" name="choice" id="choice` + _choice.choice_index +index+ `" `+ selected +` >
                <label class="form-check-label phetsarath" for="choice`+ _choice.choice_index +index+ `">` + _choice.choice + `</label>`;
                ans_box.appendChild( choice );
            } );
            quest_content.appendChild(ans_box);
        }
        if(parseInt(quest.question_type)==2){
            var ans_box = document.createElement( "div" );
            ans_box.className = "ans-box phetsarath";
            ans_box.innerHTML = `<b><u>ຄໍາຕອບ:</u></b><br>`+decodeHTMLEntities(quest.answer);;
            quest_content.appendChild(ans_box);
        }
    });
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