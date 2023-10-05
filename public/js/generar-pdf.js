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
    const _desde = desde ? desde.value : '';
    const _hasta = hasta ? hasta.value : '';

    //console.log(_desde + ' ---- '+_hasta);
    axios({
        url: "/reportes/pdf", // download file link goes here
        method: "GET",
        headers: { "Content-Type": "application/x-www-form-urlencoded" },
        responseType: "blob",
        params: {
            desde: _desde,
            hasta: _hasta,
        },
    }).then((res) => {
        //console.log(res);
        var _d = _desde ? _desde.replace("/", "-") : '';
        var _h = _hasta ? _hasta.replace("/", "-") : '';
        const url = window.URL.createObjectURL(new Blob([res.data]));
        const link = document.createElement("a");
        const nombre = _d || _h ? 'REPORTE '+_d+' AL '+_h+'.pdf' : 'REPORTE GENERAL.pdf';
        link.href = url;
        link.setAttribute("download", nombre); //or any other extension
        document.body.appendChild(link);
        link.click();
    });
}
