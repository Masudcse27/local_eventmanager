<?php
defined('MOODLE_INTERNAL') || die();

$capabilities = [
    'local/eventmanager:manageevents' => [
        'captype' => 'write',
        'contextlevel' => CONTEXT_SYSTEM,
        'archetypes' => [
            'manager' => CAP_ALLOW,
        ]
    ],
    'local/achievement:manage' => [
        'captype' => 'write', 
        'contextlevel' => CONTEXT_SYSTEM,
        'archetypes' => [
            'student' => CAP_ALLOW,
            'teacher' => CAP_ALLOW,
            'manager' => CAP_ALLOW,
        ]
    ]
];