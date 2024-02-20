
const updateUserModal = new bootstrap.Modal(document.getElementById('updateUserModal'), {});
const updatePasswModal = new bootstrap.Modal(document.getElementById('updatePassModal'), {});

const updateUserModalButton = document.getElementById('updateUserModalButton');
const updatePassModalButton = document.getElementById('updatePassModalButton');


updateUserModalButton.addEventListener('click', event => {
    updateUserModal.show();
})

updatePassModalButton.addEventListener('click', event => {
    updatePasswModal.show();
    console.log(event.target);
})


