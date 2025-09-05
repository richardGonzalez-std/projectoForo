document.addEventListener("DOMContentLoaded", function () {
    const btn = document.querySelector('button');

    btn.addEventListener('click', function () {
        if(btn.classList.contains("light_mode")){
            btn.classList.remove("light_mode");
            btn.classList.add("dark_mode");
        }else if(btn.classList.contains("dark_mode")){
            btn.classList.remove("dark_mode");
            btn.classList.add("light_mode");
        }
    });
});
