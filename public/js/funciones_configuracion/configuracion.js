const imgupload = document.querySelector("#file");
const previewcontainer = document.querySelector("#imagepreview");
const previewimage = document.querySelector("#preview");

imgupload.addEventListener("change", (e) => {
  e.preventDefault();
  const file = imgupload.files[0];
  //console.log(file);
  if (file) {
    const reader = new FileReader();
    reader.addEventListener("load", (e) => {
      e.preventDefault();
      //console.log(reader);
      previewimage.setAttribute("src", reader.result);
    });
    reader.readAsDataURL(file);
  }else{
      previewimage.setAttribute("src","");
      previewimage.textContent = "Adjuntar la imagen";
      
  }
});
