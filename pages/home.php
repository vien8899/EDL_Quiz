<?php
    require_once "controller/daskboard_controller.php";
    $_data = load_data()->fetchAll(PDO::FETCH_ASSOC)[0]['data'];
    $data = json_decode($_data);
    // print_r($_data);
    // echo "<pre>";
    // print_r($data);
    // echo "</pre>";
?>
<link rel="stylesheet" href="assets/css/home-style.css">
<div class="header-page">
        <div class="page-title">
            <h5 class="phetsarath home-link">ໜ້າຫຼັກ</h5>
        </div>
    </div>
    <div class="page-wrapper">
        <div class="row">
			
			
            <div class="col-md-6 grid-margin stretch-card">
                <div class="deskboard-card card tale-bg">
				
				    <div class="col-md-12 col-xl-6 d-flex flex-column justify-content-start">
                        <div class="ml-xl-12 mt-3">
                            <p class="card-title phetsarath f16">ຜູ້ໃຊ້ງານລະບົບທັງໝົດ</p>
                            <h1 class="text-primary"><i class="fas fa-users"></i> <?=$data->users_num?></h1>
                        </div>
                    </div>

                </div>
            </div>
			
			
            <div class="col-md-6 grid-margin transparent">
                <div class="row">
                    <div class="col-md-6 mb-4 stretch-card transparent">
					<?php if(($permission["manage_class"]==1) || ($permission["class_access"]==1)){ ?>
						<div class="deskboard-card card card-dark-blue pointer" onclick="location.href = 'template?page=classroom';">
					<?php }else{ ?>
						<div class="deskboard-card card card-dark-blue">
					<?php } ?>
                            <div class="card-body">
                                <h4 class="card-title phetsarath col-white">ຫ້ອງສອບເສັງ</h4>
                                <div class="d-flex m-t-30 m-b-20 no-block align-items-center">
                                    <span class="display-5 text-info">
                                        <img src="assets/svg/classroom.svg" width="70">
                                    </span>
                                    <a class="link display-5 ml-auto col-white"><?=$data->class_num?></a>
                                </div>
                            </div>
                        </div>
                    </div>
					
                    <div class="col-md-6 mb-4 stretch-card transparent">
					<?php if(($permission["manage_subject"]==1) || ($permission["subj_access"]==1)){ ?>
						<div class="deskboard-card card card-tale pointer" onclick="location.href = 'template?page=subject';">
					<?php }else{ ?>
						<div class="deskboard-card card card-tale">
					<?php } ?>
                            <div class="card-body">
                                <h4 class="card-title phetsarath col-white">ວິຊາເສັງ</h4>
                                <div class="d-flex m-t-30 m-b-20 no-block align-items-center">
                                    <span class="display-5 text-info">
                                        <img src="assets/svg/file.svg" width="70">
                                    </span>
                                    <a class="link display-5 ml-auto col-white"><?=$data->subj_num?></a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
				
                <div class="row">
                    <div class="col-md-6 mb-4 mb-lg-0 stretch-card transparent">
					<?php if(($permission["manage_quiz"]==1) || ($permission["view_all_quiz"]==1)){ ?>
						<div class="deskboard-card card card-light-blue pointer" onclick="location.href = 'template?page=quizes';">
					<?php }else{ ?>
						<div class="deskboard-card card card-light-blue">
					<?php } ?>
                            <div class="card-body">
                                <h4 class="card-title phetsarath col-white">ຫົວຂໍ້ສອບ</h4>
                                <div class="d-flex m-t-30 m-b-20 no-block align-items-center">
                                    <span class="display-5 text-purple">
                                        <img src="assets/svg/quiz.svg" width="70">
                                    </span>
                                    <a class="link display-5 ml-auto col-white"><?=$data->quiz_num?></a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 stretch-card transparent">
					<?php if(($permission["manage_question"]==1) || ($permission["view_all_question"]==1)){ ?>
						<div class="deskboard-card card card-light-danger pointer" onclick="location.href = 'template?page=question';">
					<?php }else{ ?>
						<div class="deskboard-card card card-light-danger">
					<?php } ?>
                            <div class="card-body">
                                <h4 class="card-title phetsarath col-white">ຄໍາຖາມ</h4>
                                <div class="d-flex m-t-30 m-b-20 no-block align-items-center">
                                    <span class="display-5 text-purple">
                                        <img src="assets/svg/qa.svg" width="70">
                                    </span>
                                    <a class="link display-5 ml-auto col-white"><?=$data->question_num?></a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>




		<!--
        <div class="row">
            <div class="col-md-12 grid-margin stretch-card">
                <div class="deskboard-card card position-relative">
                    <div class="card-body">
                        <div id="detailedReports" class="detailed-report-carousel position-static pt-2">
                            <div class="row">
                                <div class="col-md-12 col-xl-3 d-flex flex-column justify-content-start">
                                    <div class="ml-xl-4 mt-3">
                                        <p class="card-title phetsarath f16">ລາຍງານ</p>
                                        <h3 class="font-weight-500 mb-xl-4 text-primary phetsarath">ຜູ້ໃຊ້ງານລະບົບທັງໝົດ</h3>
                                        <h1 class="text-primary"><i class="fas fa-users"></i> <?=$data->users_num?></h1>
                                    </div>
                                </div>
                                <div class="col-md-12 col-xl-9">
                                    <div class="row">
                                        <div class="col-md-6 border-right">
                                            <div class="table-responsive mb-3 mb-md-0 mt-3">
                                                <table class="table table-borderless report-table">
                                                    <?php
                                                        $dep_data = $data->dep_data;
                                                        $color = array("bg-primary","bg-warning","bg-danger","bg-info","bg-warning");
                                                        if(count($dep_data)<=5){
                                                            $index = 0;
                                                            foreach($dep_data as $dep){
                                                                $percentage = (floatval($dep->member)*100)/floatval($data->users_num);
                                                                ?>
                                                                <tr>
                                                                    <td class="text-muted phetsarath"><?=$dep->dep_name?></td>
                                                                    <td class="w-100 px-0">
                                                                        <div class="progress progress-md mx-4">
                                                                            <div class="progress-bar <?=$color[$index]?>" role="progressbar" style="width: <?=$percentage?>%" aria-valuenow="<?=$percentage?>" aria-valuemin="0" aria-valuemax="100"></div>
                                                                        </div>
                                                                    </td>
                                                                    <td>
                                                                        <h5 class="font-weight-bold mb-0"><?=$dep->member?></h5>
                                                                    </td>
                                                                </tr>
                                                                <?php
                                                                $index++;
                                                            }
                                                        }else{
                                                            for($i=0;$i<5;$i++){
                                                                $percentage = (floatval($dep_data[$i]->member)*100)/floatval($data->users_num);
                                                                ?>
                                                                <tr>
                                                                    <td class="text-muted phetsarath"><?=$dep_data[$i]->dep_name?></td>
                                                                    <td class="w-100 px-0">
                                                                        <div class="progress progress-md mx-4">
                                                                            <div class="progress-bar <?=$color[$i]?>" role="progressbar" style="width: <?=$percentage?>%" aria-valuenow="<?=$percentage?>" aria-valuemin="0" aria-valuemax="100"></div>
                                                                        </div>
                                                                    </td>
                                                                    <td>
                                                                        <h5 class="font-weight-bold mb-0"><?=$dep_data[$i]->member?></h5>
                                                                    </td>
                                                                </tr>
                                                                <?php
                                                            }
                                                        }
                                                    ?>
                                                    <tr>
                                                        <td colspan="3">
                                                            <button type="button" class="btn btn-secondary phetsarath f12">ເບິ່ງເພີ່ມເຕິມ...</button>
                                                        </td>
                                                    </tr>
                                                </table>
                                            </div>
                                        </div>
                                        <div class="col-md-6 mt-3">
                                            <canvas id="north-america-chart"></canvas>
                                            <div id="north-america-legend"></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
		-->
		
    </div>