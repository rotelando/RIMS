<?php
/**
 * Created by PhpStorm.
 * User: RotelandO
 * Date: 11/11/14
 * Time: 6:08 AM
 */
?>


<!-- Start Product Source dialog box -->
<div id="ps-dialog" class="modal hide fade" style="width: 400px; margin-left: -125px;" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
        <h3 id="myModalLabel">Edit Outlet Product Source</h3>
    </div>
    <!-- Start Modal Body -->
    <div class="modal-body">
        <input type="hidden" name="ps-id" id="ps-id" />

        <label>Outlet</label>
        <input name="outlet_id" require="1" placeholder="Outlet Id" class="span4" type="text" id="outlet_id"
               value="<?php if(isset($outletmerchandize[0]['Outletmerchandize']['outlet_id'])) echo $outletmerchandize[0]['Outletmerchandize']['outlet_id']; ?>">

        <br />
        <label>Product Source Name</label>
        <input name="productsource" require="1" class="span4" type="text" id="contactfirstname" />

        <br />
        <label>Product Source Number </label>
        <input name="contactfirstname" require="1" class="span4" type="text" id="contactfirstname" />

        <br />
        <label>Product Source Alternate Name</label>
        <input name="contactfirstname" require="1" class="span4" type="text" id="contactfirstname" />

    </div>

    <div class="modal-footer">
        <a href="#" class="btn btn-success pa-saveBtn"> Save </a>
        <a href="#" data-dismiss="modal" class="btn btn-danger pull-left pa-cancelBtn"> Cancel </a>
    </div>
    <!-- End Modal Body -->
</div>