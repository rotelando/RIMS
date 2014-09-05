<!--<p style="text-align: center">-->
<div class="widget-box span11">
    <div class="widget-header header-color-blue2">
        <h4 class="lighter smaller">Today at a glance</h4>
    </div>

<!--    
Dashboard

Top information (Today at a glance)
- Actual / Planned
- Total Sales
- Field reps who have started visits / Total Field reps in the system (under the manager)
- Active locations / Total locations (under the manager)
- Number of exceptions
Take out element performance from dashboard
-->

    <div class="widget-body">
        
        <div class="infobox-container">
            <div class="infobox infobox-green" style="margin-left: 0px;">
                <div class="infobox-icon">
                    <i class="icon-pushpin"></i>
                </div>

                <div class="infobox-data">
                    <span class="infobox-data-number"><?php echo $actualvsplannedvisit; ?></span>
                    <div class="infobox-content">Actual/Planned Visits</div>
                    <!-- <span class="infobox-data-number">480/540</span>
                    <div class="infobox-content">Actual/Planned Visits</div> -->
                </div>
            </div>

            <div class="infobox infobox-pink  ">
                <div class="infobox-icon">
                    <i class="icon-truck"></i>
                </div>

                <div class="infobox-data">
                    <span class="infobox-data-number"><?php echo $totalsales; ?></span>
                    <div class="infobox-content">Total Sales (N)</div>
                    <!-- <span class="infobox-data-number">179</span>
                    <div class="infobox-content">Total Sales</div> -->
                </div>
            </div>

            <div class="infobox infobox-red  ">
                <div class="infobox-icon">
                    <i class="icon-group"></i>
                </div>

                <div class="infobox-data">
                    <span class="infobox-data-number"><?php echo $actualvstotalstaff; ?></span>
                    <div class="infobox-content">Actual/Total Staff</div>
                    <!-- <span class="infobox-data-number">268/300</span>
                    <div class="infobox-content">Actual/Total Staff</div> -->
                </div>
            </div>
            
            <div class="infobox infobox-blue  ">
                <div class="infobox-icon">
                    <i class="icon-location-arrow"></i>
                </div>

                <div class="infobox-data">
                    <span class="infobox-data-number"><?php echo $actualvstotallocation; ?></span>
                    <div class="infobox-content">Actual/Total Territories</div>
<!--                     <span class="infobox-data-number">32/81</span>
                    <div class="infobox-content">Actual/Total Territories</div> -->
                </div>
            </div>
            
            <div class="infobox infobox-orange">
                <div class="infobox-icon">
                    <i class="icon-exclamation"></i>
                </div>

                <div class="infobox-data">
                    <span class="infobox-data-number"><?php echo $visitexceptions; ?></span>
                    <div class="infobox-content">Visit Exceptions</div>
<!--                     <span class="infobox-data-number">2</span>
                    <div class="infobox-content">Visit Exceptions</div> -->
                </div>
            </div>
        </div>
    </div>
</div>
<!--</p>-->
<div class="space-12"></div>
