document.getElementById("header").innerHTML = fetch("header_widget.php")
    .then(res => res.text())
    .then(data => document.getElementById("header").innerHTML = data);

document.getElementById("footer").innerHTML = fetch("footer_widget.php")
    .then(res => res.text())
    .then(data => document.getElementById("footer").innerHTML = data);
