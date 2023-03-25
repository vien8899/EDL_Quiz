function type_selected(value){
    var ques_0 = document.getElementById('ques-0');
    var ques_1 = document.getElementById('ques-1');
    var ques_2 = document.getElementById('ques-2');
    if(value==0){
        ques_0.hidden = false;
        ques_1.hidden = true;
        ques_2.hidden = true;
    }else if(value==1){
        ques_0.hidden = true;
        ques_1.hidden = false;
        ques_2.hidden = true;
    }else{
        ques_0.hidden = true;
        ques_1.hidden = true;
        ques_2.hidden = false;
    }
}
function add_ans_q_0(){
    var ans_selection = document.getElementById('ans-ques-0');
    var correct_ans = document.getElementById('correct_ans');
    var child_num = ans_selection.childElementCount+1;
    var ans_item = document.createElement('option');
    ans_item.value = parseInt(child_num)-1;
    ans_item.innerHTML = "ຄໍາຕອບທີ "+child_num;
    ans_item.id = "item"+child_num;
    correct_ans.appendChild(ans_item);
    var choice_item = document.createElement('div');
    choice_item.className = 'choice-item';
    choice_item.id = 'choice'+child_num;
    choice_item.innerHTML = `<div><div class="choice-caption phetsarath">ຄໍາຕອບທີ `+child_num+`*</div>
    <textarea name="txt_choice" id="txt_choice`+child_num+`" class="phetsarath"></textarea></div>
    <button onclick="remove_choice_q_0('txt_choice`+child_num+`','choice`+child_num+`','item`+child_num+`')" type="button" class="btn-remove-choice btn btn-light">
    <i class="fas fa-solid fa-trash"></i></button>`;
    ans_selection.appendChild(choice_item);
    CKEDITOR.inline('txt_choice'+child_num);
}
function add_ans_q_1(){
    var ans_selection = document.getElementById('ans-ques-1');
    var child_num = ans_selection.childElementCount+1;
    var choice_item = document.createElement('div');
    choice_item.className = 'choice-item';
    choice_item.id = 'multi-choice'+child_num;
    choice_item.innerHTML = `<div>
    <div class="choice-caption phetsarath">ຄໍາຕອບທີ `+child_num+`*</div>
    <textarea name="txt_multi_choice" id="txt_multi_choice`+child_num+`" class="phetsarath"></textarea></div><div>
    <input value="`+(parseInt(child_num)-1)+`" type="radio" class="btn-check" name="choice`+child_num+`" id="choice`+child_num+`-true" autocomplete="off">
    <label class="btn-choice btn btn-outline-success phetsarath" for="choice`+child_num+`-true">ຖືກ</label>
    <input type="radio" class="btn-check" name="choice`+child_num+`" id="choice`+child_num+`-false" autocomplete="off">
    <label class="btn-choice btn btn-outline-danger phetsarath" for="choice`+child_num+`-false">ຜິດ</label>
    <button onclick="remove_choice_q_1('txt_multi_choice`+child_num+`','multi-choice`+child_num+`')" type="button" class="btn-remove-choice btn btn-light">
    <i class="fas fa-solid fa-trash"></i></button>
  </div>`;
    ans_selection.appendChild(choice_item);
    CKEDITOR.inline('txt_multi_choice'+child_num);
}
function remove_choice_q_0(txt_choice,choice,item){
    var ans_choice = document.getElementById(choice);
    ans_choice.remove();
    var txt = CKEDITOR.instances[txt_choice];
    if (txt) {
        CKEDITOR.remove(txt);
    }
    var item = document.getElementById(item);
    item.remove();
}
function remove_choice_q_1(txt_choice,choice){
    var ans_choice = document.getElementById(choice);
    ans_choice.remove();
    var txt = CKEDITOR.instances[txt_choice];
    if (txt) {
        CKEDITOR.remove(txt);
    }
}
function save_question(question_type,_user_id,url_param){
    var _subj_id = $('select#subject').val();
    var _question = CKEDITOR.instances.txt_question.getData();
    var _full_score = parseInt($('input#full_score').val());
    var _title = CKEDITOR.instances.txt_question_title.getData();
    var param = {};
    if(_title == ""){
        Swal.fire({icon:'info',html:'<span class=phetsarath>ກະລຸນາປ້ອນຂໍ້ມູນໃຫ້ຄົບຖ້ວນ!</span>'});
        return;
    }
    if(question_type==0){
        //choice
        var ans = $('select#correct_ans').val();
        var _ans_choice = [];
        var _correct_ans = [ parseInt(ans)];
        for(var instanceName in CKEDITOR.instances) {
            var name = CKEDITOR.instances[instanceName].element.$.name;
            var element_id = CKEDITOR.instances[instanceName].element.$.id;
            if(name=="txt_choice"){
                var ans_choice = CKEDITOR.instances[instanceName].getData();
                if(ans_choice==""){
                    Swal.fire({icon:'info',html:'<span class=phetsarath>ກະລຸນາປ້ອນຂໍ້ມູນໃຫ້ຄົບຖ້ວນ!</span>'});
                    return;
                }
                var index = parseInt(element_id.substring(10,element_id.length))-1;
                _ans_choice[index] = ans_choice;
            }
        }
        param = {
            urlParam:url_param,
            title:_title,
            question:_question,
            ans_choice:_ans_choice,
            correct_ans:_correct_ans,
            question_type:0,
            subj_id:_subj_id,
            user_id:_user_id,
            show_ques_content:0,
            full_point:_full_score
        }
        // console.log(param);

    }else if(question_type==1){
        //multi_choice
        var _ans_choice = [];
        var _correct_ans = [];
        for(var instanceName in CKEDITOR.instances) {
            var name = CKEDITOR.instances[instanceName].element.$.name;
            var element_id = CKEDITOR.instances[instanceName].element.$.id;
            if(name=="txt_multi_choice"){
                var ans_choice = CKEDITOR.instances[instanceName].getData();
                if(ans_choice==""){
                    Swal.fire({icon:'info',html:'<span class=phetsarath>ກະລຸນາປ້ອນຂໍ້ມູນໃຫ້ຄົບຖ້ວນ!</span>'});
                    return;
                }
                var index = parseInt(element_id.substring(16,element_id.length))-1;
                var rd_name = element_id.substring(10,element_id.length);
                var _ans = document.getElementsByName(rd_name);
                if(_ans[0].checked){
                    _correct_ans.push(parseInt(_ans[0].value));
                }
                _ans_choice[index] = ans_choice;

            }
        }
        param = {
            urlParam:url_param,
            title:_title,
            question:_question,
            ans_choice:_ans_choice,
            correct_ans:_correct_ans,
            question_type:1,
            subj_id:_subj_id,
            user_id:_user_id,
            show_ques_content:0,
            full_point:_full_score
        }
        // console.log(param);
    }else{
        //none_choice
        var _show_ques_content = 0;
        if(document.getElementById('show_question_content').checked){
            _show_ques_content = 1;
        }
        param = {
            urlParam:url_param,
            title:_title,
            question:_question,
            ans_choice:[],
            correct_ans:[],
            question_type:2,
            subj_id:_subj_id,
            user_id:_user_id,
            show_ques_content:_show_ques_content,
            full_point:_full_score
        }
    }
    var http = new XMLHttpRequest();
      http.open("POST", 'controller/question_controller.php', true);
      http.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
      http.onreadystatechange = function() {
          if (this.readyState === XMLHttpRequest.DONE && this.status === 200) {
            // console.log(this.responseText);
            eval(this.responseText);
          }
      }
      var _param = encode(JSON.stringify(param));
      http.send("new_question=" + _param);
}
function update_question(question_type,_user_id,ques_id,url_param){
    var _subj_id = $('select#subject').val();
    var _question = CKEDITOR.instances.txt_question.getData();
    var _full_score = parseInt($('input#full_score').val());
    var _title = CKEDITOR.instances.txt_question_title.getData();
    var param = {};
    if(_title == ""){
        Swal.fire({icon:'info',html:'<span class=phetsarath>ກະລຸນາປ້ອນຂໍ້ມູນໃຫ້ຄົບຖ້ວນ!</span>'});
        return;
    }
    if(question_type==0){
        //choice
        var ans = $('select#correct_ans').val();
        var _ans_choice = [];
        var _correct_ans = [ parseInt(ans)];
        for(var instanceName in CKEDITOR.instances) {
            var name = CKEDITOR.instances[instanceName].element.$.name;
            var element_id = CKEDITOR.instances[instanceName].element.$.id;
            if(name=="txt_choice"){
                var ans_choice = CKEDITOR.instances[instanceName].getData();
                if(ans_choice==""){
                    Swal.fire({icon:'info',html:'<span class=phetsarath>ກະລຸນາປ້ອນຂໍ້ມູນໃຫ້ຄົບຖ້ວນ!</span>'});
                    return;
                }
                var index = parseInt(element_id.substring(10,element_id.length))-1;
                _ans_choice[index] = ans_choice;
            }
        }
        param = {
            urlParam:url_param,
            title:_title,
            question:_question,
            ans_choice:_ans_choice,
            correct_ans:_correct_ans,
            question_type:0,
            subj_id:_subj_id,
            user_id:_user_id,
            show_ques_content:0,
            full_point:_full_score,
            question_id:ques_id
        }
        // console.log(param);

    }else if(question_type==1){
        //multi_choice
        var _ans_choice = [];
        var _correct_ans = [];
        for(var instanceName in CKEDITOR.instances) {
            var name = CKEDITOR.instances[instanceName].element.$.name;
            var element_id = CKEDITOR.instances[instanceName].element.$.id;
            if(name=="txt_multi_choice"){
                var ans_choice = CKEDITOR.instances[instanceName].getData();
                if(ans_choice==""){
                    Swal.fire({icon:'info',html:'<span class=phetsarath>ກະລຸນາປ້ອນຂໍ້ມູນໃຫ້ຄົບຖ້ວນ!</span>'});
                    return;
                }
                var index = parseInt(element_id.substring(16,element_id.length))-1;
                var rd_name = element_id.substring(10,element_id.length);
                var _ans = document.getElementsByName(rd_name);
                if(_ans[0].checked){
                    _correct_ans.push(parseInt(_ans[0].value));
                }
                _ans_choice[index] = ans_choice;

            }
        }
        param = {
            urlParam:url_param,
            title:_title,
            question:_question,
            ans_choice:_ans_choice,
            correct_ans:_correct_ans,
            question_type:1,
            subj_id:_subj_id,
            user_id:_user_id,
            show_ques_content:0,
            full_point:_full_score,
            question_id:ques_id
        }
        // console.log(param);
    }else{
        //none_choice
        var _show_ques_content = 0;
        if(document.getElementById('show_question_content').checked){
            _show_ques_content = 1;
        }
        param = {
            urlParam:url_param,
            title:_title,
            question:_question,
            ans_choice:[],
            correct_ans:[],
            question_type:2,
            subj_id:_subj_id,
            user_id:_user_id,
            show_ques_content:_show_ques_content,
            full_point:_full_score,
            question_id:ques_id
        }
    }
    // console.log(param);
    var http = new XMLHttpRequest();
      http.open("POST", 'controller/question_controller.php', true);
      http.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
      http.onreadystatechange = function() {
          if (this.readyState === XMLHttpRequest.DONE && this.status === 200) {
            // console.log(this.responseText);
            eval(this.responseText);
          }
      }
      var _param = encode(JSON.stringify(param));
      http.send("update_question=" + _param);
}