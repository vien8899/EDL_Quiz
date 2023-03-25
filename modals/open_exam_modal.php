<link rel="stylesheet" href="assets/css/open-exam-style.css">
<div class="modal fade" id="open_exam" tabindex="-1" data-bs-backdrop="static" role="dialog" aria-labelledby="open_exam">
    <div class="modal-dialog" role="document">
    <div class="modal-content">
            <div class="modal-header" 
                style="
                    background-color:var(--main-color); 
                    color:white; 
                    border-top-left-radius: .1rem;
                    border-top-right-radius: .1rem;">
                <h4 class="modal-title phetsarath" id="addclass">ເປີດສອບເສັງ</h4>
                <button type="button" class="close none-outline" data-bs-dismiss="modal" aria-label="Close" style="padding: 0px; margin: 0px -10px 0px 0px;"><span class="modal-close-lb" aria-hidden="true">&times;</span></button>
            </div>
            <form method="POST" action="">
                <div class="modal-body">
                    <div class="row center">
                        <h4 class="phetsarath">ເລືອກເວລາເປີດສອບເສັງ</h4>
                    </div>
                    <hr>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group bottom-0">
                                <div class="col-sm-12 btn-time">
                                    <label class="lb">
                                        <input type="datetime-local" id="start_time" name="start_time" onchange="date_changed(this.value)" required>
                                        <button class="btn-calendar" id="calendar_text">
                                            <div id="start-time-lb" class="phetsarath f12">ເລີ່ມຕົ້ນ</div>
                                            <div class="calender-ico"><img src="assets/svg/calendar.svg" width="20"></div>
                                        </button>
                                    </label>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group bottom-0">
                                <div class="col-sm-12 btn-time">
                                    <label class="lb">
                                        <input type="datetime-local" id="end_time" name="end_time" onchange="end_time_changed(this.value)">
                                        <button class="btn-calendar" id="calendar_text">
                                            <div id="end-time-lb" class="phetsarath f12">ສິ້ນສຸດ</div>
                                            <div class="calender-ico"><img src="assets/svg/calendar.svg" width="20"></div>
                                        </button>
                                    </label>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <textarea class="form-control phetsarath" name="txt_remark" id="txt_remark" rows="3" placeholder="Remark"></textarea>
                        </div>
                    </div>
                    <!-- <div class="form-group"> -->
                        <!-- <label for="class_des" class="phetsarath">ກະລຸນາປ້ອນລາຍລະອຽດຫ້ອງເສັງ</label> -->
                        <input type="text" name="id" id="quiz_id" hidden>
                        <!-- <input type="text" class="form-control phetsarath center none-select none-outline" id="class_des" name="class_des" required> -->
                    <!-- </div> -->
                    
                </div>
                <div class="modal-footer" style="justify-content:center;">
                    <button type="submit" name="open_test" class="cus-btn btn btn-primary btn-icon-text phetsarath none-outline none-select">
                        ເປີດສອບເສັງ
                        <!-- <i class="fas fa-save btn-icon-append"></i>                                                                       -->
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
<script src="assets/js/custom_js/open_exam.js"></script>

