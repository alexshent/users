"use strict";

const userForm = 'user_form';

const tableBody = 'users_table';

const inputUserId = 'input_id';
const inputUserFirstName = 'input_first_name';
const inputUserSecondName = 'input_second_name';
const selectUserPosition = 'select_position';

const saveUserButton = 'save_user_button';

function apiDeleteUser(user) {
    const url = '/api/delete-user';

    fetch(url, {
    method: 'POST',
    headers: {
        'Content-Type': 'application/json',
    },
    body: JSON.stringify(user),
    })
    .then((response) => response.json())
    .then((data) => {
        console.log('Success:', data);
        resetUserForm();
        getAllUsers();
    })
    .catch((error) => {
        console.error('Error:', error);
    });
}

function apiSaveUser(user) {
    const url = '/api/save-user';

    fetch(url, {
    method: 'POST',
    headers: {
        'Content-Type': 'application/json',
    },
    body: JSON.stringify(user),
    })
    .then((response) => response.json())
    .then((data) => {
        console.log('Success:', data);
    })
    .catch((error) => {
        console.error('Error:', error);
    });
}

function resetUserForm() {
    const userFormElement = document.getElementById(userForm);
    userFormElement.reset();
}

function readUserForm() {
    let user = {};
    const inputUserIdElement = document.getElementById(inputUserId);
    const inputUserFirstNameElement = document.getElementById(inputUserFirstName);
    const inputUserSecondNameElement = document.getElementById(inputUserSecondName);
    const selectUserPositionElement = document.getElementById(selectUserPosition);
    user.id = inputUserIdElement.value;
    user.firstName = inputUserFirstNameElement.value;
    user.secondName = inputUserSecondNameElement.value;
    user.position = selectUserPositionElement.value;
    return user;
}

function copyUserToForm(user) {
    const inputUserIdElement = document.getElementById(inputUserId);
    const inputUserFirstNameElement = document.getElementById(inputUserFirstName);
    const inputUserSecondNameElement = document.getElementById(inputUserSecondName);
    const selectUserPositionElement = document.getElementById(selectUserPosition);
    inputUserIdElement.value = user.id;
    inputUserFirstNameElement.value = user.firstName;
    inputUserSecondNameElement.value = user.secondName;
    selectUserPositionElement.value = user.position;
}

function getAllUsers() {
    const url = "/api/get-all-users";
        
    fetch(url)
    .then(response => response.json())
    .then(data => {
        updateUsersTable(data.users);
    });
}

function updateUsersTable(users) {
    let tableBodyHtml = '';
    users.forEach(user => {
        tableBodyHtml += '<tr onclick="tableRowClick(this)">';

        tableBodyHtml += '<td data-type="id">';
        tableBodyHtml += user.id;
        tableBodyHtml += '</td>';

        tableBodyHtml += '<td data-type="firstName">';
        tableBodyHtml += user.firstName;
        tableBodyHtml += '</td>';

        tableBodyHtml += '<td data-type="secondName">';
        tableBodyHtml += user.secondName;
        tableBodyHtml += '</td>';

        tableBodyHtml += '<td data-type="position">';
        tableBodyHtml += user.position;
        tableBodyHtml += '</td>';

        tableBodyHtml += '<td data-type="">';
        tableBodyHtml += '<button type="button" class="btn btn-danger btn-sm" onclick="deleteButtonClick(event)">X</button>';
        tableBodyHtml += '</td>';

        tableBodyHtml += '</tr>';
    });
    let tableBodyElement = document.getElementById(tableBody);
    tableBodyElement.innerHTML = tableBodyHtml;
}

function tableRowClick(row) {
    let user = {};
    row.childNodes.forEach((item) => {
        const type = item.dataset.type;
        user[type] = item.innerText;
    });
    copyUserToForm(user);
}

function deleteButtonClick(event) {
    event.stopPropagation();
    let user = {};
    event.target.parentNode.parentNode.childNodes.forEach((item) => {
        const type = item.dataset.type;
        user[type] = item.innerText;
    });
    if (window.confirm(`Delete user ${user.firstName} ${user.secondName} ?`)) {
        apiDeleteUser(user);
    }
}

document.addEventListener('DOMContentLoaded', () => {
    const saveUserButtonElement = document.getElementById(saveUserButton);
    saveUserButtonElement.addEventListener('click', () => {
        let user = readUserForm();
        apiSaveUser(user);
    });
    getAllUsers();
}
);
