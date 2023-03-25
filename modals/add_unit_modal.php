<div class="modal fade" id="add_unit" tabindex="-1" role="dialog" aria-labelledby="add_unit">
    <div class="modal-dialog" role="document">
    <div class="modal-content">
            <div class="modal-header" 
                style="
                    background-color:var(--main-color); 
                    color:white; 
                    border-top-left-radius: .1rem;
                    border-top-right-radius: .1rem;">
                <h4 class="modal-title phetsarath" id="addclass">ເພີ່ມຂໍ້ມູນພະແນກ</h4>
                <button type="button" class="close none-outline" data-bs-dismiss="modal" aria-label="Close"><span class="modal-close-lb" aria-hidden="true">&times;</span></button>
            </div>
            <form method="POST" action="">
                <div class="modal-body">
                    <div id="dep_frame">
                        <label class="phetsarath">ຂຶ້ນກັບຝ່າຍ</label>
                        <select class="form-select phetsarath" aria-label="Default select" id="dep" name="dep">
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="subj_name" class="phetsarath">ກະລຸນາປ້ອນຊື່ພະແນກ</label>
                        <input type="text" name="subj_id" id="subj_id" hidden>
                        <input type="text" class="form-control phetsarath center none-select none-outline" id="unit_des" name="unit_des" required>
                    </div>
                </div>
                <div class="modal-footer" style="justify-content:center;">
                    <button type="submit" name="add_unit" class="cus-btn btn btn-primary btn-icon-text phetsarath none-outline none-select">
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
    $(document).ready(function(){ 
        $('#add_unit').modal({
            backdrop:'static'
        });
    });
</script>
