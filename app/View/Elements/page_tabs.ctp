<p style="text-align: center">
    <?php
    echo $this->Html->link('<i class="icon-tag bigger-230"></i> Brands', 
            array('controller' => 'brands'), 
            array('class' => 'btn btn-app btn-primary no-radius', 'escape' => false));
    ?>

    <?php
    echo $this->Html->link('<i class="icon-suitcase bigger-230"></i> Products', 
            array('controller' => 'productcategories'), 
            array('class' => 'btn btn-app btn-warning no-radius', 'escape' => false));
    ?>
    
    <?php
    echo $this->Html->link('<i class="icon-location-arrow bigger-230"></i> Locations', 
            array('controller' => 'locations'), 
            array('class' => 'btn btn-app btn-purple no-radius', 'escape' => false));
    ?>
    
    <?php
    echo $this->Html->link('<i class="icon-building bigger-230"></i> Outlets', 
            array('controller' => 'outlettypes'), 
            array('class' => 'btn btn-app btn-inverse no-radius', 'escape' => false));
    ?>
    
    <?php
    echo $this->Html->link('<i class="icon-tags bigger-230"></i> Merchandize', 
            array('controller' => 'brandelements'), 
            array('class' => 'btn btn-app no-radius', 'escape' => false));
    ?>
</p>