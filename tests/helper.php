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
 * Test helpers for the logiccircuit question type.
 *
 * @package    qtype
 * @subpackage logic
 * @copyright  2011 The Open University
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */


defined('MOODLE_INTERNAL') || die();


/**
 * Test helper class for the logic circuit question type.
 *
 * @copyright  2011 The Open University
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
class qtype_logiccircuit_test_helper extends question_test_helper {
    public function get_test_questions() {
        return array('test');
    }

    /**
     * Makes a logic circuit question.
     * @return qtype_logiccircuit_question
     */
    public function make_logiccircuit_question_test() {
		global $CFG;

        question_bank::load_question_definition_classes('logiccircuit');
        $q = new qtype_logiccircuit_question();
        test_question_maker::initialise_a_question($q);
        $q->name = 'Logic circuit question';
        $q->questiontext = 'Answer this question';
        $q->generalfeedback = 'General feedback.';
        $q->qtype = question_bank::get_qtype('logiccircuit');

        $q->options->initialstate = file_get_contents($CFG->dirroot . '/question/type/logiccircuit/tests/fixtures/2bit-decoder.json');

        return $q;
    }

    public function get_logiccircuit_question_form_data_test() {
		global $CFG;

        $form = new stdClass();
        $form->name = 'Logic circuit question';
        $form->questiontext = array();
        $form->questiontext['format'] = '1';
        $form->questiontext['text'] = 'Create a 2-bit decoder.';

        $form->defaultmark = 1;
        $form->generalfeedback = array();
        $form->generalfeedback['format'] = '1';
        $form->generalfeedback['text'] = 'You had to construct a 2-bit decoder.';

        $form->initialstate = file_get_contents($CFG->dirroot . '/question/type/logiccircuit/tests/fixtures/2bit-decoder.json');

        $form->status = \core_question\local\bank\question_version_status::QUESTION_STATUS_READY;

        return $form;
    }

    function get_logiccircuit_question_data_test() {
		global $CFG;

        $q = new stdClass();
        $q->name = 'Logic circuit question';
        $q->questiontext = 'Create a 2-bit decoder.';
        $q->questiontextformat = FORMAT_HTML;
        $q->generalfeedback = 'General feedback.';
        $q->generalfeedbackformat = FORMAT_HTML;
        $q->defaultmark = 1;
        $q->qtype = 'logiccircuit';
        $q->status = \core_question\local\bank\question_version_status::QUESTION_STATUS_READY;
        $q->createdby = '2';
        $q->modifiedby = '2';
        $q->options = new stdClass();
        $q->options->initialstate = file_get_contents($CFG->dirroot . '/question/type/logiccircuit/tests/fixtures/2bit-decoder.json');

        return $q;
    }
}
