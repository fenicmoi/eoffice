$(document).ready(function () {
    $('#refresh-stats-btn').click(function () {
        var btn = $(this);
        var icon = btn.find('i');

        // Disable button and add spinning animation
        btn.prop('disabled', true);
        icon.addClass('fa-spin');

        // AJAX request to refresh statistics
        $.ajax({
            url: 'ajax_refresh_stats.php',
            type: 'GET',
            dataType: 'json',
            success: function (response) {
                if (response.success) {
                    // Update all statistics with animation
                    updateStatWithAnimation('#stat-active-users', response.data.activeUsers);
                    updateStatWithAnimation('#stat-today-docs', response.data.todayDocs);
                    updateStatWithAnimation('#stat-incoming-total', response.data.incomingTotal);
                    updateStatWithAnimation('#stat-outgoing-normal', response.data.outgoingNormal);
                    updateStatWithAnimation('#stat-active-agencies', response.data.activeAgencies);

                    // Update timestamp
                    $('#stats-timestamp').text(response.timestamp);

                    // Show success message
                    showNotification('success', 'อัพเดทข้อมูลสำเร็จ!');
                }
            },
            error: function () {
                showNotification('error', 'เกิดข้อผิดพลาดในการอัพเดทข้อมูล');
            },
            complete: function () {
                // Re-enable button and remove spinning animation
                btn.prop('disabled', false);
                icon.removeClass('fa-spin');
            }
        });
    });

    // Handle Active Agencies Modal
    $('#modalActiveAgencies').on('show.bs.modal', function () {
        var content = $('#agencies-modal-content');

        // Clear previous content and show spinner
        content.html('<div class="text-center" style="padding: 20px;"><i class="fas fa-spinner fa-spin fa-2x"></i> กำลังโหลดข้อมูล...</div>');

        // Fetch detailed agency data
        $.ajax({
            url: 'ajax_get_active_agencies.php',
            type: 'GET',
            dataType: 'json',
            success: function (response) {
                if (response.success && response.data.agencies.length > 0) {
                    var html = '<table class="table table-hover table-striped">';
                    html += '<thead style="background-color: #f8f9fc;"><tr><th>หน่วยงาน</th><th>ประเภท</th><th class="text-center">จำนวนผู้ใช้ออนไลน์</th></tr></thead>';
                    html += '<tbody>';

                    $.each(response.data.agencies, function (i, item) {
                        html += '<tr>';
                        html += '<td><strong>' + item.agency_name + '</strong></td>';
                        html += '<td>' + item.agency_type + '</td>';
                        html += '<td class="text-center"><span class="badge" style="background-color: #4e73df;">' + item.user_count + '</span></td>';
                        html += '</tr>';
                    });

                    html += '</tbody>';
                    html += '<tfoot style="background-color: #f8f9fc; font-weight: bold;">';
                    html += '<tr><td colspan="2">รวมข้อมูลทั้งสิ้น</td><td class="text-center">' + response.data.totalUsers + '</td></tr>';
                    html += '</tfoot></table>';

                    content.html(html);
                    $('#agencies-modal-timestamp').text(response.timestamp);
                } else {
                    content.html('<div class="alert alert-info text-center">ไม่มีหน่วยงานที่กำลังใช้งานระบบในขณะนี้</div>');
                }
            },
            error: function () {
                content.html('<div class="alert alert-danger text-center">เกิดข้อผิดพลาดในการดึงข้อมูล</div>');
            }
        });
    });

    // Function to update stat with fade animation
    function updateStatWithAnimation(selector, newValue) {
        var element = $(selector);
        element.fadeOut(200, function () {
            element.text(newValue);
            element.fadeIn(200);
        });
    }

    // Function to show notification
    function showNotification(type, message) {
        var bgColor = type === 'success' ? '#1cc88a' : '#e74a3b';
        var icon = type === 'success' ? 'fa-check-circle' : 'fa-exclamation-circle';

        var notification = $('<div>')
            .css({
                'position': 'fixed',
                'top': '20px',
                'right': '20px',
                'background': bgColor,
                'color': 'white',
                'padding': '15px 20px',
                'border-radius': '5px',
                'box-shadow': '0 4px 6px rgba(0,0,0,0.1)',
                'z-index': '9999',
                'display': 'none'
            })
            .html('<i class="fas ' + icon + '"></i> ' + message);

        $('body').append(notification);
        notification.fadeIn(300).delay(2000).fadeOut(300, function () {
            $(this).remove();
        });
    }
});
