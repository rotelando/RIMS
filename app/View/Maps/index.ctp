
<div class="span1">    
    <a href="<?php echo $this->MyLink->getLastVisitedUrl();?>" class="btn"> <i class="icon-chevron-left"></i> </a>
</div>

<div class="span2">
    <label>Module</label>
    <select id="maps-modules">
        <option value="outlet">Outlets</option>
        <option value="visit">Visits</option>
        <option value="merch">Merchandize</option>
        <option value="avail">Product Availabilities</option>
        <option value="order">Orders</option>
    </select>
</div>
<div class="span7">
    <label>Filter(s)</label>
    <span id="map-filters"></span>
    <button class="btn btn-primary btn-small" style="margin: -5px 20px 0px;" id="btnmapfilter">
        Go
        <i class="icon-filter icon-on-right bigger-110"></i>
    </button>
</div>

<?php // echo $this->Form->create(null, array('controller'=>'maps', 'action' => 'search'));?>
<div class="span2">
    <label>Outlet Search</label>
        <input type="text" name="q" id="qtext" placeholder="Search for outlets..." />
        <button class="btn btn-purple btn-small" id="btnmapsearch">
            <i class="icon-search icon-on-right bigger-110"></i>
        </button>
</div>
<?php // echo $this->Form->end(); ?>
 
<!--<select id="filter-item"></select>-->
    
<!--<select id="outlet-type">
    <option value="a">All</option>
    <option value="v">Visited</option>
    <option value="u">Unvisited</option>
</select>

<select id="visit-modules">
    <option value="a">All</option>
    <option value="v">Visited</option>
    <option value="u">Unvisited</option>
</select>-->