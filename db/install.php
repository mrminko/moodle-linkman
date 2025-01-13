<?php

function xmldb_local_linkman_install() {
    global $DB;

    $dbman = $DB->get_manager();

    if(!$DB->record_exists('role', ['shortname' => 'unescoadmin'])) {
        $unescoadmin = create_role('Unesco Admin', 'unescoadmin', '', 'manager');
    }
    return true;
}