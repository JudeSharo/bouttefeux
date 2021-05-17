function afficherMessage (message) {
    var obj = document.getElementById('slidegrid2');
    if (!message)
        obj.style.display = "none";
    else {
        obj.style.display = "block";
        obj.innerHTML = message;
    }
}