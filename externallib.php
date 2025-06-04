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

}