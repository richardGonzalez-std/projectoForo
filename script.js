document.addEventListener("DOMContentLoaded", function(){
    document.querySelector('#light_mode').addEventListener('click',function(){
        this.textContent = "Dark Mode";
        this.id = "dark_mode";
        document.querySelector("body").style.backgroundColor="black";
        document.querySelector("body").style.color="white";
    });
})
