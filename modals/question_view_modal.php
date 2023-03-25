<?php
    include_once("../controller/app_module.php");
    if(isset($_POST['question_data'])){
        $question_data = json_decode($_POST['question_data']);
        $question = decode($question_data->question);
        $ans_choice = json_decode(decode($question_data->ans_choice));
        $question_type = $question_data->question_type;
        ?>
        <div class="subject phetsarath">
            ວິຊາ: <?=$question_data->subj_name?>
        </div>
        <div class="question" style="text-align:left; border:solid 1px lightgrey; padding: 5px 5px 0px 5px; border-radius: 5px; min-width:300px;">
            <?= htmlspecialchars_decode($question,ENT_QUOTES) ?>
        </div>
        <!-- <div class="ans_choice" style="display: grid; grid-template-columns: 1fr 1fr; margin-top:5px; row-gap:5px; column-gap:5px;"> -->
            <?php if($question_type==0){?>
            <div class="btn-group ans_choice" role="group" aria-label="Basic radio toggle button group" style="display: grid; margin-top:5px; column-gap:5px;">
                <?php
                    $choice = UniqueRandomNumbersWithinRange(0,3,4);
                    $choice_no = array('ກ','ຂ','ຄ','ງ');
                    $i = 0;
                    foreach($choice as $index){
                        ?>
                        <input type="radio" class="btn-check" name="ans_choice" id="<?="choice$index"?>" autocomplete="off">
                        <label class="ans btn btn-outline-primary none-select none-outline" for="<?="choice$index"?>">
                        <div class="choice-no phetsarath"><?=$choice_no[$i]?></div>
                        <div style="padding-left:5px; text-align:left;"><?=htmlspecialchars_decode($ans_choice[$index],ENT_QUOTES)?></div>
                        </label>
                        <?php
                        $i = $i+1;
                    }
                ?>
            </div>
        <!-- </div> -->
        <?php
        }
        // print_r($ans_choice[0]);
    }
?>
<style>
    .choice-no{
        padding: 5px 15px;
        height: 100%;
        border: 1px solid var(--main-color);
        border-radius: 0.9em 0px 0px 0.9em;
        background-color: var(--main-color);
        color: white;
    }
    .ans{
        margin-left: 0px !important;
        border-radius: 1em !important; 
        min-width:200px;
        display: flex;
        justify-content:start;
        align-items:center;
        padding-top: 0px !important;
        padding-bottom: 0px !important;
        padding-left: 0px !important;
    }
    .ans_choice{
        grid-template-columns: 1fr 1fr;
    }
    .btn-check:checked+.btn-outline-primary{
        background-color: var(--main-color) !important;
        border-color: var(--main-color) !important;
    }
    @media(max-width:500px){
        .ans_choice{
            grid-template-columns: 1fr;
        }
        .ans{
            width: 100%;
        }
        .swal2-html-container{
            width: 100%;
            padding: 10px;
        }
    }
</style>