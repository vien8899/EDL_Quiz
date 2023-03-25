<nav class="sidebar sidebar-offcanvas" id="sidebar">
    <ul class="nav">
      <li class="nav-item">
        <a class="nav-link" href="template?page=home">
          <i class="icon-grid menu-icon"></i>
          <span class="menu-title phetsarath f12">ໜ້າຫຼັກ</span>
        </a>
      </li>
      <li class="nav-item">
        <a class="nav-link" data-bs-toggle="collapse" href="#department" aria-expanded="false" aria-controls="department">
          <i class="ti-harddrives menu-icon"></i>
          <span class="menu-title phetsarath f12">ຈັດການຂໍ້ມູນ</span>
          <i class="menu-arrow"></i>
        </a>
        <div class="collapse" id="department">
          <ul class="nav flex-column sub-menu">
            <li class="nav-item"> <a class="nav-link phetsarath f12 <?=($permission["manage_dep"] || $permission["dep_access"])?'':'disabled'?>" href="template?page=department">ຂໍ້ມູນຝ່າຍ</a></li>
            <li class="nav-item"> <a class="nav-link phetsarath f12 <?=($permission["manage_unit"] || $permission["unit_access"])?'':'disabled'?>" href="template?page=unit">ຂໍ້ມູນພະແນກ</a></li>
            <li class="nav-item"> <a class="nav-link phetsarath f12 <?=($permission["manage_position"] || $permission["position_access"])?'':'disabled'?>" href="template?page=position">ຂໍ້ມູນຕໍາແໜ່ງ</a></li>
            <li class="nav-item"> <a class="nav-link phetsarath f12 <?=($permission["manage_em"] || $permission["em_access"])?'':'disabled'?>" href="template?page=employee">ຂໍ້ມູນພະນັກງານ</a></li>
            <li class="nav-item"> <a class="nav-link phetsarath f12 <?=($permission["manage_user_group"] || $permission["user_group_access"])?'':'disabled'?>" href="template?page=user_group">ກຸ່ມຜູ້ໃຊ້ງານລະບົບ</a></li>
          </ul>
        </div>
      </li>
	  <li class="nav-item">
        <a class="nav-link" data-bs-toggle="collapse" href="#form-elements" aria-expanded="false" aria-controls="form-elements">
          <!-- <i class="fas fa-book menu-icon"></i> -->
          <i class="ti-book menu-icon"></i>
          <span class="menu-title phetsarath f12">ຂໍ້ມູນການສອບເສັງ</span>
          <i class="menu-arrow"></i>
        </a>
        <div class="collapse" id="form-elements">
          <ul class="nav flex-column sub-menu">
            <li class="nav-item"><a class="nav-link phetsarath f12 <?=($permission["manage_subject"] || $permission["subj_access"])?'':'disabled'?>" href="template?page=subject">ວີຊາເສັງ</a></li>
            <li class="nav-item"><a class="nav-link phetsarath f12 <?=($permission["manage_question"] || $permission["view_all_question"])?'':'disabled'?>" href="template?page=question">ຄໍາຖາມ</a></li>
            <li class="nav-item"><a class="nav-link phetsarath f12 <?=($permission["manage_quiz"] || $permission["view_all_quiz"])?'':'disabled'?>" href="template?page=quizes">ຫົວຂໍ້ສອບເສັງ</a></li>
          </ul>
        </div>
      </li>
      <li class="nav-item">
        <a class="nav-link <?=($permission["manage_class"] || $permission["class_access"])?'':'disabled'?>" href="template?page=classroom">
          <i class="icon-layout menu-icon"></i>
          <span class="menu-title phetsarath f12">ຫ້ອງສອບເສັງ</span>
        </a>
      </li>
      
      <!-- <li class="nav-item">
        <a class="nav-link" href="template?page=quiz">
          <i class="ti-cup menu-icon"></i>
          <span class="menu-title phetsarath f12">ຂໍ້ມູນຫົວຂໍ້ເສັງ</span>
        </a>
      </li> -->
      <li class="nav-item">
        <a class="nav-link" data-bs-toggle="collapse" href="#setting" aria-expanded="false" aria-controls="setting">
          <i class="ti-panel menu-icon"></i>
          <span class="menu-title phetsarath f12">ຈັດການການສອບເສັງ</span>
          <i class="menu-arrow"></i>
        </a>
        <div class="collapse" id="setting">
          <ul class="nav flex-column sub-menu">
            <li class="nav-item"> <a class="nav-link phetsarath f12 <?=($permission["open_exam"] || $permission["close_exam"])?'':'disabled'?>" href="template?page=open_exam">ເປີດສອບເສັງ</a></li>
            <li class="nav-item"> <a class="nav-link phetsarath f12 <?=($permission["set_score"])?'':'disabled'?>" href="template?page=quiz_overview">ກວດບົດເສັງ</a></li>
            <!-- <li class="nav-item"> <a class="nav-link phetsarath f12" href="#">ອະນຸຍາດເສັງຄືນ</a></li> -->
          </ul>
        </div>
      </li>
      <!-- <li class="nav-item">
        <a class="nav-link" href="#">
          <i class="ti-user menu-icon"></i>
          <span class="menu-title phetsarath f12">ກຸ່ມຜູ້ໃຊ້ງານລະບົບ</span>
        </a>
      </li> -->
      <!-- <li class="nav-item">
        <a class="nav-link" data-bs-toggle="collapse" href="#auth" aria-expanded="false" aria-controls="auth">
          <i class="icon-head menu-icon"></i>
          <span class="menu-title phetsarath f12">ຜູ້ໃຊ້ງານລະບົບ</span>
          <i class="menu-arrow"></i>
        </a>
        <div class="collapse" id="auth">
          <ul class="nav flex-column sub-menu">
            <li class="nav-item"> <a class="nav-link phetsarath f12" href="pages/samples/login.html"> ກຸ່ມຜູ້ໃຊ້ງານລະບົບ </a></li>
            <li class="nav-item"> <a class="nav-link phetsarath f12" href="pages/samples/register.html"> ຈັດການຜູ້ໃຊ້ງານລະບົບ </a></li>
          </ul>
        </div>
      </li> -->
      <li class="nav-item">
        <a class="nav-link <?=($permission["exam_report_access"])?'':'disabled'?>" href="template?page=score_report">
          <i class="ti-bar-chart menu-icon"></i>
          <span class="menu-title phetsarath f12">ຜົນການສອບເສັງ</span>
        </a>
      </li>
      <!-- <li class="nav-item">
        <a class="nav-link" data-bs-toggle="collapse" href="#error" aria-expanded="false" aria-controls="error">
          <i class="ti-bar-chart menu-icon"></i>
          <span class="menu-title phetsarath f12">ລາຍງານ</span>
          <i class="menu-arrow"></i>
        </a>
        <div class="collapse" id="error">
          <ul class="nav flex-column sub-menu">
            <li class="nav-item"> <a class="nav-link phetsarath f12" href="template?page=score_report">ຜົນການສອບເສັງ</a></li>
            <li class="nav-item"> <a class="nav-link" href="pages/samples/error-500.html"> 500 </a></li>
          </ul>
        </div>
      </li> -->
      <li class="nav-item">
        <a class="nav-link" href="javascript:void(0)" data-bs-toggle="modal" data-bs-target="#confirmModal">
          <i class="icon-power menu-icon"></i>
          <span class="menu-title phetsarath f12">ອອກຈາກລະບົບ</span>
        </a>
      </li>
    </ul>
</nav>