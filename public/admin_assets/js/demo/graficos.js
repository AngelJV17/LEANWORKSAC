(Chart.defaults.global.defaultFontFamily = "Nunito"),
    '-apple-system,system-ui,BlinkMacSystemFont,"Segoe UI",Roboto,"Helvetica Neue",Arial,sans-serif';
Chart.defaults.global.defaultFontColor = "#858796";

var cajas = [];
var ingresos = [];
var egresos = [];
var fechas = [];
var meses = [];
var resultado = [];

var nuevoObjeto = {};
getCajas();

var dataObject = {
    label: "Ingresos",
    backgroundColor: "#dc3545",
    hoverBackgroundColor: "#dc3545",
    borderColor: "#dc3545",
    data: [2000, 5000],
};

var datas = [];

function getCajas() {
    axios.get("cajas-all").then((res) => {
        res.data.forEach((a) => {
            cajas.push({ ...a });
            //fechas.push(formatDate(a.created_at));
        });

        cajas.forEach((elemento) => {
            let fecha = new Date(elemento.created_at);
            var mes = fecha.getMonth();
            fecha = obtenerNombreMes(mes + 1);
            //let fecha = new Intl.DateTimeFormat('es-ES', { month: 'long'}).format(new Date())
            meses.push(fecha.toUpperCase());
            if (!nuevoObjeto.hasOwnProperty(fecha)) {
                nuevoObjeto[fecha] = {
                    mes: fecha,
                    /* cajas: [], */
                    ingresos: 0,
                    egresos: 0,
                };
            }
            /* nuevoObjeto[fecha].cajas.push({
                id: elemento.id,
                proyecto: elemento.proyecto_id,
                operacion: elemento.operacion,
                created_at: elemento.created_at,
                monto: elemento.monto,
            }); */
            nuevoObjeto[fecha].ingresos +=
                elemento.operacion == 2 ? parseFloat(elemento.monto) : 0;
            nuevoObjeto[fecha].egresos +=
                elemento.operacion == 3 ? parseFloat(elemento.monto) : 0;
        });

        console.log(nuevoObjeto, "Consoleando datos del nuevoObjeto");

        meses = meses.filter((item, index) => {
            return meses.indexOf(item) === index;
        });

        console.log(nuevoObjeto["julio"].cajas);

        datas = [
            {
                label: "Ingresos",
                backgroundColor: "#dc3545",
                hoverBackgroundColor: "#dc3545",
                borderColor: "#dc3545",
                data: [20000, 5000],
            },
            {
                label: "Egresos",
                backgroundColor: "#ffc107",
                hoverBackgroundColor: "#ffc107",
                borderColor: "#ffc107",
                data: [10500, 9000],
            },
        ];

        grafica();
    });
}

function number_format(number, decimals, dec_point, thousands_sep) {
    // *     example: number_format(1234.56, 2, ',', ' ');
    // *     return: '1 234,56'
    number = (number + "").replace(",", "").replace(" ", "");
    var n = !isFinite(+number) ? 0 : +number,
        prec = !isFinite(+decimals) ? 0 : Math.abs(decimals),
        sep = typeof thousands_sep === "undefined" ? "," : thousands_sep,
        dec = typeof dec_point === "undefined" ? "." : dec_point,
        s = "",
        toFixedFix = function (n, prec) {
            var k = Math.pow(10, prec);
            return "" + Math.round(n * k) / k;
        };
    // Fix for IE parseFloat(0.55).toFixed(0) = 0;
    s = (prec ? toFixedFix(n, prec) : "" + Math.round(n)).split(".");
    if (s[0].length > 3) {
        s[0] = s[0].replace(/\B(?=(?:\d{3})+(?!\d))/g, sep);
    }
    if ((s[1] || "").length < prec) {
        s[1] = s[1] || "";
        s[1] += new Array(prec - s[1].length + 1).join("0");
    }
    return s.join(dec);
}

function grafica() {
    // Bar Chart Example
    var ctx = document.getElementById("cajasBar");
    var cajasBar = new Chart(ctx, {
        type: "bar",
        data: {
            labels: meses,
            datasets: datas,
        },
        options: {
            maintainAspectRatio: false,
            layout: {
                padding: {
                    left: 10,
                    right: 25,
                    top: 25,
                    bottom: 0,
                },
            },
            scales: {
                xAxes: [
                    {
                        time: {
                            unit: "month",
                        },
                        gridLines: {
                            display: false,
                            drawBorder: false,
                        },
                        ticks: {
                            maxTicksLimit: 6,
                        },
                        maxBarThickness: 25,
                    },
                ],
                yAxes: [
                    {
                        ticks: {
                            min: 0,
                            max: 20000,
                            maxTicksLimit: 5,
                            padding: 10,
                            // Include a dollar sign in the ticks
                            callback: function (value, index, values) {
                                return "S/. " + number_format(value);
                            },
                        },
                        gridLines: {
                            color: "rgb(234, 236, 244)",
                            zeroLineColor: "rgb(234, 236, 244)",
                            drawBorder: false,
                            borderDash: [2],
                            zeroLineBorderDash: [2],
                        },
                    },
                ],
            },
            legend: {
                display: false,
            },
            tooltips: {
                titleMarginBottom: 10,
                titleFontColor: "#6e707e",
                titleFontSize: 14,
                backgroundColor: "rgb(255,255,255)",
                bodyFontColor: "#858796",
                borderColor: "#dddfeb",
                borderWidth: 1,
                xPadding: 15,
                yPadding: 15,
                displayColors: false,
                caretPadding: 10,
                callbacks: {
                    label: function (tooltipItem, chart) {
                        var datasetLabel =
                            chart.datasets[tooltipItem.datasetIndex].label ||
                            "";
                        return (
                            datasetLabel +
                            ": S/. " +
                            number_format(tooltipItem.yLabel)
                        );
                    },
                },
            },
        },
    });
}

function formatDate(date) {
    var d = new Date(date),
        month = "" + (d.getMonth() + 1),
        day = "" + d.getDate(),
        year = d.getFullYear();

    if (month.length < 2) month = "0" + month;
    if (day.length < 2) day = "0" + day;

    return [year, month, day].join("-");
}

function obtenerNombreMes(numero) {
    let miFecha = new Date();
    if (0 < numero && numero <= 12) {
        miFecha.setMonth(numero - 1);
        return new Intl.DateTimeFormat("es-ES", { month: "long" }).format(
            miFecha
        );
    } else {
        return null;
    }
}
