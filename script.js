document.addEventListener("DOMContentLoaded", function(){
    document.querySelector('#light_mode').addEventListener('click',function(){
        this.textContent = "Dark Mode";
        this.className.add("dark-mode");
        document.body.style.background="black";
        document.body.style.color="white";
    });
})
