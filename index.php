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
    <div class="modal-content border-0 shadow">
      <div class="modal-header bg-danger p-3">
        <h5 class="modal-title text-white font-weight-bold" id="announcementModalLabel" style="font-size: 1.25rem;"><i class="fas fa-bullhorn mr-2"></i>
          ประกาศสำคัญจากคณะกรรมการ PCIO</h5>
        <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close" style="font-size: 1.5rem; padding: 0.75rem;">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>

      <div class="modal-body p-4" style="font-size: 1.65rem; line-height: 1.6; font-family: 'Sarabun', sans-serif;">
        <p class="mb-3"><strong>เรียน เจ้าหน้าที่ทุกท่าน</strong></p>
        <p class="mb-3">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;ด้วยในคราวประชุมคณะกรรมการ PCIO จังหวัดพัทลุง ครั้งที่ 1/2569
          ได้มีกำหนดเปลี่ยนแปลงการออกเลขหนังสือ ดังนี้</p>
        <ul style="padding-left: 1.5rem;">
          <li class="mb-3"><strong>วันที่ 30 เมษายน 2569 เวลา 24.00 น.</strong> ยกเลิกการออกเลขหนังสือบนระบบเดิม แต่ยังคงการใช้งาน
            "ระบบรับ-ส่งหนังสืออิเล็กทรอนิกส์"</li>
          <li class="mb-3"><strong>วันที่ 1 พฤษภาคม 2569 เวลา 1.00 น.</strong> ออกเลขหนังสือจังหวัดทางระบบใหม่ของบริษัท NT <br><a
              href="http://www.phatthalung.eoffice.go.th" target="_blank" class="text-primary text-decoration-underline">www.phatthalung.eoffice.go.th</a></li>
        </ul>
        <p class="mb-3">จึงเรียนมาเพื่อทราบ</p>
        <hr class="my-4">
        <p class="mb-2 text-muted" style="font-size: 1.25rem;">ทั้งนี้ หากติดขัดปัญหาการใช้งานสามารถติดต่อเจ้าหน้าที่ได้ที่เบอร์</p>
        <p class="mb-1">1. นายสมศักดิ์ แก้วเกลี้ยง โทร. <strong class="text-danger">081-539-9135</strong></p>
        <p class="mb-0">2. นางสาวกชพรรณ ชินภัควัต โทร. <strong class="text-danger">093-666-9974</strong></p>
      </div>

      <div class="modal-footer border-0 bg-light p-3">
        <button type="button" class="btn btn-danger shadow-sm font-weight-bold" data-dismiss="modal" style="font-size: 1.25rem; padding: 0.5rem 1.5rem; border-radius: 0.5rem;">ปิด / รับทราบ</button>
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