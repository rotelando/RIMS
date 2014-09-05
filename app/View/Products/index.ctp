<div class="main-content">


    <?php // echo $this->element('breadcrumb'); ?>
    <div class="page-content">
        <div class="page-header position-relative">
            <h1>
                Setup
                <small>
                    <i class="icon-double-angle-right"></i>
                    Products and Categories
                </small>
            </h1>
        </div>

        <?php echo $this->Session->flash(); ?>
        <?php echo $this->Session->flash('auth'); ?>


        <?php echo $this->element('page_tabs'); ?>

        <div class="row-fluid">
            <div class="span12">
                <!--PAGE CONTENT BEGINS-->

                <!--==================================-->
                
                    <div class="tabbable tabs-top">
                        <ul class="nav nav-tabs" id="myTab3">
                            <li>
                                <a data-toggle="tab" href="#categories">
                                    <i class="orange icon-suitcase bigger-110"></i>
                                    Products Categories
                                </a>
                            </li>

                            <li class="active">
                                <a data-toggle="tab" href="#product">
                                    <i class="orange icon-suitcase bigger-110"></i>
                                    Products
                                </a>
                            </li>
                        </ul>

                        <div class="tab-content">

                            <div id="categories" class="tab-pane">
                                <div class="span4">
                                    <!--<h3 class="header smaller lighter green">Add New Brand</h3>-->
                                    <div style="height: 10px;"></div>

                                    <div class="widget-box">
                                        <div class="widget-header">
                                            <h4><?php if (!isset($data['Productcategory']['id'])) echo "Add"; else echo "Edit"; ?> Product Category</h4>
                                        </div>

                                        <div class="widget-body" style="padding: 15px;">

                                            <?php echo $this->Form->create('Productcategory', array('method' => 'POST', 'controller' => 'productcategories', 'action' => 'add'));
                                            ?>
                                            <br />

                                            <?php
                                            echo $this->Form->input('id', array('type' => 'hidden'));
                                            ?>

                                            <?php
                                            echo $this->Form->input('productcategoryname', array('label' => 'Category Name', 'required' => true, 'placeholder' => 'Category Name', 'class' => 'span10 left-stripe', 'type' => 'text'));
                                            ?>
                                            
                                            <?php
                                            echo $this->Form->input('productcategorydescription', array('label' => 'Description', 'required' => true, 'placeholder' => 'Description', 'class' => 'span10 left-stripe', 'type' => 'text'));
                                            ?>

                                            <hr/>
                                            <?php if (!isset($data['Productcategory']['id'])): ?>
                                                <button type="submit" class="btn btn-success">Add Product Category</button>
                                            <?php else: ?>
                                                <button type="submit" class="btn btn-info">Update Product Category</button>
                                            <?php endif; ?>


                                            <?php echo $this->Form->end() ?>
                                        </div>
                                    </div>
                                </div>
                                <div class="span8">
                                    <!--PAGE CONTENT BEGINS-->
                                    <div class="row-fluid">
                                        <h3 class="span12 header smaller lighter green">List of Categories</h3>
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
                                                <th> Category Name</th>
                                                <th> Description </th>
                                                <th style="text-align: center" width="15%">  Actions </th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            $i = 0;
                                            foreach ($categories as $category):
                                                ?>
                                                <tr>
                                                    <td width="5%"> <?php echo++$i ?> </td>
                                                    <td> <?php echo $category['Productcategory']['productcategoryname']; ?>  </td>
                                                    <td> <?php echo $category['Productcategory']['productcategorydescription']; ?>  </td>
                                                    <td style="text-align: center">
                                                        <div class="hidden-phone visible-desktop action-buttons center">
                                                            <?php
                                                            echo $this->Html->link(
                                                                    '<i class="icon-pencil bigger-130"></i>', 
                                                                    array('controller' => 'productcategories', 'action' => 'edit', $category['Productcategory']['id']), 
                                                                    array('class' => 'green', 'escape' => false,
                                                                    "data-rel" => "tooltip", "data-placement" => "top", "data-original-title" => 'Edit'));
                                                            ?> |
                                                            <?php
                                                            echo $this->Html->link(
                                                                    '<i class="icon-trash bigger-130"></i>', 
                                                                    array('controller' => 'productcategories', 'action' => 'delete', $category['Productcategory']['id']), 
                                                                    array('class' => 'red', 'escape' => false,
                                                                    "data-rel" => "tooltip", "data-placement" => "top", "data-original-title" => 'Delete'), true);
                                                            ?>
                                                         </div>
                                                    </td>
                                                </tr>
                                            <?php endforeach; ?>
                                            <?php unset($categories); ?>
                                        </tbody>
                                    </table>
                                    <!--PAGE CONTENT ENDS-->
                                </div><!--/.span-->
                            </div>
                            
                            <div id="product" class="tab-pane in active">
                                <div class="span4">
                                        <!--<h3 class="header smaller lighter green">Add New Brand</h3>-->
                                        <div style="height: 10px;"></div>

                                        <div class="widget-box">
                                            <div class="widget-header">
                                                <h4><?php if (!isset($data['Product']['id'])) echo "Add"; else echo "Edit"; ?> Product </h4>
                                            </div>

                                            <div class="widget-body" style="padding: 15px;">

                                                <?php echo $this->Form->create('Product', array('method' => 'POST', 'controller' => 'products', 'action' => 'add'));
                                                ?>
                                                <br />

                                                <?php
                                                echo $this->Form->input('id', array('type' => 'hidden'));
                                                ?>

                                                <?php
                                                echo $this->Form->input('productname', array('label' => 'Product Name', 'required' => true, 'placeholder' => 'Product Name', 'class' => 'span10 left-stripe', 'type' => 'text'));
                                                ?>

                                                <?php
                                                echo $this->Form->input('productdescription', array('label' => 'Description', 'required' => true, 'placeholder' => 'Description', 'class' => 'span10 left-stripe', 'type' => 'text'));
                                                ?>

                                                <label class="control-label">Brand  &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php
                                                echo $this->Html->link(
                                                        '<i class="icon-plus  bigger-110 icon-only"></i> Add', 
                                                        array('controller' => 'brands', 'action' => 'index'), 
                                                        array('class'=>'btn btn-light btn-minier', 'escape' => false));
                                                ?></label>
                                                <div class="controls">
                                                    <?php
                                                    echo $this->Form->select('brandid', $brandlist, 
                                                            array('label' => 'Brand', 'required' => true, 'class' => 'span5 left-stripe'));
                                                    ?>
                                                </div>

                                                <label class="control-label">Category  &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php
                                                    echo $this->Html->link(
                                                            '<i class="icon-plus  bigger-110 icon-only"></i> Add', 
                                                            array('controller' => 'productcategories', 'action' => 'index'), 
                                                            array('class' => 'btn btn-light btn-minier float-right', 'escape' => false));
                                                    ?></label>
                                                <div class="controls">
                                                    <?php
                                                    echo $this->Form->select('categoryid', $categorylist, array('label' => 'Category', 'required' => true, 'class' => 'span5 left-stripe'));
                                                    ?>
                                                </div>

                                                <label class="control-label">Comparison Product </label>
                                                <div class="controls">
                                                    <?php
                                                    echo $this->Form->select('compareproductid', $compareproductlist, 
                                                            array('label' => 'Comparison Product', 'class' => 'span5 left-stripe'));
                                                    ?>
                                                </div>


                                                <hr/>
                                                <?php if (!isset($data['Product']['id'])): ?>
                                                    <button type="submit" class="btn btn-success">Add Product</button>
                                                <?php else: ?>
                                                    <button type="submit" class="btn btn-info">Update Product</button>
                                                <?php endif; ?>


                                                <?php echo $this->Form->end() ?>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="span8">
                                        <!--PAGE CONTENT BEGINS-->
                                        <div class="row-fluid">
                                            <h3 class="span12 header smaller lighter green">Product listing</h3>
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
                                                    <th> Product Name</th>
                                                    <th> Description </th>
                                                    <th> Brand </th>
                                                    <th> Category </th>
                                                    <th> Comparison Product </th>
                                                    <th style="text-align: center" width="15%">  Actions </th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                            $i = 0;

                                            foreach ($products as $product):
                                                ?>
                                                <tr>
                                                    <td width="5%"> <?php echo++$i ?> </td>
                                                    <td> <?php echo $product['Product']['productname']; ?>  </td>
                                                    <td> <?php echo $product['Product']['productdescription']; ?>  </td>
                                                    <td> <?php echo $product['Brand']['brandname']; ?>  </td>
                                                    <td> <?php echo $product['Productcategory']['productcategoryname']; ?> </td>
                                                    <td width="15%"> 
                                                        <?php 
                                                        if(isset($product['Product']['compareproductid'])) {
                                                            echo $compareproducts[$product['Product']['compareproductid']];
                                                        } else {
                                                            echo "-";
                                                        }
                                                            ?>  </td>
                                                    <td style="text-align: center">
                                                        <div class="hidden-phone visible-desktop action-buttons center">
                                                        <?php
                                                            echo $this->Html->link(
                                                                    '<i class="icon-pencil bigger-130"></i>', 
                                                                    array('controller' => 'products', 'action' => 'edit', $product['Product']['id']), 
                                                                    array('class' => 'green', 'escape' => false,
                                                                    "data-rel" => "tooltip", "data-placement" => "top", "data-original-title" => 'Edit'));
                                                            ?> | 
                                                            <?php
                                                            echo $this->Html->link(
                                                                    '<i class="icon-trash bigger-130"></i>', 
                                                                    array('controller' => 'products', 'action' => 'delete', $product['Product']['id']), 
                                                                    array('class' => 'red', 'escape' => false,
                                                                    "data-rel" => "tooltip", "data-placement" => "top", "data-original-title" => 'Delete'), true);
                                                            ?>
                                                        </div>
                                                    </td>
                                                </tr>
                                            <?php endforeach; ?>
                                            <?php unset($products); ?>
                                            </tbody>
                                        </table>
                                        <!--PAGE CONTENT ENDS-->
                                    </div><!--/.span-->
                            </div>
                        </div>
                    </div>
                
                <!--==================================-->
                <!--PAGE CONTENT ENDS-->
            </div><!--/.span-->
        </div><!--/.row-fluid-->
    </div><!--/.page-content-->

    <?php // echo $this->element('settings'); ?>

</div><!--/.main-content-->