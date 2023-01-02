const images = document.querySelectorAll("input[type='file']");

for (let i = 0; i < images.length; i++) {
    image = images[i];
    image.addEventListener("change", () => {
        // Exit if no files selected
        if (!image.files.length) return;

        let file = image.files.item(0);
        
        if(file){
            var reader = new FileReader();

            reader.onload = function(){
                const preview = document.querySelector("#previewImg");
                preview.setAttribute("src", reader.result);
            }

            reader.readAsDataURL(file);
          }
    });
}
