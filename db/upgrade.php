<?php
// This file is part of Moodle - http://moodle.org/
//
// Moodle is free software: you can redistribute it and/or modify
// it under the terms of the GNU General Public License as published by
// the Free Software Foundation, either version 3 of the License, or
// (at your option) any later version.
//
// Moodle is distributed in the hope that it will be useful,
// but WITHOUT ANY WARRANTY; without even the implied warranty of
// MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
// GNU General Public License for more details.
//
// You should have received a copy of the GNU General Public License
// along with Moodle.  If not, see <http://www.gnu.org/licenses/>.

defined('MOODLE_INTERNAL') || die();

function xmldb_local_linkman_upgrade($oldversion) {
    global $CFG, $DB, $SITE, $OUTPUT;
    $dbmanager = $DB->get_manager();
    if(!$dbmanager->table_exists('local_linkman')) {
        $dbmanager->install_one_table_from_xmldb_file(__DIR__ . '/install.xml', 'local_linkman');
    }
    if ($oldversion < 2025010104) {
        if(!$dbmanager->field_exists('local_linkman', 'name')) {
            $table = new xmldb_table('local_linkman');
            $field = new xmldb_field('name', XMLDB_TYPE_CHAR, '255', null, true, false, null, null);
            $dbmanager->add_field($table, $field);
        }
    }
    upgrade_plugin_savepoint(true, 2025010105, 'local', 'linkman');
}