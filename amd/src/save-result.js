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
 * Saves the logic editor state on form submission.
 *
 * @module     qtype_logic/save-result
 * @copyright  2025 YOUR NAME <your@email.com>
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
define(['jquery'], function($) {
    return {
        init: function() {
            // Listen to when the question is changed (via form submission or ajax reload)
            $(document).on('submit', 'form#responseform', function(e) {
                const logicEditor = $('logic-editor#logic-editor')[0];
                const userAnswer = logicEditor.save();
                const userAnswerString = JSON.stringify(userAnswer);
                // Update the input value here
                $('input#answer').attr('value', userAnswerString);
                console.log($('input#answer')[0])
                console.log('first');
            });

            /*
            $(document).on('click', 'input[type="submit"]#mod_quiz-next-nav.btn', function(e) {
              $('input#answer').attr('value', 'cacaValue');
              console.log($('input#answer'));
              console.log('clicked');
            });
            */
        }
    };
});
