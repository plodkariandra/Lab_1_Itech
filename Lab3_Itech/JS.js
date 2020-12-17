var cTime = new Date().getHours();
if (document.body) {
    if (6 <= cTime && cTime < 12) {
        document.body.style.backgroundColor = "#d1f4f0";
    }
    else if (12 <= cTime && cTime < 18) {
        document.body.style.backgroundColor = "#e2aaff";
    }
    else {
        document.body.style.backgroundColor = "#0b081e";
    }
}

var images = new Array();
var i = 0;
var frequency = prompt("Please enter the required interval for changing pictures (ms)");
if(isNaN(frequency)){
  alert("Invalid input data") ;
}
else{
alert("Thank you");

images[0] = 'A.jpg';
images[1] = 'B.jpg';
images[2] = 'C.jpg';
images[3] = 'D.jpg';
images[4] = 'E.jpg';
images[5] = 'F.jpg';
images[6] = 'G.jpg';
images[7] = 'H.jpg'
 
function viewImages() {
    document.getElementById("mainimg").src = images[i]; 
    i++;
    if (i == images.length) {
        i = 0;
    }
    setTimeout("viewImages()",frequency);
}   
}
