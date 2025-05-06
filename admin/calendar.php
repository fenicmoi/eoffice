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