<?php
/**
 * Created by PhpStorm.
 * User: RotelandO
 * Date: 10/29/14
 * Time: 6:55 AM
 */

?>

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
                <h3 class="header smaller lighter green">Setup Type</h3>

                <!--Location setup wizard-->
                <?php echo $this->element('_location_setup_progress', array('active' => '')); ?>
                <!--End of Location setup wizard-->

                <!--Start Main Tab-->
                <div class="span12" style="margin-left: 0px;">

                    <div class="span3">
                        <!--<h3 class="header smaller lighter green">Manage Regions</h3>-->
                        <div style="height: 10px;"></div>

                        <div class="widget-box">
                            <div class="widget-header">
                                <h4>Bulk upload</h4>
                            </div>

                            <div class="widget-body" style="padding: 15px;">

                                <?php echo $this->Form->create('Country', array('method' => 'POST', 'enctype' => "multipart/form-data", 'type' => 'file', 'controller' => 'countries', 'action' => 'bulkupload'));
                                ?>
                                <br />


                                <?php
                                echo $this->Form->input('id', array('type' => 'hidden'));
                                ?>

                                <label> Select Country</label>
                                <?php
                                echo $this->Form->select('country_id', $countrylist, array('label' => 'My Country', 'required' => true, 'placeholder' => 'Enter State', 'class' => 'span10 left-stripe', 'type' => 'text'));
                                ?>
                                <br/>

                                <label for="filename">Select CSV file to upload</label>
                                <?php echo $this->Form->file('file', array('required' => true)); ?>

                                <div class="clearfix"></div>
                                <br />

                                <div class="control-group">
                                    <div class="controls">
                                        <label class="checkbox">
                                            <input type="checkbox" name="data[Country][hasheader]" checked="true" value="on">
                                            Has header row</label>
                                    </div>
                                </div>

                                <div class="control-group">
                                    <div class="controls">
                                        <label class="checkbox">
                                            <input type="checkbox" name="data[Country][removeall]" value="on">
                                            Replace old location data</label>
                                    </div>
                                </div>

                                <div class="clearfix"></div>
                                <br />

                                <button type="submit" class="btn btn-success">Preview</button>


                                <?php echo $this->Form->end() ?>
                            </div>
                        </div>
                    </div>
                    <div class="span9">
                        <!--PAGE CONTENT BEGINS-->
                        <div class="row-fluid">
                            <h3 class="span12 header smaller lighter green">Preview Location Data
                                <?php
                                if(isset($locationdata)):
                                    echo $this->Html->link('<i class="icon-cloud-upload"></i> Its fine. Upload now!', array('controller' => 'countries', 'action' => 'upload'), array('class' => 'btn btn-mini btn-success pull-right', 'escape' => false));
                                endif;
                                ?>
                            </h3>
                        </div>
                        <table id="preview_bulkupload" class="table table-striped table-bordered table-hover">
                            <thead>
                            <tr>
                                <th> S/N </th>
                                <th> Region </th>
                                <th> Subregion </th>
                                <th> State </th>
                                <th> Territory </th>
                                <th> LGA </th>
                                <th> POP </th>
                                <!--<th width="10%" style="text-align: center"> Actions </th>-->
                            </tr>
                            </thead>
                            <tbody>
                                <?php
                                    $row = 0;
                                    if(isset($locationdata)):
                                        foreach ($locationdata as $data) { ?>
                                            <tr>
                                            <td><?php echo ++$row; ?></td>
                                            <td><?php echo $data[0]; ?></td>
                                            <td><?php echo $data[1]; ?></td>
                                            <td><?php echo $data[2]; ?></td>
                                            <td><?php echo $data[3]; ?></td>
                                            <td><?php echo $data[4]; ?></td>
                                            <td><?php echo $data[5]; ?></td>
                                            </tr>
                                <?php
                                        }
                                    endif;
                                ?>

                            </tbody>
                        </table>

                        <div class="row-fluid">
                            <br />
                            <br />
                            <br />
                            <br />
                            <br />
                            <p class="pull-right">

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

<script>
    $(document).ready(function(){

        alert('am in');
    });
</script>
