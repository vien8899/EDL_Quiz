<div class="modal fade" id="confirm_dialog" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel1">
    <div class="modal-dialog" role="document" style="max-width:350px;">
    <div class="modal-content">
            <div class="modal-header" 
                style="
                    background-color:var(--main-color); 
                    color:white; 
                    border-top-left-radius: .1rem;
                    border-top-right-radius: .1rem;">
                <h4 class="modal-title" id="exampleModalLabel1">CONFIRM</h4>
                <button type="button" class="close none-outline" data-bs-dismiss="modal" aria-label="Close" style="padding: 0px; margin: 0px -10px 0px 0px;"><span class="modal-close-lb" aria-hidden="true">&times;</span></button>
            </div>
            <form method="POST" action="">
                <div class="modal-body">
                    <div class="lb">
                        <h5 class="phetsarath" id="title"></h5>
                    </div>
                    <input type="hidden" name="id" id="id">
                </div>
                <div class="modal-footer" style="justify-content:center;">
                    <button id="btn_yes" type="submit" class="btn btn-secondary none-outline none-select" style="min-width:100px;">Yes</button>
                    <button type="button" class="btn btn-secondary none-outline none-select" data-bs-dismiss="modal" style="min-width:100px;">No</button>
                </div>
            </form>
        </div>
    </div>
</div>