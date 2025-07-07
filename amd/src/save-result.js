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
            const nextNavButton = $('input[type="submit"]#mod_quiz-next-nav.btn');

            const testResultsInput = $('input#test-results');
            const testResults = testResultsInput.data('test-results');
            if(testResults === undefined || testResults.length === 0) {
                nextNavButton.prop('disabled', true);
            }

            const runTestButton = $('button#circuit-run-test-button');

            runTestButton.on('click', async (_event) => {
                try {
                    const logicEditor = $('logic-editor#logic-editor')[0];

                    const userAnswer = logicEditor.save();
                    const testCases = userAnswer.tests[0];
                    console.log(logicEditor);
                    console.log(userAnswer);
                    console.log(testCases);
                    const testResults = await logicEditor.runTestSuite(testCases, { noUI: true });
                    const testResultsString = JSON.stringify(testResults);
                    console.log(testResults)

                    const userAnswerString = JSON.stringify(userAnswer);

                    // Update the input value here
                    $('input#answer').attr('value', userAnswerString);
                    $('input#test-results').attr('value', testResultsString);
                } catch(error) {
                    console.error(error);
                }

                nextNavButton.prop('disabled', false);
            });

            const resetButton = $('button#circuit-reset-button');

            resetButton.on('click', (_event) => {
                const initState = resetButton.data('init-state');
                const logicEditor = $('logic-editor#logic-editor')[0];

                logicEditor.loadCircuitOrLibrary(initState);
            });
        }
    };
});
