import { AutoComplete } from "./AutoComplete.mjs";

/**
 * @function SetMinEndDate
 * @description Function checking that the start date is less than or equal to the end date
 * @param {HTMLInputElement} startDateInput The start date's input
 * @param {HTMLInputElement} endDateInput  The end date's input
 * @author Arthur MATHIS
 */
function SetMinEndDate(startDateInput, endDateInput) {
    const startInput = document.getElementById(startDateInput);
    const endInput = document.getElementById(endDateInput);

    endInput.setAttribute('min', startInput.getAttribute('min'));
    startInput.addEventListener('input', () => {
        endInput.setAttribute('min', startInput.value);
        if(endInput.value && endInput.value < startInput.value)
            endInput.value = startInput.value;
    });
}

/**
 * @function setCooptInput
 * @description Function adding a new cooptInput to the HTML form
 * @param {HTMLInputElement} input The HTML input
 * @param {String} inputName The input's Classname
 * @param {String} searchValue The searched value
 * @param {Array<String>} suggestions The list of values
 * @author Arthur MATHIS
 */
function setCooptInput(input, inputName, searchValue, suggestions) {
    if(input.value == searchValue) {
        const elmt = document.createElement('div');
        elmt.className = 'autocomplete'
        const new_i = document.createElement('input');
        new_i.type = 'text';
        new_i.name = inputName + '[]';
        new_i.autocomplete = 'off';

        elmt.appendChild(new_i);
        elmt.appendChild(document.createElement('article'));

        const tab = [];
        suggestions.forEach(c => { tab.push(c.text); });
        const autocomp = new AutoComplete(new_i, tab);

        const parent = input.parentNode;
        if (parent.lastChild === input) parent.appendChild(elmt);
        else parent.insertBefore(elmt, input.nextSibling);  
    }
}
/**
 * @class cooptInput
 * @classdesc Class representing an coopter input 
 * @author Arthur MATHIS
 */
class cooptInput {
    /**
     * @constructor
     * @param {HTMLInputElement} input The HTML input
     * @param {String} inputName The input's Classname
     * @param {String} searchValue The searched value
     * @param {Array<String>} suggestions The ist of values
     */
    constructor(input, inputName, searchValue, suggestions) {
        this.input = input;
        this.inputName = inputName;
        this.searchValue = searchValue;
        this.suggestions = suggestions;

        Swal.fire({
            title            : 'Information',
            text             : "Vous ne pouvez renseigner qu'une prime de cooptation !",
            icon             : 'info',
            position         : "top-end",
            backdrop         : false,
            timer            : 6000,
            showConfirmButton: false,
            customClass      : {
                popup        : 'notification',
                title        : 'notification-title',
                content      : 'notification-content',
                confirmButton: 'action_button reverse_color'
            }
        });
    }

    /**
     * @function react
     * @description Function reacting to the change of input value
     */
    react() {
        if(this.input.value == this.searchValue) 
            this.createInput();
        else 
            this.destroyInput();
    }

    /**
     * @function createInput
     * @description Function generating the suggestion window
     */
    createInput() {
        this.elmt = document.createElement('div');
        this.elmt.className = 'autocomplete'
        const new_i = document.createElement('input');
        new_i.type = 'text';
        new_i.name = this.inputName + '[]';
        new_i.autocomplete = 'off';

        this.elmt.appendChild(new_i);
        this.elmt.appendChild(document.createElement('article'));

        const tab = [];
        this.suggestions.forEach(c => { tab.push(c.text); });
        this.autocomplete = new AutoComplete(new_i, tab);

        const parent = this.input.parentNode;
        if (parent.lastChild === this.input) 
            parent.appendChild(this.elmt);
        else 
            parent.insertBefore(this.elmt, this.input.nextSibling);  
    }
    /**
     * @function destroyInput
     * @description Function destroying the suggestion window
     */
    destroyInput() {
        if(this.autocomplete) 
            this.autocomplete = null;
        if(this.elmt) 
            this.elmt.remove();
    }
}

/**
 * @class implementInput
 * @classdesc Class representing an optionnnal input 
 * @author Arthur MATHIS
 * 
 * TODO : à compléter (ajout des méthodes de génératipn d'input : paramètre sélection de l'autocomplet + parent + type d'input)
 */
class implementInput {
    /**
     * @constructor
     * @param {HTMLInputElement} inputParent The container of inputs to generate
     * @param {String} inputType The input's type
     * @param {Integer} nbMaxInput The maximum number of inputs allowed in the container
     * @param {Array<String>} suggestions The array containing the list of suggestions
     */
    constructor(inputName, inputParent, inputType, nbMaxInput, suggestions) {
        this.inputName = inputName;
        this.inputParent = document.getElementById(inputParent);
        this.inputType = inputType
        this.nbMaxInput = nbMaxInput;
        this.nbInput = 0;
        this.suggestions = Array.from(suggestions);

        this.init();
    }

    /**
     * @function init
     * @description Function initializing the implementInput
     */
    init() {
        this.button = this.inputParent.querySelector('button');
        this.button.addEventListener('click', () => {
            Swal.fire({
                title            : "Question ?",
                text             : "Voulez-vous ajouter un nouvel input ?",
                icon             : 'question',
                backdrop         : false,
                focusConfirm     : false,
                showCancelButton : true,
                cancelButtonText : 'Annuler',
                confirmButtonText: 'Confirmer',
                customClass      : {
                    popup        : 'notification',
                    title        : 'notification-title',
                    content      : 'notification-content',
                    confirmButton: 'action_button reverse_color',
                    cancelButton : 'action_button cancel_button',
                    actions      : 'notification-actions'
                }
            }).then((result) => {
                if (result.isConfirmed) 
                    this.addInput();
            });
        });
    }
    /**
     * @function addInput
     * @description Function reacting to the create input request
     */
    addInput() {
        this.nbInput++;
        if(this.nbMaxInput && this.nbMaxInput <= this.nbInput)
            this.deleteButton();
        this.createInput();
    }
    /**
     * @function createInput
     * @description Function creating a new input
     */
    createInput() {
        let inputElement;
        switch(this.inputType) {
            case 'autocomplete': 
            inputElement = this.createAutoComplete();
                break;

            case 'liste':
                inputElement = this.createListe();
                break;   

            case 'date':
                inputElement = this.createDate();
                break;  

            case 'autocomplete/date':
                inputElement = this.createAutoCompleteDate();    
                break;

            default: throw new Error("Type d'input non reconnu. Génération d'input impossible !"); 
        }
        
        this.inputParent.appendChild(inputElement);
        const e = new CustomEvent('elementCreated', { detail: { element: inputElement }});
        document.dispatchEvent(e);
    }
    /**
     * @function deleteButton
     * @description Function deleeting the add button 
     */
    deleteButton() { this.button.remove(); }

    /**
     * @function createAutoCopmlete
     * @description Function generating a suggestion window
     * @returns {HTMLInputElement}
     */
    createAutoComplete() {
        const autocomplete = document.createElement('div');
        autocomplete.className = "autocomplete";

        const input = document.createElement('input');
        input.type = 'text';
        input.id = this.inputName + '-' + this.nbInput;
        input.name = this.inputName + '[]';
        this.autocomplete = 'off';
        
        autocomplete.appendChild(input);
        autocomplete.appendChild(document.createElement('article'));

        const tab = [];
        this.suggestions.forEach(c => { tab.push(c.text); });
        this.autocomplete = new AutoComplete(input, tab);

        return autocomplete;
    }
    /**
     * @function createListe
     * @description Function generating a list input
     * @returns {HTMLInputElement}
     */
    createListe() {
        const select = document.createElement('select');
        select.name = this.inputName + '[]';

        this.suggestions.forEach(c => {
            const option = document.createElement('option');
            option.value = c.id;
            option.textContent = c.text;
        
            select.appendChild(option);
        });

        return select;
    } 
    /**
     * @function createDate
     * @description Function generating a date input
     * @returns {HTMLInputElement}
     */
    createDate() {
        const dateInput = document.createElement('input');
        dateInput.type = 'date';
        dateInput.setAttribute('min', new Date().toISOString().split('T')[0]);
        dateInput.name = this.inputName  + '[]';
        dateInput.id = this.inputName;

        return dateInput;
    }
    /**
     * @function createAutoCompleteDate
     * @description Function generating a double-input (Autocomplete + Date)
     * @returns {HTMLInputElement}
     */
    createAutoCompleteDate() {
        const container = document.createElement('div');
        container.className = 'double-items';

        const yearInput = document.createElement('input');
        yearInput.type = 'number';
        yearInput.name = this.inputName + 'Date[]';
        yearInput.id =  this.inputName + 'Date-' + this.nbInput;
        yearInput.min = 1900; 
        yearInput.max = new Date().getFullYear(); 
        yearInput.placeholder = "Année d'obtention";

        container.appendChild(this.createAutoComplete());
        container.appendChild(yearInput);

        return container;
    }
}

export const formManipulation = { SetMinEndDate, setCooptInput, cooptInput, implementInput };