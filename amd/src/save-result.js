/**
 * Saves the logic circuit editor state on form submission.
 *
 * @package    qtype_logiccircuit/save-result
 * @copyright  2025 Groupe Modulo
 * @license    CC BY-NC-SA
 */
define(['jquery'], function($) {
    return {
        init: function() {
            // Remove this as soon as the autosave to session storage is deactivated in the logic circuit editor
            sessionStorage.clear('logic/logic-editor');

            const nextNavButton = $('input[type="submit"]#mod_quiz-next-nav.btn');
            const resultNotUploadedIcon = $('i#result_not_uploaded');
            const newResultUploadedIcon = $('i#new_result_uploaded');

            const testResultsInput = $('input#test-results');
            const testResults = testResultsInput.attr('value');

            console.log(testResults);

            // Block quiz progression until the user submits a result
            if(testResults === undefined || testResults.length === 0) {
                nextNavButton.prop('disabled', true);
                resultNotUploadedIcon.css('display', 'block');
                newResultUploadedIcon.css('display', 'none');
            } else {
                nextNavButton.prop('disabled', false);
                resultNotUploadedIcon.css('display', 'none');
                newResultUploadedIcon.css('display', 'block');
            }

            const runTestButton = $('button#circuit-run-test-button');

            runTestButton.on('click', async (_event) => {
                try {
                    const logicEditor = $('logic-editor#logic-editor')[0];

                    const userAnswer = logicEditor.save();
                    const userAnswerString = JSON.stringify(userAnswer);
                    const testCases = userAnswer.tests[0];
                    const testResults = await logicEditor.runTestSuite(testCases, { noUI: true });
                    const testResultsString = JSON.stringify(testResults);

                    console.log(logicEditor);
                    console.log(userAnswer);
                    console.log(testCases);
                    console.log(testResults)

                    // Update the input value here
                    $('input#answer').attr('value', userAnswerString);
                    $('input#test-results').attr('value', testResultsString);
                } catch(error) {
                    console.error(error);
                }

                nextNavButton.prop('disabled', false);
                resultNotUploadedIcon.css('display', 'none');
                newResultUploadedIcon.css('display', 'block');
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
