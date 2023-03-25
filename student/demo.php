<?php
    require_once "controller/demo_exam_controller.php";
    $user_id = @$user_data["id"];
    $quiz_data = load_demo_quiz()->fetchAll(PDO::FETCH_ASSOC);
?>
<div>
    <link rel="stylesheet" href="assets/css/home-style.css">
    <div class="row">
        <div class="col-lg-12 grid-margin stretch-card">
            <div class="cus-card card">
                <div class="card-body">
                    <div class="grid-margin transparent">
                        <div class="row">
                            <?php
                                $null_data = true;
                                foreach($quiz_data as $quiz){
                            ?>
                            <div class="col-lg-3 col-md-4 col-sm-6 mb-4 stretch-card transparent">
                                <div class="deskboard-card card" style="background-color:darkorange">
                                    <div class="card-body">
                                        <h3 class="phetsarath col-white"><?=$quiz['quiz_title']?></h3>
                                        <div class="d-flex m-t-30 m-b-20 no-block align-items-center">
                                            <span class="display-5 text-info pointer">
                                                <img src="assets/svg/quiz2.svg" width="70">
                                            </span>
                                            <!-- <h1 class="ml-auto col-white">test</h1> -->
                                            <div class="ml-auto">
                                                <div class="quiz_time phetsarath">ເວລາເສັງ <?=$quiz['quiz_time']?> ນາທີ</div>
                                                
                                                <div class="btn-open-test">
                                                    <button id="open_test" onclick="window.location.href='main?page=demo-invite&quiz_id=<?=$quiz['quiz_id']?>'" type="button" class="btn btn-primary phetsarath">ເລີ່ມສອບເສັງ</button>
                                                </div>
                                            </div>
                                        </div>

                                    </div>
                                </div>
                            </div>
                            <?php
                                    $null_data = false;
                                } 
                            ?>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>