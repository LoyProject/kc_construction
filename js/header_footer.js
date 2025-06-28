document.getElementById("header").innerHTML = fetch("header_widget.php")
    .then(res => res.text())
    .then(data => document.getElementById("header").innerHTML = data);

document.getElementById("footer").innerHTML = fetch("footer_widget.php")
    .then(res => res.text())
    .then(data => document.getElementById("footer").innerHTML = data);

const address = "Sangkat Kbal Koh Khan Chbar Am Pov, Phnom Penh Cambodia";
const phone = "";
const workingHours = "";

document.getElementById('address').textContent = address;
document.getElementById('phone').textContent = phone;
document.getElementById('working-hours').textContent = workingHours;