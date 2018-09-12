// DataTables + H-ui Plugin  by QNick(http://nickspace.cn)
function render_amount_info( settings ) {
    $('.iRecordsTotal strong').text(settings._iRecordsTotal);
    $('.iRecordsTotal').show();
    if(settings._iRecordsTotal != settings._iRecordsDisplay){
        $('.iRecordsDisplay strong').text(settings._iRecordsDisplay);
        $('.iRecordsDisplay').show();
    }else{
        $('.iRecordsDisplay').hide();                
    }
}