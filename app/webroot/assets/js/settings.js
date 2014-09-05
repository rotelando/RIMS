
$(document).ready(function(){
    
    var url = config.URL + 'settings/currentuser'
    
    function getSettings() {
        return $.ajax({
            url: url,
            dataType: "JSON"
        });
    }
    
    var settings = getSettings();
    
    settings.success(function(data) {
        
        if(data.Setting.DeleteVisit == 'on')
            $('#SettingDeleteVisit').attr('checked', true);
        
        $('#SettingId').val(data.Setting.id);
        
        $('#SettingFieldrepid').val(data.Setting.fieldrepid);
        
        $('#SettingTargetOrder').val(data.Setting.TargetOrder);
        
        $('#SettingTargetVisit').val(data.Setting.TargetVisit);
        
        $('#SettingVisitException').val(data.Setting.VisitException);
        
        
    });
    
    $('[data-rel=tooltip]').tooltip({
        container:'body'
    });
    $('[data-rel=popover]').popover({
        container:'body'
    });
});
