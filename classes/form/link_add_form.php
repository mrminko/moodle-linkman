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

        $mform->addElement('hidden', 'id');
        $mform->setType('id', PARAM_INT);
        $mform->setDefault('id', 0);

        $mform->addElement('text', 'name', get_string('link_name', 'local_linkman'), array('size' => 30, 'maxlength' => 20));
        $mform->setType('name', PARAM_TEXT);
        $mform->addRule('name', get_string('required'), 'required', null, 'client');

        $mform->addElement('text', 'baselink', get_string('base_link', 'local_linkman'), array('size' => 50, 'maxlength' => 70));
        $mform->setType('baselink', PARAM_URL);
        $mform->addRule('baselink', get_string('required'), 'required', null, 'client');

        $mform->addElement('text', 'note', get_string('link_note', 'local_linkman'), array('size' => 50, 'maxlength' => 100));
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
        $result = new \stdClass();
        $result->success = false;
        if($data->id) {
            $data->updated = time();
            $updated = $DB->update_record('local_linkman', $data);
            if ($updated) {
                $result->success = true;
                $result->id = $updated;
                $result->data = $data;
            } else {
                $result->success = false;
            }
        } else {
            $data->created = time();
            $data->code = random_string();
            $inserted = $DB->insert_record('local_linkman', $data);
            if ($inserted) {
                $result->success = true;
                $result->id = $inserted;
                $result->data = $DB->get_record('local_linkman', ['id' => $inserted]);
            } else {
                $result->success = false;
            }
        }

        return $result;
    }

    public function set_data_for_dynamic_submission(): void
    {
        $action = $this->_ajaxformdata['action'];
        if ($action === 'EDIT_ITEM') {
            $data = $this->_ajaxformdata['data'];
            $this->set_data(['id' => $data['id'], 'name' => $data['name'], 'baselink' => $data['base_link'], 'note' => $data['note']]);
        }
    }

    protected function get_page_url_for_dynamic_submission(): moodle_url
    {
        global $PAGE;
        return $PAGE->url;
    }
}