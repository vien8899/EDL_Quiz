function date_changed(data){
    var _date = new Date(data);
    document.getElementById("start-time-lb").innerHTML=_date.getDate().toString().padStart(2, "0")+"/"+(_date.getMonth() + 1).toString().padStart(2, "0")+"/"+_date.getFullYear()+" "+_date.getHours()+":"+_date.getMinutes();
}
function end_time_changed(data){
    var _date = new Date(data);
    document.getElementById("end-time-lb").innerHTML=_date.getDate().toString().padStart(2, "0")+"/"+(_date.getMonth() + 1).toString().padStart(2, "0")+"/"+_date.getFullYear()+" "+_date.getHours()+":"+_date.getMinutes();
}