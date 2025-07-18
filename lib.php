<?php

/**
 * Serve question type files
 *
 * @package    qtype_logic
 */

defined('MOODLE_INTERNAL') || die();

/**
 * Checks file access for true-false questions.
 * @package  qtype_truefalse
 * @category files
 * @param stdClass $course course object
 * @param stdClass $cm course module object
 * @param stdClass $context context object
 * @param string $filearea file area
 * @param array $args extra arguments
 * @param bool $forcedownload whether or not force download
 * @param array $options additional options affecting the file serving
 * @return bool
 */
function qtype_logic_pluginfile($course, $cm, $context, $filearea, $args, $forcedownload, array $options=array()) {
    global $CFG;
    require_once($CFG->libdir . '/questionlib.php');
    question_pluginfile($course, $context, 'qtype_logic', $filearea, $args, $forcedownload, $options);
}
