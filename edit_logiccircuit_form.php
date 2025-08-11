<?php

/**
 * Defines the editing form for the logic circuit question type.
 *
 * @package    qtype_logiccircuit
 * @copyright  2025 Groupe Modulo
 * @license    CC BY-NC-SA
 */


defined('MOODLE_INTERNAL') || die();

require_once($CFG->dirroot.'/question/type/edit_question_form.php');
require_once($CFG->dirroot . '/question/type/logiccircuit/vendor/autoload.php');
use ColinODell\Json5\SyntaxError;

/**
 * Logic circuit question editing form definition.
 *
 */
class qtype_logiccircuit_edit_form extends question_edit_form {

    /**
     * Add logic circuit specific form fields.
     *
     * @param object $mform the form being built.
     */
    protected function definition_inner($mform) {
        $mform->addElement(
            'textarea',
            'initialstate',
            get_string('initialstate', 'qtype_logiccircuit'),
            'wrap="virtual" rows="20" cols="50"'
        );
        $mform->addHelpButton('initialstate', 'initialstate', 'qtype_logiccircuit');
        $mform->setType('initialstate', PARAM_RAW);
    }

    public function validation($data, $files) {
        $errors = array();
        $initState = $data['initialstate'];

        if (empty($initState)) {
            $errors['initialstate'] = get_string('initial_state_empty', 'qtype_logiccircuit');
        }

        try {
            json5_decode($initState);
        } catch (TypeError | SyntaxError) {
            $errors['initialstate'] = get_string('not_valid_json', 'qtype_logiccircuit');
        }

        return $errors;
    }

    public function qtype() {
        return 'logiccircuit';
    }
}
