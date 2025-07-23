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

namespace qtype_logic;

use question_attempt_step;
use question_classified_response;
use question_display_options;
use question_state;

defined('MOODLE_INTERNAL') || die();

global $CFG;
require_once($CFG->dirroot . '/question/engine/tests/helpers.php');


/**
 * Unit tests for the logic circuit question definition class.
 *
 * @package    qtype_logic
 * @copyright  2008 The Open University
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
final class question_test extends \advanced_testcase {

	private string $jsonAnswerString;
	private string $correctTestResults;
	private string $semiCorrectTestResults;
	private string $incorrectTestResults;

	protected function setUp(): void {
		global $CFG;
		$this->jsonAnswerString = file_get_contents($CFG->dirroot . '/question/type/logic/tests/fixtures/2bit-decoder.json');
		$this->correctTestResults = file_get_contents($CFG->dirroot . '/question/type/logic/tests/fixtures/correct-test-results.json');
		$this->semiCorrectTestResults = file_get_contents($CFG->dirroot . '/question/type/logic/tests/fixtures/semi-correct-test-results.json');
		$this->incorrectTestResults = file_get_contents($CFG->dirroot . '/question/type/logic/tests/fixtures/incorrect-test-results.json');
	}

	public function test_is_complete_response(): void {
		$question = \test_question_maker::make_question('logic', 'test');

		$this->assertFalse($question->is_complete_response(array()));
		$this->assertFalse($question->is_complete_response(array('answer' => " ")));
		$this->assertFalse($question->is_complete_response(array('answer' => "", 'test_results' => " ")));
		$this->assertTrue($question->is_complete_response(array('answer' => $this->jsonAnswerString, 'test_results' => $this->jsonAnswerString)));

		$incorrectJSON = substr($this->jsonAnswerString, 0, -5);
		$this->assertFalse($question->is_complete_response(array('answer' => $incorrectJSON, 'test_results' => $incorrectJSON)));
	}

	public function test_grading(): void {
		$question = \test_question_maker::make_question('logic', 'test');

		$this->assertEquals(
			array(0, question_state::$gradedwrong),
			$question->grade_response(array('answer' => $this->jsonAnswerString, 'test_results' => $this->incorrectTestResults))
		);
		$this->assertEquals(
			array(1, question_state::$gradedright),
			$question->grade_response(array('answer' => $this->jsonAnswerString, 'test_results' => $this->correctTestResults))
		);
		$this->assertEquals(
			array(0.92, question_state::$gradedpartial),
			$question->grade_response(array('answer' => $this->jsonAnswerString, 'test_results' => $this->semiCorrectTestResults))
		);
	}

	public function test_get_question_summary(): void {
		$question = \test_question_maker::make_question('logic', 'test');
		$qsummary = $question->get_question_summary();
		$this->assertEquals($question->questiontext, $qsummary);
	}

	/*
	public function test_summarise_response(): void {
		$question = \test_question_maker::make_question('logic', 'test');

		$this->assertEquals(
			get_string('false', 'qtype_truefalse'),
			$question->summarise_response(array('answer' => '0')));

		$this->assertEquals(
			get_string('true', 'qtype_truefalse'),
			$question->summarise_response(array('answer' => '1')));
	}
	*/
}
