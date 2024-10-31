// * IMPORTS * //
import { List } from "../modules/List.mjs"; 
import { listManipulation } from "../modules/listManipulation.mjs";

// * LISTE DYNAMIQUE * //
const list = new List("main-liste");

// * MANIPULATION DE LA LISTE * //
let candidatures = document.querySelector('.liste_items .table-wrapper table tbody').rows
const entete = Array.from(document.querySelector('.liste_items .table-wrapper table thead tr').cells);
const rechercher = document.getElementById('rechercher-button');
const filtrer = document.getElementById('filtrer-button');
const rechercher_menu = document.getElementById('rechercher-menu');
const filtrer_menu = document.getElementById('filtrer-menu');

let item_clicked = null;
let method_tri = true;
entete.forEach((item, index) => {
    item.addEventListener('click', () => {
        method_tri = !method_tri;
        // On effectue le tri
        if(item_clicked != index)
            method_tri = true;
        const candidatures_triees = listManipulation.sortBy(candidatures, index, method_tri);
        item_clicked = index;

        // On cherche les éventuelles erreurs
        if(candidatures_triees == null || candidatures_triees.length === 0)
            alert("Alerte : Tri non executé.");
        
        else {
            // On déconstruit et reconstruit le tableau
            listManipulation.destroyTable(document.querySelector('.liste_items .table-wrapper table tbody'));
            listManipulation.createTable(document.querySelector('.liste_items .table-wrapper table'), candidatures_triees);

            // On recharge le tableau dans le script
            candidatures = document.querySelector('.liste_items .table-wrapper table tbody').rows
            
            // On déselectionne les entetes
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
        champs = null;
        champs_statut = null;
        champs_date = null;

        listManipulation.hideMenu(filtrer_menu);

    } else {
        const champs = [
            {
                champs: document.getElementById('filtre-ville'),
                index: 3
            }
        ];

        const bouton = document.getElementById('valider-filtre');
        const newBouton = bouton.cloneNode(true);
        bouton.parentNode.replaceChild(newBouton, bouton);
        newBouton.addEventListener('click', () => {
            try {
                let criteres = [];
                listManipulation.recoverFields(champs, criteres);

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
        champs = null;
        champs_statut = null;
        champs_date = null;

        listManipulation.hideMenu(rechercher_menu);

    } else {
        const champs_infos = [
            {
                champs: document.getElementById('recherche-nom'),
                index: 0
            },
            {
                champs: document.getElementById('recherche-prenom'),
                index: 1
            },
            {
                champs: document.getElementById('recherche-email'),
                index: 2
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