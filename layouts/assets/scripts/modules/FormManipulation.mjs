import { AutoComplete } from "./AutoComplete.mjs";

/**
 * @function setMinEndDate
 * @description Function checking that the start date is less than or equal to the end date
 * @param {HTMLInputElement} startDateInput The start date's input
 * @param {HTMLInputElement} endDateInput  The end date's input
 * @author Arthur MATHIS
 */
function setMinEndDate(startDateInput, endDateInput) {
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
 * @function manageSubit
 * @description Function receiving the submit event from the form and manage their parameters to send the right data (with AutoComplete input and others...)
 * @param {SubmitEvent} event The event for submit the form
 * @author Arthur MATHIS
 */
function manageSubmit(event) {
    event.preventDefault();
    event.target.querySelectorAll('input').forEach(elmt => {
        if(elmt.value && elmt.parentElement.classList.contains('autocomplete')) {
            console.log(`L'élément ${elmt} contient la valeur : ${elmt.value} et doit prendre la valeur : ${elmt.dataset.selectedPrimaryKey}.`);
            elmt.value = elmt.dataset.selectedPrimaryKey;
        }
    });
    event.target.submit();
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
    if(input.value === searchValue) {
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
        // TODO : remplacer l'autocomplete input par une liste déroulante
        // *  Autocomplete remanier pour renvoyer une clé primaire
        // ! Utile de remanier cette méthode ? 

        this.elmt = document.createElement('select');
        this.elmt.name = this.inputName;
        this.suggestions.forEach(c => {
            const option = document.createElement('option');
            option.value = c.id;
            option.textContent = c.text;
            this.elmt.appendChild(option);
        });

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
 */
class implementInput {
    /**
     * @constructor 
     * @param {String} inputName The input's name 
     * @param {HTMLInputElement} inputParent The container of inputs to generate
     * @param {Integer} nbMaxInput The maximum number of inputs allowed in the container
     */
    constructor(inputName, inputParent, nbMaxInput=null) {
        this.inputName = inputName;
        this.inputParent = document.getElementById(inputParent);
        this.nbMaxInput = nbMaxInput;
        this.nbInput = 0;

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

        const inputElement = this.createElement();

        this.inputParent.appendChild(inputElement);
        const e = new CustomEvent('elementCreated', { detail: { element: inputElement }});
        document.dispatchEvent(e);
    }
    /**
     * @function deleteButton
     * @description Function deleeting the add button 
     */
    deleteButton() { this.button.remove(); }

}
/**
 * @class implementInputAutoComplete
 * @classdesc Class representing an optionnnal AutoComplete input 
 * @author Arthur MATHIS
 */
class implementInputAutoComplete extends implementInput {
    /**
     * @constructor
     * @param {String} inputName The input's name 
     * @param {HTMLElement} inputParent The input's HTML parent
     * @param {Array<String>} suggestions The array containing the list of suggestions for the Autocomplete
     * @param {String} placeholder The string to write in the input placeholder
     * @param {Integer} nbMaxInput The maximum number of inputs allowed in the container
     */
    constructor(inputName, inputParent, suggestions=[], placeholder=null, nbMaxInput=null) {
        super(inputName, inputParent, nbMaxInput);
        this.placeholder = placeholder;
        this.suggestions = Array.from(suggestions);
    }

    /**
     * @function createElement
     * @description Function generating a suggestion window
     * @returns {HTMLElement}
     */
    createElement() {
        const inputElement = document.createElement('div');
        inputElement.className = "autocomplete";
    
        const input = document.createElement('input');
        input.type = 'text';
        input.id = this.inputName + '-' + this.nbInput;
        input.name = this.inputName + '[]';
        input.autocomplete = 'off';
        if(this.placeholder)
            input.placeholder = this.placeholder;
        
        inputElement.appendChild(input);
        inputElement.appendChild(document.createElement('article'));
    
        const tab = [];
        this.suggestions.forEach(c => { tab.push(c.text); });
        this.inputElement = new AutoComplete(input, tab);
    
        return inputElement;
    }
}
/**
 * @class implementInputList
 * @classdesc Class representing an optionnnal AutoComplete input 
 * @author Arthur MATHIS
 */
class implementInputList extends implementInput {
    /**
     * @constructor
     * @param {String} inputName The input's name 
     * @param {HTMLElement} inputParent The input's HTML parent
     * @param {Array<String>} suggestions The array containing the list of suggestions for the Autocomplete
     * @param {Integer} nbMaxInput The maximum number of inputs allowed in the container
     */
    constructor(inputName, inputParent, suggestions=[], nbMaxInput=null) {
        super(inputName, inputParent, nbMaxInput);
        this.suggestions = Array.from(suggestions);

        console.log(this.suggestions);
    }

    /**
     * @function createElement
     * @description Function generating a suggestion window
     * @returns {HTMLElement}
     */
    createElement() {
        const inputElement = document.createElement('select');
        inputElement.name = this.inputName + '[]';
        this.suggestions.forEach(c => {
            const option = document.createElement('option');
            option.value = c.key;
            option.textContent = c.text;
        
            inputElement.appendChild(option);
        });

        return inputElement;
    } 
}
/**
 * @class implementInputDate
 * @classdesc Class representing an optionnnal AutoComplete input 
 * @author Arthur MATHIS
 */
class implementInputDate extends implementInput {
    /**
     * @constructor
     * @param {String} inputName The input's name 
     * @param {HTMLElement} inputParent The input's HTML parent
     * @param {Integer} nbMaxInput The maximum number of inputs allowed in the container
     */
    constructor(inputName, inputParent, nbMaxInput=null) {
        super(inputName, inputParent, nbMaxInput);
    }

    /**
     * @function createElement
     * @description Function generating a date input
     * @returns {HTMLInputElement}
     */
    createElement() {
        const inputElement = document.createElement('input');
        inputElement.type = 'date';
        inputElement.setAttribute('min', new Date().toISOString().split('T')[0]);
        inputElement.name = this.inputName  + '[]';
        inputElement.id = this.inputName;

        return inputElement;
    }
}
/**
 * @class implementInputAutoCompleteDate
 * @classdesc Class representing optionnnal AutoComplete and date inputs
 * @author Arthur MATHIS
 */
class implementInputAutoCompleteDate extends implementInput {
    /**
     * @constructor
     * @param {String} inputName The input's name 
     * @param {HTMLElement} inputParent The input's HTML parent
     * @param {Array<String>} suggestions The array containing the list of suggestions for the Autocomplete
     * @param {String} placeholder The string to write in the input placeholder
     * @param {Integer} nbMaxInput The maximum number of inputs allowed in the container
     */
    constructor(inputName, inputParent, suggestions=[], placeholder=null, nbMaxInput=null) {
        super(inputName, inputParent, nbMaxInput);
        this.placeholder = placeholder;
        this.suggestions = Array.from(suggestions);
    }

    /**
     * @function createElement
     * @description Function generating a date input
     * @returns {HTMLInputElement}
     */
    createElement() {
        const container = document.createElement('div');
        container.className = 'double-items';

        container.appendChild(this.createAutoComplete());
        container.appendChild(this.createDate());

        return container;
    }
    /**
     * @function createElement
     * @description Function generating a suggestion window
     * @returns {HTMLElement}
     */
    createAutoComplete() {
        const inputElement = document.createElement('div');
        inputElement.className = "autocomplete";
    
        const input = document.createElement('input');
        input.type = 'text';
        input.id = this.inputName + '-' + this.nbInput;
        input.name = this.inputName + '[]';
        input.autocomplete = 'off';
        if(this.placeholder)
            input.placeholder = this.placeholder;
        
        inputElement.appendChild(input);
        inputElement.appendChild(document.createElement('article'));
    
        const tab = [];
        this.suggestions.forEach(c => { tab.push(c.text); });
        // this.inputElement = new AutoComplete(input, tab);
        this.inputElement = new AutoComplete(input, this.suggestions);

        return inputElement;
    }
    /**
     * @function createElement
     * @description Function generating a date input
     * @returns {HTMLInputElement}
     */
    createDate() {
        const inputElement = document.createElement('input');
        inputElement.type = 'date';
        inputElement.name = this.inputName + 'Date[]';
        inputElement.id =  this.inputName + 'Date-' + this.nbInput;
        inputElement.placeholder = "Date d'obtention";
        inputElement.max = new Date().toISOString().split("T")[0];

        return inputElement;
    }
}

export const formManipulation = { 
    setMinEndDate, 
    manageSubmit,
    setCooptInput, 
    cooptInput, 
    implementInputAutoComplete, 
    implementInputList, 
    implementInputDate,
    implementInputAutoCompleteDate
};