<?php

/**
 * Defines the editing form for the logic circuit question type.
 *
 * @package    qtype/logic
 */


defined('MOODLE_INTERNAL') || die();

require_once($CFG->dirroot.'/question/type/edit_question_form.php');

/**
 * Logic circuit question editing form definition.
 *
 */
class qtype_logic_edit_form extends question_edit_form {

    /**
     * Add logic circuit specific form fields.
     *
     * @param object $mform the form being built.
     */
    protected function definition_inner($mform) {
        $mform->addElement(
            'textarea',
            'initialstate',
            get_string('initialstate', 'qtype_logic'),
            'wrap="virtual" rows="20" cols="50"'
        );
        $mform->addHelpButton('initialstate', 'initialstate', 'qtype_logic');
        $mform->setType('initialstate', PARAM_RAW);
    }

    public function data_preprocessing($question) {
        $question = parent::data_preprocessing($question);

        // Format the JSON5 value here

        return $question;
    }

    // TODO validate the JSON5 inputs
    /*
    public function validation($data, $files) {
        $errors = array();

        $initState = $data['initialstate'];
        if (!empty($initState) && !json_validate($initState)) {
            $errors['initialstate'] = get_string('not_valid_json', 'qtype_logic');
        }

        return $errors;

    }
    */

    public function qtype() {
        return 'logic';
    }
}
