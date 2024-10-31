// * IMPORTS * //
import { List } from "../modules/List.mjs"; 
import { listManipulation } from "../modules/listManipulation.mjs";

// * LISTE DYNAMIQUE * //
const list = new List("main-liste");

// * REPONSIVE * //
let candidatures = document.querySelector('.liste_items .table-wrapper table tbody').rows
const entete = Array.from(document.querySelector('.liste_items .table-wrapper table thead tr').cells);
const sizes = [ 
    {
        width: 1580,
        indexs: [4]
    },
    {
        width: 1200,
        indexs: [5]
    },
    {
        width: 1120,
        indexs : [7]
    },
    {
        width: 920,
        indexs: [6]
    }
];
window.onresize = function() { listManipulation.responsive(window.innerWidth, entete, candidatures, sizes) };
listManipulation.responsive(window.innerWidth, entete, candidatures, sizes);

// * CODES COULEURS * //
listManipulation.setColor(candidatures, [
    {
        content: 'Non-traitée', 
        class: 'non-traitee'
    },
    {
        content: 'Acceptée', 
        class: 'acceptee'
    },
    {
        content: 'Refusée', 
        class: 'refusee'
    }
], 0);
listManipulation.setColor(candidatures, [
    {
        content: 'Email', 
        class: 'email'
    },
    {
        content: 'Hellowork', 
        class: 'hellowork'
    },
    {
        content: 'Hublo', 
        class: 'hublo'
    },
    {
        content: 'Téléphone', 
        class: 'telephone'
    }
], 6);
listManipulation.setColorAvailability(candidatures, 7);

// * MANIPULATION DE LA LISTE * //
const rechercher = document.getElementById('rechercher-button');
const filtrer = document.getElementById('filtrer-button');

const rechercher_menu = document.getElementById('rechercher-menu');
const filtrer_menu = document.getElementById('filtrer-menu');

let item_clicked = null;
let method_tri = true;
entete.forEach((item, index) => {
    item.addEventListener('click', () => {
        method_tri = !method_tri;

        if(item_clicked != index)
            method_tri = true;
        const candidatures_triees = listManipulation.sortBy(candidatures, index, method_tri);
        item_clicked = index;

        if(candidatures_triees == null || candidatures_triees.length === 0)
            alert("Alerte : Tri non executé.");
        
        else {
            listManipulation.destroyTable(document.querySelector('.liste_items .table-wrapper table tbody'));
            listManipulation.createTable(document.querySelector('.liste_items .table-wrapper table'), candidatures_triees);

            candidatures = document.querySelector('.liste_items .table-wrapper table tbody').rows
            
            entete.forEach(items => {
                items.classList.remove('active');
                items.classList.remove('reverse-tri');
            });
            item.classList.add('active');
            if(method_tri)
                item.classList.add('reverse-tri');
            else 
                item.classList.remove('reverse-tri');
        }
    });
});

let candidatures_selection = Array.from(candidatures);
let filtrerIsVisible = false;
let lastAction = "";
filtrer.addEventListener('click', () => {
    listManipulation.hideMenu(rechercher_menu);

    if(filtrerIsVisible) {
        let champs = null;
        let champs_statut = null;
        let champs_date = null;

        listManipulation.hideMenu(filtrer_menu);

    } else {
        const champs_statut = {
                champs: Array.from(document.getElementById('statut_input').querySelectorAll('input')),
                index : 0
        };
        const champs_infos = [
            {
                champs: document.getElementById('filtre-poste'),
                index : 3
            },
            {
                champs: document.getElementById('filtre-source'),
                index : 6
            }
        ];
        const champs_date = {
            index : 7,
            champs: [
                document.getElementById('filtre-date-max'),
                document.getElementById('filtre-date-min')
            ]
        };

        const bouton = document.getElementById('valider-filtre');
        const newBouton = bouton.cloneNode(true);
        bouton.parentNode.replaceChild(newBouton, bouton);
        newBouton.addEventListener('click', () => {
            try {
                let criteres = [];
                listManipulation.recoverFields(champs_infos, criteres);
                listManipulation.recoverCheckbox(champs_statut, criteres);
                listManipulation.recoverFieldsDate(champs_date, criteres);

                if(criteres.length === 0) {
                    listManipulation.resetLines(candidatures);
                    candidatures_selection = Array.from(candidatures);
                    listManipulation.displayCountItems(candidatures !== null ? candidatures.length : 0);
                
                } else {
                    if(lastAction === "filtre") 
                        candidatures_selection = Array.from(candidatures);
                
                    candidatures_selection = listManipulation.multiFilter(candidatures_selection, criteres);
                    listManipulation.deleteLines(candidatures);
                    listManipulation.resetLines(candidatures_selection);
                    listManipulation.displayCountItems(document.querySelector('.liste_items .entete h3'), candidatures_selection !== null ? candidatures_selection.length : 0);
                
                    filtrerIsVisible = !filtrerIsVisible;
                }
                lastAction = "filtre";
                listManipulation.hideMenu(filtrer_menu);
            } catch(err) {
                console.error(err);
            }
        });

        listManipulation.showMenu(filtrer_menu);
    }
    filtrerIsVisible = !filtrerIsVisible;
});
let rechercherIsVisible = false;
rechercher.addEventListener('click', () => {
    listManipulation.hideMenu(filtrer_menu);

    if(rechercherIsVisible) {
        let champs = null;
        let champs_statut = null;
        let champs_date = null;

        listManipulation.hideMenu(rechercher_menu);

    } else {
        const champs_infos = [
            {
                champs: document.getElementById('recherche-nom'),
                index : 1
            },
            {
                champs: document.getElementById('recherche-prenom'),
                index : 2
            },
            {
                champs: document.getElementById('recherche-email'),
                index : 4
            },
            {
                champs: document.getElementById('recherche-telephone'),
                index : 5
            }
        ];

        const bouton = document.getElementById('lancer-recherche');
        const newBouton = bouton.cloneNode(true);
        bouton.parentNode.replaceChild(newBouton, bouton);
        newBouton.addEventListener('click', () => {
            let criteres = [];
            listManipulation.recoverFields(champs_infos, criteres);
            if(criteres.length === 0) {
                listManipulation.resetLines(candidatures);
                candidatures_selection = Array.from(candidatures);
                listManipulation.displayCountItems(candidatures !== null ? candidatures.length : 0);

            } else {
                candidatures_selection = listManipulation.multiFilter(candidatures_selection, criteres);
                listManipulation.deleteLines(candidatures);
                listManipulation.resetLines(candidatures_selection);
                listManipulation.displayCountItems(candidatures_selection !== null ? candidatures_selection.length : 0);

                rechercherIsVisible = !rechercherIsVisible;  
            }

            lastAction = "recherche";
            listManipulation.hideMenu(rechercher_menu);
        });
        listManipulation.showMenu(rechercher_menu);
    }
    rechercherIsVisible = !rechercherIsVisible;
});

const menu_button = document.getElementById('bouton-menu');
menu_button.addEventListener('click', () => {
    listManipulation.hideMenu(filtrer_menu);
    listManipulation.hideMenu(rechercher_menu);
});