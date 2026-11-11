<?php
ob_start();
session_start();
if(!isset($_SESSION['ses_u_id'])){
	header("location:../index.php");
	exit;
}

include 'header.php';

$show_login_welcome = false;
if (isset($_SESSION['login_success']) && $_SESSION['login_success'] === true) {
    $show_login_welcome = true;
    echo "<script>
        swal({
            title: 'WELCOME',
            text: 'ยินดีต้อนรับเข้าสู่ระบบรับ-ส่ง e-ducument จังหวัดพัทลุง ',
            type: 'success',
            timer: 2000,
            showConfirmButton: false
        });
    </script>";
    unset($_SESSION['login_success']); 
}
?>

<!-- Modal แจ้งเตือนข้อความจาก Admin หลัง Login -->
<div class="modal fade" id="adminFarewellModal" tabindex="-1" role="dialog" aria-labelledby="adminFarewellModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document" style="max-width: 580px; width: 92%; margin: 30px auto;">
    <div class="modal-content" style="border-radius: 22px; overflow: hidden; border: none; box-shadow: 0 20px 50px rgba(0,0,0,0.35); font-family: 'Sarabun', sans-serif;">
      
      <!-- Modal Header -->
      <div class="modal-header text-white" style="background: linear-gradient(135deg, #1e3a8a 0%, #2563eb 55%, #4f46e5 100%); padding: 18px 24px; border-bottom: none;">
        <div style="display: flex; align-items: center; width: 100%; gap: 14px;">
          <div style="width: 48px; height: 48px; border-radius: 14px; background: rgba(255,255,255,0.2); display: flex; align-items: center; justify-content: center; font-size: 2.2rem; flex-shrink: 0; border: 1px solid rgba(255,255,255,0.3);">
            <i class="fas fa-heart text-warning"></i>
          </div>
          <div style="flex: 1;">
            <h4 class="modal-title font-weight-bold" id="adminFarewellModalLabel" style="font-size: 1.95rem; margin: 0; color: #ffffff;">
              ข้อความจากผู้ดูแลระบบ (Admin)
            </h4>
            <div style="font-size: 1.3rem; color: #dbeafe; margin-top: 2px;">
              แจ้งกำหนดการเปลี่ยนผ่านสู่ระบบ e-Office (GDCC)
            </div>
          </div>
          <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close" style="font-size: 2.8rem; margin-top: -12px; opacity: 0.9; color: #ffffff !important; outline: none;">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
      </div>

      <!-- Modal Body -->
      <div class="modal-body" style="padding: 24px; background: #ffffff; color: #334155;">
        
        <!-- ข้อความขอบคุณ -->
        <div class="text-center mb-4">
          <div style="display: inline-block; padding: 10px 20px; background: #fef3c7; border-radius: 50px; border: 1px solid #fde68a; margin-bottom: 14px; box-shadow: 0 2px 6px rgba(245, 158, 11, 0.15);">
            <span style="font-size: 1.55rem; font-weight: 700; color: #b45309;">
              🙏 ขอบคุณที่ชอบระบบนี้ครับ
            </span>
          </div>
          <p style="font-size: 1.6rem; line-height: 1.6; color: #1e293b; margin: 0; font-weight: 600;">
            แต่เพื่อเป็นไปตามการขับเคลื่อนระดับประเทศ <br class="d-none d-sm-inline">
            จึงมีความจำเป็นในการ <span style="color: #dc2626; text-decoration: underline; font-weight: 800;">ยุติระบบนี้ในวันที่ 1 พ.ย. 2569</span>
          </p>
        </div>

        <!-- กล่องคำแนะนำระบบใหม่ -->
        <div style="background: linear-gradient(135deg, #eff6ff 0%, #f0fdf4 100%); border: 1.5px solid #bfdbfe; border-left: 5px solid #2563eb; border-radius: 14px; padding: 16px; margin-bottom: 20px;">
          <div style="display: flex; align-items: flex-start; gap: 12px;">
            <i class="fas fa-lightbulb text-warning" style="font-size: 2.2rem; margin-top: 3px; filter: drop-shadow(0 2px 4px rgba(245, 158, 11, 0.3));"></i>
            <div style="font-size: 1.45rem; line-height: 1.6; color: #1e3a8a;">
              <strong style="color: #1d4ed8; font-size: 1.5rem;">อย่าลืมไปทดลองใช้ระบบใหม่นะครับ</strong> <br>
              เพราะระบบใหม่ต้องปรับตัวนิดนึง ขอความร่วมมือเจ้าหน้าที่เริ่มเข้าไปทดลองส่งและกดรับหนังสือเพื่อความคุ้นเคยก่อนเปลี่ยนผ่านจริงครับ 😊
            </div>
          </div>
        </div>

        <!-- กล่องนับถอยหลังย่อส่วน -->
        <div style="background: #0f172a; border-radius: 14px; padding: 14px 16px; text-align: center; color: #ffffff; margin-bottom: 20px; border: 1px solid #334155;">
          <div style="font-size: 1.3rem; color: #cbd5e1; margin-bottom: 8px;">
            <i class="fas fa-stopwatch text-warning mr-1"></i> นับถอยหลังสู่การปิดระบบเดิม (1 พ.ย. 2569):
          </div>
          <div style="display: flex; justify-content: center; align-items: center; gap: 8px;">
            <div style="background: rgba(255,255,255,0.1); border-radius: 8px; padding: 4px 10px; min-width: 58px;">
              <span id="farewell-cd-days" style="font-size: 2.1rem; font-weight: 800; color: #fde047; display: block; line-height: 1.1;">00</span>
              <span style="font-size: 1.1rem; color: #94a3b8; display: block;">วัน</span>
            </div>
            <span style="font-size: 1.8rem; font-weight: 800; color: #ef4444;">:</span>
            <div style="background: rgba(255,255,255,0.1); border-radius: 8px; padding: 4px 10px; min-width: 52px;">
              <span id="farewell-cd-hours" style="font-size: 2.1rem; font-weight: 800; color: #ffffff; display: block; line-height: 1.1;">00</span>
              <span style="font-size: 1.1rem; color: #94a3b8; display: block;">ชม.</span>
            </div>
            <span style="font-size: 1.8rem; font-weight: 800; color: #ef4444;">:</span>
            <div style="background: rgba(255,255,255,0.1); border-radius: 8px; padding: 4px 10px; min-width: 52px;">
              <span id="farewell-cd-minutes" style="font-size: 2.1rem; font-weight: 800; color: #ffffff; display: block; line-height: 1.1;">00</span>
              <span style="font-size: 1.1rem; color: #94a3b8; display: block;">นาที</span>
            </div>
            <span style="font-size: 1.8rem; font-weight: 800; color: #ef4444;">:</span>
            <div style="background: rgba(255,255,255,0.1); border-radius: 8px; padding: 4px 10px; min-width: 52px;">
              <span id="farewell-cd-seconds" style="font-size: 2.1rem; font-weight: 800; color: #f87171; display: block; line-height: 1.1;">00</span>
              <span style="font-size: 1.1rem; color: #94a3b8; display: block;">วินาที</span>
            </div>
          </div>
        </div>

        <!-- ปุ่มดาวน์โหลดคู่มือ -->
        <div>
          <a href="../manual_send_eoffice.pdf" target="_blank" class="btn btn-danger btn-block font-weight-bold" 
             style="font-size: 1.5rem; padding: 11px; border-radius: 10px; box-shadow: 0 4px 12px rgba(220, 38, 38, 0.3);">
            <i class="fas fa-file-pdf mr-2"></i> ดาวน์โหลดคู่มือการส่งหนังสือระบบใหม่ (PDF)
          </a>
        </div>

      </div>

      <!-- Modal Footer -->
      <div class="modal-footer" style="background: #f8fafc; border-top: 1px solid #f1f5f9; padding: 14px 24px;">
        <button type="button" class="btn btn-primary btn-block font-weight-bold" data-dismiss="modal"
                style="font-size: 1.55rem; padding: 10px; border-radius: 10px; background: linear-gradient(135deg, #2563eb, #1d4ed8); border: none;">
          <i class="fas fa-check-circle mr-1"></i> รับทราบ & เข้าสู่หน้าทำงาน
        </button>
      </div>

    </div>
  </div>
</div>

<!-- แถบ Alert Banner บนหัวหน้า Dashboard -->
<div class="container-fluid" style="margin-top: 15px; margin-bottom: 5px;">
  <div class="alert alert-dismissible shadow-sm" style="background: linear-gradient(135deg, #eff6ff 0%, #ffffff 100%); border: 1.5px solid #93c5fd; border-left: 6px solid #2563eb; border-radius: 14px; padding: 16px 20px; font-family: 'Sarabun', sans-serif;">
    <button type="button" class="close" data-dismiss="alert" style="font-size: 2.6rem; opacity: 0.6; line-height: 0.8;">&times;</button>
    <div style="display: flex; align-items: flex-start; gap: 12px;">
      <div style="width: 44px; height: 44px; min-width: 44px; border-radius: 12px; background: #dbeafe; display: flex; align-items: center; justify-content: center; font-size: 2rem; color: #1d4ed8; margin-top: 2px;">
        <i class="fas fa-heart text-danger"></i>
      </div>
      <div style="flex: 1;">
        <div style="font-size: 1.6rem; font-weight: 700; color: #1e3a8a; margin-bottom: 4px;">
          🙏 ขอบคุณที่ชอบระบบนี้ครับ
        </div>
        <div style="font-size: 1.42rem; line-height: 1.6; color: #334155;">
          แต่เพื่อเป็นไปตามการขับเคลื่อนระดับประเทศ จึงมีความจำเป็นในการยุติระบบนี้ในวันที่ <strong class="text-danger" style="color: #dc2626 !important;">1 พ.ย. 2569</strong> 
          — <strong class="text-primary" style="color: #2563eb !important;">อย่าลืมไปทดลองใช้ระบบใหม่นะครับ เพราะระบบใหม่ต้องปรับตัวนิดนึง</strong> 😊
        </div>
        <div style="margin-top: 10px; display: flex; flex-wrap: wrap; gap: 8px;">
          <a href="../manual_send_eoffice.pdf" target="_blank" class="btn btn-sm btn-danger font-weight-bold" style="font-size: 1.3rem; border-radius: 6px;">
            <i class="fas fa-file-pdf mr-1"></i> ดาวน์โหลดคู่มือระบบใหม่ (PDF)
          </a>
          <button type="button" class="btn btn-sm btn-outline-primary font-weight-bold" onclick="$('#adminFarewellModal').modal('show');" style="font-size: 1.3rem; border-radius: 6px;">
            <i class="fas fa-info-circle mr-1"></i> ดูรายละเอียดประกาศ
          </button>
        </div>
      </div>
    </div>
  </div>
</div>

<script>
$(document).ready(function() {
  // คำนวณเวลานับถอยหลังสู่ 1 พ.ย. 2569
  const targetDate = new Date("2026-11-01T00:00:00+07:00").getTime();
  function updateFarewellCountdown() {
    const now = new Date().getTime();
    const distance = targetDate - now;
    if (distance <= 0) {
      $('#farewell-cd-days').text("00");
      $('#farewell-cd-hours').text("00");
      $('#farewell-cd-minutes').text("00");
      $('#farewell-cd-seconds').text("00");
      return;
    }
    const days = Math.floor(distance / (1000 * 60 * 60 * 24));
    const hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
    const minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
    const seconds = Math.floor((distance % (1000 * 60)) / 1000);
    $('#farewell-cd-days').text(String(days).padStart(2, '0'));
    $('#farewell-cd-hours').text(String(hours).padStart(2, '0'));
    $('#farewell-cd-minutes').text(String(minutes).padStart(2, '0'));
    $('#farewell-cd-seconds').text(String(seconds).padStart(2, '0'));
  }
  updateFarewellCountdown();
  setInterval(updateFarewellCountdown, 1000);

  <?php if ($show_login_welcome): ?>
    // ถ้าเพิ่ง login เข้ามาสำเร็จ ให้แสดง sweetalert ก่อน 2 วินาที แล้วเปิด modal
    setTimeout(function() {
      $('#adminFarewellModal').modal('show');
    }, 2200);
  <?php else: ?>
    // ถ้าเข้ามาหน้านี้ตามปกติ แสดง modal ถ้ายังไม่ได้ดูในเซสชันนี้
    try {
      if (!sessionStorage.getItem('seenAdminFarewellNotice')) {
        $('#adminFarewellModal').modal('show');
        sessionStorage.setItem('seenAdminFarewellNotice', '1');
      }
    } catch(e) {
      $('#adminFarewellModal').modal('show');
    }
  <?php endif; ?>
});
</script>

<?php
include 'deskboard.php';
include 'footer.php';
?>
