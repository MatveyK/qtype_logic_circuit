<?php
/**
 * Logic circuit question type class.
 *
 * @package    qtype_logiccircuit
 * @copyright  2025 Groupe Modulo
 * @license    CC BY-NC-SA
 */

defined('MOODLE_INTERNAL') || die();

require_once($CFG->libdir . '/questionlib.php');

/**
 * The Logic Circuit question type class.
 */
class qtype_logiccircuit extends question_type {
    public function extra_question_fields() {
        return array('question_logiccircuit', 'initialstate');
    }
}
