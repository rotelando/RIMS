<div class="main-content">


    <?php // echo $this->element('breadcrumb'); ?>


    <div class="page-content">
        <!--.page-header-->
        <div class="page-header position-relative">

            <h1>
                Merchandising
                <small>
                    <i class="icon-double-angle-right"></i>
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
                    <h3 class="span12 header smaller lighter green">All Merchandise Evaluations
                        <div class="btn-group pull-right">
                            <button data-toggle="dropdown" class="btn btn-info btn-small dropdown-toggle">
                                Sort By
                                <span class="caret"></span>
                            </button>

                            <ul class="dropdown-menu dropdown-info pull-right">
                                <li>
                                    <?php
                                    echo $this->Paginator->sort('Outlet.outletname', 'Outlet Name');
                                    ?>
                                </li>

                                <li>
                                    <?php
                                    echo $this->Paginator->sort('Outlet.createdat', 'Date');
                                    ?>
                                </li>

                                <li>
                                    <?php
                                    echo $this->Paginator->sort('Brandelement.brandelementname', 'Visibility Element');
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

                    <table id="sample-table-1" class="table table-striped table-bordered table-hover">
<!--                        <thead>
                            <tr>
                                <th width="5%"> S/N </th>
                                <th width="25%"> Outlet Visited</th>
                                <th width="25%"> Brand </th>
                                <th width="5%"> Visibility Element </th>
                                <th width="5%"> Element Count </th>
                                <th width="5%"> Grand Value </th>
                                <th width="10%" style="text-align: center"> Action </th>
                            </tr>
                        </thead>-->
                        <?php 
                            $tableHeaders = $this->Html->tableHeaders(array(
                                $this->Paginator->sort('Visibilityevaluation.id','S/N'),
                                $this->Paginator->sort('Outlet.outletname','Outlet Visited'),
                                $this->Paginator->sort('Brand.brandname','Brand'),
                                $this->Paginator->sort('Brandelement.brandelementname','Visibility Element'),
                                $this->Paginator->sort('Visibilityevaluation.elementcount','Element Count'),
                                $this->Paginator->sort('grandvalue','Grand Value'),
                                $this->Paginator->sort(null,'Action', array())),
                                null,
                                array('class' => 'table_head')
                            );
                            echo $tableHeaders;
                        ?>
                        <tbody>
                            <?php
                            $i = 0;
                            foreach ($visibilities as $visibility):
                                ?>
                                <tr>
                                    <td width="5%"> <?php echo ++$i ?> </td>
                                    <td>
                                        <?php
                                        echo $this->Html->link($visibility['Outlet']['outletname'], array(
                                            'controller' => 'outlets', 'action' => 'view', $visibility['Outlet']['id']
                                        ));
                                        ?> 
                                    </td>
                                    <td> <?php echo $visibility['Brand']['brandname']; ?>  </td>
                                    <td> <?php echo $visibility['Brandelement']['brandelementname']; ?> </td>
                                    <td width="5%"> <?php echo $visibility['Visibilityevaluation']['elementcount']; ?> </td>
                                    <td width="5%"> <?php echo $visibility[0]['grandvalue']; ?> </td>

                                    <td style="text-align: center" width="25%"> 
                                        <?php
                                        echo $this->Html->link('<i class="icon-building bigger-130"></i> Visit', array('controller' => 'visits', 'action' => 'view', $visibility['Visibilityevaluation']['visitid']), array('class' => 'blue', 'escape' => false));
                                        ?>

                                        <?php
                                        echo ' | ' . $this->Html->link(
                                                '<i class="icon-pencil bigger-130"></i> Edit', array('controller' => 'visibilityevaluations', 'action' => 'edit', $visibility['Visibilityevaluation']['id']), array('class' => 'green', 'escape' => false));
                                        ?> 

                                        <?php
                                        if (isset($setting['Setting']['DeleteVisit']) && $setting['Setting']['DeleteVisit'] == 'on') {
                                            echo ' | ' . $this->Html->link(
                                                    '<i class="icon-trash bigger-130"></i> Delete', array('controller' => 'visibilityevaluations', 'action' => 'delete', $visibility['Visibilityevaluation']['id']), array('class' => 'red', 'escape' => false), true);
                                        }
                                        ?>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                            <?php unset($visibilities); 
                            echo $tableHeaders;
                            ?>
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


