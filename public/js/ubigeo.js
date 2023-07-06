let ubigeos = [];
let departamentos = [];
let provincias = [];
let distritos = [];

const $departamento_select = document.getElementById("departamento_select");
const $provincias_select = document.getElementById("provincias_select");
const $distritos_select = document.getElementById("distritos_select");

/* function getDepartamentos() {
    axios.get("lista/departamentos").then((res) => {
        res.data.forEach((a) => {
            departamentos.push({ ...a });
        });
        //console.log(departamentos);
    });
} */

function getProvincias() {
    axios.get("/lista-provincias").then((res) => {
        res.data.forEach((a) => {
            provincias.push({ ...a });
        });
        /* const _provincias = provincias.filter((p) => p.departamento_id === filtro);
        console.log(_provincias); */
    });
}

function getDistritos() {
    axios.get("/lista-distritos").then((res) => {
        res.data.forEach((a) => {
            distritos.push({ ...a });
        });

        //const distrito = distritos.filter((d) => d.provincia_id === 101);
        //console.log(distritos);
    });
}

//getDepartamentos();
getProvincias();
getDistritos();

$departamento_select.addEventListener("change", (e) => {
    let id_departamento = $departamento_select.value;

    const _provincias = [];
    provincias.forEach((provincia) => {
        //console.log(provincia);
        if (provincia.departamento_id == id_departamento) {
            _provincias.push(provincia);
        }
    });

    //console.log(_provincias);
    setSelectProvincias(_provincias);
});


$provincias_select.addEventListener("change", (e) => {
    let id_provincia = $provincias_select.value;

    const _distritos = [];
    distritos.forEach((provincia) => {
        //console.log(provincia);
        if (provincia.provincia_id == id_provincia) {
            _distritos.push(provincia);
        }
    });

    //console.log(_distritos);
    setSelectDistritos(_distritos);
});

function setSelectProvincias(list) {
    $provincias_select.innerHTML = "<option selected disabled>Selecciona la provincia</option>";
    $distritos_select.innerHTML = "<option selected disabled>Selecciona el distrito</option>";
    list.forEach((e) => {
        const option = document.createElement("option");
        option.text = e.nombre_provincia;
        option.value = e.id;
        $provincias_select.appendChild(option);
    });
}

function setSelectDistritos(list) {
    //$distritos_select.innerHTML = "<option seected disabled>Selecciona el distrito</option>";
    list.forEach((e) => {
        const option = document.createElement("option");
        option.text = e.nombre_distrito;
        option.value = e.id;
        $distritos_select.appendChild(option);
    });
}