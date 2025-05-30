
<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header style-modal-form">
        <h5 class="modal-title" id="exampleModalLabel">Buscar un cliente</h5>
        <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body style-modal-form">
        <div class="container">
          <div class="row height d-flex justify-content-center align-items-center">
              <div class="col-md-6">
                  <div class="div-content-search"> <i class="fa fa-search"></i> <input type="text" id="customers-searchs" class="form-control input_search" placeholder="Buscar un cliente..." autocomplete="off">  </div>
              </div>
          </div>
          <br>
          <table class="table table-bordered">
            <thead>
              <tr>
                <th scope="col">Agregar</th>
                <th scope="col">Nombre</th>
                <th scope="col">Direccion</th>
                <th scope="col">Email</th>
              </tr>
            </thead>
            <tbody id="show-customers">
            </tbody>
          </table>
        </div>
      </div>
      <div class="modal-footer style-modal-form">
        <button type="button" class="btn btn5 btn-close-customer" data-bs-dismiss="modal"><i class="fas fa-window-close mr-2 "></i>Cerrar</button>
      </div>
    </div>
  </div>
</div>