const descripcion = document.querySelector("#descripcion");
const monto = document.querySelector("#monto");
const btnAgregar = document.querySelector("#btnAgregar");
const ul = document.querySelector("#lista");

btnAgregar.addEventListener("click", (e) => {
    e.preventDefault();

    const _descripcion = descripcion.value;
    const _monto = monto.value;

    if (_descripcion !== "" && _monto !== "") {
        const li = document.createElement("li");
        const p = document.createElement("p");
        const span = document.createElement("span");

        const div = document.createElement("div");

        li.textContent = _descripcion;
        span.textContent = "S/. " + parseFloat(_monto).toFixed(2);

        //li.appendChild(p);
        li.appendChild(div);
        div.classList.add("m-2", "p-2", "flex-grow-1");
        li.appendChild(span);
        span.classList.add("badge", "badge-light", "p-2", "m-2");
        li.classList.add(
            "list-group-item",
            "mb-2",
            "d-flex",
            "align-items-center"
        );
        li.appendChild(addDeleteBtn());
        ul.classList.add("list-group");
        ul.appendChild(li);

        descripcion.value = "";
        monto.value = "";
        //empty.style.display = "none";
    }
});

function addDeleteBtn() {
    const deleteBtn = document.createElement("button");
    //const close = document.createElement("span");

    deleteBtn.textContent = "X";
    deleteBtn.className = "m-2 p-2 text-right badge badge-danger btn btn-danger";

    deleteBtn.addEventListener("click", (e) => {
        const item = e.target.parentElement;
        ul.removeChild(item);

        const items = document.querySelectorAll("li");

        if (items.length === 0) {
            empty.style.display = "block";
        }
    });

    return deleteBtn;
}
