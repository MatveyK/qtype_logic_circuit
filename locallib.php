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
 * TODO describe file locallib
 *
 * @package    qtype_logic
 * @copyright  2025 YOUR NAME <your@email.com>
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

 function store_result_in_database($question_id, $answer, $result) {
  global $DB;

  // Question attempt example.
  /*
  $questionattemptdata = new stdClass();
  $questionattemptdata->questionid = $questionid; // the ID of the question
  $questionattemptdata->attempt = $attemptid; // the ID of the quiz attempt
  $questionattemptdata->userid = $USER->id; // the ID of the user
  $questionattemptdata->timefinish = time(); // current timestamp
  $questionattemptdata->state = 'finished'; // state of the question attempt (e.g., finished, incomplete)
  $questionattemptdata->fraction = $score; // the score fraction (0.0 to 1.0)
  $questionattemptdata->timecreated = time(); // the timestamp of creation
  $questionattemptdata->timemodified = time(); // the timestamp when modified


  // Assuming you want to insert or update based on the question_attempt ID
  $existingattempt = $DB->get_record('question_attempts', ['questionid' => $questionid, 'attempt' => $attemptid, 'userid' => $USER->id]);

  if ($existingattempt) {
      // If the attempt exists, update it
      $questionattemptdata->id = $existingattempt->id;
      $DB->update_record('question_attempts', $questionattemptdata);
  } else {
      // If it does not exist, insert a new attempt record
      $DB->insert_record('question_attempts', $questionattemptdata);
  }
  */

  $answer_record = new stdClass();
  $answer_record->id = null;
  $answer_record->question = $question_id;
  $answer_record->answer = $answer;
  $answer_record->answerformat = FORMAT_PLAIN;
  $answer_record->fraction = $result;
  $answer_record->feedback = "TEST FEEDBACK";

  /*
  $existing_answer = $DB->get_record('question_answers', ['question' => $question_id]);
  error_log("DB ANSWER " . print_r($existing_answer, true));

  if($existing_answer) {
    $record->id = $existing_answer->id;
    return $DB->update_record('question_answers', $record);
  } else {
    return $DB->insert_record('question_answers', $record);
  }
  */

  return $DB->insert_record('question_answers', $answer_record);
}
