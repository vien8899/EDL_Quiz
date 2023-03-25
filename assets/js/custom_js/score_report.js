function print_report(){
    $("[data-dismiss=modal]").trigger({ type: "click" });
    var students = document.getElementsByName('cb_student[]');
    var student_checked = [];
    students.forEach(student => {
        if (student.checked) {
            student_checked.push(student.value);
        }
    });
    console.log(student_checked);
    if(student_checked.length==0){
        Swal.fire({icon:'info',html:'<span class=phetsarath>ກະລຸນາເລືອກຂໍ້ມູນນັກສອບເສັງກ່ອນ!</span>'});
    }else{
        if(exam_date==''){
            Swal.fire({icon:'info',html:'<span class=phetsarath>ກະລຸນາເລືອກວັນທີ່ເສັງຢູ່ Filter ກ່ອນ!</span>'});
        }else{
            var print_param = [];
            student_checked.forEach(index=>{
                print_param.push(data[index]);
            });
            var element = document.getElementById("data");
            if(element!=null){
                element.parentNode.removeChild(element);
            }
            var el_date = document.getElementById("exam_date");
            if(el_date!=null){
                el_date.parentNode.removeChild(el_date);
            }
            var form = document.getElementById('frm-param');
            var input = document.createElement('input');
            input.name = "data";
            input.id = "data";
            input.setAttribute("type", "hidden");
            input.value = JSON.stringify(print_param);
            form.appendChild(input);
            var input_date = document.createElement('input');
            input_date.name = "exam_date";
            input_date.id = "exam_date";
            input_date.setAttribute("type", "hidden");
            input_date.value = exam_date;
            form.appendChild(input_date);
            form.submit();
        }
    }
}