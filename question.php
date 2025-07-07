<?php

/**
 * True-false question definition class.
 *
 * @package    qtype_logic
 * @copyright  2009 The Open University
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */


defined('MOODLE_INTERNAL') || die();

require_once($CFG->dirroot . '/question/type/questionbase.php');

/**
 * Represents a logic circuit question.
 *
 */
class qtype_logic_question extends question_graded_automatically {
    public $initialstate;

    public $rightanswer;
    public $truefeedback;
    public $falsefeedback;
    public $trueanswerid;
    public $falseanswerid;

    public function get_expected_data() {
        error_log("Getting expected data...");
        return array(
            'answer' => PARAM_RAW,
            'test_results' => PARAM_RAW
        );
    }

    public function get_correct_response() {
        return null;
    }

    public function summarise_response(array $response) {
        error_log("Summarising responses...");
        error_log(print_r($response, true));

        if (!array_key_exists('answer', $response)) {
            return null;
        } else if ($response['answer']) {
            return get_string('true', 'qtype_truefalse');
        } else {
            return get_string('false', 'qtype_truefalse');
        }
    }

    public function un_summarise_response(string $summary) {
        if ($summary === get_string('true', 'qtype_truefalse')) {
            return ['answer' => '1'];
        } else if ($summary === get_string('false', 'qtype_truefalse')) {
            return ['answer' => '0'];
        } else {
            return [];
        }
    }

    public function classify_response(array $response) {
        error_log("Classifying response...");
        error_log(print_r($response, true));

        if (!array_key_exists('answer', $response)) {
            return array($this->id => question_classified_response::no_response());
        }
        list($fraction) = $this->grade_response($response);
        if ($response['answer']) {
            return array($this->id => new question_classified_response(1,
                    get_string('true', 'qtype_truefalse'), $fraction));
        } else {
            return array($this->id => new question_classified_response(0,
                    get_string('false', 'qtype_truefalse'), $fraction));
        }
    }

    public function is_complete_response(array $response) {
        error_log("Is complete response ?");
        error_log(print_r($response['answer']), true);
        error_log(print_r($response['test_results']), true);

        return array_key_exists('answer', $response) && array_key_exists('test_results', $response);
    }

    public function get_validation_error(array $response) {
        if ($this->is_gradable_response($response)) {
            return '';
        }
        return get_string('pleaseselectananswer', 'qtype_logic');
    }

    public function is_same_response(array $prevresponse, array $newresponse) {
        error_log("Is same response ?");
        error_log(print_r($prevresponse, true));
        error_log(print_r($newresponse, true));

        if(!isset($prevresponse) || empty($prevresponse)) {
            return false;
        }

        $prevResponseParsed = json_decode($prevresponse['answer'], true);
        $newResponseParsed = json_decode($newresponse['answer'], true);

        $diff = array_diff($prevResponseParsed, $newResponseParsed);

        if(empty($diff[0])) {
            return true;
        } else {
            return false;
        }
    }

    public function grade_response(array $response) {
        error_log("Grading response...");
        error_log(print_r($response, true));

        $totalTests = 0;
        $successfullTests = 0;

        $testResultsString = $response['test_results'];
        $testResults = json_decode($testResultsString, true);

        $testCaseResults = $testResults['testCaseResults'];

        foreach ($testCaseResults as $testCaseResult) {
            $totalTests += 1;

            $testObject = $testCaseResult[1];
            $testTag = $testObject['_tag'];

            if ($testTag == 'pass') {
                $successfullTests += 1;
            }
        }

        $fraction = $successfullTests / $totalTests;
        return array($fraction, question_state::graded_state_for_fraction($fraction));
    }

    public function check_file_access($qa, $options, $component, $filearea, $args, $forcedownload) {
        return parent::check_file_access(
            $qa,
            $options,
            $component,
            $filearea,
            $args,
            $forcedownload
        );
    }

    /**
     * Return the question settings that define this question as structured data.
     *
     * @param question_attempt $qa the current attempt for which we are exporting the settings.
     * @param question_display_options $options the question display options which say which aspects of the question
     * should be visible.
     * @return mixed structure representing the question settings. In web services, this will be JSON-encoded.
     */
    public function get_question_definition_for_external_rendering(question_attempt $qa, question_display_options $options) {
        // No need to return anything, external clients do not need additional information for rendering this question type.
        return null;
    }
}
