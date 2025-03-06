<script type="text/javascript">
    $(function(){
        $(".fixTable").tableHeadFixer();

        $("#txtcustomerlistPageCount").val("1");
        $("#txtsearchcustomer").keyup(function(e){
            if($('#txtsearchcustomer').val() == ""){
                $("#txtcustomerlistPageCount").val("1");
                displaycustomerlist();
            } else{
                $("#txtcustomerlistPageCount").val("1");
                displaycustomerlist();
            }
        });
        displaycustomerlist();
        $(".contactnum").inputmask("+63 999-999-9999");
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

    function displaycustomerlist(){
        var srchprod = $("#txtsearchcustomer").val();
        var page = $("#txtcustomerlistPageCount").val();
        $.ajax ({
            type: 'POST',
            url: 'customer/class.php',
            data: 'srchprod=' + srchprod + '&page=' + page + '&form=displaycustomerlist' ,
            success: function(data) {
                var arr = data.split("|");
                $("#tblcustomerlist").html(arr[0]);
                $("#txttotsellers").text(arr[1]);
                loadcustomerlistPagination();
            }
        })
    }

    function loadcustomerlistPagination() {
        var srchprod = $("#txtsearchcustomer").val();
        var page = $("#txtcustomerlistPageCount").val();
        $.ajax({
            type: 'POST',
            url: 'customer/class.php',
            data: 'srchprod=' + srchprod + '&page=' + page + '&form=loadcustomerlistPagination',
            success: function(data){
                var arr = data.split("|");
                if(arr[1] != 1){
                    $("#upcustomerlistPageList").html(arr[0]);
                } else{
                    $("#upcustomerlistPageList").html("");
                }
            }
        })
    }

    function customerlistPageFunc(page, pagenums) {
        $(".pgnumcustomerlistPageFunc").removeClass("active");
        $("#pgcustomerlistPageFunc" + pagenums).addClass("active");
        $("#txtcustomerlistPageCount").val(page);
        displaycustomerlist();
    }

    function modalopencustprof(ID){
        $("#mdlopencustprof").modal('show');
        $.ajax({
            type: 'POST',
            url: 'customer/class.php',
            data: 'ID=' + ID + '&form=fncdsplycustinfo',
            success: function(data){
                var arr = data.split("|");
                $("#txtfullname").text(arr[0]);
                $("#txtcontactnum").text(arr[1]);
                $("#txtemail").text(arr[2]);
                $("#txtaddress").text(arr[3]);

                $("#txtLat").val(arr[5]);
                $("#txtLong").val(arr[6]);

                $("#imgvalidID").attr('src', arr[4]);
                $("#imgvalidID").attr("onclick", "viewvalidIDphoto('"+arr[4]+"')");

            },  complete: function(){
                geocodesearching();
            }
        })
    }

    function geocodesearching(){
        var geocoder = new google.maps.Geocoder();
        if($("#txtaddress").text() == "" || $("#txtaddress").text() == null){
            var address = "";
        }else{
            var address = $("#txtaddress").text();
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

    function getLocation(){
        GMaps.geocode({
        address: $("#txtaddress").text(),
            callback: function(results, status) {
            if (status == 'OK') {
              var latlng = results[0].geometry.location;
              var maps = new GMaps({
                    el: '#map-box',
                    lat: latlng.lat(),
                    lng: latlng.lng(),
                    width: '100%',
                    height: '15em',
              });
              maps.addMarker({
                    lat: latlng.lat(),
                    lng: latlng.lng(),
                    title: 'Your Address'
              });
            }
          }
        });
        
        if (navigator.geolocation){
            } else{ 
            x.innerHTML = "Geolocation is not supported by this browser.";
        }
    }

    function viewvalidIDphoto(payimg){
        $("#mdlviewpaymentphoto").modal('show');
        $('#viewpaymentimg').attr("src", payimg);
    }

    // var imgsrc = document.getElementById("imageId").src;
</script>