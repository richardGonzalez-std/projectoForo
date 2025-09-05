document.addEventListener("DOMContentLoaded", function () {
    const btn = document.querySelector('#light_mode');

    btn.addEventListener('click', function () {
        document.body.classList.toggle("light-mode");

        if (document.body.classList.contains("light-mode")) {
            btn.textContent = "Dark Mode";
        } else {
            btn.textContent = "Light Mode";
        }
    });
});
