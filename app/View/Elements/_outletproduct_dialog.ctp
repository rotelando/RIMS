<?php
/**
 * Created by PhpStorm.
 * User: RotelandO
 * Date: 11/11/14
 * Time: 6:09 AM
 */
?>

<!-- Start Outlet Product dialog box -->
<div id="prod-dialog" class="modal hide fade" style="width: 400px; margin-left: -125px;" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
        <h3 id="myModalLabel">Edit Outlet Product</h3>
    </div>
    <!-- Start Modal Body -->
    <div class="modal-body">
        <input type="hidden" name="prod-id" id="prod-id" />

        <input type="hidden" name="id" id="id" />

        <label>Outlet</label>
        <input name="outlet_id" require="1" placeholder="Outlet Id" class="span4" type="text" id="outlet_id"
               value="<?php if(isset($outletmerchandize[0]['Outletmerchandize']['outlet_id'])) echo $outletmerchandize[0]['Outletmerchandize']['outlet_id']; ?>">

        <br />
        <label>Brand</label>
        <select name="brand_id" id="brands" class="span4">
            <option value="">MTN</option>
        </select>

        <br />
        <label>Product Category</label>
        <select name="product_id" id="product_id" class="span4">
            <option value="">Airtime</option>
        </select>
    </div>

    <div class="modal-footer">
        <a href="#" class="btn btn-success pa-saveBtn"> Save </a>
        <a href="#" data-dismiss="modal" class="btn btn-danger pull-left pa-cancelBtn"> Cancel </a>
    </div>
    <!-- End Modal Body -->
</div>