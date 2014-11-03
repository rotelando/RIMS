<div class="main-content">


    <?php // echo $this->element('breadcrumb'); ?>
    <div class="page-content">
        <div class="page-header position-relative">
            <h1>
                Setup
                <small>
                    <i class="icon-double-angle-right"></i>
                    Brands, Visibility Elements, Products & Locations
                </small>
            </h1>
        </div>

        <?php echo $this->Session->flash(); ?>
        <?php echo $this->Session->flash('auth'); ?>


        <?php echo $this->element('page_tabs'); ?>

        
        <div class="row-fluid">
            <div class="span12">
                <!--PAGE CONTENT BEGINS-->

                <div class="span4">
                    <!--<h3 class="header smaller lighter green">Add New Brand</h3>-->
                    <div style="height: 10px;"></div>

                    <div class="widget-box" style="padding: 15px;">
                        <div class="widget-header">
                            <h4><?php if (!isset($data['merchandize']['id'])) echo "Add New"; else echo "Edit"; ?> Merchandize</h4>
                        </div>

                        <div class="widget-body" style="padding: 15px;">

                            <?php echo $this->Form->create('Merchandize', array('method' => 'POST', 'controller' => 'merchandize', 'action' => 'add'));
                            ?>
                            <br />

                            <?php
                            echo $this->Form->input('id', array('type' => 'hidden'));
                            ?>

                            <?php
                            echo $this->Form->input('name', array('label' => 'Name', 'required' => true, 'placeholder' => 'Merchandize Name', 'class' => 'span10 left-stripe', 'type' => 'text'));
                            ?>
                            
                            <?php
                            echo $this->Form->input('weight', array('label' => 'Weight', 'required' => true, 'placeholder' => 'Merchandize Weight', 'class' => 'span10 left-stripe', 'type' => 'text'));
                            ?>

                            <hr/>
                            <?php if (!isset($data['Merchandize']['id'])): ?>
                                <button type="submit" class="btn btn-success">Add Merchandize</button>
                            <?php else: ?>
                                <button type="submit" class="btn btn-info">Update Merchandize</button>
                            <?php endif; ?>


                            <?php echo $this->Form->end() ?>
                        </div>
                    </div>
                </div>
                <div class="span8">
                    <!--PAGE CONTENT BEGINS-->
                    <div class="row-fluid">
                        <h3 class="span12 header smaller lighter green">List of Merchandize</h3>
                        <p class="pull-right">
                            <?php
//                            echo $this->Html->link('<i class="icon-tag bigger-160"></i> New', array('controller' => 'brands', 'action' => 'add'), array('class' => 'btn btn-app btn-primary btn-mini', 'escape' => false));
                            ?>
                        </p>
                    </div>
                    <table id="sample-table-1" class="table table-striped table-bordered table-hover">
                        <thead>
                            <tr>
                                <th> S/N </th>
                                <th> Upload ID </th>
                                <th> Merchandize Name </th>
                                <th> Weight</th>
                                <th width="15%"> Actions </th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $i = 0;
                            foreach ($merchandize as $merch):
                                ?>
                                <tr>
                                    <td width="5%"> <?php echo++$i ?> </td>
                                    <td width="5%"> <?php echo $merch['Merchandize']['id']; ?> </td>
                                    <td> <?php echo $merch['Merchandize']['name']; ?>  </td>
                                    <td> <?php echo $merch['Merchandize']['weight']; ?>  </td>
                                    <td>
                                        <div class="hidden-phone visible-desktop action-buttons center">
                                            <?php
                                            echo $this->Html->link(
                                                    '<i class="icon-pencil bigger-130"></i>', 
                                                    array('controller' => 'merchandize', 'action' => 'edit', $merch['Merchandize']['id']),
                                                    array('class' => 'green', 'escape' => false,
                                                    "data-rel" => "tooltip", "data-placement" => "top", "data-original-title" => 'Edit'));
                                            ?> |  
                                            <?php
                                            echo $this->Html->link(
                                                    '<i class="icon-trash bigger-130"></i>', 
                                                    array('controller' => 'merchandize', 'action' => 'delete', $merch['Merchandize']['id']),
                                                    array('class' => 'red', 'escape' => false,
                                                    "data-rel" => "tooltip", "data-placement" => "top", "data-original-title" => 'Delete'), true);
                                            ?>
                                        </div>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                            <?php unset($merchandize); ?>
                        </tbody>
                    </table>
                    <!--PAGE CONTENT ENDS-->
                </div><!--/.span-->
                <!--PAGE CONTENT ENDS-->
            </div><!--/.span-->
        </div><!--/.row-fluid-->
    </div><!--/.page-content-->

    <?php // echo $this->element('settings'); ?>

</div><!--/.main-content-->