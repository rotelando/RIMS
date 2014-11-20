<?php
/**
 * Created by PhpStorm.
 * User: RotelandO
 * Date: 11/11/14
 * Time: 6:08 AM
 */
?>


<div id="outlet-dialog" class="modal hide fade" style="width: 400px; margin-left: -125px;" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
        <h3 id="myModalLabel"> Edit <?php echo $outlet['Outlet']['outletname']; ?></h3>
    </div>
    <!-- Start Modal Body -->
    <?php echo $this->Form->create('Outlet', array('method' => 'POST', 'controller' => 'outlets', 'action' => 'edit')); ?>

    <div class="modal-body">

        <input type="hidden" name="id" id="id" value="<?php echo $outlet['Outlet']['id']; ?>" />

        <label>Outlet name</label>
        <input name="outletname" require="1" class="span4" type="text" id="outletname" value="<?php echo $outlet['Outlet']['outletname']; ?>"  />

        <label>Street No.</label>
        <input name="streetnumber" require="1" class="span4" type="text" id="streetnumber" value="<?php echo $outlet['Outlet']['streetnumber']; ?>"  />

        <label>Street name</label>
        <input name="streetname" require="1" class="span4" type="text" id="streetname" value="<?php echo $outlet['Outlet']['streetname']; ?>" />

        <label>Town</label>
        <input name="town" require="1" class="span4" type="text" id="town" value="<?php echo $outlet['Outlet']['town']; ?>" />

        <br />
        <label>Contact first name</label>
        <input name="contactfirstname" require="1" class="span4" type="text" id="contactfirstname" value="<?php echo $outlet['Outlet']['contactfirstname']; ?>" />

        <br />
        <label>Contact last name</label>
        <input name="contactlastname" require="1" class="span4" type="text" id="contactlastname" value="<?php echo $outlet['Outlet']['contactlastname']; ?>" />

        <label>Phone Number</label>
        <input name="contactphonenumber" require="1" class="span4" type="number" id="contactphonenumber" value="<?php echo $outlet['Outlet']['contactphonenumber']; ?>" />

        <label>Alternate Phone Number</label>
        <input name="contactalternatenumber" class="span4" type="number" id="contactalternatenumber" value="<?php echo $outlet['Outlet']['contactalternatenumber']; ?>" />

        <label>VTU Number</label>
        <input name="vtunumber" class="span4" type="number" id="vtunumber" value="<?php echo $outlet['Outlet']['vtunumber']; ?>" />

        <br />
        <label>Advocacy class</label>
        <select name="outletclass_id" id="outletclass_id" class="span4">
            <?php foreach($outletclasses as $id => $label):
                if($outlet['Outlet']['outletclass_id'] == $id) {
                    echo "<option value='{$id}' selected>{$label}</option>";
                } else {
                    echo "<option value='{$id}'>{$label}</option>";
                }

            endforeach; ?>
        </select>

        <br />
        <label>Retail Type</label>
        <select name="retailtype_id" id="retailtype_id" class="span4">
            <?php foreach($retailtypes as $id => $label):
                if($outlet['Outlet']['retailtype_id'] == $id) {
                    echo "<option value='{$id}' selected>{$label}</option>";
                } else {
                    echo "<option value='{$id}'>{$label}</option>";
                }
            endforeach; ?>
        </select>

        <br />
        <label>Field Rep</label>
        <select name="user_id" id="user_id" class="span4">
            <?php foreach($userlist as $id => $label):
                if($outlet['Outlet']['user_id'] == $id) {
                    echo "<option value='{$id}' selected>{$label}</option>";
                } else {
                    echo "<option value='{$id}'>{$label}</option>";
                }
            endforeach; ?>
        </select>

    </div>
    <!-- End Modal Body -->

    <div class="modal-footer">
        <button type="submit" href="#" class="btn btn-success saveBtn"> Save </button>
        <a href="#" data-dismiss="modal" class="btn btn-danger pull-left cancelBtn"> Cancel </a>
    </div>
    <?php echo $this->Form->end(); ?>

</div>