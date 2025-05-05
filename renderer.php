<?php

/**
 * True-false question renderer class.
 *
 * @package    qtype_logic
 */


defined('MOODLE_INTERNAL') || die();


/**
 * Generates the output for true-false questions.
 *
 */
class qtype_logic_renderer extends qtype_renderer {
    public function formulation_and_controls(question_attempt $qa, question_display_options $options) {
        global $PAGE, $OUTPUT;

        $question = $qa->get_question();
        $init_state = $question->initialstate;
        $question_id = $question->id;
        $question_name = $question->name;
        $question_text = $question->questiontext;

        $PAGE->requires->js_call_amd('qtype_logic/logic-editor', 'init');
        $PAGE->requires->js_call_amd('qtype_logic/result-upload', 'init');

        $template_data = [
            'question_name' => $question_name,
            'question_text' => $question_text,
            'init_state' => $init_state,
            'question_id' => $question_id,
        ];

        return $OUTPUT->render_from_template('qtype_logic/custom-template', $template_data);
    }

    public function specific_feedback(question_attempt $qa) {
        $question = $qa->get_question();
        $response = $qa->get_last_qt_var('answer', '');

        if ($response) {
            return $question->format_text($question->truefeedback, $question->truefeedbackformat,
                    $qa, 'question', 'answerfeedback', $question->trueanswerid);
        } else if ($response !== '') {
            return $question->format_text($question->falsefeedback, $question->falsefeedbackformat,
                    $qa, 'question', 'answerfeedback', $question->falseanswerid);
        }
    }

    public function correct_response(question_attempt $qa) {
        $question = $qa->get_question();

        if ($question->rightanswer) {
            return get_string('correctresponse', 'qtype_logic');
        } else {
            return get_string('incorrectresponse', 'qtype_logic');
        }
    }
}
