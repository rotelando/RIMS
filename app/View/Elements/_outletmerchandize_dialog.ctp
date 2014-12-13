<?php
/**
 * Created by PhpStorm.
 * User: RotelandO
 * Date: 11/11/14
 * Time: 6:09 AM
 */
?>

<div id="mer-dialog" class="modal hide fade" style="width: 400px; margin-left: -125px;" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
        <h3 id="myModalLabel"> Edit Outlet Merchandize</h3>
    </div>
    <!-- Start Modal Body -->
    <div class="modal-body">
        <input type="hidden" name="id" id="omid" />

        <label>Outlet</label>
        <input name="outlet_id" require="1" class="span4" type="text" id="outlet_id" disabled
               value="<?php echo (!empty($outlet_id) ? $outlet_id : ''); ?>"
            >

        <br />
        <label>Brand</label>
        <select name="brand_id" id="brands" class="span4">
        </select>

        <br />
        <label>Merchandize Element</label>
        <select name="merchandize_id" id="merchandize" class="span4">
        </select>

        <br />
        <label>Element Count</label>
        <input name="element_count" require placeholder="Element Count" class="span4" type="text" id="element_count">

        <br />
        <label>Appropriately Deployed</label>
        <input type="checkbox" value="off" checked="false" id="omamt" />

    </div>
    <!-- End Modal Body -->

    <div class="modal-footer">
        <a href="#" class="btn btn-success saveBtn"> Save </a>
        <a href="#" data-dismiss="modal" class="btn btn-danger pull-left cancelBtn"> Cancel </a>
    </div>
</div>