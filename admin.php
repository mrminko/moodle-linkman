<?php

require_once("../../config.php");
global $CFG, $DB, $USER, $OUTPUT, $PAGE;
require_once("./classes/form/link_add_form.php");

require_login();
$context = context_system::instance();
require_capability('local/linkman:view', $context);
$PAGE->set_context($context);
$page = optional_param("page", 0, PARAM_INT);
$link_count = $DB->count_records('local_linkman');
$url = new moodle_url('/local/linkman/admin.php');
$url->param('page', $page);
$PAGE->set_url($url);
$per_page = 10;

echo $OUTPUT->header();
if (has_capability('local/linkman:config', $context)) {
    echo html_writer::start_div('d-flex mb-2');
    echo html_writer::tag('button', 'Add new link', [
        'class' => 'btn btn-primary ml-auto linkman-add',
    ]);
    echo html_writer::end_div();
}

if (has_capability('local/linkman:view', $context)) {
    $links = $DB->get_records('local_linkman', [], 'created DESC', '*', ($page * $per_page), $per_page);
    echo $OUTPUT->render_from_template('local_linkman/admin_dashboard', ['data' => array_values($links)]);
    $PAGE->requires->js_call_amd('local_linkman/addlink', 'init');
    $pagingbar = new paging_bar($link_count, $page, $per_page, $url);
    echo $OUTPUT->render($pagingbar);
} else {
    echo "You do not have necessary permissions to view this page. Contact the administrator.";
}
echo $OUTPUT->footer();