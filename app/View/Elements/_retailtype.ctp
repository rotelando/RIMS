
<div class="span4">
    <div style="height: 10px;"></div>

    <div class="widget-box">
        <div class="widget-header">
            <h4><?php if (!isset($data['Retailtype']['id'])) echo "Add"; else echo "Edit"; ?> Retail Type </h4>
        </div>

        <div class="widget-body" style="padding: 15px;">

            <?php
            echo $this->Form->create('Retailtype', array('method' => 'POST', 'controller' => 'retailtypes', 'action' => 'add'));
            ?>
            <br />

            <?php
            echo $this->Form->input('id', array('type' => 'hidden'));
            ?>

            <?php
            echo $this->Form->input('retailtypename', array('label' => 'Retail Type', 'required' => true, 'placeholder' => 'Retail Type Name', 'class' => 'span10 left-stripe', 'type' => 'text'));
            ?>

            <?php
            echo $this->Form->input('retailtypedescription', array('label' => 'Description', 'required' => true, 'placeholder' => 'Description', 'class' => 'span10 left-stripe', 'type' => 'text'));
            ?>

            <hr/>
            <?php if (!isset($data['Retailtype']['id'])): ?>
                <button type="submit" class="btn btn-success">Add Retail Type</button>
            <?php else: ?>
                <button type="submit" class="btn btn-info">Update Retail Type</button>
            <?php endif; ?>


            <?php echo $this->Form->end() ?>
        </div>
    </div>
</div>
<div class="span8">
    <!--PAGE CONTENT BEGINS-->
    <div class="row-fluid">
        <h3 class="span12 header smaller lighter green">List of Retail Types</h3>

    </div>
    <table id="sample-table-1" class="table table-striped table-bordered table-hover">
        <thead>
        <tr>
            <th> S/N </th>
            <th> Retail Type Name</th>
            <th> Description </th>
            <th width="15%">  Actions </th>
        </tr>
        </thead>
        <tbody>
        <?php
        $i = 0;
        foreach ($retailtypes as $retailtype):
            ?>
            <tr>
                <td width="5%"> <?php echo++$i ?> </td>
                <td> <?php echo $retailtype['Retailtype']['retailtypename']; ?>  </td>
                <td> <?php echo $retailtype['Retailtype']['retailtypedescription']; ?>  </td>
                <td style="text-align: center">
                    <div class="hidden-phone visible-desktop action-buttons center">
                        <?php
                        echo $this->Html->link(
                            '<i class="icon-pencil bigger-130"></i>',
                            array('controller' => 'retailtypes', 'action' => 'edit', $retailtype['Retailtype']['id']),
                            array('class' => 'green', 'escape' => false,
                                "data-rel" => "tooltip", "data-placement" => "top", "data-original-title" => 'Edit'));
                        ?> |
                        <?php
                        echo $this->Html->link(
                            '<i class="icon-trash bigger-130"></i>',
                            array('controller' => 'retailtypes', 'action' => 'delete', $retailtype['Retailtype']['id']),
                            array('class' => 'red', 'escape' => false,
                                "data-rel" => "tooltip", "data-placement" => "top", "data-original-title" => 'Delete'), true);
                        ?>
                    </div>
                </td>
            </tr>
        <?php endforeach; ?>
        <?php unset($retailtypes); ?>
        </tbody>
    </table>
    <!--PAGE CONTENT ENDS-->
</div><!--/.span-->