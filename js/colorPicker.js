var changed = false;
var color_variables = [];

document.addEventListener('DOMContentLoaded', function () {
    const pickerInputs = document.querySelectorAll('#picker');
    const root = document.querySelector(':root');
    
    pickerInputs.forEach((input) => {
        var colorValue = input.value;
        const pickr = Pickr.create({
            el: input,
            theme: 'classic',
            default: colorValue,
            appClass: 'color-picker-icon',
            components: {
                preview: true,
                opacity: true,
                hue: true,
                interaction: {
                    hex: true,
                    rgba: true,
                    input: true,
                    cancel:true,
                    save: true
                }
            }
        });
        
        var variableToChange = input.getAttribute('variable');
        
        color_variables.push([variableToChange, input.value]);
            
        
        pickr.on('save', (color, instance) => {
            instance.hide();
            const hex = color.toHEXA().toString();
            input.value = hex;
            
            root.style.setProperty(variableToChange, hex);
    
            const thisIndex = color_variables.findIndex(element => element[0] === variableToChange);
           
            color_variables[thisIndex][1] = hex;
    
        });
        
        pickr.on('change', (color) => {
            const hex = color.toHEXA().toString();
            changed = true;
            root.style.setProperty(variableToChange, hex);
            input.value = hex;

            const thisIndex = color_variables.findIndex(element => element[0] === variableToChange);
           
            color_variables[thisIndex][1] = hex;
            
        });
        
        pickr.on('hide', (instance) => {
            instance.applyColor();
        });
        
        pickr.on('cancel', (instance) => {
            root.style.setProperty(variableToChange, colorValue);
            instance.hide();
        });
    });
});

function checkBoxClick(){
    changed = true;
}

function saveButton(){
    
    if (changed){
        
        var values = compileString(color_variables);
        var useTemplate = '';
        
        if (document.getElementById("useTemplate").checked) {
            useTemplate = "true";
        }else{
            useTemplate = "false";
        }

        let formData = new FormData();
    
        formData.append('values', values);
        formData.append('use_template', useTemplate);
        
        var xhr = new XMLHttpRequest();
        xhr.open('POST', 'saveSettings.php', true);
        xhr.onload = function() {
            if(this.responseText.trim() == "success"){
                
                location.reload();
            }
        };
        
        xhr.send(formData);
    
    }

}

function compileString(val){
    var text = "";

    for (let i = 0; i < val.length; i++) {
        if (i === val.length - 1) {
          text += val[i][0] + ": " + val[i][1] + ";";
        } else {
          text += val[i][0] + ": " + val[i][1] + "; | ";
        }
      }
      

    return text;
}

function cancelButton(){
    if(changed){
        if (confirm("Discard Changes?") == true) {
            location.reload();
          } else {
            
          }
    }
    
    
}

function printColors(){
    console.log(compileString(color_variables));
    
    navigator.clipboard.writeText(compileString(color_variables));
    
}
