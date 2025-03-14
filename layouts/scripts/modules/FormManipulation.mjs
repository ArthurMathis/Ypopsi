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
        this.elmt = document.createElement('select');
        this.elmt.name = this.inputName;
        this.elmt.id = this.inputName;

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
     * @param {String} icon The path of the icon
     */
    constructor(inputName, inputParent, nbMaxInput=null, icon=null) {
        this.inputName = inputName;
        this.inputParent = document.getElementById(inputParent);
        this.nbMaxInput = nbMaxInput;
        this.icon = icon;

        this.nbInput = 0;
        this.inputList = new Array();

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
        if(this.nbMaxInput && this.nbMaxInput <= this.nbInput) {
            this.deleteButton();
        }

        const inputElement = this.createElement();
        
        this.inputParent.appendChild(inputElement);
        const e = new CustomEvent('elementCreated', { detail: { element: inputElement }});
        document.dispatchEvent(e);

        this.inputList.push(inputElement);
    }
    /**
     * @function deleteButton
     * @description Function deleeting the add button 
     */
    deleteButton() { this.button.remove(); }

    /**
     * @function createTrash
     * @description Function creating the delete button
     * @returns {HTMLInputElement}
     */
    createTrash() {
        const trash = document.createElement('button');
        trash.type = 'button';

        trash.addEventListener('click', () => {
            const parent = trash.parentElement;
            if (parent) {
                parent.remove();
            }
        });

        const img = document.createElement('img');
        img.src = this.icon;
        this.alt = "Supprimer";

        trash.appendChild(img);

        return trash;
    }

    /**
     * @function isValidIndex
     * @description Function testing if an index correponds to an input
     * @param {Integer} index The index 
     * @returns {Boolean}
     */
    isValidIndex(index) {
        return 0 <= index && index <= this.nbInput - 1;
    }
}
/**
 * @class implementInputSuggestions
 * @classdesc Class representing an optionnal input that needs some suggestions
 * @author Arthur MATHIS
 */
class implementInputSuggestions extends implementInput {
    /**
     * @constructor 
     * @param {String} inputName The input's name 
     * @param {HTMLInputElement} inputParent The container of inputs to generate
     * @param {Array<String>} suggestions The array containing the list of suggestions for the Autocomplete
     * @param {Integer} nbMaxInput The maximum number of inputs allowed in the container
     * @param {String} icon The path of the icon
     */
    constructor(inputName, inputParent, suggestions=[], nbMaxInput=null, icon=null) {
        super(inputName, inputParent, nbMaxInput, icon);
        this.suggestions = Array.from(suggestions);
    }

    /**
     * @function isAnOption
     * @description Function testing is an index corresponds to an option
     * @param {Integer} index The index to test
     * @returns {Boolean}
     */
    isAnOption(index) {
        return 0 <= index && index <= this.suggestions.length - 1;
    }
}
/**
 * @class implementInputAutoComplete
 * @classdesc Class representing an optionnnal AutoComplete input 
 * @author Arthur MATHIS
 */
class implementInputAutoComplete extends implementInputSuggestions {
    /**
     * @constructor
     * @param {String} inputName The input's name 
     * @param {HTMLElement} inputParent The input's HTML parent
     * @param {Array<String>} suggestions The array containing the list of suggestions for the Autocomplete
     * @param {String} placeholder The string to write in the input placeholder
     * @param {Integer} nbMaxInput The maximum number of inputs allowed in the container
     * @param {String} icon The path of the icon
     */
    constructor(inputName, inputParent, suggestions=[], placeholder=null, nbMaxInput=null, icon=null) {
        super(inputName, inputParent, suggestions, nbMaxInput, icon);
        this.placeholder = placeholder;
    }

    /**
     * @function createElement
     * @description Function generating a suggestion window
     * @returns {HTMLElement}
     */
    createElement() {
        const container = document.createElement("div");
        container.className = "double-items";

        container.appendChild(this.createAutoComplete());
        container.appendChild(this.createTrash());

        return container;
    }

    /**
     * @function createAutocomplete
     * @description Function building and returning a new AutoComplete input
     * @returns {HTMLElement}
     */
    createAutoComplete() {
        const inputElement = document.createElement('div');
        inputElement.className = "autocomplete";

        const input = document.createElement('input');
        input.type = "text";
        input.id = this.inputName + "-" + this.nbInput;
        input.name = this.inputName + "[]";
        input.autocomplete = "off";
        if(this.placeholder) {
            input.placeholder = this.placeholder;
        }
        
        inputElement.appendChild(input);
        inputElement.appendChild(document.createElement("article"));
    
        this.inputElement = new AutoComplete(input, this.suggestions);
    
        return inputElement;
    }

    /**
     * @function setValue
     * @description Function setting a value in an input
     * @param {Integer} input The index of the input
     * @param {Integer} value The index of the suggestion
     */
    setValue(input, value) {
        if(!this.isValidIndex(input)) {
            throw new Error(`Aucun input ne correspond à cette requête. Index demandé ${input}, index maximal : ${this.nbInput - 1}`);
        } else if(!this.isAnOption(value)) {
            throw new Error(`Aucune valeur ne correspond à cette requête. Index demandé ${value}, index maximal : ${this.suggestions - 1}`);
        }

        this.inputList[input].value = this.suggestions[value].text;
        this.inputList[input].dataset.selectedPrimaryKey = this.suggestions[value].key;
    }

    /**
     * @function setDataset
     * @description unction setting a value in an autocomplete
     * @param {Integer} input The index of the input in the list of inputs 
     * @param {Integer} value The index of the value in the list of suggestions
     */
    setDataset(input, value) {
        input.value = this.suggestions[value].text;
        input.dataset.selectedPrimaryKey = this.suggestions[value].key;
    }
}

/**
 * @class implementInputAutoCompleteDate
 * @classdesc Class representing optionnnal AutoComplete and date inputs
 * @author Arthur MATHIS
 */
class implementInputAutoCompleteDate extends implementInputAutoComplete {
    /**
     * @constructor
     * @param {String} inputName The input's name 
     * @param {HTMLElement} inputParent The input's HTML parent
     * @param {Array<String>} suggestions The array containing the list of suggestions for the Autocomplete
     * @param {String} placeholder The string to write in the input placeholder
     * @param {Integer} nbMaxInput The maximum number of inputs allowed in the container
     * @param {String} icon The path of the icon
     */
    constructor(inputName, inputParent, suggestions=[], placeholder=null, nbMaxInput=null, icon=null) {
        super(inputName, inputParent, suggestions, placeholder, nbMaxInput, icon);
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
        container.appendChild(this.createTrash());

        return container;
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

    /**
     * @function setValue
     * @description Function setting values in an input
     * @param {Integer} input The index of the input in the list of inputs 
     * @param {Integer} value The index of the value in the list of suggestions 
     * @param {String} date The date to implente 
     */
    setValue(input, value, date) {
        if(!this.isValidIndex(input)) {
            throw new Error(`Aucun input ne correspond à cette requête. Index demandé ${input}, index maximal : ${this.nbInput - 1}`);
        } else if(!this.isAnOption(value)) {
            throw new Error(`Aucune valeur ne correspond à cette requête. Index demandé ${value}, index maximal : ${this.suggestions.length - 1}`);
        }

        const in_value = this.inputList[input].querySelector(".autocomplete input");
        this.setDataset(in_value, value);
        const in_date = this.inputList[input].querySelector("input[type=date]");
        in_date.value = date;
    }
}

/**
 * @class implementInputList
 * @classdesc Class representing an optionnnal AutoComplete input 
 * @author Arthur MATHIS
 */
class implementInputList extends implementInputSuggestions {
    /**
     * @constructor
     * @param {String} inputName The input's name 
     * @param {HTMLElement} inputParent The input's HTML parent
     * @param {Array<String>} suggestions The array containing the list of suggestions for the Autocomplete
     * @param {Integer} nbMaxInput The maximum number of inputs allowed in the container
     * @param {String} icon The path of the icon
     */
    constructor(inputName, inputParent, suggestions=[], nbMaxInput=null, icon=null) {
        super(inputName, inputParent, suggestions, nbMaxInput, icon);
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

    /**
     * @function setValue
     * @description Function setting an option in a select
     * @param {Integer} index The position of the input in the inputlist
     * @param {Integer} value The option to select
     * @return {Void}
     */
    setValue(index, value) {
        if(this.nbInput <= index) {
            throw new Error(`L'input demandé est invalide. Valeur maximale : ${this.nbInput} ; valeur demandée : ${index}.`);
        }

        let i = 0;
        let valid = false;
        while(!valid && i < this.inputList[index].options.lenght) {
            if(this.inputList[index].options[i].value) {
                valid = true;
            }

            i++;
        }

        this.inputList[index].value = value;

        const event = new Event('change', { bubbles: true });
        this.inputList[index].dispatchEvent(event);
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
    constructor(inputName, inputParent, nbMaxInput=null, icon=null) {
        super(inputName, inputParent, nbMaxInput, icon);
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