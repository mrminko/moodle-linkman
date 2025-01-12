<?php

use local_linkman\form\link_add_form;

require_once("../../config.php");
global $CFG, $DB, $USER, $OUTPUT, $PAGE;
require_once("./classes/form/link_add_form.php");

$PAGE->set_url(new moodle_url('/local/linkman/index.php'));
require_login();
$context = context_system::instance();
require_capability('local/linkman:config', $context);
$PAGE->set_context($context);
echo $OUTPUT->header();
echo $OUTPUT->render_from_template('local_linkman/admin_dashboard', []);
$PAGE->requires->js_call_amd('local_linkman/addlink', 'init');
echo $OUTPUT->footer();