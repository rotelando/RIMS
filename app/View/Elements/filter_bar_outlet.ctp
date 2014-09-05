
<?php echo $this->Form->create(null, 
        array('method' => 'POST', 
//              'controller'=>$this->params['controller'], 
//              'action'=>$this->params['action'], 
              'class' => 'form-horizontal', 
              'name' => 'filterform')); ?>    


<div class="row-fluid filter-bar">
    <h4 class="header smaller lighter green">Filter</h4>
    <div class="row-fluid outlet-class">    
        <h5 class="">Outlet Classification </h5>
        <div class="span3">
            <label>Advocacy</label>
            <select name="advocacy">
                <option value="">Availability</option>
                <option value="">Visibility</option>
                <option value="">Communication</option>
            </select>
        </div>
        <div class="span3">
            <label>Channel</label>
            <select name="advocacy">
                <option value="">Trade Partner</option>
                <option value="">Sub-trade Parter</option>
                <option value="">Retailer</option>
            </select>
        </div>
        <div class="span3">
            <label>Retailer</label>
            <select name="advocacy">
                <option value="">Pay & Go</option>
                <option value="">Shop & Browse</option>
                <option value="">Entertainment</option>
            </select>
        </div>
    </div>

    <div class="row-fluid locations">
    <h5 class="">Locations</h5>
        <div class="span3">
            <label>Region</label>
            <?php echo $this->Form->select('regions', $regions, array('id' => 'regions')); ?>
        </div>
        <div class="span3">
            <label>Sub-Regions</label>
            <?php echo $this->Form->select('subregions', $states, array('id' => 'subregions')); ?>
        </div>
        <div class="span3">
            <label>States</label>
            <?php echo $this->Form->select('states', $states, array('id' => 'states')); ?>
        </div>
        <div class="span3">
            <label>POP</label>
            <?php echo $this->Form->select('pop', $pop, array('id' => 'pop')); ?>
        </div>
        <div class="span3">
            <label>Territories</label>
            <?php echo $this->Form->select('Territories', $territories, array('id' => 'Territories')); ?>
        </div>
    </div>

    <hr />
    <div class="row-fluid">
        <div class="center">
        <a class="btn btn-small btn-success">Filter</a>
        <a class="btn btn-small btn-inverse">Clear</a>
        </div>
    </div>
    <hr />
</div>

<?php echo $this->Form->end(); ?>
