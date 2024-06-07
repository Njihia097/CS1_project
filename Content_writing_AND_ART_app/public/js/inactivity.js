
let inactivityTime = function () {
    let time;
    window.onload = resetTimer;
    document.onmousemove = resetTimer;
    document.onkeydown = resetTimer;
    document.onkeyup = resetTimer;
    document.ontouchstart = resetTimer;
    document.onclick = resetTimer;

    function logout() {
        const previousURL = window.location.href;
        window.location.href = `/lock-screen?previousURL=${encodeURIComponent(previousURL)}`;
        // sessionStorage.setItem('previousURL', window.location.href);
        // window.location.href = '/lock-screen';
    }

    function resetTimer() {
        clearTimeout(time);
        time = setTimeout(logout, 600000); // 10 minutes of inactivity
    }
};

window.onload = function() {
    inactivityTime();
};
