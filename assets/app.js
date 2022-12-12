/*
 * Welcome to your app's main JavaScript file!
 *
 * We recommend including the built version of this JavaScript file
 * (and its CSS file) in your base layout (base.html.twig).
 */

// any CSS you import will output into a single css file (app.css in this case)
import './styles/app.css';

// start the Stimulus application
import './bootstrap';


let plantPictureInput = document.getElementById('achievement_file_name');
let plantPicture = document.getElementById('PlantPicture');
let hiddenInput = document.getElementById("achievement_plant");
let hiddenLabel =  document.querySelector('[for="achievement_plant"]');
let labelValidationPlante = document.getElementById("labelValidationPlante");






hiddenLabel.style.visibility = "hidden";
hiddenInput.style.visibility = "hidden";
plantPictureInput.setAttribute("accept","image/*");
plantPictureInput.setAttribute("capture","camera");
labelValidationPlante.style.visibility = "hidden";


document.addEventListener("load",SetInputAchievement);

  
 

 function SetInputAchievement(){
    hiddenLabel.style.visibility = "hidden";
    hiddenInput.style.visibility = "hidden";
    plantPictureInput.setAttribute("accept","image/*");
    plantPictureInput.setAttribute("capture","camera");
    labelValidationPlante.style.visibility = "hidden";



}
 
plantPictureInput.onchange = evt => {
    const [file] = plantPictureInput.files
    if (file) {
        plantPicture.src = URL.createObjectURL(file);
        labelValidationPlante.style.visibility = "visible";
    }
  }