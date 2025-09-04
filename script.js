document.querySelector('#light_mode').addEventListener('click',function(){
    document.querySelector("body").style.background="black";
    this.textContent="Dark Mode";
    this.id="dark_mode";
})