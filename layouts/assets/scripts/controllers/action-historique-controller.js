// On récupère le tableau de candidatures
let candidatures = document.querySelector('.liste_items .table-wrapper table tbody').rows
const entete = Array.from(document.querySelector('.liste_items .table-wrapper table thead tr').cells);

// On ajoute le système de tri //

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



// On ajoute la Liste dynamique //

const liste = new Liste("main-liste");



// On ajoute les fonctionnalités de tri et de recherche // 

// On récupère les boutons
const rechercher = document.getElementById('rechercher-button');
const filtrer = document.getElementById('filtrer-button');

// On recupère les formulaires
const rechercher_menu = document.getElementById('rechercher-menu');
const filtrer_menu = document.getElementById('filtrer-menu');


// On ajoute les codes couleurs
listManipulation.setColor(candidatures, [
    // Utilisateur
    {
        content: 'Nouvel utilisateur', 
        class: 'utilisateur'
    },
    {
        content: 'Mise-à-jour utilisateur', 
        class: 'utilisateur'
    },
    {
        content: 'Mise-à-jour mot de passe', 
        class: 'utilisateur'
    },
    {
        content: 'Réinitialisation mot de passe', 
        class: 'utilisateur'
    },
    {
        content: 'Mise-à-jour rôle', 
        class: 'utilisateur'
    },
    // candidat
    {
        content: 'Nouveau candidat', 
        class: 'candidat'
    },
    {
        content: 'Nouveau rendez-vous', 
        class: 'candidat'
    },
    {
        content: 'Annulation rendez-vous', 
        class: 'candidat'
    },
    {
        content: 'Mise-à-jour candidat', 
        class: 'candidat'
    },
    {
        content: 'Mise-à-jour notation', 
        class: 'candidat'
    },
    {
        content: 'Mise-à-jour rendez-vous', 
        class: 'candidat'
    },
    // Candidature
    {
        content: 'Nouvelle candidature', 
        class: 'candidature'
    },
    {
        content: 'Nouvelle proposition', 
        class: 'candidature'
    },
    {
        content: 'Nouveau contrat', 
        class: 'candidature'
    },
    {
        content: 'Refus candidature', 
        class: 'candidature'
    },
    {
        content: 'Refus proposition', 
        class: 'candidature'
    },
    {
        content: 'Démission', 
        class: 'candidature'
    },
    // Fondation
    {
        content: 'Nouveau pôle', 
        class: 'fondation'
    },
    {
        content: 'Nouvel établissement', 
        class: 'fondation'
    },
    {
        content: 'Nouveau service', 
        class: 'fondation'
    },
    {
        content: 'Nouveau poste', 
        class: 'fondation'
    },
    {
        content: 'Nouveau diplome', 
        class: 'fondation'
    }    
], 0);


// On ajoute la gestion des filtres et recherche //

// On duplique le tableau pour travailler plus simplement
let candidatures_selection = Array.from(candidatures);

// On ajoute le menu de filtration
let filtrerIsVisible = false;
let lastAction = "";

filtrer.addEventListener('click', () => {
    // On cache l'autre fomulaire
    listManipulation.hideMenu(rechercher_menu);

    if(filtrerIsVisible) {
        champs = null;
        champs_date = null;
        champs_infos = null;

        // On cache le formulaire
        listManipulation.hideMenu(filtrer_menu);

    } else {
        // On récupère les champs du formulaire
        const champs_action = {
            champs: Array.from(document.querySelectorAll('.action_statut input')),
            index: 0
        };

        // On recupère le bouton de recherche
        const bouton = document.getElementById('valider-filtre');

        // Nettoyer les anciens gestionnaires d'événements pour éviter les ajouts multiples
        const newBouton = bouton.cloneNode(true);
        bouton.parentNode.replaceChild(newBouton, bouton);

        newBouton.addEventListener('click', () => {
            // On récupère la liste de critères
            try {
                let criteres = [];
                listManipulation.recoverCheckbox(champs_action, criteres);

                // On vérifie la présence de critères
                if(criteres.length === 0) {
                    // On réinitialise le tableau 
                    listManipulation.resetLines(candidatures);
                    candidatures_selection = Array.from(candidatures);
                    listManipulation.displayCountItems(candidatures !== null ? candidatures.length : 0);
                
                } else {
                    // On réinitialise la sélection
                    if(lastAction === "filtre") 
                        candidatures_selection = Array.from(candidatures);
                
                    // On applique les filtres
                    candidatures_selection = listManipulation.multiFilter(candidatures_selection, criteres);
                
                    // On met à jour l'affichage
                    listManipulation.deleteLines(candidatures);
                    listManipulation.resetLines(candidatures_selection);
                    listManipulation.displayCountItems(document.querySelector('.liste_items .entete h3'), candidatures_selection !== null ? candidatures_selection.length : 0);
                
                    // On cache le menu
                    filtrerIsVisible = !filtrerIsVisible;
                }
                lastAction = "filtre";
                // On cache le menu
                listManipulation.hideMenu(filtrer_menu);

            } catch(err) {
                console.error(err);
            }
        });

        // On affiche le menu
        listManipulation.showMenu(filtrer_menu);
    }
    filtrerIsVisible = !filtrerIsVisible;
});

// On ajoute le menu de filtration
let rechercherIsVisible = false;
rechercher.addEventListener('click', () => {
    // On cache l'autre fomulaire
    listManipulation.hideMenu(filtrer_menu);

    if(rechercherIsVisible) {
        champs = null;
        champs_date = null;
        champs_infos = null;


        // On cache le formulaire
        listManipulation.hideMenu(rechercher_menu);

    } else {
        // On récupère les champs du formulaire
        const champs_infos = [
            {
                champs: document.getElementById('recherche-utilisateur'),
                index: 1
            }
        ];
        const champs_date = {
            index: 2,
            champs : [
                document.getElementById('filtre-date-max'),
                document.getElementById('filtre-date-min')
            ]
        };

        // On recupère le bouton de recherche
        const bouton = document.getElementById('lancer-recherche');

        // Nettoyer les anciens gestionnaires d'événements pour éviter les ajouts multiples
        const newBouton = bouton.cloneNode(true);
        bouton.parentNode.replaceChild(newBouton, bouton);

        newBouton.addEventListener('click', () => {
            // On récupère la liste de critères
            let criteres = [];
            listManipulation.recoverFields(champs_infos, criteres);
            listManipulation.recoverFieldsDate(champs_date, criteres);

            // On vérifie la présence de critères
            if(criteres.length === 0) {
                // On réinitialise le tableau 
                listManipulation.resetLines(candidatures);
                candidatures_selection = Array.from(candidatures);
                listManipulation.displayCountItems(candidatures !== null ? candidatures.length : 0);

            } else {
                // On applique les filtres
                candidatures_selection = listManipulation.multiFilter(candidatures_selection, criteres);

                // On met à jour l'affichage
                listManipulation.deleteLines(candidatures);
                listManipulation.resetLines(candidatures_selection);
                listManipulation.displayCountItems(candidatures_selection !== null ? candidatures_selection.length : 0);

                // On cache le menu
                rechercherIsVisible = !rechercherIsVisible;  
            }

            lastAction = "recherche";
            
            // On cache le menu
            listManipulation.hideMenu(rechercher_menu);
        });

        // On affiche le menu
        listManipulation.showMenu(rechercher_menu);
    }
    rechercherIsVisible = !rechercherIsVisible;
});

// On corrige le bug de double affichage
const menu_button = document.getElementById('bouton-menu');
menu_button.addEventListener('click', () => {
    listManipulation.hideMenu(filtrer_menu);
    listManipulation.hideMenu(rechercher_menu);
});


const sizes = [
    {
        width: 1760,
        indexs: [3]
    }
];
window.onresize = function() { responsive(window.innerWidth, entete, candidatures, sizes) };
responsive(window.innerWidth, entete, candidatures, sizes);