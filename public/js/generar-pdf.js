const $btnPdf = document.getElementById("btnPdf");
const desde = document.getElementById("desde");
const hasta = document.getElementById("hasta");

/* const urlParams = new URLSearchParams(window.location.search);
const desde = urlParams.get('desde');
const hasta = urlParams.get('hasta'); */

$btnPdf.onclick = function () {
    myFunction();
};

function myFunction() {
    //alert(desde.value+' --- '+hasta.value);

    axios({
        url: "/reportes/pdf", // download file link goes here
        method: "GET",
        headers: { "Content-Type": "application/x-www-form-urlencoded" },
        responseType: "blob",
        params: {
            desde: desde.value,
            hasta: hasta.value,
        },
    }).then((res) => {
        var _desde = desde.value;
        var _hasta = hasta.value;
        const url = window.URL.createObjectURL(new Blob([res.data]));
        const link = document.createElement("a");
        const nombre = 'REPORTE '+_desde.replace("/", "-")+' AL '+_hasta.replace("/", "-")+'.pdf';
        link.href = url;
        link.setAttribute("download", nombre); //or any other extension
        document.body.appendChild(link);
        link.click();
    });
}
