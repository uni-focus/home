var coll = document.getElementsByClassName("collapsible");
var i;

for (i = 0; i < coll.length; i++) {
  coll[i].addEventListener("click", function() {
    this.classList.toggle("active");
    var collapsecontent = this.nextElementSibling;
    if (collapsecontent.style.maxHeight){
      collapsecontent.style.maxHeight = null;
    } else {
      collapsecontent.style.maxHeight = collapsecontent.scrollHeight + "px";
    } 
  });
}
