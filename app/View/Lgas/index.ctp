<div class="main-content">


    <?php // echo $this->element('breadcrumb'); ?>
    <div class="page-content">
        <div class="page-header position-relative">
            <h1>
                Setup
                <small>
                    <i class="icon-double-angle-right"></i>
                    Brands, Outlet Classificaitons, Merchandize, Products & Locations
                </small>
            </h1>
        </div>

        <?php echo $this->Session->flash(); ?>
        <?php echo $this->Session->flash('auth'); ?>


        <?php echo $this->element('page_tabs'); ?>

        <div class="row-fluid">

            <div class="span12">
                <h3 class="header smaller lighter green">Manage Local Government Areas</h3>

                <!--Lga setup wizard-->
                <?php echo $this->element('_location_setup_progress', array('active' => 'lga')); ?>
                <!--End of Lga setup wizard-->

                <!--Start Main Tab-->
                <div class="span12" style="margin-left: 0px;">

                    <div class="span4">
                        <!--<h3 class="header smaller lighter green">Add New Brand</h3>-->
                        <div style="height: 10px;"></div>

                        <div class="widget-box">
                            <div class="widget-header">
                                <h4><?php if (!isset($data['Lga']['id'])) echo "Add"; else echo "Edit"; ?> LGA</h4>
                            </div>

                            <div class="widget-body" style="padding: 15px;">

                                <?php echo $this->Form->create('Lga', array('method' => 'POST', 'controller' => 'lgas', 'action' => 'add'));
                                ?>
                                <br />

                                <?php
                                echo $this->Form->input('id', array('type' => 'hidden'));
                                ?>

                                <?php
                                echo $this->Form->input('lganame', array('label' => 'Local Government Area Name', 'required' => true, 'placeholder' => 'Enter name of LGA', 'class' => 'span10 left-stripe', 'type' => 'text'));
                                ?>

                                <label> Territory
                                    <?php
                                    echo $this->Html->link(
                                        '<i class="icon-plus"></i> Add', array('controller' => 'territories', 'action' => 'index'), array('class' => 'btn btn-mini orange', 'escape' => false));
                                    ?>
                                </label>
                                <?php
                                echo $this->Form->select('territory_id', $territorylist, array('label' => 'Territory', 'required' => false, 'placeholder' => 'Enter LGA', 'class' => 'span10 left-stripe', 'type' => 'text'));
                                ?>

                                <hr/>
                                <?php if (!isset($data['Lga']['id'])): ?>
                                    <button type="submit" class="btn btn-success">Add LGA</button>
                                <?php else: ?>
                                    <button type="submit" class="btn btn-info">Update LGA</button>
                                <?php endif; ?>


                                <?php echo $this->Form->end() ?>
                            </div>
                        </div>
                    </div>
                    <div class="span8">
                        <!--PAGE CONTENT BEGINS-->
                        <div class="row-fluid">
                            <h3 class="span12 header smaller lighter green">List of Local Government Areas</h3>
                            <p class="pull-right">
                                <?php
                                //                            echo $this->Html->link('<i class="icon-tag bigger-160"></i> New', array('controller' => 'lgas', 'action' => 'add'), array('class' => 'btn btn-app btn-primary btn-mini', 'escape' => false));
                                ?>
                            </p>
                        </div>
                        <table id="pop_table" class="table table-striped table-bordered table-hover">
                            <thead>
                            <tr>
                                <th width="10%"> S/N </th>
                                <th> Local Government Areas </th>
                                <th> Territory </th>
                                <!--<th> Region </th>-->
                                <th style="text-align: center" width="10%"> Actions </th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php
                            $i = 0;
                            foreach ($lgas as $lga):
                                ?>
                                <tr>
                                    <td> <?php echo++$i ?> </td>
                                    <td> <?php echo $lga['Lga']['lganame']; ?>  </td>
                                    <td> <?php echo $lga['Territory']['territoryname']; ?>  </td>
                                    <td style="text-align: center">
                                        <?php
                                        echo $this->Html->link(
                                            '<i class="icon-pencil bigger-130"></i>',
                                            array('controller' => 'lgas', 'action' => 'edit', $lga['Lga']['id']),
                                            array('class' => 'green', 'escape' => false,
                                                "data-rel" => "tooltip", "data-placement" => "top", "data-original-title" => 'Edit'));
                                        ?> |
                                        <?php
                                        echo $this->Html->link(
                                            '<i class="icon-trash bigger-130"></i>',
                                            array('controller' => 'lgas', 'action' => 'delete', $lga['Lga']['id']),
                                            array('class' => 'red', 'escape' => false,
                                                "data-rel" => "tooltip", "data-placement" => "top", "data-original-title" => 'Delete'), true);
                                        ?>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                            <?php unset($lgas); ?>
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
                                echo $this->Html->link('<i class="icon-chevron-right"></i> Next', array('controller' => 'locations', 'action' => 'index'), array('class' => 'btn btn-success btn-large','escape' => false));
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