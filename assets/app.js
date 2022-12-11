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


let plantPictureInput = document.getElementById('achievement_file_file');
let plantPicture = document.getElementById('PlantPicture');
plantPictureInput.setAttribute("accept","image/*");
plantPictureInput.setAttribute("capture","camera");

document.addEventListener("load",SetInputAchievement);

 
 

 function SetInputAchievement(){
    plantPictureInput.setAttribute("accept","image/*");
    plantPictureInput.setAttribute("capture","camera");
}

plantPictureInput.onchange = evt => {
    const [file] = plantPictureInput.files
    if (file) {
        plantPicture.src = URL.createObjectURL(file);
    }
  }