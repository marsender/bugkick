$(document).bind(
    'keydown',
    'e',
    function (evt){
        $.post(
            $("a.update-bug-link").attr("href"),
            { YII_CSRF_TOKEN :YII_CSRF_TOKEN },
              function(data){
                jQuery("#bugUpdateForm").html(data);
                jQuery("#updateBugDialog").dialog("open");
                jQuery(".chzn-select").chosen();
              },
              "html"
        );
       return false;
    }
);
$(document).bind(
    'keydown',
    'c',
    function (evt){
      if (confirm('Close this ticket?')){
          window.location='/bugkick/bug/setarchived/' + $("#archived-link").attr("ticket-id");
       }
       return false;
    }
);
$(document).bind(
    'keydown',
    'x',
    function (evt){
       if (confirm('Delete this ticket?')){
          $.post(
              '/bugkick/bug/delete/' + $("#archived-link").attr("ticket-id"),
              {YII_CSRF_TOKEN :YII_CSRF_TOKEN},
              function(data){
                window.location='/bugkick/bug/';
              },
              "html"
          );
       }
       return false;
    }
);
