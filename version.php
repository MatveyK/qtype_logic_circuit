<?php
/**
 * logic question type version information.
 *
 * @package    qtype_logic
 * @copyright  Modulo 2025
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

 defined('MOODLE_INTERNAL') || die();

 $plugin->component = 'qtype_logic';
 $plugin->version  = 2025032100;
 $plugin->requires = 2022040100;  // Moodle 4.0.
 $plugin->supported = [404, 405];
 $plugin->maturity  = MATURITY_ALPHA;
 $plugin->release  = 'v0.0.1';
