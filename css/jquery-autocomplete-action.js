$(function(){
    $("#country").autocomplete({
        source: function(request,response){
            $.getJSON("ajaxCountry.php?keyword=" + request.term,function(data){
                if(data!=null){
                    response($.map(data, function(item){
                        return {
                            label: item.country_id + " - " + item.country,
                            value: item.country,
                            id: item.country_id
                        };
                    }));
                }
            });
        },
        select: function(event,ui){
            $("span.result-data").html(ui.item.label);
        }
    });
});