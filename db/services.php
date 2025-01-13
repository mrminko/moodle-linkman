<?php
$functions = [
    'local_linkman_link_reducer' => [

        'classname'   => 'local_linkman\external\link_reducer',

        'classpath'   => 'local/linkman/external/link_reducer.php',

        'capabilities' => 'local/linkman:config',

        'description' => 'Ajax call for partial rendering',

        'type'        => 'write',

        'ajax'        => true,

        'services' => [
            MOODLE_OFFICIAL_MOBILE_SERVICE,
        ]
    ],
];