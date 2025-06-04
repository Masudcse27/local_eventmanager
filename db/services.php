<?php

$services = [
    'Event Manager Custom Web Services' => [
        'functions' => [
            'local_eventmanager_get_event_details',
            'local_eventmanager_create_event'
        ],
        'restrictedusers' => 0,
        'enabled' => 1,
        'shortname' => 'eventmanagercustomws',
    ],
];

$functions = [
    'local_eventmanager_get_event_details' => [
        'classname'   => 'local_eventmanager_external',
        'methodname'  => 'get_event_details',
        'classpath'   => 'local/eventmanager/externallib.php',
        'description' => 'Retrieve details of an event.',
        'type'        => 'read'
    ],
    'local_eventmanager_create_event' => [
        'classname'   => 'local_eventmanager_external',
        'methodname'  => 'create_event',
        'classpath'   => 'local/eventmanager/externallib.php',
        'description' => 'Create a new event.',
        'type'        => 'write',
    ]
];