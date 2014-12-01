<?php

class User extends AppModel {

    public $name = 'User';
    var $displayField = 'username';
    
    public $validate = array(
        'firstname' => array(
            'Cannot be empty' => array(
                'rule' => 'notEmpty',
                'message' => 'Please enter your firstname'
            )
        ),
        'username' => array(
            'Cannot be empty' => array(
                'rule' => 'notEmpty',
                'message' => 'Please fill in your username'
            ),
            'Greater than 6 character' => array(
                'rule' => array('minLength', 5),
                'message' => 'Minimum length of 5 characters'
            ),
            'Unique value' => array(
                'rule' => 'isUnique',
                'message' => 'Username already exist.'
            )
        ),
        'emailaddress' => array(
            'Valid email address' => array(
                'rule' => 'email',
                'message' => 'Please enter a valid email address'
            )
        ),
        'password' => array(
            'Cannot be empty' => array(
                'rule' => 'notEmpty',
                'message' => 'Please fill in your password'
            ),
            'Match Passwords' => array(
                'rule' => 'matchPassword',
                'message' => 'Please ensure password matches'
            )
        ),
        'confirm_password' => array(
            'Cannot be empty' => array(
                'rule' => 'notEmpty',
                'message' => 'Password do not match'
            )
        ),
        'reset_password' => array(
            'Reset Cannot be empty' => array(
                'rule' => 'notEmpty',
                'message' => 'Password do not match'
            )
        ),
        'confirm_reset_password' => array(
            'Reset Cannot be empty' => array(
                'rule' => 'notEmpty',
                'message' => 'Password do not match'
            )
        ),
        'oldpassword' => array(
            'Cannot be empty' => array(
                'rule' => 'notEmpty',
                'message' => 'Password do not match'
            )
        ),
        'userroleid' => array(
            'Cannot be empty' => array(
                'rule' => 'notEmpty',
                'required'=>true,
                'message' => 'Please select a User Role'
            )
        )
    );
    public $belongsTo = array(
        'Userrole' => array(
            'className' => 'Userrole',
            'foreignKey' => 'userroleid'
        )
    );
    
    public $hasMany = array(
        'Outlet' => array(
            'className' => 'Outlet',
            'foreignKey' => 'user_id',
            'dependent' => true
        )
    );

    public function getAllUsers() {

        $options['fields'] = array(
            'User.*',
            'Userrole.*'
        );
        $options['recursive'] = 0;
        $users = $this->find('all', $options);

        return $users;
    }

    public function getUsersAsList() {

        $userlist = $this->find('list');
        return $userlist;
    }

    public function matchPassword($data) {
        
//        debug($data);
//        debug($this->data);
        
        if ($data['password'] == $this->data['User']['confirm_password']) {
            return true;
        }
        $this->invalidate('confirm_password', 'Password do not match');
        return false;
    }
    

    public function beforeSave($options = array()) {
        parent::beforeSave($options);

        //Check if the password from the form data is set or not empty
//        if (isset($this->data[$this->alias]['password'])) {
//            $this->data[$this->alias]['password'] = AuthComponent::password($this->data['User']['password']);
//        }
        
        if (isset($this->data[$this->alias]['password'])) {
            $this->data[$this->alias]['password'] = Security::hash($this->data[$this->alias]['password'], 'sha512');
        }

        return true;
    }


    public function countUser($options = null) {

        return $this->find('count', $options);
    }

    public function fieldRepLists($count = false) {

        //$currentUserSettings = $this->setCurrentUserSettings();
        if (!isset($currentUserSettings['Setting']['fieldrepid'])) {
            $fieldrepid = 3;
        } else {
            $fieldrepid = $currentUserSettings['Setting']['fieldrepid'];
        }

        $options['conditions']['User.userroleid'] = $fieldrepid;

        if($count) {
            $fieldreps = $this->find('count', $options);
        } else {
            $fieldreps = $this->find('list', $options);
        }
        return $fieldreps;
    }
    
}
