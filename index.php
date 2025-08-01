<?php
require('../../config.php');
require_login();
$context = context_system::instance();
$canmanage = has_capability('local/eventmanager:manageevents', $context);

$PAGE->set_context($context);
$PAGE->set_url(new moodle_url('/local/eventmanager/index.php'));
$PAGE->set_title('Event Manager');
$PAGE->set_heading('Event Manager');

$events = $DB->get_records('local_eventmanager', null, 'eventdate ASC');

$templatecontext = [
    'canmanage' => $canmanage,
    'heading' => get_string('institutionevents', 'local_eventmanager'),
    'newevent' => get_string('newevent', 'local_eventmanager'),
    'newurl' => new moodle_url('/local/eventmanager/edit.php'),
    'events' => !empty($events),
    'list' => []
];

foreach ($events as $event) {
    $item = [
        'title' => format_string($event->title),
        'eventdate' => userdate($event->eventdate),
        'show_url' => new moodle_url('/local/eventmanager/show.php', ['id' => $event->id])
    ];
    if ($canmanage) {
        $item['editurl'] = new moodle_url('/local/eventmanager/edit.php', ['id' => $event->id]);
        $item['deleteurl'] = new moodle_url('/local/eventmanager/delete.php', ['id' => $event->id]);
    }

    $templatecontext['list'][] = $item;
}

echo $OUTPUT->header();
echo $OUTPUT->render_from_template('local_eventmanager/eventlist', $templatecontext);
echo $OUTPUT->footer();