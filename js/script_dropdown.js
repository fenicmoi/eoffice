$(function(){
    var officeTypeObject = $('#office_type');
    var departObject = $('#depart');
    var sectionObject = $('#section');

    // on change office_type
    officeTypeObject.on('change', function(){
        var officeTypeId = $(this).val();
        departObject.html('<option value="">เลือกหน่วยงาน</option>');
        sectionObject.html('<option value="">เลือกกลุ่มงาน</option>');
        $.get('get_depart.php?type_id=' + officeTypeId, function(data){
            var result = JSON.parse(data);
            $.each(result, function(index, item){
                departObject.append(
                    $('<option></option>').val(item.dep_id).html(item.dep_name)
                );
            });
        });
    });

    // on change section

    departObject.on('change', function(){
        var departId = $(this).val();
            sectionObject.html('<option value="">เลือกกลุ่มงาน</option>');
        $.get('get_section.php?depart_id=' + departId, function(data){
            var result = JSON.parse(data);
            $.each(result, function(index, item){
                districtObject.append(
                    $('<option></option>').val(item.sec_id).html(item.sec_name)
                );
            });
        });
    });

});