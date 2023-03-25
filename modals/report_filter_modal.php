<?php
    require_once "controller/report_controller.php";
    $class_data = get_class_data()->fetchAll(PDO::FETCH_ASSOC);
    $filter_data = isset($_SESSION['report_filter'])?$_SESSION['report_filter']:[];
    $has_filter = isset($_SESSION['report_filter'])?true:false;
    $class_id = $has_filter?$filter_data['class_id']:0;
    $quiz_data = get_quiz($class_id)->fetchAll(PDO::FETCH_ASSOC);
?>
<link rel="stylesheet" href="assets/css/report-filter-style.css">
<div class="modal fade" id="report_filter" tabindex="-1" role="dialog" aria-labelledby="report_filter">
    <div class="modal-dialog" role="document">
    <div class="modal-content">
            <div class="modal-header" 
                style="
                    background-color:var(--main-color); 
                    color:white; 
                    border-top-left-radius: .1rem;
                    border-top-right-radius: .1rem;">
                <h4 class="modal-title phetsarath" id="addclass">Report Filter</h4>
                <button type="button" class="close none-outline" data-dismiss="modal" aria-label="Close" style="padding: 0px; margin: 0px -10px 0px 0px;"><span class="modal-close-lb" aria-hidden="true">&times;</span></button>
            </div>
            <form method="POST" action="">
                <div class="modal-body">
                    <div class="form-group">
                        <label for="class" class="phetsarath">ຫ້ອງເສັງ</label>
                        <select class="form-select phetsarath" aria-label="Default select" id="class" name="class">
                            <option value="0">ບໍ່ລະບຸ</option>
                            <?php 
                                foreach($class_data as $class){
                                    ?>
                                    <option value="<?=$class['id']?>" 
                                        <?=($has_filter && ($filter_data['class_id']==$class['id']))?'selected':''?>>
                                        <?=$class['class_des']?>
                                    </option>
                                    <?php
                                }
                            ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="quiz" class="phetsarath">ຫົວຂໍ້ເສັງ</label>
                        <select class="form-select phetsarath" aria-label="Default select" id="quiz" name="quiz">
                            <option value="0">ບໍ່ລະບຸ</option>
                            <?php 
                                foreach($quiz_data as $quiz){
                                    ?>
                                    <option value="<?=$quiz['quiz_id']?>" 
                                        <?=($has_filter && ($filter_data['quiz_id']==$quiz['quiz_id']))?'selected':''?>>
                                        <?=$quiz['quiz_title']?>
                                    </option>
                                    <?php
                                }
                            ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <div class="col-sm-12 btn-time">
                            <label class="lb">
                                <input type="date" id="exam_date_param" name="exam_date_param" onchange="date_changed(this.value)" <?=($has_filter && ($filter_data['exam_date']!=''))?'value="'.$filter_data['exam_date'].'"':''?>>
                                <button class="btn-calendar" id="calendar_text">
                                    <div id="exam-date-lb" class="phetsarath f12"> <?= ($has_filter && ($filter_data['exam_date']!='')) ? date("d/m/Y", strtotime($filter_data['exam_date'])):"ວັນທີເສັງ" ?></div>
                                    <div class="calender-ico"><img src="assets/svg/calendar.svg" width="20"></div>
                                </button>
                            </label>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="subj_name" class="phetsarath">Remake</label>
                        <input type="text" class="form-control phetsarath center none-select none-outline" id="remark" name="remark" <?=($has_filter)?'value="'.$filter_data['remark'].'"':''?>>
                    </div>
                </div>
                <div class="modal-footer" style="justify-content:center;">
                    <button type="submit" name="apply_filter" class="cus-btn btn btn-primary btn-icon-text phetsarath none-outline none-select">
                        ສະແດງຂໍ້ມູນ
                        <i class="fas fa-solid fa-eye btn-icon-append"></i>                                                                          
                    </button>
                    <button onclick="clear_data()" type="button" class="cus-btn btn btn-warning btn-icon-text phetsarath none-outline none-select">
                        Clear
                        <i class="fas fa-times btn-icon-append"></i>                                                                            
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>