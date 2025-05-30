import { operations } from '../export_funcion/rogercode_export_function_general.js';

let getToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

$(document).ready(function () {
    $('#inventory_table').DataTable();
});

let tableInventory = document.querySelector("#inventory_table tbody");
tableInventory.addEventListener("click", (e) => {
    let element = e.target;
    if (element.name === "btnAjustar") {
        let articuloId = element.getAttribute("dataId");
        let btnId = document.querySelector(`#btn${articuloId}`);

        const sendData = new operations();
        sendData.spinnerStart(btnId,"Actualizando");

        let newStock = document.querySelector(`#stock${articuloId}`);
        if (newStock.value === null || newStock.value === "") {
            sendData.msgError("Debe ingresar un valor para el stock");
            return false;
        }

        const dataform = new FormData();
        dataform.append("articuloId", articuloId);
        dataform.append("newStock", newStock.value);
        sendData.updateData("/updateStock",dataform,getToken).then((result) => {
            console.log(result);
            if (result.status === 1) {
                let TableRefreshProduct = $('#inventory_table').dataTable(); 
                TableRefreshProduct.fnDraw(false);
                sendData.msgSuccess(result.message);
                sendData.spinnerEnd(btnId,"Ajustar");
            }
            if (result.status === 0) {
                sendData.spinnerEnd(btnId,"Ajustar");
                sendData.msgError(result.message);
            }
        }); 
    }

});