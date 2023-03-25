function clear_data(){
    var _class = document.getElementById("class");
    var quiz = document.getElementById("quiz");
    var exam_date = document.getElementById("exam_date_param");
    var exam_date_lb = document.getElementById("exam-date-lb");
    var remark = document.getElementById("remark");
    _class.value = '0';
    quiz.value = '0';
    exam_date.value = '';
    remark.value = '';
    exam_date_lb.innerHTML = "ວັນທີເສັງ";
}
function date_changed( data ) {
    var _date = new Date( data );
    document.getElementById( "exam-date-lb" ).innerHTML = _date.getDate().toString().padStart( 2, "0" ) + "/" + ( _date.getMonth() + 1 ).toString().padStart( 2, "0" ) + "/" + _date.getFullYear();
}