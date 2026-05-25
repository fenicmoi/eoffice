<?php
// Ensure this file is accessed via the main system
if (!defined('IS_SYSTEM_RUNNING')) {
    header('Location: index.php');
    exit();
}
?>
<div class="container-fluse" style="font-family: 'Sarabun', sans-serif;">
    <div class="bg-gradient-to-r from-blue-500 to-cyan-600 rounded-2xl shadow-lg p-8 mb-8 text-white mt-4">
        <h2 class="text-4xl md:text-5xl font-bold mb-2 m-0"><i class="fas fa-book-reader mr-3"></i>
            คู่มือการใช้งานและวิดีโอแนะนำระบบ</h2>
        <p class="text-xl md:text-2xl opacity-90 m-0 mt-2">ศูนย์รวมคู่มือการใช้งานและวิดีโอการอบรมสำหรับผู้ใช้งานทุกระดับ</p>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mb-10">
        
        <!-- Document 1 -->
        <a href="https://documents.eoffice.go.th/docs/ManualeSaraban" target="_blank" class="bg-white rounded-2xl shadow-md hover:shadow-xl transition-all duration-300 overflow-hidden border border-gray-100 flex flex-col group no-underline hover:no-underline focus:outline-none hover:-translate-y-2">
            <div class="bg-blue-50 p-6 flex flex-col items-center border-b border-blue-100 relative">
                <div class="absolute top-4 right-4 text-blue-300 group-hover:text-blue-500 transition-colors">
                    <i class="fas fa-external-link-alt text-xl"></i>
                </div>
                <div class="w-24 h-24 bg-white rounded-full flex items-center justify-center text-blue-500 shadow-sm mb-4">
                    <i class="fas fa-file-pdf text-5xl"></i>
                </div>
                <h4 class="text-2xl font-bold text-gray-900 text-center m-0 group-hover:text-blue-600 transition-colors">คู่มือการใช้งานระบบ e-Office</h4>
                <p class="text-lg text-gray-500 text-center mt-2 mb-0">(ครอบคลุมทุกฟังก์ชัน)</p>
            </div>
        </a>

        <!-- Document 2 -->
        <a href="https://documents.eoffice.go.th/docs/ManualAdminTool" target="_blank" class="bg-white rounded-2xl shadow-md hover:shadow-xl transition-all duration-300 overflow-hidden border border-gray-100 flex flex-col group no-underline hover:no-underline focus:outline-none hover:-translate-y-2">
            <div class="bg-purple-50 p-6 flex flex-col items-center border-b border-purple-100 relative">
                <div class="absolute top-4 right-4 text-purple-300 group-hover:text-purple-500 transition-colors">
                    <i class="fas fa-external-link-alt text-xl"></i>
                </div>
                <div class="w-24 h-24 bg-white rounded-full flex items-center justify-center text-purple-500 shadow-sm mb-4">
                    <i class="fas fa-cogs text-5xl"></i>
                </div>
                <h4 class="text-2xl font-bold text-gray-900 text-center m-0 group-hover:text-purple-600 transition-colors">คู่มือสำหรับผู้ดูแลระบบ</h4>
                <p class="text-lg text-gray-500 text-center mt-2 mb-0">(Administrator)</p>
            </div>
        </a>

        <!-- Video 1 -->
        <a href="https://documents.eoffice.go.th/docs/VideoTutorial" target="_blank" class="bg-white rounded-2xl shadow-md hover:shadow-xl transition-all duration-300 overflow-hidden border border-gray-100 flex flex-col group no-underline hover:no-underline focus:outline-none hover:-translate-y-2">
            <div class="bg-red-50 p-6 flex flex-col items-center border-b border-red-100 relative">
                <div class="absolute top-4 right-4 text-red-300 group-hover:text-red-500 transition-colors">
                    <i class="fas fa-external-link-alt text-xl"></i>
                </div>
                <div class="w-24 h-24 bg-white rounded-full flex items-center justify-center text-red-500 shadow-sm mb-4">
                    <i class="fab fa-youtube text-5xl"></i>
                </div>
                <h4 class="text-2xl font-bold text-gray-900 text-center m-0 group-hover:text-red-600 transition-colors">วิดีโอแนะนำการใช้งานระบบ</h4>
                <p class="text-lg text-gray-500 text-center mt-2 mb-0">สำหรับผู้ใช้งานทั่วไป</p>
            </div>
        </a>

        <!-- Video 2 -->
        <a href="https://documents.eoffice.go.th/docs/VideoTutorialAdmin" target="_blank" class="bg-white rounded-2xl shadow-md hover:shadow-xl transition-all duration-300 overflow-hidden border border-gray-100 flex flex-col group no-underline hover:no-underline focus:outline-none hover:-translate-y-2">
            <div class="bg-orange-50 p-6 flex flex-col items-center border-b border-orange-100 relative">
                <div class="absolute top-4 right-4 text-orange-300 group-hover:text-orange-500 transition-colors">
                    <i class="fas fa-external-link-alt text-xl"></i>
                </div>
                <div class="w-24 h-24 bg-white rounded-full flex items-center justify-center text-orange-500 shadow-sm mb-4">
                    <i class="fas fa-video text-5xl"></i>
                </div>
                <h4 class="text-2xl font-bold text-gray-900 text-center m-0 group-hover:text-orange-600 transition-colors">วิดีโอแนะนำการใช้งานระบบ</h4>
                <p class="text-lg text-gray-500 text-center mt-2 mb-0">สำหรับผู้ดูแลระบบ (Admin)</p>
            </div>
        </a>

        <!-- Video 3 -->
        <a href="https://documents.eoffice.go.th/docs/VideoTraining" target="_blank" class="bg-white rounded-2xl shadow-md hover:shadow-xl transition-all duration-300 overflow-hidden border border-gray-100 flex flex-col group no-underline hover:no-underline focus:outline-none hover:-translate-y-2">
            <div class="bg-teal-50 p-6 flex flex-col items-center border-b border-teal-100 relative">
                <div class="absolute top-4 right-4 text-teal-300 group-hover:text-teal-500 transition-colors">
                    <i class="fas fa-external-link-alt text-xl"></i>
                </div>
                <div class="w-24 h-24 bg-white rounded-full flex items-center justify-center text-teal-500 shadow-sm mb-4">
                    <i class="fas fa-chalkboard-teacher text-5xl"></i>
                </div>
                <h4 class="text-2xl font-bold text-gray-900 text-center m-0 group-hover:text-teal-600 transition-colors">วิดีโอบันทึกการอบรม</h4>
                <p class="text-lg text-gray-500 text-center mt-2 mb-0">บันทึกการสอนการใช้งานแบบละเอียด</p>
            </div>
        </a>

    </div>
</div>
