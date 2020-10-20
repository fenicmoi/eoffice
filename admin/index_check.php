<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>itOffside.com - check email</title>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
        <script type="text/javascript">
            $(document).ready(function() {
                $('#btnSubmit').click(function() {
                    var check = check_email();
                    check.success(function(data) {
                        if (data != 1){
                            $('#register').submit();
                            return false;
                        }
                    });
                    
                });
                $('#email').focusout(function() {
                    var check = check_email();
                    check.success(function(data) {
                        if (data == 1) {
                            $('.message').html('ชื่ออีเมล์นี้มีคนใช้แล้ว กรุณาเปลี่ยนชื่ออีเมล์ใหม่');
                        }
                    });
                });
            });
            function check_email() {
                return $.ajax({
                    type: 'POST',
                    data: {email: $('#email').val()},
                    url: 'check_mail.php'
                });
            }
        </script>
        <style>
            .message{
                font-size: 12px;
                color: red;
            }
        </style>
    </head>
    <body style="padding-top: 50px;">
        <h3 style="text-align:center;">สมัครสมาชิกกัน!</h3>
        <form name="register" id="register" method="POST" action="register.php">
            <table border="0" width="700" cellpadding="5" style="margin: 0 auto;">
                <tr>
                    <td style="text-align: right; width: 200px;">E-Mail</td>
                    <td>
                        <input type="text" id="email" name="email" value="">
                        <span class="message"></span>
                    </td>
                </tr>                
                <tr>
                    <td style="text-align: right;">Name</td>
                    <td><input type="text" id="Name" name="Name" value=""></td>
                </tr>
                <tr>
                    <td style="text-align: right;">&nbsp;</td>
                    <td><button type="button" id="btnSubmit">ตกลง</button></td>
                </tr>
            </table>
        </form>     
    </body>
</html>