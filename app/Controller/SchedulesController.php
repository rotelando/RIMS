<?php

class SchedulesController extends AppController {
    
    var $name = 'Schedules';
    var $uses = array('Visit', 'Schedule', 'Outlet', 'Location', 'User');
    
    public function details($id = null) {
        
        $this->Schedule->unbindModel(
                array('belongsTo' => array('Outlet'))
        );
        
        $options['fields'] = array(
            'Schedule.id', 
            'Schedule.scheduledate', 
            'Schedule.visited',
            'Outlet.id', 
            'Outlet.outletname',
            'User.id',
            'User.firstname',
            'User.lastname',
            'Location.id',
            'Location.locationname'
        );
        $options['order'] = array('Schedule.createdat desc');
        $options['conditions'] = array('Schedule.id' => $id);
        $options['joins'] = array(
            array(
                'table' => 'outlets',
                'alias' => 'Outlet',
                'type' => 'LEFT',
                'conditions' => array(
                    'Outlet.id = Schedule.outletid'
                )
            ),
            array(
                'table' => 'users',
                'alias' => 'User',
                'type' => 'LEFT',
                'conditions' => array(
                    'User.id = Outlet.userid'
                )
            ),
            array(
                'table' => 'locations',
                'alias' => 'Location',
                'type' => 'LEFT',
                'conditions' => array(
                    'Location.id = Outlet.locationid'
                )
            )
        );
        $schedule = $this->Schedule->find('all', $options);
        $response = [];
        foreach ($schedule as $sched) {
            $response['scheduleid'] = $sched['Schedule']['id'];
            $response['scheduledate'] = $sched['Schedule']['scheduledate'];
            $response['visited'] = $sched['Schedule']['visited'];
            $response['outletid'] = $sched['Outlet']['id'];
            $response['outletname'] = $sched['Outlet']['outletname'];
            $response['fieldstaffid'] = $sched['User']['id'];
            $response['fieldstaff'] = $sched['User']['firstname'] . ' ' . $sched['User']['lastname'];
            $response['locationid'] = $sched['Location']['id'];
            $response['locationname'] = $sched['Location']['locationname'];
        }
        
//        $jsonresponse = json_encode($response);
        $jsonresponse = json_encode($response);

        $this->layout = 'ajax';
        $this->view = 'ajax_response';
        $this->set('response', $jsonresponse);
//        return $schedule;
    }
}