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

        <div class="row-fluid">
            <div class="span12">
                <!--PAGE CONTENT BEGINS-->
                <!-- Start Form -->


                <div class="span4">
                    <div class="widget-box">
                        <div class="widget-header">
                            <h4>Upload New Brief</h4>
                        </div>

                        <div class="widget-body" style="padding: 15px;">
                            <div class="widget-main">
                                <?php echo $this->Form->create('Brief', array('method' => 'POST', 'type' => 'file', 'controller' => 'briefs', 'action' => 'upload', 'class' => 'form-horizontal'));
                                ?>

                                <?php // echo $this->Form->input('id', array('type' => 'hidden'));
                                ?>

                                <?php echo $this->Form->input('Brief.title', array('require'=>true, 'label' => 'Brief Name', 'placeholder' => 'Name', 'class' => 'left-stripe', 'type' => 'text'));
                                ?>

                                <br />
                                <?php echo $this->Form->input('Brief.description', array('require'=>true, 'label' => 'Brief Description', 'placeholder' => 'Description', 'class' => '', 'type' => 'text'));
                                ?>
                                <!--<input type="text" name="lastname" placeholder="Lastname" class="span5">-->
                                <br />
                                <!--<label for="BriefFilename">File</label>-->
                                <?php echo $this->Form->file('Brief.brief', array('require'=>true)); ?>
                                <!--<input type="file" name="data[Brief][filename]" id="BriefFilename" />-->
                                <br />
                                <br />
                                <button type="submit" class="btn btn-success">Upload Brief</button>

                                <?php echo $this->Form->end(); ?>

                            </div>
                        </div>
                    </div>
                </div>

                <div class="span8">
                    <!--PAGE CONTENT BEGINS-->
                    <div class="row-fluid">
                        <h3 class="header smaller lighter green">Brief List</h3>
                    </div>
                    <table id="sample-table-1" class="table table-striped table-bordered table-hover">
                        <thead>
                            <tr>
                                <th class="center">#</th>
                                <th class="hidden-480">Name</th>
                                <th class="hidden-480">Description</th>
                                <th class="hidden-480">No of Views</th>
                                <th width="13%" class="hidden-480">Date Created</th>
                                <th width="35%">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $i = 0;
                            foreach ($briefs as $brief):
                                ?>

                                <tr>
                                    <td class="center"> <?php echo++$i ?> </td>
                                    <td> <?php echo $brief['Brief']['title']; ?>  </td>
                                    <td> <?php echo $brief['Brief']['description']; ?>  </td>
                                    <td> <?php echo rand(0,5); ?>  </td>
                                    <td> <?php echo $brief['Brief']['createdat']; ?>  </td>
                                    <td class="">
                                        
                                        <div class="hidden-phone visible-desktop action-buttons">
                                            <!--<a href="<?php // echo $path . $brief['Brief']['brief_file_name']  ?>" class="btn btn-minier btn-primary"><i class="icon-download-alt"></i></a>-->
                                            <?php
                                            echo $this->Html->link('<i class="icon-download-alt"></i> Download', array('controller' => 'briefs', 'action' => 'download', $brief['Brief']['id']), array('class' => 'green', 'escape' => false));
                                            ?> |

                                            <?php
                                            echo $this->Html->link('<i class="icon-zoom-in bigger-130"></i> View', array('controller' => 'briefs', 'action' => 'view', $brief['Brief']['id']), array('class' => 'blue', 'escape' => false));
                                            ?> | 

                                            <?php
                                            echo $this->Html->link(
                                                    '<i class="icon-trash bigger-130"></i> Delete', array('controller' => 'briefs', 'action' => 'delete', $brief['Brief']['id']), array('class' => 'red', 'escape' => false), true);
                                            ?>
                                        </div>
                                    </td>
                                </tr>
                                        <?php endforeach; ?>
                                        <?php unset($briefs); ?>
                        </tbody>
                    </table>
                    <!--PAGE CONTENT ENDS-->
                </div><!--/.span-->
            </div>
            <!--PAGE CONTENT ENDS-->
        </div><!--/.row-fluid-->
    </div><!--/.page-content-->
</div><!--/.main-content-->