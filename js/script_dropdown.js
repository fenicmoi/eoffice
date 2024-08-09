$(function(){
    var officeTypeObject = $('#office_type');
    var departObject = $('#depart');
    var sectionObject = $('#section');

    // on change province
    officeTypeObject.on('change', function(){
    var officeTypeId = $(this).val();
    departObject.html('<option value="">เลือกหน่วยงาน</option>');
    sectionObject.html('<option value="">เลือกกลุ่มงาน</option>');
    $.get('get_depart.php?type_id=' + officeTypeId, function(data){
    var result = JSON.parse(data);
    $.each(result, function(index, item){
    sectionObject.append(
    $('<option></option>').val(item.id).html(item.name_th)
    );
    });
    });
    });
    // on change amphure
    departObject.on('change', function(){
    var departId = $(this).val();
    sectionObject.html('<option value="">เลือกกลุ่มงาน</option>');
    $.get('get_depart.php?depart_id=' + amphureId, function(data){
    var result = JSON.parse(data);
    $.each(result, function(index, item){
    districtObject.append(
    $('<option></option>').val(item.id).html(item.name_th)
    );
    });
    });
    });
    });