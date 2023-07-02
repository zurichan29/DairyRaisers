/** FLASH MESSAGE */

setTimeout(function () {
    document.getElementById('flash-message').classList.add('hidden');
}, 5000);

/** SESSION TIMER */

var logoutTimer;
function resetLogoutTimer() {
    clearTimeout(logoutTimer);
    logoutTimer = setTimeout(logoutUser, 300000); // 5 minutes (300,000 milliseconds)
}

function logoutUser() {
    window.location.href = '/logout'; // Replace with the actual logout route
}