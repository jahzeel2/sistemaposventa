import { sendDataForm,msgError, spinnerStart, spinnerEnd, getdata } from '../export_funcion/rogercode_function_send_data.js';

let getToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
let divtable = document.querySelector("#table-content");

let formdate = document.querySelector("#getdate");
let btnform = document.querySelector("#btnSendData");

btnform.addEventListener("click", (e) => {
    e.preventDefault();
    spinnerStart(btnform);
    let url = "/caja/showlista";
    sendDataForm(url,formdate,getToken).then(result => {
        console.log(result);
        if (result.status === 1) {
            spinnerEnd(btnform);
            showTbody(result);
        }
        if (result.status === 0) {
            spinnerEnd(btnform);
            msgError(result.alert);
        }
    });
});

const showTbody = (result) => {
    console.log(result);
    divtable.innerHTML = "";
    divtable.innerHTML = `
        <table id="table_cortes_de_caja" class="table table-bordered table-hover">
          <thead class="">
            <tr>
              <th scope="col">Cajero</th>
              <th scope="col">Fecha apertura</th>
              <th scope="col">Monto apertura</th>
              <th scope="col">Monto cierre</th>
              <th scope="col">Sobrante o faltante</th>
              <th scope="col">Fecha cierre</th>
              <th scope="col"><i class="fa fa-cog" aria-hidden="true"></i></th>
            </tr>
          </thead>
          <tbody id="tbodydatahistorial"></tbody>
        </table>
    `;
    let tbodytable = document.querySelector("#tbodydatahistorial");
    tbodytable.innerHTML = "";
    let arrayData = result.datacorte;
    arrayData.forEach(row => {
        console.log(row);
        let sobranteOfaltante = 0.00;
        let cantTipo = ``;

        let cantInicial = Number(row.cantidad_final); 
        let cantFinal = Number(row.total_acomulado); 
        if ( cantInicial > cantFinal ) {
            sobranteOfaltante = cantInicial - cantFinal;
            //sobrante
            cantTipo += `<span class="badge bg-success">${sobranteOfaltante.toFixed(2)}</span>`;
        }
        if (cantFinal > cantInicial ) {
            sobranteOfaltante = cantFinal - cantInicial;
            //faltante
            cantTipo += `<span class="badge bg-danger">${sobranteOfaltante.toFixed(2)}</span>`;
        }

        if (cantFinal === cantInicial ) {
            cantTipo += `<span class="badge bg-danger">${sobranteOfaltante.toFixed(2)}</span>`;
        }
        tbodytable.innerHTML += `
        <tr>
        <td>${row.name}</td>
        <td>${formatDate(row.fecha_hora)}</td>
        <td><h5><span class="badge bg-info">${row.cantidad_inicial}</span></h5></td>
        <td><h5><span class="badge bg-success">${row.cantidad_final}</span></h5></td>
        <td><h5>${cantTipo}</h5></td>
        <td>${formatDate(row.fecha_hora_cierre)}</td>
        <td><button id="${row.idapertura}" name="btnShowDetail" class="btn btn-secondary">Ver</button></td>
        </tr>
        `;
    });
    $('#table_cortes_de_caja').DataTable();
    showDetailCaja();
};


const showDetailCaja = () => {
    let table = document.querySelector("#table_cortes_de_caja tbody");
    table.addEventListener("click", (e) => {
        let element = e.target;
        //console.log(element);
        if (element.name === "btnShowDetail") {
            let aperturaId = element.getAttribute("id");
            console.log(aperturaId);
            getdata(`/caja/showHistoryDetalle/`,aperturaId).then(result => {
                console.log(result);
                document.querySelector("#name_empresa").textContent = result.settings.name;
                document.querySelector("#date_operation").textContent = formatDate(result.cierre);
                document.querySelector("#name_cajero").textContent = result.name_cajero;
                document.querySelector("#fondo_caja").textContent = result.inicio;
                document.querySelector("#efectivo_caja").textContent = result.final;
                document.querySelector("#sale_efectivo").textContent = result.total;
                let datafaltante = document.querySelector("#faltante_caja");
                datafaltante.textContent = Number(result.faltante).toFixed(2);
                let datasobrante = document.querySelector("#sobrante_caja");
                datasobrante.textContent = Number(result.sobrante).toFixed(2);
                let textfaltante = result.faltante;
                if (textfaltante > 0) {
                    datafaltante.style.color="red";
                }else{
                    datasobrante.style.color="green";
                }

                let myModal = new bootstrap.Modal(document.getElementById('detailCajaModal'));
                myModal.show();
            });
        }
    });
}