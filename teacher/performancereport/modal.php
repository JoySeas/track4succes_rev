<div id="mdladdproduct" class="modal" data-keyboard="false" data-backdrop="static">
    <div class="modal-dialog modal-md" style="max-width: 750px;">
        <div class="modal-content">

            <div class="modal-body">
                <div class="row">
                    <div class="col-md-12 mb-3">
                        <div style="display: flex;justify-content: space-between !important;">
                            <h4 class="headerfontfont2" style="color: #2c2b2e;font-weight: 500;" id="txtopenproductheader">New Product</h4>
                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true" onclick="clearfieldvalues()" style="padding: 1rem 1rem;margin: -1.6rem -1rem -1rem auto;">×</button>
                        </div>
                    </div>

                    <input type="hidden" class="form-control clearinfo" id="txtprodID">
                </div>

                <div class="row mb-2">
                    <div class="col-md-5">
                        <form method="post" action="#" enctype="multipart/form-data" id="frmUploadProductPic">
                            <div class="row" id="appendprodimage">

                            </div>

                            <div class="row" id="appendprodimage2">

                            </div>

                            <input type="hidden" class="clearinfo" id="hiddenwala" name="hiddenwala">
                            <input type="hidden" class="clearinfo" name="txtproductimageID" id="txtproductimageID">
                        </form>

                        <div class="row">
                            <div class="col-md-12 mb-2">
                                <button class="btn waves-effect waves-light btn-light" style="width:100%" onclick="fncappendprodimage();"><i class="fas fa-plus"></i> Image</button>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-7">
                        <div class="row">
                            <div class="col-md-12 mb-2">
                                <input type="hidden" class="form-control clearinfo" id="txtseller_id">
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="fas fa-search"></i></span>
                                    </div>
                                    <input type="text" class="form-control clearinfo reqresinfo" id="txtaddsellername" placeholder="Search Seller . . ." readonly="" style="cursor: pointer; background-color: white!important; color: black; border:1px solid #b9bec3;" onclick="openmdlseller();">
                                </div>
                            </div>

                            <div class="col-md-12 mb-2">
                                <span style="font-weight:400">Product Name</span>
                                <input type="text" class="form-control clearinfo reqresinfo" id="txtaddprodname" style="font-size: .9rem;">
                            </div>

                            <div class="col-md-12 mb-2">
                                <span style="font-weight:400">Description</span>
                                <textarea class="form-control clearinfo reqresinfo" id="txtaddproddesc" rows="4" style="font-size: .9rem;"></textarea>
                            </div>

                            <div class="col-md-4 mb-2">
                                <span style="font-weight:400">Quantity</span>
                                <input type="text" class="form-control numonly focus clearinfo reqresinfo" id="txtaddprodqty" style="font-size: .9rem;">
                            </div>

                            <div class="col-md-8 mb-2 modalpaddingnew">
                                <span style="font-weight:400">Price</span>
                                <input type="text" class="form-control numonly txtAmountFields clearinfo reqresinfo focus" id="txtaddprodprice" maxlength="10" onkeypress="return isNumberKey(event)" style="font-size: .9rem;">
                            </div>
                            <div class="col-md-12 mb-2">
                                <span style="font-weight:400">Available at</span>
                                <input type="date" class="form-control clearinfo reqresinfo" id="txtaddprodavailat" style="font-size: .9rem;">
                            </div>
                            <div class="col-md-12 mb-2">
                                <span style="font-weight:400">Available until</span>
                                <input type="date" class="form-control clearinfo reqresinfo" id="txtaddprodavailuntil" style="font-size: .9rem;">
                            </div>

                            <div class="col-md-12 mb-2">
                                <label for="txtaddprodunit" style="font-weight: 400;">Unit</label>
                                <select class="form-control clearinfo reqresinfo" id="txtaddprodunit" style="font-size: 0.9rem;">
                                    <option value="">- Select Unit -</option>
                                    <option value="Kg">Kg</option>
                                    <option value="grams">grams</option>
                                    <option value="Liters">Liters</option>
                                    <option value="ml">ml</option>
                                    <option value="Tray">Tray</option>
                                    <option value="piece">piece</option>
                                    <!-- Add more options as needed -->
                                </select>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <span style="font-weight:400">Category</span>
                            </div>
                            <input type="hidden" class="clearinfo" id="hiddenwala2" name="hiddenwala2">
                            <div class="col-md-9 mb-2" id="appendcategory">

                            </div>
                            <div class="col-md-3 mb-2 modalpaddingnew">
                                <button class="btn waves-effect waves-light btn-secondary" style="width:100%;padding: 0.375rem 0.75rem;" onclick="fncappendcategory();"><i class="fas fa-plus"></i></button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="modal-footer" style="padding: 10px 15px;">
                <div class="row">
                    <div class="col-md-12">
                        <button type="button" class="btn waves-effect waves-light btn-secondary float-right buttonproduct btnprodsave" onclick="addproduct();" style="background-color: #79a206 !important; border: 1px solid #79a206 !important;">Save
                            Product</button>

                        <button type="button" class="btn waves-effect waves-light btn-secondary float-right buttonproduct btnprodupdate" onclick="editproduct();" style="background-color: #79a206 !important; border: 1px solid #79a206 !important;display: none;">Update
                            Product</button>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>

<div id="mdllistofseller" class="modal" data-keyboard="false" data-backdrop="static">
    <div class="modal-dialog modal-dialog-centered modal-md" style="max-width: 800px;">
        <div class="modal-content">

            <div class="modal-body">
                <div class="row">
                    <div class="col-md-12 mb-3">
                        <div style="display: flex;justify-content: space-between !important;">
                            <h4 class="headerfontfont2" style="color: #2c2b2e;font-weight: 500;">Select Seller</h4>
                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true" onclick="clearuseracc()" style="padding: 1rem 1rem;margin: -1.6rem -1rem -1rem auto;">×</button>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-12">
                        <div class="mb-3">
                            <table data-height="350" class="table table-bordered fixTable table-hover" style="margin-bottom: 0px;">
                                <thead class="bg-success text-white">
                                    <tr>
                                        <th style="width: 2%;white-space: nowrap;text-align: center;"> # </th>
                                        <th style="width: 7%;white-space: nowrap;"> Image </th>
                                        <th style="width: 25%;white-space: nowrap;"> Name </th>
                                        <th style="width: 7%;white-space: nowrap;"> Phone </th>
                                        <th style="width: 7%;white-space: nowrap;"> Email </th>
                                    </tr>
                                </thead>
                                <tbody id="tblpendingsellerlist"></tbody>
                            </table>
                        </div>

                        <input id="txtpendingsellerlistPageCount" type="hidden">
                        <ul id="uppendingsellerlistPageList" class="pagination float-right"></ul>
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
                            <h4 class="headerfontfont2" style="color: #2c2b2e;font-weight: 500;">Seller Information</h4>
                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true" onclick="clearuseracc()" style="padding: 1rem 1rem;margin: -1.6rem -1rem -1rem auto;">×</button>
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
                        <!-- <div class="mb-4" id="map-box"></div> -->

                        <input type="hidden" class="form-control" id="txtLat">
                        <input type="hidden" class="form-control" id="txtLong">
                        <div class="mb-4" id="map_canvas" style="height: 300px; width:100% !important; border-radius: 0px !important;"></div>

                        <h6>Valid ID</h6>
                        <img src="assets/images/noimage5.png" alt="user" class="img" width="120" style="border: 1px solid #e6e6e6; cursor:pointer;" id="imgvalidID" onclick="">
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>

<div id="mdlviewpaymentphoto" class="modal">
    <div class="modal-dialog modal-dialog-centered modal-md" style="max-width: 600px;">
        <div class="modal-content">
            <img src="assets/images/noimage5.png" class="img-thumbnail" id="viewpaymentimg">
        </div>
    </div>
</div>