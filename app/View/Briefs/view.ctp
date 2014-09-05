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

        <?php // echo $this->element('filter_bar'); ?>
        
        <div class="row-fluid">

            <div class="span12">

                
                <!--PAGE CONTENT BEGINS-->
                <!-- Start Form -->


                <div class="span8">
                    <div class="row-fluid">
                        <h3 class="span11 header smaller lighter green">Details</h3>
                    </div>
                    <div class="span8">
                        <h4 class="blue">
                            <span class="middle"><?php echo $brief['Brief']['title']; ?></span>

                            <span class="label label-purple arrowed-in-right">
                                <i class="icon-circle smaller-80"></i>
                                recent
                            </span>
                        </h4>

                        <div class="profile-user-info">
                            <div class="profile-info-row">
                                <div class="profile-info-name"> Title </div>

                                <div class="profile-info-value">
                                    <span><?php echo $brief['Brief']['title']; ?></span>
                                </div>
                            </div>

                            <div class="profile-info-row">
                                <div class="profile-info-name"> Description </div>

                                <div class="profile-info-value">
                                    <i class="icon-info-sign light-orange bigger-110"></i>
                                    <span><?php echo $brief['Brief']['description']; ?></span>
                                </div>
                            </div>

                            <div class="profile-info-row">
                                <div class="profile-info-name"> File Name </div>

                                <div class="profile-info-value">
                                    <span><?php echo $brief['Brief']['brief_file_name']; ?></span>
                                </div>
                            </div>

                            <div class="profile-info-row">
                                <div class="profile-info-name"> File Type </div>

                                <div class="profile-info-value">
                                    <span><?php echo $brief['Brief']['brief_content_type']; ?></span>
                                </div>
                            </div>

                            <div class="profile-info-row">
                                <div class="profile-info-name"> File Size </div>

                                <div class="profile-info-value">
                                    <span><?php
                                    $kbsize = intval($brief['Brief']['brief_file_size']) / 1024;
                                    echo round($kbsize, 2);
                                    ?> KB</span>
                                </div>
                            </div>

                            <div class="profile-info-row">
                                <div class="profile-info-name"> Date Created </div>

                                <div class="profile-info-value">
                                    <span><?php echo $brief['Brief']['createdat']; ?></span>
                                </div>
                            </div>
                        </div>

                        <div class="hr hr-8 dotted"></div>
                    </div>
                    <!--<a data-toggle="modal" href="#signin">Sign In</a>-->

                    <?php
                    echo $this->Html->link('<i class="icon-upload-alt"></i>', 
                            array('#' => 'newversion'), 
                            array('data-toggle' => 'modal', 
                                'class' => 'btn btn-small btn-success', 
                                'escape' => false,
                                'data-rel'=> 'tooltip',
                                'data-placement'=> 'bottom', 
                                'data-original-title' => 'Upload new version'
                                ));
                    ?>

                    <?php
                    // echo $this->Html->link('<i class="icon-upload-alt"></i>', 
//                        array('controller'=>'briefs', 'action'=>'newversion', $brief['Brief']['id'] ), 
//                        array('class'=>'btn btn-small btn-success', 'escape'=>false)); 
                    ?> |

                    <?php
                    echo $this->Html->link('<i class="icon-download-alt"></i>', 
                            array('controller' => 'briefs', 'action' => 'download', $brief['Brief']['id']), 
                            array(
                                'class' => 'btn btn-small btn-primary', 
                                'escape' => false,
                                'data-rel'=> 'tooltip',
                                'data-placement'=> 'bottom', 
                                'data-original-title' => 'Download'
                                ));
                    ?> |

                    <?php
                    echo $this->Html->link('<i class="icon-trash"></i>', 
                            array('controller' => 'briefs', 'action' => 'delete', $brief['Brief']['id']), 
                            array(
                                'class' => 'btn btn-small btn-danger', 
                                'escape' => false,
                                'data-rel'=> 'tooltip',
                                'data-placement'=> 'bottom', 
                                'data-original-title' => 'Delete'
                                ));
                    ?>
                    <!--PAGE CONTENT ENDS-->
                </div>

                <div class="span4">
                    <div class="widget-box">
                        <div class="widget-header">
                            <h4>Briefs Versions</h4>
                        </div>

                        <div class="widget-body" style="padding: 0px 5px 0px 10px;">
                            <div class="widget-main">
                                <dl id="dt-list-1">
                                    <?php foreach ($versions as $version):
                                        ?>
                                        <dt><i class="icon-share-alt green"></i> <?php echo $brief['Brief']['title']; ?></dt>
                                        <dd><?php echo $this->TextFormater->fixTextWidth($brief['Brief']['description'], 90); ?></dd>
                                        <dd><i><?php echo $version['Brief']['createdat']; ?></i> 
                                            <?php
                                            echo $this->Html->link('<i class="icon-download-alt"></i>', 
                                                    array('controller' => 'briefs', 'action' => 'download', $version['Brief']['id']), 
                                                    array(
                                                        'class' => 'btn btn-minier btn-primary pull-right', 
                                                        'escape' => false,
                                                        'data-rel'=> 'tooltip',
                                                        'data-placement'=> 'bottom', 
                                                        'data-original-title' => 'Download'
                                                        ));
                                            ?>
                                        </dd>
                                        <hr style="margin: 5px 0px" />
                                    <?php endforeach; ?>
                                    <dt>
                                    <?php echo $this->Html->link('View All', array(
                                        'controller'=>'briefs',
                                        'action'=>'versions',
                                        $brief['Brief']['id']
                                        
                                    ), array(
                                        'class'=>'btn btn-mini',
                                        'style'=>'margin-top: 15px; text-align: center;'
                                    )); ?>
                                </dl>
                                </dl>
                            </div>
                        </div>
                    </div><!--/.span-->
                </div>
                <!--PAGE CONTENT BEGINS-->

            </div>
            <!--PAGE CONTENT ENDS-->
        </div><!--/.row-fluid-->
    </div><!--/.page-content-->
</div><!--/.main-content-->


<div id="newversion" class="modal hide fade" style="width: 350px; margin-left: -125px;" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
        <h3 id="myModalLabel">Upload New Version <h5 class="text-warning">[ <?php echo $brief['Brief']['title']; ?> ]</h5></h3>
    </div>
    <!-- Start Modal Body -->
    <div class="modal-body">
        <!-- Start Form -->
        <?php echo $this->Form->create('Brief', array('method' => 'POST', 'type' => 'file', 'controller' => 'briefs', 'action' => 'newversion', 'class' => 'form-horizontal'));
        ?>

        <?php echo $this->Form->input('id', array('type' => 'hidden'));
        ?>

        <?php echo $this->Form->input('Brief.title', array('require' => true, 'label' => 'Brief Name', 'placeholder' => 'Name', 'class' => 'left-stripe', 'type' => 'text'));
        ?>

        <br />
        <?php echo $this->Form->input('Brief.description', array('require' => true, 'label' => 'Brief Description', 'placeholder' => 'Description', 'class' => '', 'type' => 'text'));
        ?>
        <!--<input type="text" name="lastname" placeholder="Lastname" class="span5">-->
        <br />
        <!--<label for="BriefFilename">File</label>-->
        <?php echo $this->Form->file('Brief.brief', array('require' => true)) ?>
        <!--<input type="file" name="data[Brief][filename]" id="BriefFilename" />-->
        <br />
        <br />
        <button type="submit" class="btn btn-success">Upload Brief</button>

        <?php echo $this->Form->end(); ?>
        <!-- End Form -->
    </div>   
    <!-- End Modal Body -->
</div>

<?php echo $this->Html->script('/assets/bootstrap/bootstrap-modal'); ?>