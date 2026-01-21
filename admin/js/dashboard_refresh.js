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
                    updateStatWithAnimation('#stat-commands', response.data.commands);
                    updateStatWithAnimation('#stat-circular-docs', response.data.circularDocs);
                    updateStatWithAnimation('#stat-pending-docs', response.data.pendingDocs);
                    updateStatWithAnimation('#stat-completed-docs', response.data.completedDocs);

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
