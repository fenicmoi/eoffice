<?php require_once 'header.php'; ?>
<?php
$menu = isset($_GET['menu']) ? (int) $_GET['menu'] : 1;
switch ($menu) {
  case 1:
    include('content.php');
    break;
  case 2:
    include('flow-command-front.php');
    break;
  case 3:
    include('list_user.php');
    break;
  case 4:
    include('contact_staff.php');
    break;
  default:
    include('content.php');
    break;
}
?>
<?php require_once 'footer.php'; ?>

<!-- Modal ประกาศข่าวสาร -->
<div class="modal fade" id="announcementModal" tabindex="-1" role="dialog" aria-labelledby="announcementModalLabel"
  aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
    <div class="modal-content border-0 shadow-lg custom-modal-animate" style="background-color: #fffde7; border: 5px solid #ffc107 !important; border-radius: 15px;">
      <div class="modal-header bg-warning p-3" style="border-top-left-radius: 10px; border-top-right-radius: 10px;">
        <h5 class="modal-title text-dark font-weight-bold" id="announcementModalLabel" style="font-size: 2.2rem;"><i
            class="fas fa-bullhorn mr-3 shake-icon text-danger"></i>
          ประกาศสำคัญจากคณะกรรมการ PCIO</h5>
        <button type="button" class="close text-dark" data-dismiss="modal" aria-label="Close"
          style="font-size: 2.5rem; padding: 0.75rem;">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>

      <div class="modal-body p-4 text-dark" style="font-size: 2.4rem; line-height: 1.6; font-family: 'Sarabun', sans-serif;">
        <p class="mb-3"><strong>เรียน เจ้าหน้าที่ทุกท่าน</strong></p>
        <p class="mb-3">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;ด้วยในคราวประชุมคณะกรรมการ PCIO จังหวัดพัทลุง
          ครั้งที่ 1/2569
          ได้มีกำหนดเปลี่ยนแปลงการออกเลขหนังสือ ดังนี้</p>
        <ul style="padding-left: 1.5rem;">
          <li class="mb-3"><span class="highlight-date"><i class="fas fa-calendar-alt mr-1"></i>วันที่ 1 มิถุนายน
              2569</span> <strong>ขอความร่วมมือราชการส่วนภูมิภาคทุกหน่วยงาน</strong>
            ส่งหนังสือให้ผู้บริหารลงนามด้วยระบบลงนามดิจิทัล <br></li>
        </ul>
        <p class="mb-3">จึงเรียนมาเพื่อทราบ</p>
        <hr class="my-4">
        <p class="mb-2 text-muted" style="font-size: 1.8rem;">ทั้งนี้
          หากติดขัดปัญหาการใช้งานสามารถติดต่อเจ้าหน้าที่ได้ที่เบอร์</p>
        <p class="mb-1">1. นายสมศักดิ์ แก้วเกลี้ยง โทร. <strong class="text-danger">081-539-9135</strong></p>
        <p class="mb-0">2. นางสาวกชพรรณ ชินภัควัต โทร. <strong class="text-danger">093-666-9974</strong></p>
      </div>

      <div class="modal-footer border-0 p-3" style="background-color: #fffde7; border-bottom-left-radius: 10px; border-bottom-right-radius: 10px;">
        <a href="javascript:void(0)" class="btn btn-warning shadow-sm font-weight-bold" onclick="$('#announcementModal').modal('hide'); setTimeout(function(){ document.getElementById('statistics-section').scrollIntoView({behavior: 'smooth', block: 'start'}); }, 350);"
          style="font-size: 1.8rem; padding: 0.75rem 2rem; border-radius: 0.8rem;"><i class="fas fa-chart-line mr-2"></i> หน่วยงานที่ดำเนินการแล้ว</a>
        <button type="button" class="btn btn-danger shadow-sm font-weight-bold pulse-btn" data-dismiss="modal"
          style="font-size: 1.8rem; padding: 0.75rem 2rem; border-radius: 0.8rem;">ปิด / รับทราบ</button>
      </div>
    </div>
  </div>
</div>

<!-- Modal Browser Notice (เดิม) -->
<div class="modal fade" id="popupModal" tabindex="-1" role="dialog" aria-labelledby="popupModalLabel"
  aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-sm" role="document">
    <div class="modal-content border-0 shadow">
      <div class="modal-header bg-primary">
        <h5 class="modal-title text-white" id="popupModalLabel"><i class="fas fa-info-circle mr-2"></i> ข้อตกลงการใช้งาน
        </h5>
        <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>

      <div class="modal-body">
        <div class="text-center">
          <p class="lead mb-2"><i class="fas fa-exclamation-triangle fa-2x text-warning"></i></p>
          <h6 class="mb-2">แนะนำบราวเซอร์สำหรับการใช้งาน</h6>
          <p class="small text-muted">เว็บไซต์นี้ทำงานได้ดีที่สุดบน Google Chrome หรือ Mozilla Firefox (เดสก์ท็อป)</p>

          <div class="d-flex justify-content-center mt-3">
            <a href="https://www.google.com/chrome/" class="btn btn-outline-primary mr-2" target="_blank"
              rel="noopener">
              <i class="fab fa-chrome mr-1"></i> Chrome
            </a>
            <a href="https://www.mozilla.org/th/firefox/new/" class="btn btn-outline-secondary" target="_blank"
              rel="noopener">
              <i class="fab fa-firefox mr-1"></i> Firefox
            </a>
          </div>

          <div class="mt-3">
            <small class="text-muted">หากใช้เบราว์เซอร์อื่นแล้วพบปัญหา โปรดลองเปลี่ยนเป็น Chrome/Firefox</small>
          </div>
        </div>
      </div>

      <div class="modal-footer border-0 bg-light">
        <button type="button" class="btn btn-primary btn-block shadow-sm" data-dismiss="modal">ปิด / รับทราบ</button>
      </div>
    </div>
  </div>
</div>

<style>
  @keyframes modalZoomIn {
    0% { transform: scale(0.5) translateY(-100px); opacity: 0; }
    70% { transform: scale(1.05) translateY(10px); opacity: 1; }
    100% { transform: scale(1) translateY(0); opacity: 1; }
  }

  .custom-modal-animate {
    animation: modalZoomIn 0.6s cubic-bezier(0.175, 0.885, 0.32, 1.275) forwards;
  }

  @keyframes shake-icon {
    0%, 100% { transform: rotate(0deg) scale(1); }
    25% { transform: rotate(-20deg) scale(1.2); }
    75% { transform: rotate(20deg) scale(1.2); }
  }

  .shake-icon {
    display: inline-block;
    animation: shake-icon 0.6s infinite;
  }

  @keyframes pulse-btn {
    0% { transform: scale(1); box-shadow: 0 0 0 0 rgba(220, 53, 69, 0.7); }
    70% { transform: scale(1.05); box-shadow: 0 0 0 15px rgba(220, 53, 69, 0); }
    100% { transform: scale(1); box-shadow: 0 0 0 0 rgba(220, 53, 69, 0); }
  }

  .pulse-btn {
    animation: pulse-btn 2s infinite;
  }

  @keyframes glow-date {
    0% {
      color: #dc3545;
      box-shadow: 0 0 5px rgba(220, 53, 69, 0.2);
      transform: scale(1);
    }

    50% {
      color: #ff1a1a;
      box-shadow: 0 0 15px rgba(255, 26, 26, 0.6);
      transform: scale(1.03);
    }

    100% {
      color: #dc3545;
      box-shadow: 0 0 5px rgba(220, 53, 69, 0.2);
      transform: scale(1);
    }
  }

  .highlight-date {
    display: inline-block;
    animation: glow-date 1.5s infinite;
    font-weight: 900;
    background: linear-gradient(45deg, #fff0f0, #ffffff);
    padding: 4px 12px;
    border-radius: 8px;
    border: 2px solid #ff4d4d;
    margin-right: 8px;
    margin-bottom: 5px;
  }
</style>

<script>
  $(document).ready(function () {
    // แสดง modal ข่าวสารทุกครั้งที่เข้าหน้าระบบ
    $('#announcementModal').modal('show');

    // จัดการ modal แนะนำ browser ให้แสดงหลังจาก modal ข่าวสารปิดลง (ถ้ายังไม่เคยเห็น)
    $('#announcementModal').on('hidden.bs.modal', function () {
      try {
        if (!localStorage.getItem('seenBrowserNotice')) {
          $('#popupModal').modal('show');
          localStorage.setItem('seenBrowserNotice', '1');
        }
      } catch (e) {
        $('#popupModal').modal('show');
      }
    });
  });
</script>