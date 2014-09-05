<div class="main-content">


    <?php // echo $this->element('breadcrumb'); ?>


    <div class="page-content">
        <!--.page-header-->
        <div class="page-header position-relative">

             <h1>
                Visits Management
                <small>
                    <i class="icon-double-angle-right"></i>
                    Creations & Views
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
                            <input id="toggleFilter" 
                                   <?php 
                                if(isset($filtertext) && $filtertext != '') {
                                    echo 'data-open="on"'; 
                                } else {
                                    echo 'data-open="off"'; 
                                }    ?>
                                   name="toggleFilter" class="ace ace-switch ace-switch-4" type="checkbox">
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
                    <h3 class="span12 header smaller lighter green">Scheduled Visits
<!--                        <div class="pull-right">
                            <a href="<?php // echo $this->here; ?>" class="btn btn-info btn-small" style="margin-left: 20px"> Go </a>
                        </div>-->
                        <div class="btn-group pull-right">
                            <button data-toggle="dropdown" class="btn btn-success btn-small dropdown-toggle">
                                Filter By
                                <span class="caret"></span>
                            </button>

                            <ul class="dropdown-menu dropdown-info pull-right">
                                <li>
                                    <?php
                                    echo $this->Html->link('Visited', array('controller' => 'visits', 'action' => 'planned',
                                        '?' => array('filter' => 'visited')));
                                    ?>
                                </li>

                                <li>
                                    <?php
                                    echo $this->Html->link('Unvisited', array('controller' => 'visits', 'action' => 'planned',
                                        '?' => array('filter' => 'unvisited')));
                                    ?>
                                </li>

                                <li>
                                    <?php
                                    echo $this->Html->link('All', array('controller' => 'visits', 'action' => 'planned',
                                        '?' => array('filter' => 'both')));
                                    ?>
                                </li>

                                <!--<li class="divider"></li>-->
                            </ul>
                        </div>
                    </h3>

                    <div style="text-align: center;">

                        <h3 class="text-info"><strong><?php echo $this->Paginator->param('limit') * $this->Paginator->param('count'); ?></strong> results found</h3>
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

                    <table id="sample-table-1" class="table table-striped table-bordered table-hover">
                        <thead>
                            <tr>
                                <th width="10px"> S/N </th>
                                <th> Outlet Name</th>
                                <th> Field Staff</th>
                                <th width="13%"> Scheduled Time </th>
                                <th width="10%"> Visit Status </th>                                
                                <th width="180px" style="text-align: center"> Actions </th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $i = 0;
                            foreach ($visits as $visit):
                                ?>
                                <tr>
                                    <td width="5%"> <?php echo++$i; ?> </td>
                                    <td>
                                    
                                    <?php
                                    echo $this->Html->link($visit['Outlet']['outletname'], array(
                                        'controller' => 'outlets', 'action' => 'view', $visit['Outlet']['id']
                                    ));
                                    ?> 
                                    </td>
                                    <td> <?php echo $visit['User']['firstname'] . ' ' . $visit['User']['lastname']; ?> </td>
                                    <td> <?php echo $visit['Schedule']['scheduledate']; ?> </td>
                                    <td>
                                        <?php
                                                if($visit['Schedule']['visited'] == '1') {
                                                    $text = 'Visited';
                                                    $type = "label label-success";
                                                } else {
                                                    $text = 'Unvisited';
                                                    $type = "label label-important";
                                                }
                                                echo "<span class=\"label {$type}\"> {$text} </span>";
                                            ?> 
                                    </td>
                                    <td style="text-align: center"> 
                                        <?php
                                        echo $this->Html->link('<i class="icon-zoom-in bigger-130"></i> View', array('controller' => 'visits', 'action' => 'view', $visit['Schedule']['id']), array('class' => 'blue', 'escape' => false));
                                        ?> |
                                        <?php
                                        echo $this->Html->link(
                                                '<i class="icon-pencil bigger-130"></i> Edit', array('controller' => 'visits', 'action' => 'edit', $visit['Schedule']['id']), array('class' => 'green', 'escape' => false));
                                        ?> |  
                                        <?php
                                        echo $this->Html->link(
                                                '<i class="icon-trash bigger-130"></i> Delete', array('controller' => 'visits', 'action' => 'delete', $visit['Schedule']['id']), array('class' => 'red', 'escape' => false), true);
                                        ?>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                            <?php unset($visits); ?>
                        </tbody>
                    </table>
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
    </div><!--/.page-content-->
</div><!--/.main-content-->


