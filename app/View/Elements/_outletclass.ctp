
    <div class="span4">
        <div style="height: 10px;"></div>

        <div class="widget-box">
            <div class="widget-header">
                <h4><?php if (!isset($data['Outletclass']['id'])) echo "Add"; else echo "Edit"; ?> Channel </h4>
            </div>

            <div class="widget-body" style="padding: 15px;">

                <?php
                echo $this->Form->create('Outletclass', array('method' => 'POST', 'controller' => 'Outletclass', 'action' => 'add'));
                ?>
                <br />

                <?php
                echo $this->Form->input('id', array('type' => 'hidden'));
                ?>

                <?php
                echo $this->Form->input('outletclassname', array('label' => 'Advocacy Class Name', 'required' => true, 'placeholder' => 'Advocacy Class Name', 'class' => 'span10 left-stripe', 'type' => 'text'));
                ?>

                <?php
                echo $this->Form->input('outletclassdescription', array('label' => 'Description', 'required' => true, 'placeholder' => 'Description', 'class' => 'span10 left-stripe', 'type' => 'text'));
                ?>

                <hr/>
                <?php if (!isset($data['Outletclass']['id'])): ?>
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
            foreach ($outletclasses as $outletclass):
                ?>
                <tr>
                    <td width="5%"> <?php echo++$i ?> </td>
                    <td> <?php echo $outletclass['Outletclass']['outletclassname']; ?>  </td>
                    <td> <?php echo $outletclass['Outletclass']['outletclassdescription']; ?>  </td>
                    <td style="text-align: center">
                        <div class="hidden-phone visible-desktop action-buttons center">
                            <?php
                            echo $this->Html->link(
                                '<i class="icon-pencil bigger-130"></i>',
                                array('controller' => 'outletclasses', 'action' => 'edit', $outletclass['Outletclass']['id']),
                                array('class' => 'green', 'escape' => false,
                                    "data-rel" => "tooltip", "data-placement" => "top", "data-original-title" => 'Edit'));
                            ?> |
                            <?php
                            echo $this->Html->link(
                                '<i class="icon-trash bigger-130"></i>',
                                array('controller' => 'outletclasses', 'action' => 'delete', $outletclass['Outletclass']['id']),
                                array('class' => 'red', 'escape' => false,
                                    "data-rel" => "tooltip", "data-placement" => "top", "data-original-title" => 'Delete'), true);
                            ?>
                        </div>
                    </td>
                </tr>
            <?php endforeach; ?>
            <?php unset($outletclasses); ?>
            </tbody>
        </table>
        <!--PAGE CONTENT ENDS-->
    </div><!--/.span-->