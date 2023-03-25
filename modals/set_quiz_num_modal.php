<div class="modal fade" id="question_num" tabindex="-1" role="dialog" aria-labelledby="question_num" data-bs-backdrop="static">
    <div class="modal-dialog" role="document">
    <div class="modal-content">
            <div class="modal-header" 
                style="
                    background-color:var(--main-color); 
                    color:white; 
                    border-top-left-radius: .1rem;
                    border-top-right-radius: .1rem;">
                <h4 class="modal-title phetsarath" id="question_num">ກໍານົດຈໍານວນຄໍາຖາມສອບເສັງ</h4>
                <button type="button" class="close none-outline" data-bs-dismiss="modal" aria-label="Close" style="padding: 0px; margin: 0px -10px 0px 0px;"><span class="modal-close-lb" aria-hidden="true">&times;</span></button>
            </div>
            <form method="POST" action="">
                <div class="modal-body">
                    <div class="form-group">
                        <label id="question_num_lb" class="col-form-label phetsarath f12 quiz_time_lb">ຈໍານວນຄໍາຖາມ: 0 ຄໍາຖາມ</label>
                        <input name="q_num" onchange="update_question_num(this.value)" type="range" step="1" class="form-range" min="0" max="0" id="_question_num" value="0">
                        <input type="hidden" id="quiz_id" name="quiz_id" value="">
                    </div>
                    
                </div>
                <div class="modal-footer" style="justify-content:center;">
                    <button type="submit" name="set_question_num" class="cus-btn btn btn-primary btn-icon-text phetsarath none-outline none-select">
                        ບັນທຶກ
                        <i class="fas fa-save btn-icon-append"></i>                                                                             
                    </button>
                    <button type="button" class="cus-btn btn btn-warning btn-icon-text phetsarath none-outline none-select" data-bs-dismiss="modal">
                        ຍົກເລີກ
                        <i class="fas fa-times btn-icon-append"></i>                                                                            
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
<script>
    function update_question_num(value){
        document.getElementById('question_num_lb').innerHTML = "ຈໍານວນຄໍາຖາມ: "+value+" ຄໍາຖາມ";
    }
</script>

