const table = document.getElementById("table");
const tableWidthInput = document.getElementById('table-width');
const tableHeightInput = document.getElementById('table-height');
const answer = document.getElementById("answer");

tableWidthInput.addEventListener('input', updateTableSize);
tableHeightInput.addEventListener('input', updateTableSize);


function updateTableSize() {
    const width = parseInt(tableWidthInput.value);
    const height = parseInt(tableHeightInput.value);

    let html = '';

    for (let i = 0; i < height; i++) {
        html += '<tr>';

        for (let j = 0; j < width; j++) {
            html += `<td style="color:white;">[${i},${j}] <input type="number" pattern="[0-9]+" name="row${i}${j}" id="row${i}${j}"></td>`;
        }

        html += '</tr>';
    }

    table.innerHTML = html;
}

function Calculate() {
    // get info from form to php
    const rows = table.querySelectorAll('tr');
    const maze = [];
    try {
        rows.forEach(function (row) {
            const cell = table.querySelectorAll('td');
            const rowArray = [];

            cell.forEach(element => {
                const value = parseInt(element.querySelector('input').value);
                rowArray.push(value);
            });

            maze.push(rowArray);
        });
    } catch (e) {
        alert(e);
    }
    $.ajax({
        url: "index.php",
        type: "POST",
        data: {maze: maze},
        success: function(response) {
            console.log(response);
        },
        error: function(xhr) {
            console.log(xhr.responseText);
        }
    });
    
    notification("Calculate succesfull");
    
}


function notification(message) {
    try {
        var notification = document.getElementById('notification');
        notification.style.display = 'flex';
        notification.innerHTML += message;
        setTimeout(function () {
            notification.style.display = 'none';
            notification.innerHTML = '';
        }, 650);
    } catch (e) {
        console.log(e);
    }
}

const modal = document.querySelector('.modal');
const closeButtons = document.querySelectorAll('.close-modal');
modal.classList.toggle('modal-open');

document.querySelector('.open-modal').addEventListener('click', function () {
    modal.classList.toggle('modal-open');
});

for (i = 0; i < closeButtons.length; ++i) {
    closeButtons[i].addEventListener('click', function () {
        modal.classList.toggle('modal-open');
    });
}

document.querySelector('.modal-inner').addEventListener('click', function () {
    modal.classList.toggle('modal-open');
});

document.querySelector('.modal-content').addEventListener('click', function (e) {
    e.stopPropagation();
});