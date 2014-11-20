<div class="main-content">


    <?php // echo $this->element('breadcrumb'); ?>
    <div class="page-content">
        <div class="page-header position-relative">
            <h1>
                Setup
                <small>
                    <i class="icon-double-angle-right"></i>
                    Brands, Outlet Classifications, Merchandize, Products & Locations
                </small>
            </h1>
        </div>

        <?php echo $this->Session->flash(); ?>
        <?php echo $this->Session->flash('auth'); ?>


        <?php echo $this->element('page_tabs'); ?>

        <div class="row-fluid">

            <div class="span12">
                <h3 class="header smaller lighter green">Manage Territories</h3>

                <!--Territory setup wizard-->
                <?php echo $this->element('_location_setup_progress', array('active' => 'territory')); ?>
                <!--End of Territory setup wizard-->

                <!--Start Main Tab-->
                <div class="span12" style="margin-left: 0px;">

                    <div class="span4">
                        <!--<h3 class="header smaller lighter green">Add New Brand</h3>-->
                        <div style="height: 10px;"></div>

                        <div class="widget-box">
                            <div class="widget-header">
                                <h4><?php if (!isset($data['Territory']['id'])) echo "Add"; else echo "Edit"; ?> Territory</h4>
                            </div>

                            <div class="widget-body" style="padding: 15px;">

                                <?php echo $this->Form->create('Territory', array('method' => 'POST', 'controller' => 'territories', 'action' => 'add'));
                                ?>
                                <br />

                                <?php
                                echo $this->Form->input('id', array('type' => 'hidden'));
                                ?>

                                <?php
                                echo $this->Form->input('territoryname', array('label' => 'Territory Name', 'required' => true, 'placeholder' => 'Enter name of Territory', 'class' => 'span10 left-stripe', 'type' => 'text'));
                                ?>

                                <label> Select State
                                    <?php
                                    echo $this->Html->link(
                                        '<i class="icon-plus"></i> Add', array('controller' => 'territories', 'action' => 'index'), array('class' => 'btn btn-mini orange', 'escape' => false));
                                    ?>
                                </label>
                                <?php
                                echo $this->Form->select('state_id', $statelist, array('label' => 'State', 'required' => false, 'placeholder' => 'Select State', 'class' => 'span10 left-stripe', 'type' => 'text'));
                                ?>

                                <hr/>
                                <?php if (!isset($data['Territory']['id'])): ?>
                                    <button type="submit" class="btn btn-success">Add Territory</button>
                                <?php else: ?>
                                    <button type="submit" class="btn btn-info">Update Territory</button>
                                <?php endif; ?>


                                <?php echo $this->Form->end() ?>
                            </div>
                        </div>
                    </div>
                    <div class="span8">
                        <!--PAGE CONTENT BEGINS-->
                        <div class="row-fluid">
                            <h3 class="span12 header smaller lighter green">List of Territories</h3>
                            <p class="pull-right">
                                <?php
                                //                            echo $this->Html->link('<i class="icon-tag bigger-160"></i> New', array('controller' => 'territories', 'action' => 'add'), array('class' => 'btn btn-app btn-primary btn-mini', 'escape' => false));
                                ?>
                            </p>
                        </div>
                        <table id="pop_table" class="table table-striped table-bordered table-hover">
                            <thead>
                            <tr>
                                <th width="10%"> S/N </th>
                                <th> Territory </th>
                                <th> State </th>
                                <!--<th> Region </th>-->
                                <th style="text-align: center" width="10%"> Actions </th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php
                            $i = 0;
                            foreach ($territories as $territory):
                                ?>
                                <tr>
                                    <td> <?php echo++$i ?> </td>
                                    <td> <?php echo $territory['Territory']['territoryname']; ?>  </td>
                                    <td> <?php echo $territory['State']['statename']; ?>  </td>
                                    <td style="text-align: center">
                                        <?php
                                        echo $this->Html->link(
                                            '<i class="icon-pencil bigger-130"></i>',
                                            array('controller' => 'territories', 'action' => 'edit', $territory['Territory']['id']),
                                            array('class' => 'green', 'escape' => false,
                                                "data-rel" => "tooltip", "data-placement" => "top", "data-original-title" => 'Edit'));
                                        ?> |
                                        <?php
                                        echo $this->Html->link(
                                            '<i class="icon-trash bigger-130"></i>',
                                            array('controller' => 'territories', 'action' => 'delete', $territory['Territory']['id']),
                                            array('class' => 'red', 'escape' => false,
                                                "data-rel" => "tooltip", "data-placement" => "top", "data-original-title" => 'Delete'), true);
                                        ?>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                            <?php unset($territories); ?>
                            </tbody>
                        </table>

                        <div class="row-fluid">
                            <br />
                            <br />
                            <br />
                            <br />
                            <br />
                            <p class="pull-right">
                                <?php
                                echo $this->Html->link('<i class="icon-chevron-right"></i> Next', array('controller' => 'lgas', 'action' => 'index'), array('class' => 'btn btn-success btn-large','escape' => false));
                                ?>
                            </p>
                        </div>
                        <!--PAGE CONTENT ENDS-->
                    </div><!--/.span-->

                </div>

                <!--End Main Tab-->
                <!--PAGE CONTENT ENDS-->
            </div><!--/.span-->
        </div><!--/.row-fluid-->
    </div><!--/.page-content-->

</div><!--/.main-content-->