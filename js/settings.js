var changed = false;
var color_variables_personal = [];
var color_variables_organization = [];

const inputOrganization = document.querySelector('#inputOrganization');
inputOrganization.addEventListener('change', () => {changed = true;});

const inputName = document.querySelector('#inputName');
inputName.addEventListener('keyup', () => {changed = true;});

document.addEventListener('DOMContentLoaded', function () {
    const pickerPersonal = document.querySelectorAll('#pickerPersonal');
    const root = document.querySelector(':root');
    
    pickerPersonal.forEach((input) => {
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
        
        color_variables_personal.push([variableToChange, input.value]);
            
        
        pickr.on('save', (color, instance) => {
            instance.hide();
            const hex = color.toHEXA().toString();
            input.value = hex;
            
            root.style.setProperty(variableToChange, hex);
    
            const thisIndex = color_variables_personal.findIndex(element => element[0] === variableToChange);
           
            color_variables_personal[thisIndex][1] = hex;
    
        });
        
        pickr.on('change', (color) => {
            const hex = color.toHEXA().toString();
            changed = true;
            root.style.setProperty(variableToChange, hex);
            input.value = hex;

            const thisIndex = color_variables_personal.findIndex(element => element[0] === variableToChange);
           
            color_variables_personal[thisIndex][1] = hex;
            
        });
        
        pickr.on('hide', (instance) => {
            instance.applyColor();
        });
        
        pickr.on('cancel', (instance) => {
            root.style.setProperty(variableToChange, colorValue);
            instance.hide();
        });
    });

    const pickerOrganization = document.querySelectorAll('#pickerOrganization');

    pickerOrganization.forEach((input) => {
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
        
        color_variables_organization.push([variableToChange, input.value]);
            
        
        pickr.on('save', (color, instance) => {
            instance.hide();
            const hex = color.toHEXA().toString();
            input.value = hex;
            
            root.style.setProperty(variableToChange, hex);
    
            const thisIndex = color_variables_organization.findIndex(element => element[0] === variableToChange);
           
            color_variables_organization[thisIndex][1] = hex;
    
        });
        
        pickr.on('change', (color) => {
            const hex = color.toHEXA().toString();
            changed = true;
            root.style.setProperty(variableToChange, hex);
            input.value = hex;
            
            const thisIndex = color_variables_organization.findIndex(element => element[0] === variableToChange);
           
            color_variables_organization[thisIndex][1] = hex;
            
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
        
        var values_personal = compileString(color_variables_personal);
        var values_organization = compileString(color_variables_organization);
        var activeOrg = document.getElementById("inputOrganization").value;
        var name = document.getElementById("inputName").value;
        var useTemplate = '';
        
        if (document.getElementById("useTemplate").checked) {
            useTemplate = "true";
        }else{
            useTemplate = "false";
        }

        let formData = new FormData();
    
        formData.append('values_personal', values_personal);
        formData.append('values_organization', values_organization);
        formData.append('name', name);
        formData.append('use_template', useTemplate);
        formData.append('active_organization', activeOrg)
        
        var xhr = new XMLHttpRequest();
        xhr.open('POST', 'saveSettings.php', true);
        xhr.onload = function() {
            if(this.responseText.trim() == "success"){
                
                location.reload();
            } else{
                console.error(this.responseText);
            }
        };
        
        xhr.send(formData);
    
    } else{
        alert('Nothing has changed.');
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
    console.log(compileString(color_variables_personal));
    
    navigator.clipboard.writeText(compileString(color_variables_personal));
    
}

function toggleJoin(b){
    const settingsPanel = document.getElementById('settingsPanel');
    const joinPanel = document.getElementById('joinPanel');

    if(!b){
        joinPanel.classList.add('hide');
        settingsPanel.classList.remove('hide');
    } else{
        joinPanel.classList.remove('hide');
        settingsPanel.classList.add('hide');
    }
    
}

function joinCheck(){
    
    var joinOrg = document.getElementById("inputJoin").value;
    
    let formData = new FormData();

    formData.append('join_org', joinOrg);
    var xhr = new XMLHttpRequest();
    xhr.open('POST', 'registerAction.php', true);
    xhr.onload = function() {
        if(this.responseText.trim() == "success"){
            alert('Success! Just wait for the confirmation from the organization Admins.');
            location.reload();
        } else{
            alert(this.responseText);
        }
    };
    
    xhr.send(formData);
}