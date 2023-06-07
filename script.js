const buttonSend = document.getElementById('send');

const validateFields = (fullName, lastNameOne, lastNameTwo, email, login, password) => {
    if (fullName === '' || lastNameOne === '' || lastNameTwo === '' || email === '' || login === '' || password === '') {
        return false;
    }
    return true;
}

const validateEmail = (email) => {
    const regex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    if (regex.test(email)) {
        return true;
    }
    return false;
};

const validatePassword = (password) => {
    if (password.length >= 4 && password.length <= 8) {
        return true;
    }

    return false;
};

const validateForm = () => {
    const fullName = document.getElementById('name').value;
    const lastNameOne = document.getElementById('last-name-one').value;
    const lastNameTwo = document.getElementById('last-name-two').value;
    const email = document.getElementById('email').value;
    const login = document.getElementById('login').value;
    const password = document.getElementById('password').value;
    const isValidFields = validateFields(fullName, lastNameOne, lastNameTwo, email, login, password);

    if (!isValidFields) {
        alert('Por favor, completa todos los campos');
        return;
    }

    const isValidEmail = validateEmail(email);

    if (!isValidEmail) {
        alert('Por favor, ingresa un correo electrónico válido');
        return;
    }

    const isValidPassword = validatePassword(password);

    if (!isValidPassword) {
        alert('Por favor, ingresa una contraseña válida');
        return;
    }

}

buttonSend.addEventListener('click', validateForm);

