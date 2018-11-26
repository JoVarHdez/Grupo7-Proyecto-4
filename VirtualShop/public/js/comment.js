$(document).ready(function(){
        
    $("a").click(function() {
        var str = this.id.split("_");
        var comparisson = str[0].localeCompare("replyButton");

        if (comparisson == 0)
    	{

            $("#commentReply_" + this.id).fadeToggle();
            return 1;
        }
        
        comparisson = str[0].localeCompare("deleteButton");
        if (comparisson == 0)
        {
            
           
        }
    });

});
