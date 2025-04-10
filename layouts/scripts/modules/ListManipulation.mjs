export const listManipulation = {
    clearFields,
    clearFieldsCheckbox,
    clearFieldsDate,
    createTable,
    deleteLines,
    destroyTable,
    displayCountItems,
    hideMenu,
    multiFilter,
    recupApplications,
    recoverCheckbox,
    recoverFields,
    recoverFieldsDate,
    responsive,
    resetLines,
    setColor,
    setColorAvailability,
    showMenu,
    sortBy
};


// * GRAPHICS * //
/**
 * @function resetLines
 * @description Function displaying a HTMLTable's rows
 * @param {HTMLTableElement} items The HTMLTable to display
 * @author Arthur MATHIS
 */
function resetLines(items) {
    if(items === null)
        return ;

    for(let i = 0; i < items.length; i++) 
        items[i].style.display = 'table-row';
}
/**
 * @function deleteLines
 * @description Function hiding a HTMLTable's rows
 * @param {HTMLTableElement} items The HTMLTable to hide
 * @author Arthur MATHIS
 */
function deleteLines(items) {
    if(items === null)
        return ;

    for(let i = 0; i < items.length; i++) 
        items[i].style.display = 'none';
}
/**
 * @function displayCountItems
 * @description Function displaying the number of elements in a list
 * @param {HTMLElement} item The element in which to write
 * @param {Integer} nb_items The number of elements present
 * @author Arthur MATHIS
 */
function displayCountItems(item, nb_items) {
    if(item === null || !Number.isInteger(nb_items))
        return;

    item.innerHTML = nb_items;
}

/**
 * @function
 * @description Function displaying the search/filter menu
 * @param {HTMLElement} item The menu
 * @author Arthur MATHIS
 */
function showMenu(item) { item.classList.add('active'); }
/**
 * @function
 * @description Function hiding the search/filter menu
 * @param {HTMLElement} item The menu
 * @author Arthur MATHIS
 */
function hideMenu(item) { item.classList.remove('active'); }

/**
 * @function showHeader 
 * @description Function displaying a column header
 * @param {HTMLTableRowElement} items The HTML Table's header
 * @param {Integer} index The column's index
 * @author Arthur MATHIS
 */
function showHeader(items, index) {
    Array.from(items).forEach((cell, i) => {
        if (i == index) 
            cell.style.display = '';
    });
}
/**
 * @function hideHeader 
 * @description Function hiding a column header
 * @param {HTMLTableRowElement} items The HTML Table's header
 * @param {Integer} index The column's index
 * @author Arthur MATHIS
 */
function hideHeader(items, index) {
    Array.from(items).forEach((cell, i) => {
        if (i == index) 
            cell.style.display = 'none';
    });
}
/**
 * @function showColumn
 * @description Function displaying an HTML Table's column 
 * @param {HTMLTableElement} items The HTML Table's body
 * @param {Integer} index The column's index
 * @author Arthur MATHIS
 */
function showColumn(items, index) {
    Array.from(items).forEach(row => {
        Array.from(row.cells).forEach((cell, i) => {
            if (i == index) 
                cell.style.display = '';
        });
    }); 
}
/**
 * @function hideColumn
 * @description Function hiding an HTML Table's column 
 * @param {HTMLTableElement} items The HTML Table's body
 * @param {Integer} index The column's index
 * @author Arthur MATHIS
 */
function hideColumn(items, index) {
    Array.from(items).forEach(row => {
        Array.from(row.cells).forEach((cell, i) => {
            if (i == index) 
                cell.style.display = 'none';
        });
    });
}
/**
 * @function responsive
 * @description Function hiding or displaying the columns of the html table according to the responsive need
 * @param {Integer} width The width of the window
 * @param {HTMLTableHeaderElement} header The HTML Table's header
 * @param {HTMLTableElement} items The HTML Tabke to resize 
 * @param {Array<Integer, Array<Integer>} sizes The list of indexes and their maximum width
 */    
function responsive(width, header, items, sizes) {
    sizes.forEach(size => {
        if (width <= size.width) {
            size.indexs.forEach(index => { 
                hideHeader(header, index);
                hideColumn(items, index); 
            });
        } else {
            size.indexs.forEach(index => { 
                showHeader(header, index);
                showColumn(items, index); 
            });
        }
    });
}

/**
 * @function createTable
 * @description Function adding the an HTML table a list of rows
 * @param {HTMLTableElement} table The HTML table 
 * @param {Array<HTMLTableRowElement} items The array containing the HTML table's rows 
 * @author Arthur MATHIS
 */
function createTable(table=null, items=[]) {
    if(table === null || items.length <= 0)
        return;

    const tbody = document.createElement('tbody');
    items.forEach(line => { tbody.append(line); });
    table.appendChild(tbody);
}
/**
 * @function destroyTable
 * @description Function destroying a HTML Table
 * @param {HTMLTableElement} table The HTML table 
 * @author Arthur MATHIS
 */
function destroyTable(table=null) {
    if(table === null)
        return;

    table.remove();
}

/**
 * @function recupApplications
 * @description Function downloading the application's array in the script
 * @param {String} source The application's sources
 * @returns {Array<HTMLElement>} The application's array
 * @author Arthur MATHIS
 */
function recupApplications(source) { return document.querySelector(source).rows; }

/**
 * @function setColor
 * @description Function determining the color code of the elements of an array according to a list of criteria
 * @param {HTMLTableElement} items The HTML Table
 * @param {Array<Integer, Array<String>>} criteres The list of criteria
 * @param {Integer} index The index of the column from which to determine the color code
 * @author Arthur MATHIS
 */
function setColor(items=[], criteres=[], index) {
    if (!Array.isArray(criteres)) 
        throw new Error("Erreur lors de la détermination du code couleur. La liste de critères doit être de type Array !");
    if (index === null || !Number.isInteger(index) || index < 0) 
        throw new Error("Erreur lors de la détermination du code couleur. L'index doit être un nombre entier positif !");
    if(!items[0].cells || items[0].cells.length === 1) {
        console.error('Aucun élément détecté...');
        return;
    }
    items = Array.from(items);
    items.forEach(line => {
        let i = 0, find = false;
        while (i < criteres.length && !find) {
            if (line.cells[index].textContent.trim() === criteres[i].content.trim()) {
                find = true;
                line.classList.add(criteres[i].class);
            }
            
            i++;
        }
    });
}
/**
 * @function setColorAvailability
 * @description Function designating a color code according to availability
 * @param {HTMLTableElement} items The HTML Table
 * @param {Integer} index  The index of the column from which to determine the color code
 * @author Arthur MATHIS
 */
function setColorAvailability(items=[], index) {
    if(!items.cells || items.cells.length === 1) {
        return;
    }

    const current_date = new Date();

    for(let i = 0; i < items.length; i++) {
        const date = new Date(items[i].cells[index].innerHTML.trim());

        if(date < current_date)
            items[i].classList.add('date_future');
    }
}


// * FILTER * //
/**
 * @function recoverFields
 * @description Function to define a list of criteria based on a list of text fields
 * @param {HTMLInputElement} fields The list of inputs
 * @param {Array<Integer, String, String>|NULL} criteria The table of criteria to implement
 * @author Arthur MATHIS
 */
function recoverFields(fields=[], criteria=[]) { 
    if(!Array.isArray(fields)) {
        throw new Error("Erreur lors de la récupération des critères. La liste de critères doit être de type Array !");
    }

    for(let i = 0; i < fields.length; i++) {
        if(fields[i].champs.value !== '') {
            criteria.push({
                'index'  : fields[i].index,
                'critere': fields[i].champs.value,
                'type'   : 'default'
            });
        }
    }
}
/**
 * @function recoverCheckbox
 * @description Function to define a list of criteria according to a list of checkboxes
 * @param {HTMLInputElement} fields The list of input fields
 * @param {Array<Integer, String, String>} criteria The table of criteria to implement
 * @author Arthur MATHIS
 */
function recoverCheckbox(fields=[], criteria=[]) {
    if (!Array.isArray(fields.champs)) {
        throw new Error("Erreur lors de la récupération des critères. La liste de critères doit être de type Array !");
    }

    let new_c = [];
    fields.champs.forEach(c => {
        if(c.checked) {
            new_c.push(c.name);
        }
    });

    if(new_c.length !== fields.champs.length) {
        criteria.push({
            'index'   : fields.index,
            'criteres': new_c,
            'type'    : 'multi'
        });
    }
}
/**
 * @function recoverFieldsDate
 * @description Function to retrieve data entered in the form's date selections
 * @param {Array<Integer, String, Date>} fields the list of dates
 * @param {Array} criteria The array containing the list of criteria
 * @author Arthur MATHIS
 */
function recoverFieldsDate(fields=[], criteria=[]) {
    if(fields.champs.length === 0 || 2 < fields.champs.length) {
        console.warn('Le nombre de champs est invalide');
        return; 
    }
        
    let new_c = [];
    if(fields.champs[0].value) {
        new_c.push({
            'type' : 'min',
            'value': new Date(fields.champs[0].value)
        });
    }
    if(fields.champs[1].value) {
        new_c.push({
            'type' : 'max',
            'value': new Date(fields.champs[1].value)
        });
    }

    if(new_c.length > 0) {
        criteria.push({
            'index'   : fields.index,
            'criteres': new_c,
            'type'    : 'date'
        });
    } else {
        console.warn("Aucun critère ajouté");
    }
}
/**
 * @function clearFields
 * @description Function that clears one list of HTMLInputElement
 * @param {Array<HTMLInputElement} fields 
 * @author Arthur MATHIS
 */
function clearFields(fields=[]) {
    fields.forEach(obj => { obj.champs.value = null; });
}
/**
 * @function clearFieldsCheckbox
 * @description Function that clears one list of HTMLCheckboxElement
 * @param {Array<HTMLInputElement} fields 
 * @author Arthur MATHIS
 */
function clearFieldsCheckbox(fields=[]) {
    fields.champs.forEach(obj => { obj.checked = true; });
}
/**
 * @function clearFields
 * @description Function that clears one list of HTMLInputElement
 * @param {Array<HTMLInputElement} fields 
 * @author Arthur MATHIS
 */
function clearFieldsDate(fields=[]) {
    fields.champs.forEach(obj => { obj.value = null; });
}
/**
 * @function filterBy
 * @description Function to filter a table according to a single criterion filter
 * @param {HTMLTableRowElement} item The table line
 * @param {Integer} index The column in which the filter is performed
 * @param {String} criteria The value sought
 * @returns {Boolean}
 * @author Arthur MATHIS
 */
function filterBy(item, index, criteria) {
    if (index < 0 || index >= item.cells.length) 
        throw new Error("Impossible d'appliquer le filtre. Indice de colonne invalide !");

    return item.cells[index].textContent
            .trim()
            .normalize("NFD")
            .replace(/[\u0300-\u036f]/g, "")
            .toLowerCase()
            .startsWith(
                criteria.normalize("NFD")
                    .replace(/[\u0300-\u036f]/g, "")
                    .toLowerCase()
            );
}
/**
 * @function filterByCriteria
 * @description Function to filter a table according to a filter with several criteria 
 * @param {HTMLTableRowElement} item The table line
 * @param {Integer} index The column in which the filter is performed
 * @param {Array<String>} criteria La liste des valeurs recherchées
 * @returns {Boolean}
 * @author Arthur MATHIS
 */
function filterByCriteria(item, index, criteria=[]) {
    if (index < 0 || item.cells.length <= index) {
        console.warn("Impossible d'appliquer le filtre. Indice de invalide !");
    }

    let i = 0, find = false;
    while(find === false && i < criteria.length) {
        if(item.cells[index].textContent.trim() === criteria[i]) {
            find = true;
        }
        i++;
    }

    return find;
}
/**
 * @function filterByDate
 * @description Function to filter applications according to their availability date
 * @param {HTMLTableRowElement} item The application
 * @param {Integer} index The column in which the filter is performed
 * @param {Date} date_min The minimum date to be respected
 * @param {Date} date_max The maximum date to be respected
 * @returns {Boolean}
 * @author Arthur MATHIS
 */
function filterByDate(item, index, critere_date=[]) {
    if(index < 0 || critere_date === null) {
        return; 
    }

    const date = new Date(item.cells[index].textContent.trim());
    let i = 0, res = true;
    while(res && i < critere_date.length) {
        switch(critere_date[i].type) {
            case 'min': 
                res = res && critere_date[i].value <= date;
                break;

            case 'max':
                res = res && date <= critere_date[i].value;
                break;   

            default: 
                console.error(`Critère non reconnu ${critere_date[i]}`);
                break;
        } 
        i++;
    }
    
    return res;
}
/**
 * @function multiFilter 
 * @description Function to filter an array of elements according to a list of criteria
 * @param {HTMLTableElement} items The HTML table
 * @param {Array<Integer, String, String|Array<String>>} criteria The list of criterias
 * @returns {Array<HTMLtableRowElement>}
 * @author Arthur MATHIS
 */
function multiFilter(items, criteria=[]) {
    if(items === null) {
        throw new Error("Une erreur s'est produite. Impossible d'effectuer de filtre ou de recherche sur un ensemble vide !");
    }

    if(criteria === null) {
        return;
    }

    let search = Array.from(items);
    let i = 0;
    while(search !== null && i < criteria.length) {
        switch(criteria[i].type) {
            case 'date':
                search = search.filter(item => filterByDate(item, criteria[i].index, criteria[i].criteres));
                break;
        
            case 'multi':
                search = search.filter(item => filterByCriteria(item, criteria[i].index, criteria[i].criteres));
                break;

            case 'default': 
                search = search.filter(item => filterBy(item, criteria[i].index, criteria[i].critere));
                break;

            default: 
                console.warn(`Critère invalide à l'index ${i}.`);
        }
        i++;
    }

    return search;
}


// * SORT * //
/**
 * @function sortByInteger
 * @description Function to sort between integers
 * @param {HTMLTableRowElement} item1 The first line
 * @param {HTMLTableRowElement} item2 The second line
 * @param {Integer} index The column containing the integers to be compared
 * @returns {Boolean}
 * @author Arthur MATHIS
 */
function sortByInteger(item1=[], item2=[], index) {
    const x1 = parseInt(item1.cells[index].textContent.trim()) || 0;
    const x2 = parseInt(item2.cells[index].textContent.trim()) || 0;

    return x1 - x2;
}
/**
 * @function sortByString
 * @description Function for sorting between character strings
 * @param {HTMLTableRowElement} item1 The first line
 * @param {HTMLTableRowElement} item2 The second line
 * @param {Integer} index The column containing the strings to be compared
 * @returns {Boolean}
 * @author Arthur MATHIS
 */
function sortByString(item1=[], item2=[], index) {
    const s1 = item1.cells[index].textContent.trim().toLowerCase();
    const s2 = item2.cells[index].textContent.trim().toLowerCase();

    return s1.localeCompare(s2, 'fr', {sensitivity: 'base'});
}
/**
 * @function sortByDate
 * @description Function to sort between dates
 * @param {HTMLTableRowElement} item1 The first line
 * @param {HTMLTableRowElement} item2 The second line
 * @param {Integer} index The column containing the dates to be compared
 * @returns {Boolean}
 * @author Arthur MATHIS
 */
function sortByDate(item1=[], item2=[], index) {
    const d1 = new Date(item1.cells[index].textContent.trim());
    const d2 = new Date(item2.cells[index].textContent.trim());

    return d1 - d2;
}
/**
 * @function sortBy
 * @description Function triggering the sorting of the table
 * @param {HTMLTableElement} items The HTML Table
 * @param {Integer} index The column containing the dates to be compared
 * @param {Boolean} croissant True, if sorted in ascending order
 * @returns {Array<HTMLTableRowElement>}
 * @author Arthur MATHIS
 */
function sortBy(items, index, croissant = true) {
    switch(true) {
        case !items:
            throw new Error('Tri impossible, items nul');

        case items.length === 0:
            throw new Error('Tri impossible, items vide');

        case index === null:
            throw new Error('Tri impossible, index introuvable');

        case index < 0:
            throw new Error('Tri impossible, index négatif');

        case items[0].cells.length <= index:
            throw new Error('Tri impossible, index supérieur à dimension items');
    }

    let search = Array.from(items);
    const item = items[0].cells[index].textContent.trim();
    switch(true) {
        case !isNaN(Date.parse(item)):
            search.sort((item1, item2) => sortByDate(item1, item2, index));
            break;

        case !isNaN(parseInt(item)):
            search.sort((item1, item2) => sortByInteger(item1, item2, index));
            break;

        default:
            search.sort((item1, item2) => sortByString(item1, item2, index));
            break;
    }

    if (typeof croissant !== 'boolean') {
        croissant = true;
    }

    if (!croissant) {
        search.reverse();
    }

    return search;
}
