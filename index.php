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
  case 5:
    include('manual.php');
    break;
  default:
    include('content.php');
    break;
}
?>
<?php require_once 'footer.php'; ?>

<!-- Modal เชิญชวนเข้าร่วมกลุ่ม LINE e-Office จังหวัดพัทลุง -->
<div class="modal fade" id="lineGroupModal" tabindex="-1" role="dialog" aria-labelledby="lineGroupModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document" style="max-width: 520px; width: 92%; margin: 30px auto;">
    <div class="modal-content border-0 shadow-2xl" style="border-radius: 24px; overflow: hidden; background: #ffffff;">
      
      <!-- Modal Header (LINE Official Green Theme) -->
      <div class="modal-header border-0 text-white p-4 text-center position-relative" 
           style="background: linear-gradient(135deg, #06C755 0%, #05a847 100%); border-bottom: 3.5px solid #048a3a;">
        <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close"
                style="position: absolute; right: 18px; top: 16px; font-size: 2.4rem; color: #ffffff !important; opacity: 0.9; text-shadow: none;">
          <span aria-hidden="true">&times;</span>
        </button>
        <div class="d-flex align-items-center justify-content-center" style="gap: 12px;">
          <div style="background: rgba(255,255,255,0.25); border-radius: 50%; width: 50px; height: 50px; display: flex; align-items: center; justify-content: center; flex-shrink: 0;">
            <i class="fab fa-line" style="font-size: 3rem; color: #ffffff;"></i>
          </div>
          <div class="text-left">
            <h4 class="modal-title font-weight-bold m-0" id="lineGroupModalLabel" 
                style="font-size: 2rem; color: #ffffff; font-family: 'Sarabun', sans-serif; line-height: 1.2;">
              กลุ่ม LINE e-Office
            </h4>
            <div style="font-size: 1.3rem; color: #e8fced; font-weight: 500; font-family: 'Sarabun', sans-serif;">
              จังหวัดพัทลุง (ประสานงาน & แจ้งข่าวสาร)
            </div>
          </div>
        </div>
      </div>

      <!-- Modal Body -->
      <div class="modal-body p-4 text-center" style="font-family: 'Sarabun', sans-serif; background: #fafafa;">
        
        <p class="font-weight-bold mb-3" style="font-size: 1.5rem; color: #1e293b; line-height: 1.5;">
          ขอเชิญเจ้าหน้าที่สารบรรณและผู้ใช้งานทุกท่าน<br>
          <span style="color: #05a847; font-weight: 800;">เข้าร่วมกลุ่ม LINE เพื่อรับข่าวสารและสอบถามปัญหา</span>
        </p>

        <!-- QR Code Card -->
        <div class="d-inline-block p-3 rounded-2xl shadow-sm mb-3" 
             style="background: #ffffff; border: 2.5px solid #06C755; border-radius: 20px; box-shadow: 0 8px 24px rgba(6, 199, 85, 0.2);">
          <img src="images/line_group_qrcode.jpg" alt="LINE Group QR Code e-Office จังหวัดพัทลุง" 
               class="img-responsive mx-auto" 
               style="max-width: 220px; width: 100%; height: auto; border-radius: 12px; display: block;">
          <div class="mt-2 font-weight-bold" style="font-size: 1.35rem; color: #05a847;">
            <i class="fas fa-qrcode mr-1"></i> สแกน QR Code เพื่อเข้าร่วม
          </div>
        </div>

        <!-- Info List -->
        <div class="text-left mx-auto p-3 rounded-xl mb-2" 
             style="max-width: 420px; background: #ffffff; border: 1px solid #e2e8f0; border-radius: 14px; font-size: 1.35rem; color: #334155;">
          <div class="d-flex align-items-center mb-2" style="gap: 10px;">
            <i class="fas fa-bullhorn text-success flex-shrink-0" style="color: #06C755; font-size: 1.4rem;"></i>
            <span>ติดตามข่าวสาร ประกาศสำคัญ และกำหนดการระบบ</span>
          </div>
          <div class="d-flex align-items-center mb-2" style="gap: 10px;">
            <i class="fas fa-comments text-success flex-shrink-0" style="color: #06C755; font-size: 1.4rem;"></i>
            <span>สอบถามปัญหาการใช้งาน ปรึกษาทีม Admin จังหวัด</span>
          </div>
          <div class="d-flex align-items-center" style="gap: 10px;">
            <i class="fas fa-book-reader text-success flex-shrink-0" style="color: #06C755; font-size: 1.4rem;"></i>
            <span>รับเอกสารคู่มือและวิดีโอแนะนำการใช้งานล่าสุด</span>
          </div>
        </div>

      </div>

      <!-- Modal Footer -->
      <div class="modal-footer border-0 p-3 bg-white d-flex justify-content-between align-items-center" 
           style="border-top: 1px solid #f1f5f9;">
        <a href="images/line_group_qrcode.jpg" download="LINE_eOffice_Phatthalung.jpg" 
           class="btn btn-outline-success font-weight-bold" 
           style="border-radius: 10px; font-size: 1.35rem; border: 1.5px solid #06C755; color: #05a847; padding: 7px 16px;">
          <i class="fas fa-download mr-1"></i> บันทึกรูป QR Code
        </a>
        <button type="button" class="btn btn-secondary font-weight-bold" data-dismiss="modal" 
                style="border-radius: 10px; font-size: 1.35rem; padding: 7px 22px; background: #64748b; border: none; color: #ffffff;">
          ปิดหน้าต่าง
        </button>
      </div>

    </div>
  </div>
</div>

<!-- Floating Button to Open LINE Group Modal Anytime -->
<div style="position: fixed; bottom: 25px; right: 25px; z-index: 1040;">
  <button type="button" class="btn shadow-lg" data-toggle="modal" data-target="#lineGroupModal"
          style="background: linear-gradient(135deg, #06C755 0%, #05a847 100%); color: #ffffff; border-radius: 30px; padding: 10px 22px; font-weight: 700; font-size: 1.45rem; border: 2.5px solid #ffffff; box-shadow: 0 6px 20px rgba(6, 199, 85, 0.5); display: flex; align-items: center; gap: 8px; transition: all 0.25s ease;"
          onmouseover="this.style.transform='scale(1.05)';" onmouseout="this.style.transform='scale(1)';">
    <i class="fab fa-line" style="font-size: 2.4rem;"></i>
    <span>กลุ่ม LINE e-Office</span>
  </button>
</div>

<script>
  $(document).ready(function() {
    // แสดง Modal เชิญชวนเข้ากลุ่ม LINE เมื่อเปิดหน้าหลัก
    $('#lineGroupModal').modal('show');
  });
</script>
