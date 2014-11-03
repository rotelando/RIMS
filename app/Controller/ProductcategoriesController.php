<?php

class ProductcategoriesController extends AppController {
    
    var $name = 'Productcategories';
    var $uses = array('Productcategory', 'Product', 'Brand');
    
    public function beforeFilter() {
        parent::beforeFilter();
        
//        $allowed = $this->UserAccessRight->isAllowedSetupModule($this->_getCurrentUserId(), 'view');
//        if(!$allowed) {
//            $this->Session->setFlash('You are not authorized to view that page!', 'page_notification_error');
//            $this->redirect(array('controller' => 'dashboard', 'action' => 'index'));
//        }
        
        $this->_setViewVariables();
        $this->_getAllCategories();
        $this->_getAllProducts();
    }
    
    public function index() {
        
    }
    
    public function add($id = null) {
        
        $this->render('index');
        
//        debug($this->request->data);
        if ($this->request->is('Post') || $this->request->is('Put')) {
                
            $this->request->data['Productcategory']['created_at'] = $this->_createNowTimeStamp();    //create now timestamp if not set
            if ($this->Productcategory->save($this->request->data)) {
                $this->Session->setFlash($this->request->data['Productcategory']['productcategoryname'] . ' has been added', 'page_notification_info');
                $this->redirect(array('controller' => 'productcategories', 'action' => 'index'));
            } else {
                $this->Session->setFlash('problem adding category. Please, try again', 'page_notification_error');
                $this->_setViewVariables();
            }
        }
    }
    
    public function delete($id = null) {
        if (!$id) {

            $this->Session->setFlash('Invalid Category selected', 'page_notification_error');
            $this->redirect(array('controller' => 'productcategories', 'action' => 'index'));
        }

        $this->Productcategory->id = $id;

        if ($this->Productcategory->saveField('deleted_at', "{$this->_createNowTimeStamp()}")) {
            $this->Session->setFlash('Category has been deleted', 'page_notification_info');
            $this->redirect(array('controller' => 'productcategories', 'action' => 'index'));
        } else {
            $this->Session->setFlash('Unable to delete category. Please, try again', 'page_notification_error');
        }
    }
    
    public function edit($id = null) {
        
        $this->render('index');
        
        $this->Productcategory->id = $id;
        
        if (!($this->request->is('Post') || $this->request->is('Put')) && isset($id)) {
            
            $this->request->data = $this->Productcategory->read();
            $this->set('data', $this->request->data);
            $this->_getAllCategories();
            $this->_setViewVariables();
        }
        
        $this->add($id);
        
    }
    
    private function _getAllProducts() {

        $products = $this->Product->getAllProducts();
        $brandlist = $this->Brand->find('list');
        $options['joins'] = array(
                    array(
                        'table' => 'brands',
                        'alias' => 'Brand',
                        'type' => 'LEFT',
                        'conditions' => array(
                            'Product.brandid = Brand.id'
                        )
                    )
                );
        $compareproducts = $this->Product->find('list', $options);
        $options['conditions'] = array('Brand.current' => 1);
        $compareproductlist = $this->Product->find('list', $options);
        
        $categorylist = $this->Productcategory->find('list');

        $this->set(array(
            'products' => $products, 
            'brandlist' => $brandlist, 
            'categorylist' => $categorylist, 
            'compareproductlist' => $compareproductlist, 
            'compareproducts' => $compareproducts)
        );
    }
    
    private function _getAllCategories(){
        $categories = $this->Productcategory->find('all'); 
        $this->set(array('categories'=>$categories));
    }
    
    private function _setViewVariables() {
        $this->_setSidebarActiveItem('setup');
        $this->_setSidebarActiveSubItem('products');
        $this->_setTitleOfPage('Products and Categories');
    }
    
//    public function beforeRender() {
//        parent::beforeRender();
//        $this->_getAllProducts();
//        $this->_getAllCategories();
//        $this->_setViewVariables();
//        return true;
//    }
}
