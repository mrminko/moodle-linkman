<?php

require_once("../../config.php");
global $CFG, $DB, $USER, $OUTPUT, $PAGE, $SESSION;

$code = required_param("code", PARAM_TEXT);
$url = new moodle_url('/local/linkman/request.php', ['code' => $code]);

if (!isloggedin() or isguestuser()) {
    $SESSION->wantsurl = $url;
    redirect(get_login_url());
}
$context = context_system::instance();
$PAGE->set_context($context);
$PAGE->set_url($url);
$code_sql = $DB->sql_compare_text('code');
$record = $DB->get_record_sql('SELECT * FROM {local_linkman} WHERE ' . $code_sql . ' = :code ', ['code' => $code]);
if(!$record) {
    echo $OUTPUT->header();
    echo $OUTPUT->notification("Invalid code");
    echo $OUTPUT->footer();
} else {
    redirect($record->baselink);
}
