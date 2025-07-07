<?php

/**
 * True-false question renderer class.
 *
 * @package    qtype_logic
 */


defined('MOODLE_INTERNAL') || die();


/**
 * Renders the logic-editor questions.
 */
class qtype_logic_renderer extends qtype_renderer {
    public function formulation_and_controls(question_attempt $qa, question_display_options $options) {
        global $PAGE, $OUTPUT;

        $question = $qa->get_question();
        $init_state = $question->initialstate;
        $question_name = $question->name;
        $question_text = $question->questiontext;

        $response = $qa->get_last_qt_data();
        $answer_input_name = $qa->get_qt_field_name('answer');
        $test_results_input_name = $qa->get_qt_field_name('test_results');
        $current_answer = isset($response['answer']) ? $response['answer'] : '';
        $current_test_results = isset($response['test-results']) ? $response['test-results'] : '';

        $PAGE->requires->js_call_amd('qtype_logic/logic-editor', 'init');
        $PAGE->requires->js_call_amd('qtype_logic/save-result', 'init');


        $template_data = [
            'question_name' => $question_name,
            'question_text' => $question_text,
            'init_state' => $init_state,
            'answer_name' => $answer_input_name,
            'test_results_name' => $test_results_input_name,
            'answer_value' => $current_answer,
            'test_results_value' => $current_test_results
        ];

        return $OUTPUT->render_from_template('qtype_logic/logic-editor', $template_data);
    }

    # TODO improve the specific feedback in case of failure
    /*
    public function specific_feedback(question_attempt $qa) {
        $resultAnalysis = $qa->get_response_summary();

        if ($resultAnalysis) {
            return $resultAnalysis;
        }
    }
    */

    public function correct_response(question_attempt $qa) {
        $question = $qa->get_question();

        if ($question->rightanswer) {
            return $question->rightanswer;
        } else {
            return "";
        }
    }
}
