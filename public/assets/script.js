let arrow = document.querySelectorAll(".arrow");
for (var i = 0; i < arrow.length; i++) {
  arrow[i].addEventListener("click", (e)=>{
 let arrowParent = e.target.parentElement.parentElement;//selecting main parent of arrow
 arrowParent.classList.toggle("showMenu");
  });
}

let sidebar = document.querySelector(".sidebar");
let sidebarBtn = document.querySelector(".bx-menu");
console.log(sidebarBtn);
sidebarBtn.addEventListener("click", ()=>{
  sidebar.classList.toggle("close");
});

let Profile = document.getElementById("Profile");
function toggleMenu(){
  Profile.classList.toggle("open");
}

document.querySelectorAll('.custombtn').forEach
(link => {
  if(link.href === window.location.href){
    link.setAttribute('aria-current', 'page')
  }
})