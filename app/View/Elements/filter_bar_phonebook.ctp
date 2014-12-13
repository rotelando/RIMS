
<form method="POST" action="<?php echo "/{$controller}/{$action}"; ?>" name="filterform" class="form-inline">

    <div class="filter-bar" id="filter-bar">

        <h4 class="header smaller lighter green">Location Filter</h4>

        <input type="hidden" id="getparam" name="data[Outlet][getparam]"
               value="<?php echo isset($getparam) ? $getparam : ''; ?>" />

        <div class="span2" id="locationcontainer" style="margin-left: 0px;">
            <label>Region / Subregion</label>
            <?php echo $this->Form->select('locFilter', $regsubreg,
                array('id' => 'filter-location')); ?>
            <!--<input type="hidden" name="floc" id="floc" value="">-->
        </div>
        <div class="span2" id="statecontainer">
            <label>State</label>
            <?php echo $this->Form->select('locState', $state_list,
                array('id' => 'filter-state',  'style' => 'margin-left: 0px;')); ?>
            <!--<input type="hidden" name="floc" id="floc" value="">-->
        </div>
        <div class="span2" id="territorycontainer">
            <label>Territory</label>
            <?php echo $this->Form->select('locTerritory', $territory_list,
                array('id' => 'filter-territory', 'style' => 'margin-left: 0px;')); ?>
            <!--<input type="hidden" name="floc" id="floc" value="">-->
        </div>
        <div class="span2" id="lgacontainer">
            <label>LGA</label>
            <?php echo $this->Form->select('locLga', $lga_list,
                array('id' => 'filter-lga', 'style' => 'margin-left: 0px;')); ?>
            <!--<input type="hidden" name="floc" id="floc" value="">-->
        </div>
        <div class="span2" id="retblockcontainer">
            <label>Retail Block</label>
            <?php echo $this->Form->select('locRetblock', $retailblock_list,
                array('id' => 'filter-retblock', 'style' => 'margin-left: 0px;')); ?>
            <!--<input type="hidden" name="floc" id="floc" value="">-->
        </div>


        <div class="span2" style="margin-top: 20px;">
            <input type="submit" class="btn btn-small btn-success btnfilter" id="btnPhonefilter" value="Go" />
            <input type="reset" id="btnreset" class="btn btn-small btn-inverse btnfilter" value="Reset"/>
        </div>


        <div class="span2" id="numtypecontainer" style="margin-left: 0px; margin-top: 20px;">
            <label>Line Type</label>
            <?php echo $this->Form->select('phoneprefixlist', $phoneprefixlist, array('id' => 'filter-noType')); ?>
        </div>

        <div class="span2" id="usercontainer" style="margin-top: 20px;">
            <label>Users</label>
            <?php echo $this->Form->select('userFilter', $fieldreplist, array('id' => 'filter-user')); ?>
            <!--<input type="hidden" name="fusr" id="fusr" value="">-->
        </div>

        <div class="span2" id="retailtypecontainer" style="margin-top: 20px;">
            <label>Retailtype</label>
            <?php echo $this->Form->select('retailtypelist', $retailtypelist, array('id' => 'filter-retailtype', 'multiple' => true)); ?>
            <!--<input type="hidden" name="fusr" id="fusr" value="">-->
        </div>

        <div class="span3" id="datecontainer" style="margin-top: 20px;">
            <label>Date</label><br />
            <?php echo $this->Form->select('dateFilter', $datelist, array('id' => 'filter-date')); ?>

            <div id="dateoption">
                <hr style="width: 215px; margin: 10px 0px;"/>
                <div class="input-group">
                    <input class="form-control" type="text" name="custdate" id="custdate" style="width:160px;"/>
                <span class="btn btn-mini">
                    <i class="icon-calendar bigger-110"></i>
                </span>
                </div>
                <!--<div class="input-append filter-date-picker">
                <?php /*echo $this->Form->input('sdate', array('placeholder' => 'Start date',
                    'class' => 'datepicker input-small input-mask-date',
                    'id' => 'sdate',
                    'label' => false,
                    'type'=>'text',
                    'readonly'));
                */?>

                <span class="btn btn-small">
                    <i class="icon-calendar bigger-110"></i>
                </span>
            </div>
            <div class="input-append filter-date-picker">
                <?php /*echo $this->Form->input('edate', array('placeholder' => 'End date',
                    'class' => 'datepicker input-small input-mask-date',
                    'id' => 'edate',
                    'label' => false,
                    'type'=>'text',
                    'readonly')); */?>
                <span class="btn btn-small">
                    <i class="icon-calendar bigger-110"></i>
                </span>
            </div>-->
            </div>
        </div>

        <br /><br />
        <br /><br />
        <br /><br />
        <br /><br />
        <br /><br />
        <div class="span1"></div>
    </div>

</form>
