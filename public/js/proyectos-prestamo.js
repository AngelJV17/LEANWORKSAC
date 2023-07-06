let proyectosList = [];

const $proyecto_emisor = document.getElementById("proyecto_emisor");
const $proyecto_receptor = document.getElementById("proyecto_receptor");

function getProyectos() {
    axios.get("/lista-proyectos").then((res) => {
        res.data.forEach((a) => {
            proyectosList.push({ ...a });
        });
        //const filtrado = categoriasGlobales.filter((c) => c.parent_id === 2);
    });
    //console.log(proyectosList);
}


getProyectos();

$proyecto_emisor.addEventListener("change", (e) => {
    let id_proyecto = $proyecto_emisor.value;

    const _proyectos_list = [];
    proyectosList.forEach((c) => {
        //console.log(c);
        if (c.id != id_proyecto) {
            _proyectos_list.push(c);
        }
    });

    //console.log(_proyectos_list);
    proyectoReceptor(_proyectos_list);
});

function proyectoReceptor(list) {
    $proyecto_receptor.innerHTML = "<option selected disabled>Seleccione</option>";
    list.forEach((e) => {
        const option = document.createElement("option");
        option.text = e.nombre_proyecto;
        option.value = e.id;
        $proyecto_receptor.appendChild(option);
    });
}