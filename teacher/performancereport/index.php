<link href='https://fonts.googleapis.com/css?family=Poppins' rel='stylesheet'>
<link href='https://fonts.googleapis.com/css?family=Montserrat' rel='stylesheet'>
<style type="text/css">
    .Iclass {
        font-family: 'Poppins';
        font-size: 1.3rem;
        cursor: pointer;
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

    .pagination li:first-child {
        border-top-left-radius: 4px;
        border-bottom-left-radius: 4px;
    }

    .pagination li:last-child {
        border-top-right-radius: 4px;
        border-bottom-right-radius: 4px;
    }

    ul.pagination li:hover {
        background-color: #3a4651;
        color: white !important;
    }

    .pagination .active {
        background-color: #3a4651;
        color: white !important;
    }

    .table thead th,
    .table th {
        background-color: #5598FB !important;
        color: #2C4E80;
    }
    .table th, .table thead th{
        color: #2C4E80;
    }

    .swal2-icon {
        margin-bottom: 10px !important;
    }

    .modalpaddingnew {
        padding-left: 10px;
        margin-bottom: 10px;
    }
</style>

<div class="container-fluid" style="padding: 15px 15px; background-color: white; min-height: 540px; margin-top: 15px; border-radius: 5px; border: 1px solid;">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h3 class="mb-0 headerfontfont" style="color: #2c2b2e;font-weight: 500;">Student Behavior</h3>
            <h3></h3>
            <!-- <h6 class="mb-0 headerfontfont" style="font-weight: 500;font-size: 15px;">Total of <span id="txttotorders" style="font-size: 20px; font-weight: 900;"> 35</span> Students</h6> -->
        </div>
        <div class="col-md-4">
            <div class="input-group">
                <div class="input-group-prepend">
                    <span class="input-group-text searchinputorder"><i class="fas fa-search"></i></span>
                </div>
                <input type="text" class="form-control searchinputorder" id="txtsearchorder" placeholder="Search . . .">
            </div>
        </div>
    </div>
    
    <div class="row">
        <div class="col-12">
            <div class="mb-3" style="border-radius: 10px;">
                <table data-height="350" class="table table-bordered fixTable table-hover" style="margin-bottom: 0px;">
                    <thead class="bg-success text-white">
                        <tr>
                            <th style="width: 20%;white-space: nowrap;text-align: left; color: #2C4E80;"> TRAITS </th>
                            <th style="width: 10%;white-space: nowrap;"> RATING </th>
                            <th style="width: 10%;white-space: nowrap;"> REMARKS </th>
                            <!-- <th style="width: 10%;white-space: nowrap;"> Teacher </th> -->
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
include("schedule/modal.php");
include("schedule/script.php");
?>