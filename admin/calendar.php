<h1>ปฏิทินการจองห้องประชุม</h1>
    <div id='calendar'></div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // อ้างอิงไปยัง element ที่มี id='calendar'
            var calendarEl = document.getElementById('calendar');

            // สร้าง instance ของ FullCalendar
            var calendar = new FullCalendar.Calendar(calendarEl, {
                // --- การตั้งค่าพื้นฐาน ---
                initialView: 'dayGridMonth', // มุมมองเริ่มต้น (รายสัปดาห์แบบตารางเวลา)
                                             // ลองเปลี่ยนเป็น 'dayGridMonth', 'timeGridDay' ได้
                locale: 'th', // ตั้งค่าภาษาเป็นไทย (ต้องแน่ใจว่า CDN หรือไฟล์ที่ใช้รองรับ)
                buttonText: {
                    today: 'วันนี้',
                    month: 'เดือน',
                    week: 'สัปดาห์',
                    day: 'วัน',
                    list: 'รายการ'
                },
                titleFormat: { year: 'numeric', month: 'long', day: 'numeric' },
                allDayText: 'ทั้งวัน',
                weekText: 'สัปดาห์',
                dayMaxEventRows: true,
                headerToolbar: { // การตั้งค่าปุ่มบนหัวปฏิทิน
                    left: 'prev,next today',
                    center: 'title',
                    right: 'dayGridMonth,timeGridWeek,timeGridDay' // ปุ่มเปลี่ยนมุมมอง
                },
                navLinks: true, // ทำให้วันที่และสัปดาห์คลิกได้
                nowIndicator: true, // แสดงเส้นบอกเวลาปัจจุบัน
                slotMinTime: '08:00:00', // เวลาเริ่มต้นของวันในปฏิทิน
                slotMaxTime: '19:00:00', // เวลาสิ้นสุดของวันในปฏิทิน
                businessHours: { // แสดงช่วงเวลาทำงาน (สีพื้นหลังต่างกัน)
                    daysOfWeek: [ 1, 2, 3, 4, 5 ], // จันทร์ - ศุกร์
                    startTime: '09:00',
                    endTime: '18:00',
                },
                // --- การดึงข้อมูล Event (การจอง) ---
                events: '/api/bookings' // *** สำคัญ: นี่คือ URL ของ API ที่จะดึงข้อมูลการจอง ***
                                        // FullCalendar จะส่ง parameter ?start=...&end=... ไปให้เอง
                                        // เพื่อบอกช่วงเวลาที่ต้องการข้อมูล

                /*
                // หรือจะใส่ข้อมูล Event ลงไปตรงๆ เลยก็ได้ (สำหรับทดสอบ)
                events: [
                    {
                        id: '1',
                        title: 'ประชุมทีม Marketing - ห้อง A',
                        start: '2025-04-21T10:00:00', // รูปแบบ ISO 8601
                        end: '2025-04-21T11:30:00',
                        backgroundColor: '#3788d8', // สีพื้นหลัง (Optional)
                        borderColor: '#3788d8' // สีขอบ (Optional)
                    },
                    {
                        id: '2',
                        title: 'คุยงาน Project X - ห้อง B',
                        start: '2025-04-22T14:00:00',
                        end: '2025-04-22T15:00:00',
                        backgroundColor: '#d8a037'
                    },
                    {
                        id: '3',
                        title: 'อบรมพนักงานใหม่ - ห้อง A',
                        start: '2025-04-23T09:00:00',
                        end: '2025-04-23T12:00:00'
                    }
                ]
                */

                // --- การโต้ตอบ (ตัวอย่างเพิ่มเติม) ---
                // selectable: true, // อนุญาตให้ผู้ใช้ลากเลือกช่วงเวลาได้
                // select: function(info) {
                //     // ฟังก์ชันที่จะทำงานเมื่อผู้ใช้เลือกช่วงเวลา
                //     var title = prompt('หัวข้อการประชุม:');
                //     if (title) {
                //         var room = prompt('ห้องประชุม: (เช่น ห้อง A, ห้อง B)');
                //         if (room) {
                //             // ตรงนี้คือจุดที่คุณจะส่งข้อมูลไปสร้างการจองที่ Backend API
                //             console.log('สร้างการจองใหม่:', title, room, info.startStr, info.endStr);
                //             // หลังจากบันทึกสำเร็จ อาจจะต้องเรียก calendar.addEvent(...) หรือ calendar.refetchEvents()
                //              calendar.addEvent({
                //                 title: title + ' - ' + room,
                //                 start: info.start,
                //                 end: info.end,
                //                 allDay: info.allDay // ปกติจะเป็น false สำหรับ timeGrid
                //             });
                //         }
                //     }
                //     calendar.unselect(); // ยกเลิกการเลือก
                // },
                // eventClick: function(info) {
                //     // ฟังก์ชันที่จะทำงานเมื่อคลิกที่ Event (การจอง) ที่มีอยู่
                //     alert('ข้อมูลการจอง:\n' + info.event.title + '\nเวลา: ' + info.event.start.toLocaleString() + ' - ' + info.event.end.toLocaleString());
                //     // สามารถเพิ่มปุ่มแก้ไข หรือลบได้ตรงนี้
                //     if (confirm('ต้องการลบการจองนี้หรือไม่?')) {
                //         // ส่ง request ไปลบที่ Backend API โดยใช้ info.event.id
                //         console.log('ลบการจอง ID:', info.event.id);
                //         // หลังจากลบสำเร็จ
                //         info.event.remove();
                //     }
                // }
            });

            // แสดงผลปฏิทิน
            calendar.render();
        });
    </script>
        <?php
    // filepath: c:\wamp64\www\eoffice\eoffice\admin\reserve_room_save.php
    include '../library/database.php';
    
    // ตรวจสอบว่ามีการ submit ฟอร์มหรือไม่
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['room_id'], $_POST['meeting_title'], $_POST['start_date'], $_POST['end_date'])) {
    
        // รับค่าจากฟอร์ม
        $room_id        = (int)$_POST['room_id'];
        $meeting_title  = trim($_POST['meeting_title']);
        $meeting_chair  = isset($_POST['meeting_chair']) ? trim($_POST['meeting_chair']) : '';
        $start_date     = trim($_POST['start_date']);
        $end_date       = trim($_POST['end_date']);
        $doc_file       = "";
    
        // ตรวจสอบและอัปโหลดไฟล์
        if (isset($_FILES["doc_file"]["tmp_name"]) && is_uploaded_file($_FILES["doc_file"]["tmp_name"])) {
            $allowed = ['pdf', 'jpg', 'jpeg', 'png', 'doc', 'docx'];
            $ext = strtolower(pathinfo($_FILES["doc_file"]["name"], PATHINFO_EXTENSION));
            if (in_array($ext, $allowed) && $_FILES["doc_file"]["size"] <= 5*1024*1024) {
                $doc_file = uniqid('doc_') . '.' . $ext;
                move_uploaded_file($_FILES["doc_file"]["tmp_name"], "../doc/" . $doc_file);
            }
        }
    
        // เตรียม SQL สำหรับบันทึกข้อมูล
        $sql = "INSERT INTO meeting_reserve (book_id, subject, numpeople, head, room_id, start_date, end_date, fileupload)
                VALUES (?, ?, ?, ?, ?, ?)";
    
        $conn = dbConnect(); // สมมติว่ามีฟังก์ชันนี้ใน database.php
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("isssss", $room_id, $meeting_title, $meeting_chair, $start_date, $end_date, $doc_file);
    
        if ($stmt->execute()) {
            echo "<script>
                Swal.fire({
                    icon: 'success',
                    title: 'บันทึกสำเร็จ',
                    text: 'การจองห้องประชุมถูกบันทึกเรียบร้อยแล้ว!',
                    confirmButtonText: 'ตกลง'
                }).then(function(){
                    window.location = 'meet_index.php';
                });
            </script>";
        } else {
            echo "<script>
                Swal.fire({
                    icon: 'error',
                    title: 'เกิดข้อผิดพลาด',
                    text: 'ไม่สามารถบันทึกข้อมูลได้ กรุณาลองใหม่อีกครั้ง',
                    confirmButtonText: 'ตกลง'
                }).then(function(){
                    window.history.back();
                });
            </script>";
        }
    
        $stmt->close();
        $conn->close();
    
    } else {
        // กรณีไม่ได้ submit หรือข้อมูลไม่ครบ
        echo "<script>
            Swal.fire({
                icon: 'warning',
                title: 'ข้อมูลไม่ครบถ้วน',
                text: 'กรุณากรอกข้อมูลให้ครบถ้วน',
                confirmButtonText: 'ตกลง'
            }).then(function(){
                window.history.back();
            });
        </script>";
    }
    ?>
    <!-- ต้องมี SweetAlert2 และ jQuery ในหน้าเพจนี้ -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>