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
                    ]),
                ),
                'error' => new external_value(PARAM_TEXT, 'error message', VALUE_OPTIONAL),
            ])
        ], 'data to be displayed', VALUE_OPTIONAL);
    }

    public static function execute($action, $payload) {
        global $CFG, $DB;
        $params = self::validate_parameters(self::execute_parameters(), ['action' => $action, 'payload' => $payload]);
        $result = new \stdClass();
        $result->success = true;
        $result->data = new stdClass();
        $item = new stdClass();
        $item->id = 1;
        $item->name = 'mgmg';
        $item->code = 'uadf';
        $item->created = 'ndfa';
        $item->baselink = 'fdfasa';
        $item->note = 'noteeeee';
//        $items = ['id' => 1, 'name' => 'mgmg', 'code' => 'uier', 'created' => 'jkfas', 'baselink' => 'base', 'note' => 'ndhfakl'];
        $result->data->items = [$item];
        return $result;
    }
}