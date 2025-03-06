<div id="modaladduser" class="modal" data-keyboard="false" data-backdrop="static">
    <div class="modal-dialog modal-md" style="max-width: 530px;">
        <div class="modal-content">

            <div class="modal-body">
                <div class="row">
                    <div class="col-md-12 mb-3">
                        <div style="display: flex;justify-content: space-between !important;">
                            <h4 class="headerfontfont2" style="color: #2c2b2e;font-weight: 500;">Add New Customer</h4>
                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true"
                                onclick="clearuseracc()"
                                style="padding: 1rem 1rem;margin: -1.6rem -1rem -1rem auto;">×</button>
                        </div>
                    </div>

                    <input type="hidden" class="form-control clearinfo" id="txtuser_id">

                    <div class="col-md-4 mb-2">
                        <span style="font-weight:400">Firstname</span>
                        <input type="text" class="form-control clearinfo reqresinfo" id="txtadduserFname"
                            style="font-size: .9rem;">
                    </div>

                    <div class="col-md-4 mb-2 modalpaddingnew">
                        <span style="font-weight:400">Middlename</span>
                        <input type="text" class="form-control clearinfo" id="txtadduserMname"
                            style="font-size: .9rem;">
                    </div>

                    <div class="col-md-4 mb-2 modalpaddingnew">
                        <span style="font-weight:400">Lastname</span>
                        <input type="text" class="form-control clearinfo reqresinfo" id="txtadduserLname"
                            style="font-size: .9rem;">
                    </div>

                    <div class="col-md-6 mb-2">
                        <span style="font-weight:400">Contact Number</span>
                        <input type="text" class="form-control clearinfo contactnum " id="txtadduserContact"
                            style="font-size: .9rem;">
                    </div>

                    <div class="col-md-6 mb-2 modalpaddingnew">
                        <span style="font-weight:400">Email Address</span>
                        <input type="text" class="form-control clearinfo reqresinfo" id="txtadduserEmail"
                            style="font-size: .9rem;">
                    </div>

                    <div class="col-md-12 mt-4">
                        <hr>
                    </div>

                    <div class="col-md-6 mb-2">
                        <span style="font-weight:400">Username</span>
                        <input type="text" class="form-control clearinfo reqresinfo" id="txtadduserUsername"
                            style="font-size: .9rem;">
                    </div>

                    <div class="col-md-6 mb-2 modalpaddingnew">
                        <span>Password</span>
                        <div class="input-group">
                            <div class="input-group-prepend" id="inputaddusereye2" style="cursor: pointer;"
                                onclick="fncaddpassattribunHash();">
                                <span class="input-group-text"><i class="fas fa-eye-slash" id="addusereye2"></i></span>
                            </div>
                            <input type="Password" class="form-control clearinfo reqresinfo" id="txtadduserpass">
                        </div>
                    </div>
                </div>
            </div>

            <div class="modal-footer mt-4" style="padding: 10px 15px;">
                <div class="row">
                    <div class="col-md-12">
                        <button type="button"
                            class="btn waves-effect waves-light btn-secondary float-right buttonproduct btnuseraccSAVE"
                            onclick="adduseracc();"
                            style="background-color: #79a206 !important; border: 1px solid #79a206 !important;">Save
                            Customer</button>

                        <button type="button"
                            class="btn waves-effect waves-light btn-secondary float-right buttonproduct btnuseraccUPDATE"
                            onclick="adduseracc();"
                            style="background-color: #79a206 !important; border: 1px solid #79a206 !important; display: none;"><i
                                class="fas fa-save"></i> Update</button>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>

<div id="mdlapprovecust" class="modal" data-keyboard="false" data-backdrop="static">
    <div class="modal-dialog modal-md" style="max-width: 770px;">
        <div class="modal-content">

            <div class="modal-body">
                <div class="row">
                    <div class="col-md-12 mb-3">
                        <div style="display: flex;justify-content: space-between !important;">
                            <h4 class="headerfontfont2" style="color: #2c2b2e;font-weight: 500;">Pending Customers</h4>
                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true"
                                onclick="clearuseracc()"
                                style="padding: 1rem 1rem;margin: -1.6rem -1rem -1rem auto;">×</button>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-12">
                        <div class="mb-3">
                            <table data-height="350" class="table table-bordered fixTable table-hover"
                                style="margin-bottom: 0px;">
                                <thead class="bg-success text-white">
                                    <tr>
                                        <th style="width: 20%;white-space: nowrap;"> Name </th>
                                        <th style="width: 12%;white-space: nowrap;"> Phone </th>
                                        <th style="width: 12%;white-space: nowrap;"> Email </th>
                                        <th style="width: 10%;white-space: nowrap; text-align: center;"> Options </th>
                                    </tr>
                                </thead>
                                <tbody id="tblpendingcustlist"></tbody>
                            </table>
                        </div>

                        <input id="txtpendingcustlistPageCount" type="hidden">
                        <ul id="uppendingcustlistPageList" class="pagination float-right"></ul>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>

<div id="mdlopencustprof" class="modal" data-keyboard="false" data-backdrop="static">
    <div class="modal-dialog modal-dialog-centered modal-md" style="max-width: 450px;">
        <div class="modal-content">

            <div class="modal-body">
                <div class="row">
                    <div class="col-md-12 mb-3">
                        <div style="display: flex;justify-content: space-between !important;">
                            <h4 class="headerfontfont2" style="color: #2c2b2e;font-weight: 500;">Customer Information
                            </h4>
                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true"
                                onclick="clearuseracc()"
                                style="padding: 1rem 1rem;margin: -1.6rem -1rem -1rem auto;">×</button>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-12">
                        <h6>Full Name: <span style="color: #54667a;font-weight: 300;" id="txtfullname"></span></h6>
                        <h6>Contact Number: <span style="color: #54667a;font-weight: 300;" id="txtcontactnum"></span>
                        </h6>
                        <h6 class="mb-4">Email: <span style="color: #54667a;font-weight: 300;" id="txtemail"></span>
                        </h6>

                        <h6>Address: <span style="color: #54667a;font-weight: 300;" id="txtaddress"></span></h6>

                        <input type="hidden" class="form-control" id="txtLat">
                        <input type="hidden" class="form-control" id="txtLong">
                        <div class="mb-4" id="map_canvas"
                            style="height: 300px; width:100% !important; border-radius: 0px !important;"></div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>

<div id="mdlviewpaymentphoto" class="modal">
    <div class="modal-dialog modal-dialog-centered modal-md" style="max-width: 600px;">
        <div class="modal-content">
            <img src="assets/images/profile4.png" class="img-thumbnail" id="viewpaymentimg">
        </div>
    </div>
</div>