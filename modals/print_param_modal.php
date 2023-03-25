<div class="modal fade" id="param" tabindex="-1" role="dialog" aria-labelledby="param">
    <div class="modal-dialog" role="document">
    <div class="modal-content">
            <div class="modal-header" 
                style="
                    background-color:var(--main-color); 
                    color:white; 
                    border-top-left-radius: .1rem;
                    border-top-right-radius: .1rem;">
                <h4 class="modal-title phetsarath" id="param-title">param</h4>
                <button type="button" class="close none-outline" data-dismiss="modal" aria-label="Close" style="padding: 0px; margin: 0px -10px 0px 0px;"><span class="modal-close-lb" aria-hidden="true">&times;</span></button>
            </div>
            <form id="frm-param" method="POST" action="print_form/score_report.php" target="_blank">
                <div class="modal-body">
                    <div class="form-group">
                        <label for="des" class="phetsarath">ເນື້ອໃນໃບປະເມີນວິຊາການ</label>
                        <input type="text" class="form-control phetsarath center none-select none-outline" 
                        id="des" name="des" 
                        value="ລາຍງານຜົນການປະເມີນພະນັກງານວິຊາການຂັ້ນ ..."
                        required>
                    </div>
                </div>
                <div class="modal-footer" style="justify-content:center;">
                    <button onclick="print_report()" type="button" name="print" class="cus-btn btn btn-primary btn-icon-text phetsarath none-outline none-select">
                        ພິມ
                        <i class="fas fa-solid fa-print btn-icon-append"></i>                                                                             
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