<script type="text/javascript">
	$(function(){
		$(".fixTable").tableHeadFixer();
		date_time();
		dsplyFname();
		dsplytotalseller();
		dsplytotalcustomer();
		dsplytotalproduct();
		dsplytotalorders();

		setTimeout(function(){ 
            new Chart(document.getElementById("chart1"),
            {
                "type":"line",
                "data":{"labels":["January","February","March","April","May","June","July","August","September","October","November","December"],
                "datasets":[{
                                "label":"Monthly Orders",
                                "data": JSON.parse(loadchartappointment()),
                                "fill":false,
                                "borderColor":"rgb(86, 192, 216)",
                                "lineTension":0.1
                            }]
            },"options":{}});
        }, 1000);

        setTimeout(function(){ 
            new Chart(document.getElementById("chart2"),
            {
                "type":"line",
                "data":{"labels":['2023', '2024', '2025', '2026', '2027', '2028', '2029', '2030', '2031', '2032', '2033', '2034'],
                "datasets":[{
                                "label":"Yearly Orders",
                                "data": JSON.parse(loadchartappointment2()),
                                "fill":false,
                                "borderColor":"rgb(86, 192, 216)",
                                "lineTension":0.1
                            }]
            },"options":{}});
        }, 1000);

        setTimeout(function(){ 
            new Chart(document.getElementById("chart3"),
            {
                "type":"line",
                "data":{"labels":['First Week', 'Second Week', 'Third Week', 'Fourth Week'],
                "datasets":[{
                                "label":"Weekly Orders",
                                "data": JSON.parse(loadchartappointment3()),
                                "fill":false,
                                "borderColor":"rgb(86, 192, 216)",
                                "lineTension":0.1
                            }]
            },"options":{}});
        }, 1000);

	});

	function date_time(){
	    date = new Date(getcurrentdatetime());
	    year = date.getFullYear();
	    month = date.getMonth();
	    months = new Array('January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December');
	    d = date.getDate();
	    day = date.getDay();
	    days = new Array('Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday');
	    h = date.getHours();
	    ampm = h >= 12 ? 'PM' : 'AM';
	    if(h<10)
	    {
	            h = "0"+h;
	    }
	    m = date.getMinutes();
	    if(m<10)
	    {
	            m = "0"+m;
	    }
	    s = date.getSeconds();
	    if(s<10)
	    {
	            s = "0"+s;
	    }
	    result = ''+days[day]+', '+months[month]+' '+d+', '+year+' &nbsp;&nbsp;&nbsp;'+h+':'+m+':'+s + ' '+ampm+' ';

	    $("#txtdatex").html(result);
	    setTimeout(function(){ date_time(); }, 1000);
	    return true;
	}

	function getcurrentdatetime(){
	    var vals = ""
	    $.ajax({
	        type : 'POST',
	        url :  'dashboard/dashboardclass.php',
	        data : "form=currenttime",
	        async:false,
	        beforeSend:function(){    
	               
	        },
	        success : function(data){
	            vals = data;
	        }
	    });
	    return vals;
	}

	function dsplyFname() {
		$.ajax ({
			type: 'POST',
			url: 'dashboard/dashboardclass.php',
			data: 'form=dsplyFname' ,
			success: function(data) {
				$("#txtuserFname").text(data);
			}
		})
	}

	function dsplytotalseller() {
		$.ajax ({
			type: 'POST',
			url: 'dashboard/dashboardclass.php',
			data: 'form=dsplytotalseller' ,
			success: function(data) {
				$("#txtTotsellers").text(data);
			}
		})
	}

	function dsplytotalcustomer() {
		$.ajax ({
			type: 'POST',
			url: 'dashboard/dashboardclass.php',
			data: 'form=dsplytotalcustomer' ,
			success: function(data) {
				$("#txtTotcustomer").text(data);
			}
		})
	}

	function dsplytotalproduct() {
		$.ajax ({
			type: 'POST',
			url: 'dashboard/dashboardclass.php',
			data: 'form=dsplytotalproduct' ,
			success: function(data) {
				$("#txtTotproduct").text(data);
			}
		})
	}

	function dsplytotalorders() {
		$.ajax ({
			type: 'POST',
			url: 'dashboard/dashboardclass.php',
			data: 'form=dsplytotalorders' ,
			success: function(data) {
				$("#txtTotorders").text(data);
			}
		})
	}

	function loadchartappointment(){
        var genderDataHolder = "";
        $.ajax({
            type: 'POST',
            data: 'form=loadchartappointment',
            url : 'dashboard/dashboardclass.php',
            async: false,
            success: function(data)
            {
                genderDataHolder = data;
            }
        });
        return genderDataHolder;
    }

    function loadchartappointment2(){
        var genderDataHolder2 = "";
        $.ajax({
            type: 'POST',
            data: 'form=loadchartappointment2',
            url : 'dashboard/dashboardclass.php',
            async: false,
            success: function(data)
            {
                genderDataHolder2 = data;
            }
        });
        return genderDataHolder2;
    }

    function loadchartappointment3(){
        var genderDataHolder3 = "";
        $.ajax({
            type: 'POST',
            data: 'form=loadchartappointment3',
            url : 'dashboard/dashboardclass.php',
            async: false,
            success: function(data)
            {
                genderDataHolder3 = data;
            }
        });
        return genderDataHolder3;
    }
</script>