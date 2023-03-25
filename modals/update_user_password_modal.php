<div class="modal fade" id="update_pwd" tabindex="-1" role="dialog" aria-labelledby="update_pwd">
    <div class="modal-dialog" role="document">
    <div class="modal-content">
            <div class="modal-header" 
                style="
                    background-color:var(--main-color); 
                    color:white; 
                    border-top-left-radius: .1rem;
                    border-top-right-radius: .1rem;">
                <h4 class="modal-title phetsarath" id="addclass">ຕັ້ງລະຫັດຜ່ານໃໝ່</h4>
                <button type="button" class="close none-outline" data-bs-dismiss="modal" aria-label="Close"><span class="modal-close-lb" aria-hidden="true">&times;</span></button>
            </div>
            <form method="POST" action="">
                <div class="modal-body">
                    <div class="form-group">
                        <label for="subj_name" class="phetsarath">ກະລຸນາປ້ອນລະຫັດຜ່ານໃໝ່</label>
                        <input type="text" name="u_id" id="u_id" hidden>
                        <input type="password" class="form-control phetsarath center none-select none-outline" id="password" name="password" value="edlquiz" required>
                    </div>
                    
                </div>
                <div class="modal-footer" style="justify-content:center;">
                    <button type="submit" name="update_pwd" class="cus-btn btn btn-primary btn-icon-text phetsarath none-outline none-select">
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
            $('#update_pwd').modal({
                backdrop:'static'
            });
        });
</script>
