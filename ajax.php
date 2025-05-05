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

/**
 * TODO describe file ajax
 *
 * @package    qtype_logic
 * @copyright  2025 YOUR NAME <your@email.com>
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

use core\router\schema\response\payload_response;

define('AJAX_SCRIPT', true);  // Required for AJAX requests
require_once('../../../config.php');
require_once($CFG->libdir . '/ajax/ajaxlib.php');
require_once($CFG->dirroot . '/question/type/logic/locallib.php');

require_login();
//$context = context_course::instance();
//require_capability('moodle/course:view', $context); // Adjust as needed

$questionid = required_param('question_id', PARAM_INT);
$answer = required_param('answer', PARAM_RAW);
$result = required_param('result', PARAM_RAW);

// Here, call a function to store the result in the database
$status = store_result_in_database($questionid, $answer, $result);  // You need to create this function in locallib.php

// Return a response
if ($status) {
    $response = json_encode(['status' => 'success', 'message' => 'Result saved successfully']);
} else {
    $response = json_encode(['status' => 'error', 'message' => 'Failed to save result']);
}

// Send JSON response back
header('Content-Type: application/json');
echo json_encode($response);
exit;
