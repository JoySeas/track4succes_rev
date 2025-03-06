<script type="text/javascript">
    $(function(){
        $(".fixTable").tableHeadFixer();

        $("#txtorderlistPageCount").val("1");
        $("#txtsearchorder").keyup(function(e){
            if($('#txtsearchorder').val() == ""){
                $("#txtorderlistPageCount").val("1");
                displayorderslist();
            } else{
                $("#txtorderlistPageCount").val("1");
                displayorderslist();
            }
        });
        displayorderslist();
        $(".contactnum").inputmask("+63 999-999-9999");

        $(".date-picker").datepicker({
            autoHide: true,
            format: 'mm/dd/yyyy',
            todayHighlight: true
        });
    });

    function reqField1 ( classN ){
        var isValid = 1;
        $('.'+classN).each(function(){
            if( $(this).val() == '' ){
                $(this).css('border','1px #a94442 solid');
                $(this).addClass('lala');
                isValid = 0;
            } else {
                $(this).css('border','');
                $(this).removeClass('lala');
            }
        });

        return isValid;
    }

    function displayorderslist(){
        var srchprod = $("#txtsearchorder").val();
        var page = $("#txtorderlistPageCount").val();
        var orderstat = $("#filterselectorderstat").val();
        var datefrom = $("#txtsearchfilterdatefrom").val();
        var dateto = $("#txtsearchfilterdateto").val();
        $.ajax ({
            type: 'POST',
            url: 'payments/class.php',
            data: 'srchprod=' + srchprod + '&page=' + page + '&orderstat=' + orderstat + '&datefrom=' + datefrom + '&dateto='+ dateto + '&form=displayorderslist' ,
            success: function(data) {
                var arr = data.split("|");
                $("#tblorderlist").html(arr[0]);
                $("#txttotorders").text(arr[1]);
                loadorderslistPagination();
            }
        })
    }

    function loadorderslistPagination() {
        var srchprod = $("#txtsearchorder").val();
        var page = $("#txtorderlistPageCount").val();
        var orderstat = $("#filterselectorderstat").val();
        var datefrom = $("#txtsearchfilterdatefrom").val();
        var dateto = $("#txtsearchfilterdateto").val();
        $.ajax({
            type: 'POST',
            url: 'payments/class.php',
            data: 'srchprod=' + srchprod + '&page=' + page + '&orderstat=' + orderstat + '&datefrom=' + datefrom + '&dateto='+ dateto + '&form=loadorderslistPagination',
            success: function(data){
                var arr = data.split("|");
                if(arr[1] != 1){
                    $("#uporderlistPageList").html(arr[0]);
                } else{
                    $("#uporderlistPageList").html("");
                }
            }
        })
    }

    function orderlistPageFunc(page, pagenums) {
        $(".pgnumorderlistPageFunc").removeClass("active");
        $("#pgorderlistPageFunc" + pagenums).addClass("active");
        $("#txtorderlistPageCount").val(page);
        displayorderslist();
    }

    function modalopenorderdet(product_id, order_id, customer_id){
        $("#mdlopenorderdet").modal('show');
        $.ajax({
            type: 'POST',
            url: 'payments/class.php',
            data: 'product_id=' + product_id + '&order_id=' + order_id + '&customer_id=' + customer_id + '&form=fncdsplyorderinfo',
            success: function(data){
                var arr = data.split("|");
                $("#prodbuynowimg").html(arr[0]);
                $("#txtprodbuynowname").text(arr[1]);
                $("#txtprodbuynowqty").text(arr[6]);
                $("#txtprodbuynowprice").text(arr[7]);

                $("#txtprodbuynowuser").text(arr[11]);
                $("#txtprodbuynowphone").text(arr[12]);
                $("#txtprodbuynowadd").text(arr[13]);
                $("#txtLat").val(arr[14]);
                $("#txtLong").val(arr[15]);

                if(arr[10] == "CASH"){
                    $("#txtorddetpaymenttype").text("Cash On Delivery");
                    $("#txtpaymentcaption").text("Pay when you receive.");
                    $(".gcashpayment").addClass("hide");
                } else{
                    $("#txtorddetpaymenttype").text("GCASH");
                    $("#txtpaymentcaption").text("Pay with your GCASH account.");
                    $(".gcashpayment").removeClass("hide");
                }

                var textprodprice = (arr[7]).replace(/,/g,"");
                var subtotamt = (textprodprice * arr[6]);

                $("#txtprodbuynowsubtotal").text(parseFloat(subtotamt).toFixed(2).replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1,"));
                $("#txtprodbuynowshipfee").text(arr[8]);
                $("#txtprodbuynowtotal").text(arr[9]);

                $("#txtprodbuynowrefnum").text(arr[16]);
                $("#prodbuynowgcashimg").html(arr[17]);

            },  complete: function(){
                geocodesearching();
            }
        })
    }

    function geocodesearching(){
        var geocoder = new google.maps.Geocoder();
        if($("#txtprodbuynowadd").text() == "" || $("#txtprodbuynowadd").text() == null){
            var address = "";
        }else{
            var address = $("#txtprodbuynowadd").text();
        }
        var lat = document.getElementById("txtLat").value;
        var lng = document.getElementById("txtLong").value;
        geocoder.geocode( { 'address': address}, function(results, status) {
            if (status == google.maps.GeocoderStatus.OK) {
                var latitude = results[0].geometry.location.lat();
                var longitude = results[0].geometry.location.lng();
                initialize(lat,lng);
                // $("#txtLat").val(latitude);
                // $("#txtLong").val(longitude);
            }else{
                initialize(lat,lng);
            }
        });
    }

    function initialize(latitude,longitude) {
        var latlng = new google.maps.LatLng(latitude,longitude);
        var myOptions = {
            zoom: 16,
            center: latlng,
            mapTypeId: google.maps.MapTypeId.ROADMAP,
            mapTypeControl: false
        };
        var map = new google.maps.Map(document.getElementById("map_canvas"),myOptions);
        var marker = new google.maps.Marker({
            position: latlng, 
            map: map,
            draggable: true
        });

        google.maps.event.addListener(marker, 'dragend', function(evt){
            $("#txtLat").val(evt.latLng.lat());
            $("#txtLong").val(evt.latLng.lng());
        });

        google.maps.event.addListener(marker, 'drag', function(evt){
             console.log("marker is being dragged");
        });
    }

    function viewvalidIDphoto(payimg){
        $("#mdlviewpaymentphoto").modal('show');
        $('#viewpaymentimg').attr("src", payimg);
    }

    // var imgsrc = document.getElementById("imageId").src;
</script>