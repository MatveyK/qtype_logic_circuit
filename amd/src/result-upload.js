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

const sendResultToDatabase = async (answer, result) => {
    const container = document.querySelector('.data-container');
    if(!container) {
        console.log('container not found !');
    }
    const questionId = container.getAttribute('question-id-param');

    const moodleReq = await fetch(`${M.cfg.wwwroot}/question/type/logic/ajax.php?question_id=${encodeURIComponent(questionId)}&answer=${encodeURIComponent(answer)}&result=${encodeURIComponent(result)}`, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-Requested-With': 'XMLHttpRequest'
        },
        credentials: 'same-origin' // Ensures Moodle session cookie is sent
    });

    if(!moodleReq.ok) {
        throw new Error('Did not work');
    } else {
        console.log('Request worked.');
    }
};

export const init = () => {
    window.sendResultToDatabase = sendResultToDatabase;
    window.addEventListener("send-result", () => {
        // TODO pass the params and call the sendResult function
    })
};

