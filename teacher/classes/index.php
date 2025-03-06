<link href='https://fonts.googleapis.com/css?family=Poppins' rel='stylesheet'>
<link href='https://fonts.googleapis.com/css?family=Montserrat' rel='stylesheet'>
<style type="text/css">
.Iclass {
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
    background-color: #9e9e9e !important;
}

.swal2-icon {
    margin-bottom: 10px !important;
}

.modalpaddingnew {
    padding-left: 5px;
    margin-bottom: 10px;
}
.box img {
        width: 100%;
        height: 100%;
    }
</style>
<div class="row">
    <div class="col-12">
        <div class="card" style="margin-bottom: 0px;">
            <div class="card-body" style="padding-top: .5rem; padding-bottom: .5rem; border-radius: 5px; box-shadow: 2px 3px 5px rgb(126, 142, 159);">
                <div class="row page-titles rowpageheaderpadd" style="padding-bottom: 0px;">
                    <div class="col-md-6 col-6" style="padding-left: 1rem;">
                        <h3 class="" style="font-family: 'Poppins'; font-weight: 500; font-size: 2rem; margin-bottom: 2rem; margin-top: 1rem;">Classroom</h3>
                    </div>
                </div>
                
                <div class="row">
                    <div class="col-md-12">
                        <div class="row" style="">
                            <?php include("classes/fetch_classrooms.php"); ?>  <!-- Include your dynamic PHP code here -->
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>



<?php
include("classes/modal.php");
include("classes/script.php");
?>