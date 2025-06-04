<?php
require_once($CFG->libdir . "/externallib.php");

class local_eventmanager_external extends external_api
{
    public static function get_event_details_parameters(){
        return new external_function_parameters([
            'eventid' => new external_value(PARAM_INT, 'Event id')
        ]);
    }

    public static function get_event_details($eventid){
        global $DB;
        $params = self::validate_parameters(self::get_event_details_parameters(), ['eventid' => $eventid]);
        $event = $DB->get_record('local_eventmanager', ['id' => $params['eventid']], '*');

        return [
            'id' => $event->id,
            'name' => $event->title,
            'description' => $event->description,
            'event_date' => userdate($event->eventdate)
        ];
    }

    public static function get_event_details_returns(){
        return new external_single_structure([
            'id' => new external_value(PARAM_INT, 'Event id'),
            'name' => new external_value(PARAM_TEXT, 'Event Name'),
            'description' => new external_value(PARAM_RAW, 'Event description'),
            'event_date' => new external_value(PARAM_TEXT, 'Event Date'),
        ]);
    }

    public static function create_event_parameters(){
        return new external_function_parameters([
            'title' => new external_value(PARAM_TEXT, 'Event title'),
            'description' => new external_value(PARAM_RAW, 'Event description'),
            'category' => new external_value(PARAM_INT, 'Event category'),
            'eventdate' => new external_value(PARAM_INT, 'Event date as timestamp'),
        ]);
    }

    public static function create_event($title, $description, $category, $eventdate){
        global $DB, $USER;

        $params = self::validate_parameters(self::create_event_parameters(), [
            'title' => $title,
            'description' => $description,
            'category' => $category,
            'eventdate' => $eventdate
        ]);

        $record = new stdClass();
        $record->title = $params['title'];
        $record->description = $params['description'];
        $record->format = FORMAT_HTML;
        $record->category = $params['category'];
        $record->eventdate = $params['eventdate'];
        $record->timecreated = time();

        $id = $DB->insert_record('local_eventmanager', $record);

        $event = $DB->get_record('local_eventmanager', ['id' => $id], '*', MUST_EXIST);
        return [
        'id'          => $event->id,
        'title'       => $event->title,
        'description' => $event->description,
        'category'    => $event->category,
        'eventdate'   => $event->eventdate,
        'format'      => $event->format,
        'timecreated' => $event->timecreated,
        ];
    }

    public static function create_event_returns(){
        return new external_single_structure([
        'id'          => new external_value(PARAM_INT, 'Event ID'),
        'title'       => new external_value(PARAM_TEXT, 'Title'),
        'description' => new external_value(PARAM_RAW, 'Description'),
        'category'    => new external_value(PARAM_INT, 'Category'),
        'eventdate'   => new external_value(PARAM_INT, 'Event Date'),
        'format'      => new external_value(PARAM_INT, 'Format'),
        'timecreated' => new external_value(PARAM_INT, 'Time created'),
    ]);
    }

}