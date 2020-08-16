function togglesidebar() {
    document.getElementById("sidebar").classList.toggle("active");
    document.getElementById("toggle2").classList.toggle("pressed");
}

function togglesidebar2() {
    document.getElementById("sidebar").classList.toggle("active");
    document.getElementById("toggle2").classList.toggle("pressed");
}

var click=0;

function togglesidebar1() {
    document.getElementById("left-sidebar").classList.toggle("active");
    document.getElementById("toggle1").classList.toggle("pressed");
    if(click==0) {
        document.getElementById("left-arrow").style.display="inline";
        document.getElementById("right-arrow").style.display="none";
        click=1;
    }
    else {
        document.getElementById("left-arrow").style.display="none";
        document.getElementById("right-arrow").style.display="inline";
        click=0;
    }
}

var click2=0;
function menubtn(a,b) {
    if(click2==0) {
        document.getElementById(a).style.display="none";
        document.getElementById(b).style.display="inline";
        click2=1;
    }
    else {
        document.getElementById(a).style.display="inline";
        document.getElementById(b).style.display="none";
        click2=0;
    }
}

function toggleCollapse(a) {
    document.getElementById(a).classList.toggle("active");
}

function append(a) {
    document.getElementById("field").value=document.getElementById("field").value+a;
}
function append2(a) {
    document.getElementById("field2").value=document.getElementById("field2").value+a;
}
function backspace(x) {
    var a=document.getElementById(x).value;
    var b=a.substr(0, a.length-1);
    document.getElementById(x).value=b;
}