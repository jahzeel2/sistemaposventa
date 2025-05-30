const radios = document.querySelector('.div_roles_permisos');
const getvalueradio = (value) =>{
    if (document.querySelector('input[name="full-access"]:checked')) {
        switch (value) {
           case "yes":
              radios.style.display = "none";
               break;
            case "no":
              radios.style.display = "block";
                break;
           default:
               break;
        }
    }
}

/** */
const slug = document.querySelector("#slug");
const nameRol = document.querySelector("#name");
nameRol.addEventListener("keyup", (event) => {
    //e.preventDefault;
    //console.log(event.target.value)
    slug.value = event.target.value;
});