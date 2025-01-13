<?php

//defined('MOODLE_INTERNAL') || die();
namespace local_linkman\form;
use context;
use core_form\dynamic_form;
use moodle_url;
use context_system;
use \core\uuid;

class link_add_form extends dynamic_form {
    protected function definition() {
        $mform = $this->_form;

        $mform->addElement('text', 'name', get_string('link_name', 'local_linkman'), array('size' => 60, 'maxlength' => 128));
        $mform->setType('name', PARAM_TEXT);
        $mform->addRule('name', get_string('required'), 'required', null, 'client');

        $mform->addElement('text', 'baselink', get_string('base_link', 'local_linkman'));
        $mform->setType('baselink', PARAM_URL);
        $mform->addRule('baselink', get_string('required'), 'required', null, 'client');

        $mform->addElement('textarea', 'note', get_string('link_note', 'local_linkman'));
        $mform->setType('note', PARAM_TEXT);
    }

    protected function get_context_for_dynamic_submission(): context
    {
        return context_system::instance();
    }

    protected function check_access_for_dynamic_submission(): void
    {
        require_capability('local/linkman:config', context_system::instance());
    }

    public function process_dynamic_submission()
    {
        global $CFG, $DB;
        $data = $this->get_data();
        $data->created = time();
        $data->code = random_string();
        $inserted = $DB->insert_record('local_linkman', $data);
        $result = new \stdClass();
        if ($inserted) {
            $result->success = true;
            $result->id = $inserted;
            $result->data = $DB->get_record('local_linkman', ['id' => $inserted]);
        } else {
            $result->success = false;
        }
        return $result;
    }

    public function set_data_for_dynamic_submission(): void
    {

        $this->set_data([]);
    }

    protected function get_page_url_for_dynamic_submission(): moodle_url
    {
        global $PAGE;
        return $PAGE->url;
    }
}