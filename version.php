<?php
/**
 * logic question type version information.
 *
 * @package    qtype_logiccircuit
 * @copyright  2025 Groupe Modulo
 * @license    CC BY-NC-SA
 */

defined('MOODLE_INTERNAL') || die();

$plugin->component = 'qtype_logiccircuit';
$plugin->version  = 2025032100;
$plugin->requires = 2022040100;  // Moodle 4.0.
$plugin->supported = [404, 405];
$plugin->maturity  = MATURITY_RC;
$plugin->release  = 'v0.1.0';
