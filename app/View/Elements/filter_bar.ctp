
<?php echo $this->Form->create(null, 
        array('method' => 'POST', 
//              'controller'=>$this->params['controller'], 
//              'action'=>$this->params['action'], 
              'class' => 'form-inline', 
              'name' => 'filterform')); ?>    

<div class="filter-bar" id="filter-bar">
    <h4 class="header smaller lighter green">Filter</h4>

    <div class="span3" id="locationcontainer">
        <label>Location</label>
        <?php echo $this->Form->select('locFilter', $locations, 
                array('id' => 'filter-location')); ?>
        <!--<input type="hidden" name="floc" id="floc" value="">-->
              </div>

    <div class="span3" id="usercontainer">
        <label>Users</label>
        <?php echo $this->Form->select('userFilter', $fieldreplist, array('id' => 'filter-user')); ?>
        <!--<input type="hidden" name="fusr" id="fusr" value="">-->
    </div>

    <div class="span3" id="datecontainer">
        <label>Date</label>
        <?php echo $this->Form->select('dateFilter', $datelist, array('id' => 'filter-date')); ?>

        <div id="dateoption">
            <div class="input-append filter-date-picker">
                <?php echo $this->Form->input('sdate', array('placeholder' => 'Start date', 
                    'class' => 'datepicker input-small input-mask-date',
                    'id' => 'sdate',
                    'label' => false,
                    'type'=>'text', 
                    'readonly')); 
                ?>
                
                <!--<input name="sdate" placeholder="Start date" class="datepicker input-small input-mask-date" id="sdate" type="text" readonly>-->
                <span class="btn btn-small">
                    <i class="icon-calendar bigger-110"></i>
                </span>
            </div>
            <div class="input-append filter-date-picker">
                <?php echo $this->Form->input('edate', array('placeholder' => 'End date', 
                    'class' => 'datepicker input-small input-mask-date',
                    'id' => 'edate',
                    'label' => false,
                    'type'=>'text', 
                    'readonly')); ?>
                <span class="btn btn-small">
                    <i class="icon-calendar bigger-110"></i>
                </span>
            </div>
        </div>
    </div>

    <div class="span2" style="margin-top: 20px;">
        <input type="submit" class="btn btn-small btn-success btnfilter" id="btnfilter" value="Go" />
        <input type="reset" id="btnreset" class="btn btn-small btn-inverse btnfilter" id="btnfilter" value="Reset"/>
    </div>

    <br /><br />
    <br /><br />
    <br /><br />
    <br /><br />
    <div class="span1"></div>
</div>

<?php echo $this->Form->end(); ?>