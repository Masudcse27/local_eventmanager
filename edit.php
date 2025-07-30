<?php
require('../../config.php');
use local_eventmanager\form\event_form;

require_login();

$PAGE->set_context(context_system::instance());

$id = optional_param('id', 0, PARAM_INT);
$event = $id ? $DB->get_record('local_eventmanager', ['id' => $id], '*', MUST_EXIST) : null;


$PAGE->set_url(new moodle_url('/local/eventmanager/edit.php', ['id' => $id]));
if ($id) {
    $PAGE->set_title('Edit Event');
    $PAGE->set_heading('Edit Event');
} else {
    $PAGE->set_title('Create Event');
    $PAGE->set_heading('Create Event');
}



$mform = new event_form();

if ($mform->is_cancelled()) {
    redirect(new moodle_url('/local/eventmanager/index.php'), get_string('cancel_form', 'local_eventmanager'));
} else if ($data = $mform->get_data()) {
    $record = (object) [
        'title' => $data->title,
        'description' => $data->description['text'],
        'format' => $data->description['format'],
        'category' => $data->category,
        'eventdate' => $data->eventdate,

    ];
    if ($data->id) {
        $record->id = $data->id;
        $DB->update_record('local_eventmanager', $record);
        redirect(new moodle_url('/local/eventmanager/index.php'), get_string('event_updated', 'local_eventmanager'));
    } else {
        $record->timecreated = time();
        $DB->insert_record('local_eventmanager', $record);
        redirect(new moodle_url('/local/eventmanager/index.php'), get_string('event_created', 'local_eventmanager'));
    }
    
}

if ($event) {
    $event->description = [
        'text' => $event->description,
        'format' => $event->format
    ];
    $mform->set_data($event);
}


echo $OUTPUT->header();
$mform->display();
echo $OUTPUT->footer();