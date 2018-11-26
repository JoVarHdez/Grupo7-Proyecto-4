$(document).ready(function(){

    $('#submitRate').on('click', function() {
        var starValue = $('input[name=star]:checked', '#star_form').val(); 
        var starProduct = $('input[name=idProductStar]', '#star_form').val();
        var ratesCount = $('input[name=ratesCount]', '#star_form').val(); 
        var ratesSum = $('input[name=ratesSum]', '#star_form').val();
        var oldRate = $('input[name=oldRate]', '#star_form').val(); 

        var formData = {
            _token: $('meta[name="_token"]').attr('content'),
            idUser: $('input[name=idUserStar]', '#star_form').val(),
            idProduct: starProduct,
            rate: starValue

        }

        $.ajax({
            method:'POST',
            url:'/ratings',
            data:formData,
            dataType: "json",
            
            success:function(data){
                if (data.msg != "error")
                {
                    changeRateState(data);
                    changeGlobalRate(data);
                }
                else
                    alert("Error");
            },
            error:function(xhr, ajaxOptions, errorInfo)
            {
                alert(xhr.status + " " + errorInfo);
            }
        });


        return false;
    });

    $('#updateRate').on('click', function()
    {
        changeRateState();
    });

});


function changeGlobalRate(data)
{
    var newHTML = "Average Rate: ";
    var newRate;
    if (data.ratesCount > 0)
        newRate = data.ratesSum/data.ratesCount;
    else 
        newRate = 0;

    newHTML += newRate;

    document.getElementById("averageRate2").innerHTML = newHTML;
    document.getElementById("globalRate2").innerHTML = newHTML;

    var newHTML2 = "";
    newHTML2 += "(" + data.ratesCount + " rates)";
    document.getElementById("ratesCount1").innerHTML = newHTML2;
    document.getElementById("ratesCount2").innerHTML = newHTML2;
}

function changeRateState(data)
{
    $("#starUpdate").fadeToggle();
    $("#starShow").fadeToggle();
    
    var newHTML = "";

    for (var i = 5; i > 0; i--)
    {
        newHTML += "<input class='star star-"+i + "' id='star-"+i + "-2' type='radio' name='star'";
        if (i == parseInt(data.rate))
            newHTML += "checked/>\n";
        else
            newHTML += "/>\n";

        newHTML += "<label class='star star-"+i+"' for='star-"+i+"-2'></label>\n";
									
    }

    document.getElementById("starRestart").innerHTML = newHTML;
}