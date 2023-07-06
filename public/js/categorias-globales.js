let categoriasGlobales = [];

const $operacion_select = document.getElementById("operacion_select");
const $tipo_select = document.getElementById("tipo_select");
const $subtipo_select = document.getElementById("subtipo_select");

function getCategoriasGlobales() {
    axios.get("/lista-categorias-globales").then((res) => {
        res.data.forEach((a) => {
            categoriasGlobales.push({ ...a });
        });
        //const filtrado = categoriasGlobales.filter((c) => c.parent_id === 2);
        //console.log(filtrado);
    });
}


getCategoriasGlobales();

$operacion_select.addEventListener("change", (e) => {
    let id_categoria = $operacion_select.value;

    const _cat_filtrados = [];
    categoriasGlobales.forEach((c) => {
        //console.log(c);
        if (c.parent_id == id_categoria) {
            _cat_filtrados.push(c);
        }
    });

    //console.log(_cat_filtrados);
    setSelectTipos(_cat_filtrados);
});

function setSelectTipos(list) {
    $tipo_select.innerHTML = "<option selected disabled>Seleccione</option>";
    $subtipo_select.innerHTML = "<option selected disabled>Seleccione</option>";
    list.forEach((e) => {
        const option = document.createElement("option");
        option.text = e.categoria_descripcion;
        option.value = e.id;
        $tipo_select.appendChild(option);
    });
}

$tipo_select.addEventListener("change", (e) => {
    let id_categoria = $tipo_select.value;

    const _tipos_filtrados = [];
    categoriasGlobales.forEach((c) => {
        //console.log(c);
        if (c.parent_id == id_categoria) {
            _tipos_filtrados.push(c);
        }
    });

    //console.log(_cat_filtrados);
    setSelectSubTipos(_tipos_filtrados);
});

function setSelectSubTipos(list) {
    $subtipo_select.innerHTML = "<option selected disabled>Seleccione</option>";
    list.forEach((e) => {
        const option = document.createElement("option");
        option.text = e.categoria_descripcion;
        option.value = e.id;
        $subtipo_select.appendChild(option);
    });
}