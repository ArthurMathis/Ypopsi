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
        const candidatures_triees = trierSelon(candidatures, index, method_tri);
        item_clicked = index;

        // On cherche les éventuelles erreurs
        if(candidatures_triees == null || candidatures_triees.length === 0)
            alert("Alerte : Tri non executé.");
        
        else {
            // On déconstruit et reconstruit le tableau
            destroyTable(document.querySelector('.liste_items .table-wrapper table tbody'));
            createTable(document.querySelector('.liste_items .table-wrapper table'), candidatures_triees);

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
setColor(candidatures, [
    {
        content: 'Propriétaire',
        class: 'owner'
    },
    {
        content: 'Administrateur', 
        class: 'administrateur'
    },
    {
        content: 'Modérateur', 
        class: 'moderateur'
    },
    {
        content: 'Utilisateur', 
        class: 'utilisateur'
    },
    {
        content: 'Invité', 
        class: 'invite'
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
    cacheMenu(rechercher_menu);

    if(filtrerIsVisible) {
        champs = null;
        champs_roles = null;
        champs_infos = null;

        // On cache le formulaire
        cacheMenu(filtrer_menu);

    } else {
        // On récupère les champs du formulaire
        const champs_roles = {
            champs: Array.from(document.getElementById('role_input').querySelectorAll('input')),
            index: 0
        };
        const champs = [
            {
                champs: document.getElementById('filtre-etablissement'),
                index: 3
            }
        ];

        // On recupère le bouton de recherche
        const bouton = document.getElementById('valider-filtre');

        // Nettoyer les anciens gestionnaires d'événements pour éviter les ajouts multiples
        const newBouton = bouton.cloneNode(true);
        bouton.parentNode.replaceChild(newBouton, bouton);

        newBouton.addEventListener('click', () => {
            // On récupère la liste de critères
            try {
                let criteres = [];
                recupChamps(champs, criteres);
                recupCheckbox(champs_roles, criteres);

                // On vérifie la présence de critères
                if(criteres.length === 0) {
                    // On réinitialise le tableau 
                    resetLignes(candidatures);
                    candidatures_selection = Array.from(candidatures);
                    afficheNbItems(candidatures !== null ? candidatures.length : 0);
                
                } else {
                    // On réinitialise la sélection
                    if(lastAction === "filtre") 
                        candidatures_selection = Array.from(candidatures);
                
                    // On applique les filtres
                    candidatures_selection = multiFiltre(candidatures_selection, criteres);

                    // On met à jour l'affichage
                    retireLignes(candidatures);
                    resetLignes(candidatures_selection);
                    afficheNbItems(document.querySelector('.liste_items .entete h3'), candidatures_selection !== null ? candidatures_selection.length : 0);

                    // On cache le menu
                    filtrerIsVisible = !filtrerIsVisible;
                }
                lastAction = "filtre";
                // On cache le menu
                cacheMenu(filtrer_menu);

            } catch(err) {
                console.error(err);
            }
        });

        // On affiche le menu
        montreMenu(filtrer_menu);

    }
    filtrerIsVisible = !filtrerIsVisible;
});

// On ajoute le menu de filtration
let rechercherIsVisible = false;
rechercher.addEventListener('click', () => {
    // On cache l'autre fomulaire
    cacheMenu(filtrer_menu);

    if(rechercherIsVisible) {
        champs = null;
        champs_roles = null;
        champs_infos = null;

        // On cache le formulaire
        cacheMenu(rechercher_menu);

    } else {
        // On récupère les champs du formulaire
        const champs_infos = [
            {
                champs: document.getElementById('recherche-identifiant'),
                index: 1
            }
        ];

        // On recupère le bouton de recherche
        const bouton = document.getElementById('lancer-recherche');

        // Nettoyer les anciens gestionnaires d'événements pour éviter les ajouts multiples
        const newBouton = bouton.cloneNode(true);
        bouton.parentNode.replaceChild(newBouton, bouton);

        newBouton.addEventListener('click', () => {
            // On récupère la liste de critères
            let criteres = [];
            recupChamps(champs_infos, criteres);

            // On vérifie la présence de critères
            if(criteres.length === 0) {
                // On réinitialise le tableau 
                resetLignes(candidatures);
                candidatures_selection = Array.from(candidatures);
                afficheNbItems(candidatures !== null ? candidatures.length : 0);

            } else {
                // On applique les filtres
                candidatures_selection = multiFiltre(candidatures_selection, criteres);

                // On met à jour l'affichage
                retireLignes(candidatures);
                resetLignes(candidatures_selection);
                afficheNbItems(candidatures_selection !== null ? candidatures_selection.length : 0);

                // On cache le menu
                rechercherIsVisible = !rechercherIsVisible;  
            }

            lastAction = "recherche";
            
            // On cache le menu
            cacheMenu(rechercher_menu);
        });

        // On affiche le menu
        montreMenu(rechercher_menu);
    }
    rechercherIsVisible = !rechercherIsVisible;
});

// On corrige le bug de double affichage
const menu_button = document.getElementById('bouton-menu');
menu_button.addEventListener('click', () => {
    cacheMenu(filtrer_menu);
    cacheMenu(rechercher_menu);
});