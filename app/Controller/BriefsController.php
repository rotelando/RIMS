<?php

class BriefsController extends AppController {

    var $name = 'Briefs';
    var $uses = array('Brief', 'Brief2');
    var $helpers = array('Form', 'TextFormater');
    var $components = array('Paginator');

    public function beforeFilter() {
        parent::beforeFilter();
        
//        $allowed = $this->UserAccessRight->isAllowedBriefsModule($this->_getCurrentUserId(), 'view');
//        if(!$allowed) {
//            $this->Session->setFlash('You are not authorized to view that page!', 'page_notification_error');
//            $this->redirect(array('controller' => 'dashboard', 'action' => 'index'));
//        }
        
        $this->_setViewVariables();
        $this->_fetchAndSetAllBriefs();
    }

    public function index() {
        
    }

    public function upload() {

//        debug($this->request->data);
//        debug(Router::url('/', true));
        $this->view = 'index';
        if (!empty($this->request->data)) {
            
            $brief['Brief']['title'] = $this->request->data['Brief']['title'];
            $brief['Brief']['description'] = $this->request->data['Brief']['description'];
            
            //Hash name and append the id and extension to the name
            $arrFilename = explode('.', $this->request->data['Brief']['brief']['name']);
            $extension = end($arrFilename);
            $briefwithid = $this->Brief->find('first', array('fields' => array('id'), 'order' => array('id desc')));
            $id = intval($briefwithid['Brief']['id']) + 1;
            $hashname = hash('md5', $this->request->data['Brief']['brief']['name']);
            $brief['Brief']['brief_file_name'] = $hashname . '_' . $id .'.'. $extension;
            
            $brief['Brief']['brief_content_type'] = $this->request->data['Brief']['brief']['type'];
            $brief['Brief']['brief_file_size'] = $this->request->data['Brief']['brief']['size'];
            $brief['Brief']['groupidentity'] = $this->_generateNewGroupIdentity();
            $brief['Brief']['userid'] = $this->Auth->user('id');
            $brief['Brief']['createdat'] = $this->_createNowTimeStamp();    //create now timestamp if not set
            
            
            $success = move_uploaded_file($this->request->data['Brief']['brief']['tmp_name'], 
                    WWW_ROOT . 'upload' . DS . 'briefs' . DS . $brief['Brief']['brief_file_name']);
            
//            $brief['Brief']['createdat'] = $this->_createNowTimeStamp();    //create now timestamp if not set
//            $this->Brief->create($this->request->data);
//            $this->Brief->set(array('groupidentity' => $this->_generateNewGroupIdentity()));
//            $this->Brief->set(array('userid' => $this->Auth->user('id')));
            if($success) {
                if ($this->Brief->save($brief)) {
                    $this->Session->setFlash($this->request->data['Brief']['title'] . ' has been added', 'page_notification_info');
                    $this->redirect('/briefs/index');
                }
            }
        }
    }

    public function download($id = null) {

        $this->autoRender = false;
        
        if ($this->Brief->exists($id)) {

            $brief = $this->Brief->findById($id);

            //append the _:id to the file name

//            $split_name = explode('.', $brief['Brief']['brief_file_name']);
//            $count = count($split_name);
//            $filename = '';
//            $short_name = '';
//            for ($i = 0; $i < $count; $i++) {
//                if ($i == $count - 1) {
//                    $short_name = $filename;    //get the original name of the file before appending :id
//                    $filename .= '_' . $brief['Brief']['id'] . '.';
//                }
//
//                $filename .= $split_name[$i];
//            }
            $arrFilename = explode('.', $brief['Brief']['brief_file_name']);
            $extension = end($arrFilename);
            $name = $arrFilename[0] . '_' . $id . $extension;
            $filepath = 'webroot' . DS . 'upload' . DS . 'briefs' . DS . $brief['Brief']['brief_file_name'];
//            debug($filepath);
            $this->response->header(array( 'Content-type: application/pdf' ));
            $this->response->file($filepath, array('download' => true, 'name' => $this->brief['Brief']['title']));

//            $this->response->send();
//            $this->response->header(array( 'Content-type: application/pdf' ));
//            $this->response->download($filepath);
//            return $this->response;
            
        } else {
            $this->Session->setFlash('Selected brief cannot be found on the server', 'page_notification_error');
        }
    }

    public function delete($id = null) {
        if (!$id) {

            $this->Session->setFlash('Invalid brief selected', 'page_notification_error');
            $this->redirect(array('controller' => 'briefs', 'action' => 'index'));
        }

        $this->Brief->id = $id;

        if ($this->Brief->saveField('deletedat', "{$this->_createNowTimeStamp()}")) {
            $this->Session->setFlash('Brief has been deleted', 'page_notification_info');
            $this->redirect(array('controller' => 'briefs', 'action' => 'index'));
        } else {
            $this->Session->setFlash('Unable to delete brief. Please, try again', 'page_notification_error');
        }
    }

    public function view($id = null) {

        $this->Brief->id = $id;

        if (!$this->Brief->exists() || !$id) {
            $this->Session->setFlash('Invalid brief selected', 'page_notification_error');
            $this->redirect(array('controller' => 'briefs', 'action' => 'index'));
        }

        $this->set(array('brief' => $this->Brief->read()));
        $this->request->data = $this->Brief->read();

        $this->_fetchAndSetAllBriefsVersions($this->request->data['Brief']['groupidentity'], 3);
    }

    public function newversion($id = null) {

        $this->Brief->id = $id;
        if (!$this->Brief->exists() || !$id) {
            $this->Session->setFlash('Invalid brief selected', 'page_notification_error');
            $this->redirect(array('controller' => 'briefs', 'action' => 'index'));
        }
        $this->Brief->read();
//        debug($this->Brief->data);
        
        $brief['Brief']['title'] = $this->request->data['Brief']['title'];
        $brief['Brief']['description'] = $this->request->data['Brief']['description'];
            
        //Hash name and append the id and extension to the name
        $arrFilename = explode('.', $this->request->data['Brief']['brief']['name']);
        $extension = end($arrFilename);
        $briefwithid = $this->Brief->find('first', array('fields' => array('id'), 'order' => array('id desc')));
        $id = intval($briefwithid['Brief']['id']) + 1;
        $hashname = hash('md5', $this->request->data['Brief']['brief']['name']);
        $brief['Brief']['brief_file_name'] = $hashname . '_' . $id .'.'. $extension;
            
        $brief['Brief']['brief_content_type'] = $this->request->data['Brief']['brief']['type'];
        $brief['Brief']['brief_file_size'] = $this->request->data['Brief']['brief']['size'];
        $brief['Brief']['groupidentity'] = $this->Brief->data['Brief']['groupidentity'];
        $brief['Brief']['userid'] = $this->Auth->user('id');
        $brief['Brief']['createdat'] = $this->_createNowTimeStamp();    //create now timestamp if not set
            
            
        $success = move_uploaded_file($this->request->data['Brief']['brief']['tmp_name'], 
                WWW_ROOT . 'upload' . DS . 'briefs' . DS . $brief['Brief']['brief_file_name']);
            
        $this->Brief->clear();
        if($success) {
            if ($this->Brief->save($brief)) {
                $this->Session->setFlash('A new version of ' . $this->request->data['Brief']['title'] . ' has been created', 'page_notification_info');
                $this->redirect(array('controller' => 'briefs', 'action' => 'view', $this->Brief->getLastInsertID()));
            }
        }
            
        $this->view = 'view';
    }

    public function versions($id = null) {
        $this->Brief->id = $id;

        if (!$this->Brief->exists() || !$id) {
            $this->Session->setFlash('Invalid brief selected', 'page_notification_error');
            $this->redirect(array('controller' => 'briefs', 'action' => 'index'));
        }

        $this->set(array('brief' => $this->Brief->read()));
        $this->request->data = $this->Brief->read();
        $groupidentity = $this->request->data['Brief']['groupidentity'];

        $paginate_options = array(
            'limit' => 20,
            'order' => array(
                'Brief.createdat' => 'desc'
            ),
            'conditions' => array('groupidentity' => $groupidentity)
        );
        $this->Paginator->settings = $paginate_options;

        $versions = $this->Paginator->paginate('Brief');
        $this->set(array('versions' => $versions));
    }

    public function _generateNewGroupIdentity() {

        $group_identity = md5($this->_createNowTimeStamp());
        return $group_identity;
    }

    private function _fetchAndSetAllBriefs() {

//        <=== Brief2 Views ==> 
//        SELECT id, title, description, brief_file_name, brief_content_type,
//        brief_file_size, groupidentity, max(createdat) as createdat, updatedat, deletedat 
//        FROM briefs 
//        GROUP BY groupidentity
//
//        $query = "SELECT Brief.* FROM Briefs Brief 
//        INNER JOIN Brief2
//        ON Brief.groupidentity = Brief2.groupidentity 
//        AND Brief.createdat = Brief2.createdat";
//        
//        $briefs = $this->Brief->query($query);
//        $briefs = $this->Brief->find('all', $options);
//================================================================
        $paginate_options = array(
            'limit' => 10,
            'order' => array(
                'Brief.createdat' => 'desc'
            ),
            'joins' => array(
                array(
                    'table' => 'Brief2',
                    'alias' => 'Brief2',
                    'type' => 'INNER',
                    'conditions' => array(
                        'Brief.groupidentity = Brief2.groupidentity',
                        'Brief.createdat = Brief2.createdat'
                    )
                )
            )
        );
        $this->Paginator->settings = $paginate_options;

        //Now you can use the paginate option
        $briefs = $this->Paginator->paginate('Brief');

        $this->set(array('briefs' => $briefs));
    }

    private function _fetchAndSetAllBriefsVersions($groupidentity, $limit = null) {

        $versions = $this->Brief->find('all', array(
            'conditions' => array('groupidentity' => $groupidentity), 'limit' => $limit, 'order' => array('Brief.createdat desc')));
        $this->set(array('versions' => $versions));
    }

    private function _setViewVariables() {
        $this->_setSidebarActiveItem('briefs');
        $this->_setTitleOfPage('Briefs');
    }

}