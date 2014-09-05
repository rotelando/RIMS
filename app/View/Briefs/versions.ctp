<div class="main-content">


    <?php // echo $this->element('breadcrumb'); ?>


    <div class="page-content">
        <!--.page-header-->
        <div class="page-header position-relative">

            <h1>
                Briefs Management
                <small>
                    <i class="icon-double-angle-right"></i>
                    creation and views
                </small>
            </h1>

        </div><!--/.page-header-->

        <?php echo $this->Session->flash(); ?>
        <?php echo $this->Session->flash('auth'); ?>

        <!--There is no filter bar in the briefs view-->
        <?php // echo $this->element('filter_bar'); ?>

        <div class="row-fluid">

            <div class="span12">
                <div class="row-fluid">
                    <h3 class="span12 header smaller lighter green">All Versions of <?php echo $brief['Brief']['title']; ?>
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
                        <thead>
                            <tr>
                                <th> S/N </th>
                                <th width="150px"> Name </th>
                                <th> Description</th>
                                <th> File Name </th>
                                <!--<th> Content Type </th>-->
                                <th width="50px"> File Size </th>
                                <th width="80px"> Date Uploaded </th>
                                <th width="180px" style="text-align: center"> Actions </th>
                            </tr>
                        </thead>
                        <tbody>


                            <?php
                            $i = 0;
                            foreach ($versions as $version):
                                ?>
                                <tr>
                                    <td width="5%"> <?php echo++$i; ?> </td>
                                    <td> <?php echo $version['Brief']['title'] . '&nbsp;&nbsp;';  
                                        if($brief['Brief']['id'] == $version['Brief']['id']):
                                            echo '<span class="label label-info">Current</span>';
                                        endif;
                                    ?>  
                                    </td>
                                    <td> <?php echo $version['Brief']['description']; ?> </td>
                                    <td> <?php echo $version['Brief']['brief_file_name']; ?> </td>
                                    <!--<td> <?php // echo $version['Brief']['brief_content_type']; ?> </td>-->
                                    <td> <?php
                                        $kbsize = intval($brief['Brief']['brief_file_size']) / 1024;
                                        echo round($kbsize, 2);
                                            ?> KB 
                                    </td>
                                    <td> <?php echo $version['Brief']['createdat']; ?> </td>
                                    <td style="text-align: center"> 
                                        <?php
                                        echo $this->Html->link('<i class="icon-zoom-in bigger-130"></i> View', array('briefs' => 'outlets', 'action' => 'view', $version['Brief']['id']), array('class' => 'blue', 'escape' => false));
                                        ?> |
                                        <?php
                                        echo $this->Html->link(
                                                '<i class="icon-pencil bigger-130"></i> Edit', array('controller' => 'briefs', 'action' => 'edit', $version['Brief']['id']), array('class' => 'green', 'escape' => false));
                                        ?> |  
                                        <?php
                                        echo $this->Html->link(
                                                '<i class="icon-trash bigger-130"></i> Delete', array('controller' => 'briefs', 'action' => 'delete', $version['Brief']['id']), array('class' => 'red', 'escape' => false), true);
                                        ?>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                            <?php unset($versions); ?>


                        </tbody>
                    </table>
                    <div style="text-align: center;">

                        <h4 class="text-info">Showing page <?php echo $this->Paginator->counter(); ?> </h4>

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


