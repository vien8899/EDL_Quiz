<div class="modal fade" id="editsubject" tabindex="-1" role="dialog" aria-labelledby="editsubject">
    <div class="modal-dialog" role="document">
    <div class="modal-content">
            <div class="modal-header" 
                style="
                    background-color:var(--main-color); 
                    color:white; 
                    border-top-left-radius: .1rem;
                    border-top-right-radius: .1rem;">
                <h4 class="modal-title phetsarath" id="addclass">ແກ້ໄຂຂໍ້ມູນວິຊາເສັງ</h4>
                <button type="button" class="close none-outline" data-bs-dismiss="modal" aria-label="Close"><span class="modal-close-lb" aria-hidden="true">&times;</span></button>
            </div>
            <form method="POST" action="">
                <div class="modal-body">
                    <div class="form-group">
                        <label for="subj_name" class="phetsarath">ກະລຸນາປ້ອນຊື່ວິຊາເສັງ</label>
                        <input type="text" name="subj_id" id="subj_id" hidden>
                        <input type="text" class="form-control phetsarath center none-select none-outline" id="subj_name" name="subj_name" required>
                    </div>
                    
                </div>
                <div class="modal-footer" style="justify-content:center;">
                    <button type="submit" name="update_subject" class="cus-btn btn btn-primary btn-icon-text phetsarath none-outline none-select">
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
            $('#editsubject').modal({
                backdrop:'static'
            });
        });
</script>
