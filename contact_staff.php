<?php
$staff_members = [
    [
        'name' => 'นายสมศักดิ์ แก้วเกลี้ยง',
        'position' => 'นักวิชาการคอมพิวเตอร์ชำนาญการ',
        'agency' => 'สำนักงานจังหวัดพัทลุง',
        'image' => 'images/somsak.jpg',
        'duty' => 'ที่ปรึกษาด้านการวางโครงสร้างหน่วยงาน',
        'phone' => '0815399135',
        'phone_display' => '081-539-9135',
        'bg_top' => 'bg-blue-50',
        'border_top' => 'border-blue-100',
        'text_icon' => 'text-blue-500',
        'bg_badge' => 'bg-blue-100',
        'text_badge' => 'text-blue-800',
        'btn_bg' => 'bg-blue-600',
        'btn_hover' => 'hover:bg-blue-700'
    ],
    [
        'name' => 'น.ส. กชพรรณ ชินภัควัต',
        'position' => 'ผู้ช่วยนักวิเคราะห์นโยบายและแผน',
        'agency' => 'สำนักงานจังหวัดพัทลุง',
        'image' => 'images/kotchapan.jpg',
        'duty' => 'ที่ปรึกษาด้านเทคนิคการใช้งานทั่วไป',
        'phone' => '0936669974',
        'phone_display' => '093-666-9974',
        'bg_top' => 'bg-blue-50',
        'border_top' => 'border-blue-100',
        'text_icon' => 'text-blue-500',
        'bg_badge' => 'bg-blue-100',
        'text_badge' => 'text-blue-800',
        'btn_bg' => 'bg-blue-600',
        'btn_hover' => 'hover:bg-blue-700'
    ],
    [
        'name' => 'นางวิสรรพ์พร ยืนยง',
        'position' => 'ผู้ช่วยโทรคมจังหวัดพัทลุง',
        'agency' => 'บริษัทโทรคมนาคมแห่งชาติ จำกัด สาขาพัทลุง',
        'image' => 'images/care.png',
        'duty' => 'ประสานงานภายในบริษัท NT',
        'phone' => '0893932270',
        'phone_display' => '089-393-2270',
        'bg_top' => 'bg-orange-50',
        'border_top' => 'border-orange-100',
        'text_icon' => 'text-orange-500',
        'bg_badge' => 'bg-orange-100',
        'text_badge' => 'text-orange-800',
        'btn_bg' => 'bg-orange-500',
        'btn_hover' => 'hover:bg-orange-600'
    ],
    [
        'name' => 'นายจิรายุทธ วงศ์พิพันธ์',
        'position' => 'นักบริการงานพาณิชย์ 6',
        'agency' => 'บริษัทโทรคมนาคมแห่งชาติ จำกัด สาขาพัทลุง',
        'image' => 'images/jirayut.png',
        'duty' => 'ประสานงานส่วนราชการกับส่วนกลาง',
        'phone' => null,
        'phone_display' => 'ไม่มีเบอร์ติดต่อ',
        'bg_top' => 'bg-orange-50',
        'border_top' => 'border-orange-100',
        'text_icon' => 'text-orange-500',
        'bg_badge' => 'bg-orange-100',
        'text_badge' => 'text-orange-800',
        'btn_bg' => '',
        'btn_hover' => ''
    ],
    [
        'name' => 'นายภิญญาวัฒน์ สุขแก้ว',
        'position' => 'ผู้อำนวยการกลุ่มงานวิชาการสถิติและวางแผน',
        'agency' => 'สำนักงานสถิติจังหวัดพัทลุง',
        'image' => 'images/pinyawat.png',
        'duty' => 'ประสานงานส่วนราชการกับส่วนกลาง',
        'phone' => '0805235887',
        'phone_display' => '080-523-5887',
        'bg_top' => 'bg-purple-50',
        'border_top' => 'border-purple-100',
        'text_icon' => 'text-purple-500',
        'bg_badge' => 'bg-purple-100',
        'text_badge' => 'text-purple-800',
        'btn_bg' => 'bg-purple-600',
        'btn_hover' => 'hover:bg-purple-700'
    ]
];

// สุ่มสลับตำแหน่ง (Randomize order)
shuffle($staff_members);
?>
<div class="container-fluse" style="font-family: 'Sarabun', sans-serif;">
    <div class="bg-gradient-to-r from-indigo-500 to-purple-600 rounded-2xl shadow-lg p-8 mb-8 text-white mt-4">
        <h2 class="text-4xl md:text-5xl font-bold mb-2 m-0"><i class="fas fa-address-book mr-3"></i>
            ทำเนียบเจ้าหน้าที่ผู้ให้คำปรึกษา</h2>
        <p class="text-xl md:text-2xl opacity-90 m-0 mt-2">ข้อมูลการติดต่อเจ้าหน้าที่สำหรับสอบถามปัญหาการใช้งานระบบ
            e-office</p>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mb-10">
        <?php foreach ($staff_members as $staff): ?>
            <!-- Card -->
            <div
                class="bg-white rounded-2xl shadow-md hover:shadow-xl transition-shadow duration-300 overflow-hidden border border-gray-100 flex flex-col">
                <div
                    class="<?php echo $staff['bg_top']; ?> p-6 flex flex-col items-center border-b <?php echo $staff['border_top']; ?>">
                    <div
                        class="w-72 h-72 bg-white rounded-full flex items-center justify-center <?php echo $staff['text_icon']; ?> shadow-sm mb-4 overflow-hidden border-4 border-white">
                        <img src="<?php echo $staff['image']; ?>" alt="<?php echo $staff['name']; ?>"
                            class="w-full h-full object-cover">
                    </div>
                    <h4 class="text-2xl md:text-3xl font-bold text-gray-900 text-center m-0"><?php echo $staff['name']; ?>
                    </h4>
                    <p class="text-lg text-gray-600 text-center mt-1 mb-0"><?php echo $staff['position']; ?></p>
                    <p class="text-lg text-gray-600 text-center mt-1 mb-0"><?php echo $staff['agency']; ?></p>
                </div>
                <div class="p-6 flex flex-col flex-grow">
                    <div class="mb-4 flex-grow">
                        <span
                            class="inline-block <?php echo $staff['bg_badge']; ?> <?php echo $staff['text_badge']; ?> text-base px-3 py-1 rounded-full font-semibold mb-2">หน้าที่ให้คำปรึกษา</span>
                        <p class="text-gray-700 text-xl m-0"><?php echo $staff['duty']; ?></p>
                    </div>
                    <?php if ($staff['phone']): ?>
                        <a href="tel:<?php echo $staff['phone']; ?>"
                            class="block w-full text-center bg-blue-600 hover:bg-blue-700 text-white font-bold py-3 rounded-xl transition-colors text-2xl no-underline hover:no-underline focus:outline-none mt-auto">
                            <i class="fas fa-phone-alt mr-2"></i> <?php echo $staff['phone_display']; ?>
                        </a>
                    <?php else: ?>
                        <a href="#"
                            class="block w-full text-center bg-gray-200 text-gray-500 font-bold py-3 rounded-xl transition-colors text-2xl no-underline hover:no-underline focus:outline-none cursor-not-allowed mt-auto"
                            onclick="return false;">
                            <i class="fas fa-phone-slash mr-2"></i> <?php echo $staff['phone_display']; ?>
                        </a>
                    <?php endif; ?>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</div>