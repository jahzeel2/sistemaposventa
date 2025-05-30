class Roles {
  success_message(msg) {
    Swal.fire({
      //position: 'top-end',
      type: "success",
      title: msg,
      showConfirmButton: false,
      width: 300,
      timer: 2000,
    });
  }

  error_message(msg){
    Swal.fire({
      //position: 'top-end',
      type: "error",
      title: msg,
      showConfirmButton: false,
      width: 300,
      timer: 2000,
    });

  }
}

class rolesAccions extends Roles {
  downRol = async (url, form) => {
    try {
      let token = document
        .querySelector('meta[name="csrf-token"]')
        .getAttribute("content");
      let seend = await fetch(url, {
        headers: {
          "X-CSRF-TOKEN": token,
        },
        method: "post",
        body: form,
      });
      let data = await seend.json();
      let resp = data.estado;
      //console.log(data);
      switch (resp) {
        case 1:
          if (data.execute == "exito") {
            super.success_message(data.mensaje);
            setTimeout(() => {
              location.reload();
            }, 2000);
          }
          if (data.execute == "error") {
            super.error_message(data.mensaje);
          }
          break;
        case 0:
          break;
        default:
          break;
      }
    } catch (error) {
      console.log(error);
    }
  };
}

//const btnDelete = document.querySelector("");

const deleteRol = (id) => {
  //alert(id);
  Swal.fire({
    title: "Estas seguro de eliminar el Rol?",
    text: "El Rol ya no estara disponible en el sistema!",
    type: "warning",
    showCancelButton: true,
    confirmButtonColor: "#3085d6",
    cancelButtonColor: "#d33",
    confirmButtonText: "Aceptar",
    cancelButtonText: "Cancelar",
  }).then((result) => {
    if (result.value) {
      let url = "/downrol";
      let formrol = new FormData();
      formrol.append("id", id);
      const rol = new rolesAccions();
      rol.downRol(url, formrol);
    }
  });
};
