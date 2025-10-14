<?php require_once 'header.php';?>
<?php    
   $menu = isset($_GET['menu']) ? (int)$_GET['menu'] : 1;
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
    default:
       include('content.php');
      break;
   }
?>
<?php require_once 'footer.php'; ?> 

<!-- Modal -->
<div class="modal fade" id="popupModal" tabindex="-1" role="dialog" aria-labelledby="popupModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-sm" role="document">
    <div class="modal-content border-primary">
      <div class="modal-header bg-primary text-white">
        <h5 class="modal-title" id="popupModalLabel"><i class="fas fa-info-circle mr-2"></i> ข้อตกลงการใช้งาน</h5>
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
            <a href="https://www.google.com/chrome/" class="btn btn-outline-primary mr-2" target="_blank" rel="noopener">
              <i class="fab fa-chrome mr-1"></i> Chrome
            </a>
            <a href="https://www.mozilla.org/th/firefox/new/" class="btn btn-outline-secondary" target="_blank" rel="noopener">
              <i class="fab fa-firefox mr-1"></i> Firefox
            </a>
          </div>

          <div class="mt-3">
            <small class="text-muted">หากใช้เบราว์เซอร์อื่นแล้วพบปัญหา โปรดลองเปลี่ยนเป็น Chrome/Firefox</small>
          </div>
        </div>
      </div>

      <div class="modal-footer">
        <button type="button" class="btn btn-primary btn-block" data-dismiss="modal">ปิด / รับทราบ</button>
      </div>
    </div>
  </div>
</div>

<script>
  // แสดง modal เฉพาะครั้งแรก (ต่อผู้ใช้บนเบราว์เซอร์เดียวกัน)
  (function() {
    try {
      if (!localStorage.getItem('seenBrowserNotice')) {
        $('#popupModal').modal('show');
        localStorage.setItem('seenBrowserNotice', '1');
      }
    } catch (e) {
      // ถ้า browser ไม่รองรับ localStorage ให้ยังคงแสดง modal แบบปกติ
      $('#popupModal').modal('show');
    }
  })();
</script>


