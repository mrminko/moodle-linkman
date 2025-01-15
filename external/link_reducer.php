<?php

namespace local_linkman\external;
use core_external\external_function_parameters;
use core_external\external_multiple_structure;
use core_external\external_single_structure;
use core_external\external_value;
use stdClass;

class link_reducer extends \core_external\external_api {
    public static function execute_parameters() {
        return new external_function_parameters([
            'action' => new external_value(PARAM_TEXT, 'reducer action', VALUE_REQUIRED),
            'payload' => new external_single_structure([
                'id' => new external_value(PARAM_INT, 'item id for CRUD', VALUE_OPTIONAL),
                'page' => new external_value(PARAM_INT, 'page', VALUE_OPTIONAL),
            ], 'payload to be consumed by backend', VALUE_OPTIONAL),
        ]);
    }

    public static function execute_returns() {
        return new external_single_structure([
            'success' => new external_value(PARAM_BOOL, 'success or failure', VALUE_REQUIRED),
            'data' => new external_single_structure([
                'items' => new external_multiple_structure(
                    new external_single_structure([
                        'id' => new external_value(PARAM_INT, 'item id'),
                        'name' => new external_value(PARAM_TEXT, 'item name'),
                        'code' => new external_value(PARAM_TEXT, 'item code'),
                        'created' => new external_value(PARAM_TEXT, 'item created'),
                        'baselink' => new external_value(PARAM_TEXT, 'item base link'),
                        'note' => new external_value(PARAM_TEXT, 'item note'),
                    ]), 'items to display', VALUE_OPTIONAL,
                ),
                'error' => new external_value(PARAM_TEXT, 'error message', VALUE_OPTIONAL),
            ],'data to be displayed', VALUE_OPTIONAL)
        ]);
    }

    public static function execute($action, $payload) {
        global $CFG, $DB;
        $params = self::validate_parameters(self::execute_parameters(), ['action' => $action, 'payload' => $payload]);
        $result = new \stdClass();
        $result->success = false;
        $result->data = new stdClass();
        switch ($params['action']) {
            case 'DELETE_ITEM':
                $id = $params['payload']['id'];
                try {
                    $deleted = $DB->delete_records('local_linkman', ['id' => $id]);
                    if ($deleted) {
                        $result->success = true;
                    } else {
                        $result->success = false;
                    }
                } catch (\Exception $e) {
                    $result->success = false;
                }
                break;
            default:
                $result->data->error = "Error when deleting record.";
                break;
        }
        return $result;
    }
}