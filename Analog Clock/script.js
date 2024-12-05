let hr = document.getElementById("hour");
let min = document.getElementById("min");
let sec = document.getElementById("sec");

function displayTime(){
    let date = new Date();
    // console.log(date);

    let hh = date.getHours();
    let mm = date.getMinutes();
    let ss = date.getSeconds();
    // console.log(hh,mm,ss);

    let hRotation = (hh % 12) / 12 * 360 + mm / 60 * 30;
    let mRotation = mm / 60 * 360 + ss / 60 * 6;
    let sRotation = ss / 60 * 360;
    console.log(hRotation,mRotation,sRotation);

    hr.style.transform = `rotate(${hRotation}deg`;
    min.style.transform = `rotate(${mRotation}deg`;
    sec.style.transform = `rotate(${sRotation}deg`;


}

setInterval(displayTime,1000);