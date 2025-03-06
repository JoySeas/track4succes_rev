<style type="text/css">
    .Iclass{
        font-size:1.3rem;
        cursor:pointer;
        font-weight: 500;
    }

    ul.pagination {
        display: inline-block;
        padding: 0;
        margin: 0;
    }

    ul.pagination li {
        cursor: pointer;
        display: inline;
        color: #3a4651 !important;
        font-weight: 600;
        padding: 4px 8px;
        border: 1px solid #CCC;
    }

    .pagination li:first-child{
        border-top-left-radius: 4px;
        border-bottom-left-radius: 4px;
    }

    .pagination li:last-child{
        border-top-right-radius: 4px;
        border-bottom-right-radius: 4px;
    }

    ul.pagination li:hover{
        background-color: #3a4651;
        color: white !important;
    }

    .pagination .active{
        background-color: #3a4651;
        color: white !important;
    }

    .table thead th, .table th {
        background-color: #9e9e9e !important;
    }

    .swal2-icon {
        margin-bottom: 10px !important;
    }

    .modalpaddingnew {
        padding-left: 10px;
        margin-bottom: 10px;
    }
</style>

<div class="row">
    <div class="col-12">
        <div class="card" style="margin-bottom: 0px;">
            <div class="card-body" style="padding-top: .5rem; padding-bottom: .5rem;">
                <div class="row page-titles rowpageheaderpadd" style="padding-bottom: 0px;">
                    <div class="col-md-6 col-6 align-self-center" style="padding-left:10px;">
                        <h3 class="mb-0 mt-0 headerfontfont text-themecolor" style="font-weight: 600;">DELIVERY</h3>
                    </div>
                    <div class="col-md-6 col-6 align-self-center" style="padding-right:10px;">
                        <ol class="breadcrumb float-right headerfontfont">
                            <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
                            <li class="breadcrumb-item active">Delivery</li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="container-fluid" style="padding: 15px 15px; background-color: white; min-height: 540px; margin-top: 15px;">
    <h4 class="mb-0 headerfontfont2" style="color: #2c2b2e;font-weight: 500;">Delivery List</h4>
    <h6 class="mb-4 headerfontfont" style="font-weight: 300;font-size: 13px;">You have total of <span id="txttotorders"></span> Delivery</h6>

    <div class="row" style="margin-bottom: .5rem;">
        <div class="col-md-4 coldashboardbox3" style="margin-bottom: 10px; padding-right: 0px;">
            <div class="input-group">
                <div class="input-group-prepend">
                    <span class="input-group-text searchinputorder"><i class="fas fa-search"></i></span>
                </div>
                <input type="text" class="form-control searchinputorder" id="txtsearchorder" placeholder="Search . . .">
            </div>
        </div>

        <div class="col-md-2 coldashboardbox3" style="padding-right: 0px;">
            <select class="form-control" id="filterselectorderstat" onchange="displayorderslist();" style="cursor: pointer; padding: .375rem .60rem;">
                <option value="">- Delivery Status -</option>
                <option value="PENDING">Pending</option>
                <option value="TODELIVER">For Delivery</option>
                <option value="COMPLETED">Completed</option>
            </select>
        </div>

        <div class="col-md-2 coldashboardbox3" style="padding-right: 0px;">
            <input type="text" class="form-control date-picker searchinputorder" id="txtsearchfilterdatefrom" placeholder="Date From" readonly="" onchange="$('#txtsearchfilterdatefrom').datepicker('hide');displayorderslist();" style="cursor: pointer;background-color: white!important; color: black; border:1px solid #b9bec3;">
        </div>

        <div class="col-md-2 coldashboardbox3" style="padding-right: 0px;">
            <input type="text" class="form-control date-picker searchinputorder" id="txtsearchfilterdateto" placeholder="Date To" readonly="" onchange="$('#txtsearchfilterdateto').datepicker('hide');displayorderslist();" style="cursor: pointer;background-color: white!important; color: black; border:1px solid #b9bec3;">
        </div>

        <div class="col-md-2 coldashboardbox4">

        </div>
    </div>

    <div class="row">
        <div class="col-12">
            <div class="mb-3">
                <table data-height="350" class="table table-bordered fixTable table-hover" style="margin-bottom: 0px;">
                    <thead class="bg-success text-white">
                        <tr>
                            <th style="width: 2%;white-space: nowrap;text-align: center;"> # </th>
                            <th style="width: 8%;white-space: nowrap;"> Order Code </th>
                            <th style="width: 15%;white-space: nowrap;"> Customer </th>
                            <th style="width: 15%;white-space: nowrap;"> Seller </th>
                            <th style="width: 15%;white-space: nowrap;"> Product </th>
                            <th style="width: 8%;white-space: nowrap;"> Price </th>
                            <th style="width: 8%;white-space: nowrap;"> Total Amount </th>
                            <th style="width: 5%;white-space: nowrap;"> Delivery Stat </th>
                            <th style="width: 3%;white-space: nowrap; text-align: center;"> Option </th>
                        </tr>
                    </thead>
                    <tbody id="tblorderlist"></tbody>
                </table>
            </div>

            <input id="txtorderlistPageCount" type="hidden">
            <ul id="uporderlistPageList" class="pagination float-right"></ul>
        </div>
    </div>
</div>

<?php 
    include("delivery/modal.php"); 
    include("delivery/script.php"); 
?>
