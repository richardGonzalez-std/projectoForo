document.addEventListener("DOMContentLoaded", function(){
    var mode = document.querySelector('button').textContent;
    if(mode != "Light Mode"){
        document.querySelector('#dark_mode').addEventListener('click',function(){
        this.textContent = "Light Mode";
        this.id = "light_mode";
        document.querySelector("body").style.backgroundColor="white";
        document.querySelector("body").style.color="black";
    });
    }else if(mode != "Dark Mode"){
    document.querySelector('#light_mode').addEventListener('click',function(){
        this.textContent = "Dark Mode";
        this.id = "dark_mode";
        document.querySelector("body").style.backgroundColor="black";
        document.querySelector("body").style.color="white";
    });
    }

})
