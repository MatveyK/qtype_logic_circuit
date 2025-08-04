<?php

defined('MOODLE_INTERNAL') || die();

require_once($CFG->libdir . '/questionlib.php');

/**
 * The true-false question type class.
 */
class qtype_logiccircuit extends question_type {
    public function extra_question_fields() {
        return array('question_logiccircuit', 'initialstate');
    }

    public function save_question($question, $form) {
        return parent::save_question($question, $form);
    }

    public function save_question_options($question) {
        return parent::save_question_options($question);
    }

    public function get_question_options($question) {
        return parent::get_question_options($question);
    }
}
