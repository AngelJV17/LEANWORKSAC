const $div_padre = document.getElementById("div_padre");
$div_padre.style = "display:none";

function mostrar(dato) {
    if (dato == "SI") {
        $div_padre.style = "display:none";
    }
    if (dato == "NO") {
        $div_padre.style = "display:block";
    }
}
