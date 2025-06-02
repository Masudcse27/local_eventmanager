<?php
require('../../config.php');
require_login();

$id = required_param('id', PARAM_INT);
if(!$id){
    redirect(new moodle_url('/local/eventmanager/index.php'), get_string('id_require', 'local_eventmanager'));
}
$event = $DB->get_record('local_eventmanager', ['id' => $id], '*');
if(!$event){
    redirect(new moodle_url('/local/eventmanager/index.php'), get_string('invalid_id', 'local_eventmanager'));
}
$DB->delete_records('local_eventmanager', ['id' => $id]);
redirect(new moodle_url('/local/eventmanager/index.php'), get_string('deleted','local_eventmanager'));