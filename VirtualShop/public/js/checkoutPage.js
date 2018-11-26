$(document).ready(function(){
        
    $('.value-plus').on('click', function () {
        var str = this.id.split("_");
        var newHTML ="";

        var divUpd =  $(this).parent().find('.value'),
            newVal = parseInt(divUpd.text(), 10) + 1;

        if (newVal <= parseInt(str[2]))
        {
            divUpd = $("#quantity_" + str[1]);
            divUpd.text(newVal);
            divUpd = $("#quantityC_" + str[1]);
            divUpd.text(newVal);

            newHTML += "$" + newVal * parseInt(str[3]);
            var itemPriceHTML = document.getElementById("itemPrice_" + str[1]);

            if (itemPriceHTML != null)
            {
                itemPriceHTML.innerHTML = newHTML;
            }
            
            document.getElementById("itemPriceC_" + str[1]).innerHTML = newHTML;

            var formData = {
                _token: $('meta[name="_token"]').attr('content'),
                idProduct: str[1],
                value: newVal
    
            }
    
            $.ajax({
                method:'POST',
                url:'/incrementItem',
                data:formData,
                dataType: "json",
                
                success:function(data){
                    var newHTML2 = "";
                    newHTML2 += "Total = $" + data['totalPrice'];
                    var totalPriceHTML = document.getElementById("totalPrice");
                    
                    if (totalPriceHTML != null)
                    {
                        totalPriceHTML.innerHTML = newHTML2;
                    }
    
                    document.getElementById("totalPriceC").innerHTML = newHTML2;
                },
                error:function(xhr, ajaxOptions, errorInfo)
                {
                    alert(xhr.status + " " + errorInfo);
                }
            });

        }

        


        return true;
    });

    $('.value-minus').on('click', function () {
        var str = this.id.split("_");
        var newHTML ="";

        var divUpd = $(this).parent().find('.value'),
            newVal = parseInt(divUpd.text(), 10) - 1;
        if (newVal >= 1)
        { 
            divUpd = $("#quantity_" + str[1]);
            divUpd.text(newVal);
            divUpd = $("#quantityC_" + str[1]);
            divUpd.text(newVal);

            newHTML += "$" + newVal * parseInt(str[3]);
            var itemPriceHTML = document.getElementById("itemPrice_" + str[1]);

            if (itemPriceHTML != null)
            {
                itemPriceHTML.innerHTML = newHTML;
            }
            
            document.getElementById("itemPriceC_" + str[1]).innerHTML = newHTML;
        }
        var formData = {
            _token: $('meta[name="_token"]').attr('content'),
            idProduct: str[1],
            value: newVal

        }

        $.ajax({
            method:'POST',
            url:'/decrementItem',
            data:formData,
            dataType: "json",
            
            success:function(data){
                var newHTML2 = "";
                newHTML2 += "Total = $" + data['totalPrice'];

                var totalPriceHTML = document.getElementById("totalPrice");

                if (totalPriceHTML != null)
                {
                    totalPriceHTML.innerHTML = newHTML2;
                }

                document.getElementById("totalPriceC").innerHTML = newHTML2;

            },
            error:function(xhr, ajaxOptions, errorInfo)
            {
                alert(xhr.status + " " + errorInfo);
            }
        });
  
        return true;
    });


});