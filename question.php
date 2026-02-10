<?php

/**
 * Logic circuit question definition class.
 *
 * @package    qtype_logiccircuit
 * @copyright  2025 Groupe Modulo
 * @license    CC BY-NC-SA
 */

use ColinODell\Json5\SyntaxError;

defined('MOODLE_INTERNAL') || die();

require_once($CFG->dirroot . '/question/type/questionbase.php');
require_once($CFG->dirroot . '/question/type/logiccircuit/vendor/autoload.php');

/**
 * Represents a logic circuit question.
 *
 */
class qtype_logiccircuit_question extends question_graded_automatically {
    public $initialstate;
    public $editormode;
    public $componentstoshow;

    public function get_expected_data() {
        debugging("Getting expected data...", DEBUG_DEVELOPER);
        return array(
            'answer' => PARAM_RAW,
            'test_results' => PARAM_RAW
        );
    }

    public function get_correct_response() {
        return null;
    }

    public function summarise_response(array $response) {
        debugging("Summarising responses...", DEBUG_DEVELOPER);
        debugging(print_r($response, true), DEBUG_DEVELOPER);

        $result = "";
        $testResults = $response['test_results'];
        $responseAnalysis = $this->analyse_response($testResults);
        $testSummary = $responseAnalysis['test_summary'];

        foreach ($testSummary as $testName => $testResult) {
            $result .= "Test $testName : $testResult\n";
        }

        return $result;
    }

    // TODO do we need to classify the response ?
    public function classify_response(array $response) {
        debugging("Classifying response...", DEBUG_DEVELOPER);

        return array();
    }

    public function is_complete_response(array $response) {
        debugging("Is complete response ?");

        if(!isset($response['answer']) || !isset($response['test_results'])) {
            return false;
        }

        debugging(print_r($response['answer'], true), DEBUG_DEVELOPER);
        debugging(print_r($response['test_results'], true), DEBUG_DEVELOPER);

        try {
            json5_decode($response['answer']);
            json5_decode($response['test_results']);
        } catch (TypeError | SyntaxError $error) {
            //error_log($error->getMessage());
            return false;
        }

        return (array_key_exists('answer', $response) && isset($response['answer'])) &&
            (array_key_exists('test_results', $response) && isset($response['test_results']));
    }

    public function get_validation_error(array $response) {
        if ($this->is_gradable_response($response)) {
            return '';
        }
        return get_string('answer_incomplete', 'qtype_logiccircuit');
    }

    public function is_same_response(array $prevresponse, array $newresponse) {
        error_log("Is same response ?");
        error_log(print_r($prevresponse, true));
        error_log(print_r($newresponse, true));

        if(!$this->notEmptyResponse($prevresponse) && !$this->notEmptyResponse($newresponse)) {
            return true;
        } else if(!$this->notEmptyResponse($prevresponse)) {
            return false;
        } else {
            $prevResponseParsed = json5_decode($prevresponse['answer'], true);
            $newResponseParsed = json5_decode($newresponse['answer'], true);

            $diff = array_diff($prevResponseParsed, $newResponseParsed);

            if(empty($diff[0])) {
                return true;
            } else {
                return false;
            }
        }
    }

    public function grade_response(array $response) {
        debugging("Grading response...", DEBUG_DEVELOPER);
        debugging(print_r($response, true), DEBUG_DEVELOPER);

        $testResults = $response['test_results'];
        $responseAnalysis = $this->analyse_response($testResults);
        $fraction = $responseAnalysis['fraction'];

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

    private function analyse_response(string $testResults) {
        $totalTests = 0;
        $successfullTests = 0;

        $testResultsArray = json5_decode($testResults, true);
        $firstOfResultsArray = $testResultsArray[0];

        $testCaseResults = $firstOfResultsArray['testCaseResults'];

        if($testCaseResults) {
            $testSummaryArray = array();

            foreach ($testCaseResults as $testCaseResult) {
                $totalTests += 1;

                $testCaseDescription = $testCaseResult[0];
                $testName = $testCaseDescription['name'];

                $testResult = $testCaseResult[1];
                $testTag = $testResult['_tag'];

                $testSummaryArray[$testName] = $testTag;

                if ($testTag == 'pass') {
                    $successfullTests += 1;
                }
            }

            $fraction = round($successfullTests / $totalTests, 2);

            return array(
                'fraction' => $fraction,
                'test_summary' => $testSummaryArray
            );
        } else {
            return array(
                'fraction' => 0,
                'test_summary' => []
            );
        }
    }

    private function notEmptyResponse(array $response) {
        return (isset($response['answer']) && !empty($response['answer'])) &&
            (isset($response['test_results']) && !empty($response['test_results']));
    }
}
