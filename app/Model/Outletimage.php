<?php

class Outletimage extends AppModel {
    
    var $name = 'Outletimage';

    public function recentImages($amount = 16, $options = null) {

        $options['fields'] = array(
            'Outletimage.id',
            'Outletimage.description',
            'Outletimage.url',
            'Outletimage.created_at',
            'Outlet.id',
            'CONCAT(User.firstname," ",User.lastname) as fullname',
            'Outlet.outletname',
            'Location.locationname',
        );
        $options['order'] = array('Outletimage.created_at DESC');
        $options['limit'] = $amount;
        $options['recursive'] = -1;

        //move the joins to the beginning of the array to allow proper flow
        array_unshift($options['joins'], array(
            'table' => 'users',
            'alias' => 'User',
            'type' => 'LEFT',
            'conditions' => array(
                'User.id = Outlet.user_id'
            )
        ));
        array_unshift($options['joins'], array(
            'table' => 'outlets',
            'alias' => 'Outlet',
            'type' => 'INNER',
            'conditions' => array(
                'Outlet.id = Outletimage.outlet_id'
            )
        ));

        $images = $this->find('all', $options);
        return $images;
    }

    public function imagesForOutlet($id) {

        $options['fields'] = array(
            'Outletimage.id',
            'Outletimage.description',
            'Outletimage.url',
            'Outletimage.created_at',
            'Outlet.id',
            'CONCAT(User.firstname," ",User.lastname) as fullname',
            'Outlet.outletname',
            'Location.locationname',
        );
        $options['order'] = array('Outletimage.created_at DESC');
        $options['conditions'] = array('Outletimage.outlet_id' => $id);
        $options['recursive'] = -1;
        $options['joins'] = array(
            array(
                'table' => 'outlets',
                'alias' => 'Outlet',
                'type' => 'INNER',
                'conditions' => array(
                    'Outlet.id = Outletimage.outlet_id'
                )
            ),
            array(
                'table' => 'locations',
                'alias' => 'Location',
                'type' => 'INNER',
                'conditions' => array(
                    'Location.id = Outlet.location_id'
                )
            ),
            array(
                'table' => 'users',
                'alias' => 'User',
                'type' => 'INNER',
                'conditions' => array(
                    'User.id = Outlet.user_id'
                )
            )
        );

        $image = $this->find('all', $options);
        return $image;
    }

    public function getPaginatedImages($paginatorObject, $options = null, $number) {

        $options['fields'] = array(
            'Outletimage.id',
            'Outletimage.description',
            'Outletimage.url',
            "DATE_FORMAT(Outletimage.created_at,'%Y-%m-%d') as dateline",
            'Outletimage.created_at',
            'Outlet.id',
            'CONCAT(User.firstname," ",User.lastname) as fullname',
            'Outlet.outletname',
            'Location.locationname'
        );
        $options['order'] = array('Outletimage.created_at' => 'desc');
        $options['limit'] = $number;
        $options['recursive'] = -1;

        array_unshift($options['joins'], array(
                'table' => 'users',
                'alias' => 'User',
                'type' => 'INNER',
                'conditions' => array(
                    'Outlet.user_id = User.id'
                )
            )
        );
        array_unshift($options['joins'], array(
                'table' => 'outlets',
                'alias' => 'Outlet',
                'type' => 'INNER',
                'conditions' => array(
                    'Outlet.id = Outletimage.outlet_id'
                )
            )
        );

        $paginatorObject->settings = $options;
        $images = $paginatorObject->Paginate('Outletimage');
//        debug($images);
        return $images;
    }
}
