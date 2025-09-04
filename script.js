document.addEventListener("DOMContentLoaded", function(){
    document.querySelector('#light_mode').addEventListener('click',function(){
        this.textContent = "Dark Mode";
        this.className.add("dark-mode");
        document.body.style.backgroundColor="black";
        document.body.style.color="white";
        document.querySelector("input").style.background="#d6ecc16e";
    });
})
