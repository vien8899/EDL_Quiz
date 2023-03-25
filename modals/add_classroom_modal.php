<div class="modal fade" id="addclass" tabindex="-1" role="dialog" aria-labelledby="addclass">
    <div class="modal-dialog" role="document">
    <div class="modal-content">
            <div class="modal-header" 
                style="
                    background-color:var(--main-color); 
                    color:white; 
                    border-top-left-radius: .1rem;
                    border-top-right-radius: .1rem;">
                <h4 class="modal-title phetsarath" id="addclass">ເພີ່ມຫ້ອງເສັງໃໝ່</h4>
                <button type="button" class="close none-outline" data-dismiss="modal" aria-label="Close" style="padding: 0px; margin: 0px -10px 0px 0px;"><span class="modal-close-lb" aria-hidden="true">&times;</span></button>
            </div>
            <form method="POST" action="">
                <div class="modal-body">
                    <div class="form-group">
                        <label for="class_des" class="phetsarath">ກະລຸນາປ້ອນລາຍລະອຽດຫ້ອງເສັງ</label>
                        <input type="text" class="form-control phetsarath center none-select none-outline" id="class_des" name="class_des" required>
                    </div>
                    
                </div>
                <div class="modal-footer" style="justify-content:center;">
                    <button type="submit" name="new_class" class="cus-btn btn btn-primary btn-icon-text phetsarath none-outline none-select">
                        ບັນທຶກ
                        <i class="fas fa-save btn-icon-append"></i>                                                                             
                    </button>
                    <button type="button" class="cus-btn btn btn-warning btn-icon-text phetsarath none-outline none-select" data-dismiss="modal">
                        ຍົກເລີກ
                        <i class="fas fa-times btn-icon-append"></i>                                                                            
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
<!-- @if(session('update')==false)
<script>
    $(document).ready(function(){ 
        $('#addclass').modal({
             backdrop:'static'
        });
        @error('class_des')
            $('#addclass').modal('show');
        @enderror
    });
</script>
@endif -->

