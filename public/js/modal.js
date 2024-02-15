
// const myModal = new bootstrap.Modal(document.getElementById('staticBackdrop'),{});
// or
// const createUserModal = new bootstrap.Modal('#createUserModal', {});

// const createUserModal = document.getElementById('createUserModal');
// const updateUserModal = document.getElementById('updateUserModal');
// const updatePassModal = document.getElementById('updatePassModal');
// const updateUserModal = new bootstrap.Modal('#updateUserModal', {});
// const updatePassModal = new bootstrap.Modal('#updatePassModal', {});

//definición de ventanas modales
const createUserModal = new bootstrap.Modal(document.getElementById('createUserModal'), {});
const deleteUserModal = new bootstrap.Modal(document.getElementById('deleteUserModal'), {});
const updateUserModal = new bootstrap.Modal(document.getElementById('updateUserModal'), {});
const updatePasswModal = new bootstrap.Modal(document.getElementById('updatePassModal'), {});



const createUserModalButton = document.getElementById('createUserModalButton');
const updateUserModalButton = document.getElementById('updateUserModalButton');
const updatePassModalButton = document.getElementById('updatePassModalButton');

createUserModalButton.addEventListener('click', event => {
    createUserModal.show();
    console.log(event.target);
})

updateUserModalButton.addEventListener('click', event => {
    // document.getElementById("idUsuarioActualizar").value = element.childNodes[11].childNodes[0].id;
    updateUserModal.show();
    console.log(event.target);
})

updatePassModalButton.addEventListener('click', event => {
    updatePasswModal.show();
    console.log(event.target);
})


