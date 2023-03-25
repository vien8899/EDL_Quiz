<?php
require_once "controller/open_exam_controller.php";
$class_id = "";
if (isset($_GET['class_id'])) {
    $class_id = $_GET['class_id'];
} else {
    echo "<script>window.location.href = 'template?page=open_exam'</script>";
}
?>
<link rel="stylesheet" href="assets/css/classroom-style.css">
<script src="assets/js/jquery-1.9.1.min.js"></script>
<div class="header-page">
    <div class="page-title">
        <h5 class="phetsarath">
            <a href="template?page=home" class="home-link">ໜ້າຫຼັກ</a><i class="fas fa-chevron-right"></i>
            <a href="template?page=open_exam" class="home-link"> ຫ້ອງສອບເສັງ</a><i class="fas fa-chevron-right"></i>
            ເລືອກຫົວຂໍ້ເສັງ
        </h5>
    </div>
</div>
<div class="page-wrapper">
    <div class="content-wrapper">
        <?php
        $user_id = @$user_data['id'];
        if(isset($_POST['open_test'])){
            $quiz_id = $_POST['id'];
            $start_time = $_POST['start_time'];
            $end_time = $_POST['end_time'];
            $remark = $_POST['txt_remark'];
            open_test($quiz_id,$start_time,$end_time,$user_id,$class_id,$remark);
        }
        $quiz_data = get_quiz_data($class_id)->fetchAll(PDO::FETCH_ASSOC);
        ?>
        <div class="row">
            <div class="col-lg-12 grid-margin stretch-card">
                <div class="cus-card card">
                <div class="card-body">
                    <h4 class="card-title phetsarath">ຫ້ອງສອບເສັງ</h4>
                    <div class="grid-margin transparent">
                        <div class="row">
                            <?php
                                foreach($quiz_data as $quiz){
                                    ?>
                                        <div class="col-lg-3 col-md-4 col-sm-6 mb-4 stretch-card transparent">
                                            <div class="deskboard-card card" style="background-color:darkorange">
                                                <div class="card-body">
                                                    <h3 class="phetsarath col-white"><?= $quiz["quiz_title"] ?></h3>
                                                    <div class="d-flex m-t-30 m-b-20 no-block align-items-center">
                                                        <span class="display-5 text-info pointer">
                                                            <img src="assets/svg/quiz2.svg" width="70">
                                                        </span>
                                                        <div class="ml-auto">
                                                            <div class="quiz_time phetsarath">ເວລາເສັງ <?= $quiz["quiz_time"] ?> ນາທີ</div>
                                                            <?php
                                                                if ($quiz["is_open"] == 0) {
                                                            ?>
                                                                    <div class="btn-open-test" >
                                                                        <button 
                                                                            data-bs-toggle="modal" data-id="<?= $quiz["quiz_id"] ?>" data-bs-target="#open_exam" 
                                                                            type="button" class="btn btn-primary phetsarath" 
                                                                            <?=$permission['open_exam']?'':'style="text-decoration: line-through;" disabled'?> >
                                                                            ເປີດສອບເສັງ
                                                                        </button>
                                                                    </div>
                                                                <?php
                                                                } else {
                                                                ?>
                                                                    <div class="btn-close-test">
                                                                        <button onclick="close_exam('<?=$quiz['quiz_id']?>','<?=$user_id?>','<?=$class_id?>')" type="button" class="btn btn-warning phetsarath" <?=$permission['close_exam']?'':'style="text-decoration: line-through;" disabled'?> >ປິດສອບເສັງ</button>
                                                                    </div>
                                                            <?php
                                                                }
                                                            ?>
                                                        </div>
                                                    </div>

                                                </div>
                                            </div>
                                        </div>
                                    <?php
                                }
                            ?>
                        </div>
                    </div>
                </div>
                </div>
            </div>
        </div>
        
    </div>
</div>
<?php
include_once("modals/open_exam_modal.php");
include_once("modals/confirm_dialog.php");
?>
<script>
    var open_exam = document.getElementById('open_exam');
    open_exam.addEventListener('show.bs.modal', function(event) {
        var quiz_data = $(event.relatedTarget);
        var quiz_id = quiz_data.data('id');
        var modal = $(this);
        modal.find('.modal-body #quiz_id').val(quiz_id);
    });
    function close_exam(_quiz_id,_user_id,_class_id){
        var param = {
            quiz_id:_quiz_id,
            user_id:_user_id,
            class_id:_class_id
        };
        // console.log(param);
        Swal.fire({
                title: '<span class="phetsarath">ທ່ານຕ້ອງການປິດການສອບເສັງແມ່ນບໍ່ ?</span>',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: '<span class="phetsarath">ຕົກລົງ</span>',
                cancelButtonText:'<span class="phetsarath">ຍົກເລີກ</span>'
            }).then((result) => {
                if (result.isConfirmed) {
                    var http = new XMLHttpRequest();
                    http.open( "POST", 'controller/open_exam_controller.php', true );
                    http.setRequestHeader( 'Content-type', 'application/x-www-form-urlencoded' );
                    http.onreadystatechange = function () {
                        if ( this.readyState === XMLHttpRequest.DONE && this.status === 200 ) {
                            // console.log(this.responseText);
                            var res = JSON.parse(this.responseText);
                            if(res.success){
                                Swal.fire('Success !', '', 'success').then(()=>{
                                    location.reload();
                                });
                            }
                        }
                    }
                    var _param = JSON.stringify( param );
                    http.send( "close_exam=" + _param );
                }
            });
    }
</script>