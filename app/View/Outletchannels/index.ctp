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
                <div style="height: 10px;"></div>
                <div class="tabbable tabs-top">
                        <ul class="nav nav-tabs" id="myTab3">
                            <li>
                                <a data-toggle="tab" href="#types">
                                    <i class="grey icon-building bigger-110"></i>
                                    Advocacy Class
                                </a>
                            </li>

                            <li class="active">
                                <a data-toggle="tab" href="#channels">
                                    <i class="grey icon-building bigger-110"></i>
                                    Channels
                                </a>
                            </li>
                        </ul>
                    
                    <div class="tab-content">
                            
                            <!--============Outlet Types==============-->
                            <div id="types" class="tab-pane">
                                <div class="span4">
                                    <div style="height: 10px;"></div>

                                    <div class="widget-box">
                                        <div class="widget-header">
                                            <h4><?php if (!isset($data['Outlettype']['id'])) echo "Add"; else echo "Edit"; ?> Channel </h4>
                                        </div>

                                        <div class="widget-body" style="padding: 15px;">

                                            <?php 
                                                echo $this->Form->create('Outlettype', array('method' => 'POST', 'controller' => 'outlettypes', 'action' => 'add'));
                                            ?>
                                            <br />

                                            <?php
                                            echo $this->Form->input('id', array('type' => 'hidden'));
                                            ?>

                                            <?php
                                            echo $this->Form->input('outlettypename', array('label' => 'Advocacy Class Name', 'required' => true, 'placeholder' => 'Advocacy Class Name', 'class' => 'span10 left-stripe', 'type' => 'text'));
                                            ?>
                                            
                                            <?php
                                            echo $this->Form->input('outlettypedescription', array('label' => 'Description', 'required' => true, 'placeholder' => 'Description', 'class' => 'span10 left-stripe', 'type' => 'text'));
                                            ?>

                                            <hr/>
                                            <?php if (!isset($data['Outlettype']['id'])): ?>
                                                <button type="submit" class="btn btn-success">Add Advocacy Class</button>
                                            <?php else: ?>
                                                <button type="submit" class="btn btn-info">Update Advocacy Class</button>
                                            <?php endif; ?>


                                            <?php echo $this->Form->end() ?>
                                        </div>
                                    </div>
                                </div>
                                <div class="span8">
                                    <!--PAGE CONTENT BEGINS-->
                                    <div class="row-fluid">
                                        <h3 class="span12 header smaller lighter green">List of Advocacy Classifications</h3>
                                        
                                    </div>
                                    <table id="sample-table-1" class="table table-striped table-bordered table-hover">
                                        <thead>
                                            <tr>
                                                <th> S/N </th>
                                                <th> Advocacy class Name</th>
                                                <th> Description </th>
                                                <th width="15%">  Actions </th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            $i = 0;
                                            foreach ($outlettypes as $outlettype):
                                                ?>
                                                <tr>
                                                    <td width="5%"> <?php echo++$i ?> </td>
                                                    <td> <?php echo $outlettype['Outlettype']['outlettypename']; ?>  </td>
                                                    <td> <?php echo $outlettype['Outlettype']['outlettypedescription']; ?>  </td>
                                                    <td style="text-align: center">
                                                        <div class="hidden-phone visible-desktop action-buttons center">
                                                            <?php
                                                            echo $this->Html->link(
                                                                    '<i class="icon-pencil bigger-130"></i>', 
                                                                    array('controller' => 'outlettypes', 'action' => 'edit', $outlettype['Outlettype']['id']), 
                                                                    array('class' => 'green', 'escape' => false,
                                                                    "data-rel" => "tooltip", "data-placement" => "top", "data-original-title" => 'Edit'));
                                                            ?> |  
                                                            <?php
                                                            echo $this->Html->link(
                                                                    '<i class="icon-trash bigger-130"></i>', 
                                                                    array('controller' => 'outlettypes', 'action' => 'delete', $outlettype['Outlettype']['id']), 
                                                                    array('class' => 'red', 'escape' => false,
                                                                    "data-rel" => "tooltip", "data-placement" => "top", "data-original-title" => 'Delete'), true);
                                                            ?>
                                                        </div>
                                                    </td>
                                                </tr>
                                            <?php endforeach; ?>
                                            <?php unset($outlettypes); ?>
                                        </tbody>
                                    </table>
                                    <!--PAGE CONTENT ENDS-->
                                </div><!--/.span-->
                        </div>

                            <!--============End Outlet Types==============-->
                            
                            <!--============Outlet Channel==============-->
                            <div id="channels" class="tab-pane in active">
                                <div class="span4">
                                    <div style="height: 10px;"></div>

                                    <div class="widget-box">
                                        <div class="widget-header">
                                            <h4><?php if (!isset($data['Outletchannel']['id'])) echo "Add"; else echo "Edit"; ?> Channel</h4>
                                        </div>

                                        <div class="widget-body" style="padding: 15px;">

                                            <?php echo $this->Form->create('Outletchannel', array('method' => 'POST', 'controller' => 'Outletchannels', 'action' => 'add'));
                                            ?>
                                            <br />

                                            <?php
                                            echo $this->Form->input('id', array('type' => 'hidden'));
                                            ?>

                                            <?php
                                            echo $this->Form->input('outletchannelname', array('label' => 'Channel Name', 'required' => true, 'placeholder' => 'Channel Name', 'class' => 'span10 left-stripe', 'type' => 'text'));
                                            ?>
                                            
                                            <?php
                                            echo $this->Form->input('outletchanneldescription', array('label' => 'Description', 'required' => true, 'placeholder' => 'Description', 'class' => 'span10 left-stripe', 'type' => 'text'));
                                            ?>

                                            <hr/>
                                            <?php if (!isset($data['Outletchannel']['id'])): ?>
                                                <button type="submit" class="btn btn-success">Add Channel</button>
                                            <?php else: ?>
                                                <button type="submit" class="btn btn-info">Update Channel</button>
                                            <?php endif; ?>


                                            <?php echo $this->Form->end() ?>
                                        </div>
                                    </div>
                                </div>
                                <div class="span8">
                                    <!--PAGE CONTENT BEGINS-->
                                    <div class="row-fluid">
                                        <h3 class="span12 header smaller lighter green">List of Outlet Channels</h3>
                                    </div>
                                    <table id="sample-table-1" class="table table-striped table-bordered table-hover">
                                        <thead>
                                            <tr>
                                                <th> S/N </th>
                                                <th> Channel Name</th>
                                                <th> Channel Description</th>
                                                <th width="15%">  Actions </th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            $i = 0;
                                            foreach ($outletchannels as $outletchannel):
                                                ?>
                                                <tr>
                                                    <td width="5%"> <?php echo++$i ?> </td>
                                                    <td> <?php echo $outletchannel['Outletchannel']['outletchannelname']; ?>  </td>
                                                    <td> <?php echo $outletchannel['Outletchannel']['outletchanneldescription']; ?>  </td>
                                                    <td style="text-align: center">
                                                        <div class="hidden-phone visible-desktop action-buttons center">
                                                            <?php
                                                            echo $this->Html->link(
                                                                    '<i class="icon-pencil bigger-130"></i>', 
                                                                    array('controller' => 'outletchannels', 'action' => 'edit', $outletchannel['Outletchannel']['id']), 
                                                                    array('class' => 'green', 'escape' => false,
                                                                    "data-rel" => "tooltip", "data-placement" => "top", "data-original-title" => 'Edit'));
                                                            ?> |  
                                                            <?php
                                                            echo $this->Html->link(
                                                                    '<i class="icon-trash bigger-130"></i>', 
                                                                    array('controller' => 'outletchannels', 'action' => 'delete', $outletchannel['Outletchannel']['id']), 
                                                                    array('class' => 'red', 'escape' => false,
                                                                    "data-rel" => "tooltip", "data-placement" => "top", "data-original-title" => 'Delete'), true);
                                                            ?>
                                                        </div>
                                                    </td>
                                                </tr>
                                            <?php endforeach; ?>
                                            <?php unset($outletchannels); ?>
                                        </tbody>
                                    </table>
                                    <!--PAGE CONTENT ENDS-->
                                </div><!--/.span-->
                        </div>                            
                            <!--============Outlet Channels==============-->

                </div>
                <!--PAGE CONTENT ENDS-->
            </div><!--/.span-->
        </div><!--/.row-fluid-->
    </div><!--/.page-content-->

    <?php // echo $this->element('settings'); ?>

</div><!--/.main-content-->
</div><!--/.main-content-->

