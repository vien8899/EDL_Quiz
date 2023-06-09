<div class="modal fade" id="param_exp" tabindex="-1" role="dialog" aria-labelledby="param">
    <div class="modal-dialog" role="document">
    <div class="modal-content">
            <div class="modal-header" 
                style="
                    background-color:var(--main-color); 
                    color:white; 
                    border-top-left-radius: .1rem;
                    border-top-right-radius: .1rem;">
                <h4 class="modal-title phetsarath" id="param-title">Report Title</h4>
                <button type="button" class="close none-outline" data-dismiss="modal" aria-label="Close" style="padding: 0px; margin: 0px -10px 0px 0px;"><span class="modal-close-lb" aria-hidden="true">&times;</span></button>
            </div>
            <form id="frm-param_exp" method="POST" action="print_form/score_report_exp.php" target="_blank">
                <div class="modal-body">
                    <div class="form-group">
                        <label for="title_des" class="phetsarath">ເນື້ອໃນໃບປະເມີນວິຊາການ</label>
                        <input type="text" class="form-control phetsarath center none-select none-outline" 
                        id="title_des" name="title_des" 
                        value="ລາຍງານຜົນການປະເມີນພະນັກງານວິຊາການຂັ້ນ ..."
                        required>
                    </div>
                </div>
                <div class="modal-footer" style="justify-content:center;">
                    <button onclick="export_to_excel()" type="button" name="print" class="cus-btn btn btn-primary btn-icon-text phetsarath none-outline none-select">
                        ຕົກລົງ
                        <i class="fas fa-file-excel btn-icon-append"></i>                                                                             
                    </button>
                    <button id="btn_close" type="button" class="cus-btn btn btn-warning btn-icon-text phetsarath none-outline none-select" data-dismiss="modal">
                        ຍົກເລີກ
                        <i class="fas fa-times btn-icon-append"></i>                                                                            
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>