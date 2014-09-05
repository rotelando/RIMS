<div class="main-content">


    <?php // echo $this->element('breadcrumb'); ?>


    <div class="page-content">
        <!--.page-header-->
        
        <?php if($prodavailcount == 0): ?>
            
            <div class="page-header position-relative">
                <h1>
                    Product Availabilities
                    <small>
                        <i class="icon-double-angle-right"></i>
                        views and comparison
                    </small>
                </h1>
            </div><!--/.page-header-->
            <div class="row">
                <h3 class="text-center text-warning">No record for product availabilities</h3>
            </div>
            
        <?php else: ?>
            
        <div class="page-header position-relative">

             <h1>
                Product Availabilities
                <small>
                    <i class="icon-double-angle-right"></i>
                    views and comparison
                    <?php 
                            if(isset($filtertext) && $filtertext != '') {
                                echo " [Filter: {$filtertext}]";
                            }
                        ?>
                </small>
                <div class="pull-right">
                    <form class="form-inline">
                        <label>Filter </label>            
                        <label>
                            <input id="toggleFilter" name="toggleFilter" 
                                    <?php 
                                if(isset($filtertext) && $filtertext != '') {
                                    echo 'data-open="on"'; 
                                } else {
                                    echo 'data-open="off"'; 
                                }    ?> 
                                   class="ace ace-switch ace-switch-4" type="checkbox">
                            <span class="lbl"></span>
                        </label>
                    </form>
                </div>
            </h1>

        </div><!--/.page-header-->

        <?php echo $this->Session->flash(); ?>
        <?php echo $this->Session->flash('auth'); ?>

        <?php echo $this->element('filter_bar'); ?>

        <div class="row-fluid">

            <div class="span12">
                <div class="row-fluid">
                    <h3 class="span12 header smaller lighter green">All Product Availabilities
                        <div class="pull-right">
                            <a href="<?php echo $this->here; ?>" class="btn btn-info btn-small" style="margin-left: 20px"> Go </a>
                        </div>
                        <div class="btn-group pull-right">
                            <button data-toggle="dropdown" class="btn btn-info btn-small dropdown-toggle">
                                Sort By
                                <span class="caret"></span>
                            </button>

                            <ul class="dropdown-menu dropdown-info pull-right">
                                <li>
                                    <?php
                                    echo $this->Html->link('Outlet Name', array('controller' => 'visits', 'action' => 'all',
                                        '?' => array('sort' => 'outletname')));
                                    ?>
                                </li>

                                <li>
                                    <?php
                                    echo $this->Html->link('Above date', array('controller' => 'visits', 'action' => 'all',
                                        '?' => array('sort' => 'abovedate')));
                                    ?>
                                </li>

                                <li>
                                    <?php
                                    echo $this->Html->link('Below date', array('controller' => 'visits', 'action' => 'all',
                                        '?' => array('sort' => 'belowdate')));
                                    ?>
                                </li>

                                <!--<li class="divider"></li>-->
                            </ul>
                        </div>
                    </h3>

                    <div style="text-align: center;">

                        <h4 class="text-info">Showing page <?php echo $this->Paginator->counter(); ?></h4>

                        <div class="pagination">
                            <ul>
                                <?php
                                echo $this->Paginator->numbers(array(
                                    'first' => '<<',
                                    'separator' => '',
                                    'currentClass' => 'active',
                                    'tag' => 'li',
                                    'last' => '>>'
                                ));
                                ?>
                            </ul>
                        </div>
                    </div>

                    <?php if(isset($prodavails) && count($prodavails) > 0): ?>
                        <table id="sample-table-1" class="table table-striped table-bordered table-hover">
                            <thead>
                                <tr>
                                    <th width="3%"> S/N </th>
                                    <th> Brand </th>
                                    <th> Product </th>
                                    <th width="13%"> Quantity </th>
                                    <th width="13%"> Unit Price (N) </th>
                                    <th> Purchase Point </th>
                                    <th width="20%" style="text-align: center"> Actions </th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $i = 0;
                                foreach ($prodavails as $prodavail):
                                    ?>
                                    <tr>
                                        <td width="5%"> <?php echo ++$i + (25 * ($this->Paginator->counter() - 1)); ?> </td>
                                        <td> <?php echo $prodavail['Brand']['brandname']; ?> </td>
                                        <td> <?php echo $prodavail['Product']['productname']; ?>  </td>
                                        <td> <?php echo $prodavail['Productavailability']['quantityavailable']; ?>  </td>
                                        <td> <?php echo $prodavail['Productavailability']['unitprice']; ?>  </td>
                                        <td> <?php echo $prodavail['Productavailability']['purchasepoint']; ?>  </td>
                                        <td style="text-align: center"> 
                                            <?php
                                            echo $this->Html->link('<i class="icon-zoom-in bigger-130"></i> Visit', array('controller' => 'visits', 'action' => 'view', $prodavail['Productavailability']['visitid']), array('class' => 'blue', 'escape' => false));
                                            ?>

                                            <?php
//                                            echo ' | ' . $this->Html->link(
//                                                    '<i class="icon-pencil bigger-130"></i> Edit', array('controller' => 'visits', 'action' => 'edit', $prodavail['Productavailability']['id']), array('class' => 'green', 'escape' => false));
                                            ?> 

                                            <?php
                                            if (isset($setting['Setting']['DeleteVisit']) && $setting['Setting']['DeleteVisit'] == 'on') {
                                                echo ' | ' . $this->Html->link(
                                                        '<i class="icon-trash bigger-130"></i> Delete', array('controller' => 'productvisibilities', 'action' => 'delete', $prodavail['Productavailability']['id']), array('class' => 'red', 'escape' => false), true);
                                            }
                                            ?>
                                        </td>
                                    </tr>
                                    <?php endforeach; ?>
                                <?php unset($prodavails); ?>
                            </tbody>
                        </table>
                        <?php 
                            else:
                                echo 'No Product Availability recorded yet';
                            endif;
                         ?>
                    <div style="text-align: center;">

                        <h4 class="text-info">Showing page <?php echo $this->Paginator->counter(); ?></h4>

                        <div class="pagination">
                            <ul>
                                <?php
                                echo $this->Paginator->numbers(array(
                                    'first' => '<<',
                                    'separator' => '',
                                    'currentClass' => 'active',
                                    'tag' => 'li',
                                    'last' => '>>'
                                ));
                                ?>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div><!--/.row-fluid-->
        <?php endif; ?>
    </div><!--/.page-content-->
</div><!--/.main-content-->


