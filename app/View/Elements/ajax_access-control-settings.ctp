<?php 

//$this->response->header('Access-Control-Allow-Origin', $access_control_domain);
//And use the following code if you want to allow access from any host that does not belong to your rest server domain.
//$this->response->header('Access-Control-Allow-Origin','http://localhost/*, http://fieldmaxadmin.alexanderharing.com/*');
$this->response->header('Access-Control-Allow-Origin','http://rims.local/*, http://localhost/*', 'http://retailman.local/*');
$this->response->header('Access-Control-Allow-Methods','GET, POST');
$this->response->header('Access-Control-Allow-Headers','X-Requested-With');
$this->response->header('Access-Control-Max-Age','172800');
$this->response->type('json');

?>