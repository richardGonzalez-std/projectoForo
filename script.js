document.addEventListener("DOMContentLoaded", function(){
    var light_mode = document.querySelector('#light_mode').textContent;
    var dark_mode = document.querySelector('#light_mode').textContent;
    if(light_mode){
        document.querySelector('#dark_mode').addEventListener('click',function(){
        this.textContent = "Light Mode";
        this.id = "light_mode";
        document.querySelector("body").style.backgroundColor="white";
        document.querySelector("body").style.color="black";
    });
    }else if(dark_mode){
    document.querySelector('#light_mode').addEventListener('click',function(){
        this.textContent = "Dark Mode";
        this.id = "dark_mode";
        document.querySelector("body").style.backgroundColor="black";
        document.querySelector("body").style.color="white";
    });
    }

})
