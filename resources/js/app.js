import './bootstrap';

document.getElementById('openModalButton').addEventListener('click', function () {
    document.getElementById('myModal').classList.add('active');
});

var closeButton = document.querySelectorAll('.modal-close');
for (var i = 0; i < closeButton.length; i++) {
    closeButton[i].addEventListener('click', function () {
        document.getElementById('myModal').classList.remove('active');
    });
}

/** FLASH MESSAGE */

setTimeout(function () {
    document.getElementById('flash-message').classList.add('hidden');
}, 5000);


/** SESSION TIMER */

let logoutTimer;

function resetLogoutTimer() {
    clearTimeout(logoutTimer);
    logoutTimer = setTimeout(logoutUser, 300000); // 5 minutes (300,000 milliseconds)
}

function logoutUser() {
    window.location.href = '/logout'; // Replace with the actual logout route
}

// Bind the resetLogoutTimer function to user activity events
document.addEventListener('mousemove', resetLogoutTimer);
document.addEventListener('keydown', resetLogoutTimer);
