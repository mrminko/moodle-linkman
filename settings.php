<?php
$systemcontext = context_system::instance();
if ($hassiteconfig
    or has_capability('moodle/user:create', $systemcontext)
    or has_capability('moodle/user:update', $systemcontext)
    or has_capability('moodle/user:delete', $systemcontext)
    or has_capability('moodle/role:manage', $systemcontext)
    or has_capability('moodle/role:assign', $systemcontext)) {
    $ADMIN->add('root', new admin_externalpage('linkmanadminpage', get_string('pluginname', 'local_linkman'), "$CFG->wwwroot/local/linkman/admin.php", 'local/linkman:view'));
}
