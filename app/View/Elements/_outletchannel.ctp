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
</div>