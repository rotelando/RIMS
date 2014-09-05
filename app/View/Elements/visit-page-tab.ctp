<!--<p style="text-align: center">-->
<div class="widget-box span11">
    <div class="widget-header header-color-blue2">
        <h4 class="lighter smaller">Today at a glance</h4>
    </div>

<!--
Use "Today at a glance" on visits module. 

Actual/Planned  (in numbers), 
A/P (percentage), 
A/T (percentage), 
P/T (percentage), 
Exceptions.
-->

    <div class="widget-body">
        
        <div class="infobox-container">
            <div class="infobox infobox-green" style="margin-left: 0px;">
                <div class="infobox-icon">
                    <i class="icon-pushpin"></i>
                </div>

                <div class="infobox-data">
                    <span class="infobox-data-number"><?php echo $percentageactualvsplannedvisit; ?></span>
                    <div class="infobox-content">Actual/Planned (%)</div>
<!--                    <span class="infobox-data-number">88%</span>
                    <div class="infobox-content">Actual/Planned (%)</div>-->
                </div>
            </div>

            <div class="infobox infobox-pink  ">
                <div class="infobox-icon">
                    <i class="icon-pushpin"></i>
                </div>

                <div class="infobox-data">
                    <span class="infobox-data-number"><?php echo '8'; ?></span>
                    <div class="infobox-content">Trade Partners</div>
<!--                    <span class="infobox-data-number">8</span>
                    <div class="infobox-content">Trade Partners</div>-->
                </div>
            </div>

            <div class="infobox infobox-red  ">
                <div class="infobox-icon">
                    <i class="icon-pushpin"></i>
                </div>

                <div class="infobox-data">
                    <span class="infobox-data-number"><?php echo '4'; ?></span>
                    <div class="infobox-content">Sub Trade Partners</div>
<!--                    <span class="infobox-data-number">4</span>
                    <div class="infobox-content">Sub Trade Partners</div>-->
                </div>
            </div>
            
            <div class="infobox infobox-blue  ">
                <div class="infobox-icon">
                    <i class="icon-pushpin"></i>
                </div>

                <div class="infobox-data">
                    <span class="infobox-data-number"><?php echo '12'; ?></span>
                    <div class="infobox-content">Retailers</div>
<!--                    <span class="infobox-data-number">12</span>
                    <div class="infobox-content">Retailers</div>-->
                </div>
            </div>
            
            <div class="infobox infobox-orange">
                <div class="infobox-icon">
                    <i class="icon-pushpin"></i>
                </div>

                <div class="infobox-data">
                    <span class="infobox-data-number"><?php echo $visitexceptions; ?></span>
                    <div class="infobox-content">Visit Exceptions</div>
                </div>
            </div>
        </div>
    </div>
</div>
<!--</p>-->
<div class="space-12"></div>
