<nav class="options_barre">
    <article></article>
    <article>
        <p class="action_button" id="filtrer-button">Filtrer</p>
        <p class="action_button" id="rechercher-button">Rechercher</p>
    </article>
</nav>
<div class="candidatures-menu" id="filtrer-menu">
    <h2>Filtrer par</h2>
    <main>
        <content>
            <section class="action_statut small-section">
                <p>Actions sur candidats</p>
                <div class="container-statut">
                    <input type="checkbox" name="Nouveau candidat" checked>
                    <p>Nouveau candidat</p>
                </div>
                <div class="container-statut margin">
                    <input type="checkbox" name="Nouveau rendez-vous" checked>
                    <p>Nouveau rendez-vous</p>
                </div>
                <div class="container-statut">
                    <input type="checkbox" name="Mise à jour candidat" checked>
                    <p>Mise-àjour candidat</p>
                </div>
                <div class="container-statut">
                    <input type="checkbox" name="Mise à jour notation" checked>
                    <p>Mise à jour notation</p>
                </div>
                <div class="container-statut margin">
                    <input type="checkbox" name="Mise à jour rendez-vous" checked>
                    <p>Mise à jour rendez-vous</p>
                </div>
                <div class="container-statut">
                    <input type="checkbox" name="Annulation rendez-vous" checked>
                    <p>Annulation rendez-vous</p>
                </div>
            </section>
            <section class="action_statut small-section">
                <p>Actions sur candidatures</p>
                <div class="container-statut">
                    <input type="checkbox" name="Nouvelle candidature" checked>
                    <p>Nouvelle candidature</p>
                </div>
                <div class="container-statut">
                    <input type="checkbox" name="Nouvelle proposition" checked>
                    <p>Nouvelle proposition</p>
                </div>
                <div class="container-statut margin">
                    <input type="checkbox" name="Nouveau contrat" checked>
                    <p>Nouveau contrat</p>
                </div>
                <div class="container-statut">
                    <input type="checkbox" name="Refus candidature" checked>
                    <p>refus candidature</p>
                </div>
                <div class="container-statut">
                    <input type="checkbox" name="Refus proposition" checked>
                    <p>Refus proposition</p>
                </div>
                <div class="container-statut margin">
                    <input type="checkbox" name="Démission" checked>
                    <p>Démission</p>
                </div>
            </section>
            <section class="action_statut small-section">
                <p>Actions sur la fondation</p>
                <div class="container-statut">
                    <input type="checkbox" name="Nouveau poste" checked>
                    <p>Nouveau poste</p>
                </div>
                <div class="container-statut">
                    <input type="checkbox" name="Nouveau service" checked>
                    <p>Nouveau service</p>
                </div>
                <div class="container-statut">
                    <input type="checkbox" name="Nouvel établissement" checked>
                    <p>Nouvel établissement</p>
                </div>
                <div class="container-statut">
                    <input type="checkbox" name="Nouveau pôle" checked>
                    <p>Nouveau pôle</p>
                </div>
                <div class="container-statut">
                    <input type="checkbox" name="Nouvelle qualification" checked>
                    <p>Nouvelle qualification</p>
                </div>
            </section>
            <section class="action_statut small-section">
                <p>Actions sur utilisateurs</p>
                <div class="container-statut">
                    <input type="checkbox" name="Nouvel utilisateur" checked>
                    <p>Nouvel utilisateur</p>
                </div>
                <div class="container-statut">
                    <input type="checkbox" name="Mise à jour utilisateur" checked>
                    <p>Mise à jour utilisateur</p>
                </div>
                <div class="container-statut">
                    <input type="checkbox" name="Mise à jour mot de passe" checked>
                    <p>Mise à jour mot de passe</p>
                </div>
                <div class="container-statut">
                    <input type="checkbox" name="Réinitialisation mot de passe" checked>
                    <p>Réinitialisation mot de passe</p>
                </div>
                <div class="container-statut">
                    <input type="checkbox" name="Mise à jour rôle" checked>
                    <p>Mise à jour rôle</p>
                </div>
            </section>
        </content> 
        <aside>
            <button id="reinint-filtre" class="reinint_button LignesHover">
                <p>Réinitialiser les filtres</p>
                <img src="<?= APP_PATH ?>\layouts\assets\img\logo\close.svg" alt="">
            </button>
            <button id="valider-filtre" class="reverse_color">
                <p>Appliquer</p>
                <img src="<?= APP_PATH ?>\layouts\assets\img\logo\white-filtre.svg" alt="">
            </button>
        </aside>   
    </main>
</div>
<div class="candidatures-menu" id="rechercher-menu">
    <h2>Rechercher selon</h2>
    <main>
        <content>
            <section>
                <p>Informations personnelles</p>
                <input type="text" id="recherche-utilisateur"  placeholder="Utilisateur">
            </section>
            <section>
                <p>Date minimale</p>
                <input type="date" id="filtre-date-max" name="filre-data-max">
            </section>
            <section>
                <p>Date maximale</p>
                <input type="date" id="filtre-date-min" name="filre-data-min">
            </section>
        </content>
        <aside>
            <button id="reinint-recherche" class="reinint_button LignesHover">
                <p>Réinitialiser les filtres</p>
                <img src="<?= APP_PATH ?>\layouts\assets\img\logo\close.svg" alt="">
            </button>
            <button id="valider-recherche" class="reverse_color">
                <p>Appliquer</p>
                <img src="<?= APP_PATH ?>\layouts\assets\img\logo\white-recherche.svg" alt="">
            </button>
        </aside>
    </main>
</div>
<script type='module'>
    // * IMPORTS * //
    import List from "<?= APP_PATH ?>\\layouts\\scripts\\modules\\List.mjs"; 
    import { listManipulation } from "<?= APP_PATH ?>\\layouts\\scripts\\modules\\ListManipulation.mjs";

    document.addEventListener('DOMContentLoaded', () => {
        // * LISTE DYNAMIQUE * //
        const list = new List("main-liste");

        // * REPONSIVE * //
        let candidatures = document.querySelector('.liste_items .table-wrapper table tbody').rows
        const entete = Array.from(document.querySelector('.liste_items .table-wrapper table thead tr').cells);

        // * CODES COULEURS * //
        listManipulation.setColor(candidatures, [
            // Users // 
            {
                content: 'Nouvel utilisateur', 
                class: 'utilisateur'
            },
            {
                content: 'Mise à jour utilisateur', 
                class: 'utilisateur'
            },
            {
                content: 'Mise à jour mot de passe', 
                class: 'utilisateur'
            },
            {
                content: 'Réinitialisation mot de passe', 
                class: 'utilisateur'
            },
            {
                content: 'Mise à jour rôle', 
                class: 'utilisateur'
            },
            // Candidates //
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
                content: 'Mise à jour candidat', 
                class: 'candidat'
            },
            {
                content: 'Mise à jour notation', 
                class: 'candidat'
            },
            {
                content: 'Mise à jour rendez-vous', 
                class: 'candidat'
            },
            // Applications //
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
            // Fondation //
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

        // * MANIPULATION DE LA LISTE * //
        const rechercher = document.getElementById('rechercher-button');
        const filtrer = document.getElementById('filtrer-button');

        const appliquer_filtre = document.getElementById('valider-filtre');
        const appliquer_recherche = document.getElementById('valider-recherche');

        const reinit_filtre = document.getElementById('reinint-filtre');
        const reinit_recherche = document.getElementById('reinint-recherche');

        const rechercher_menu = document.getElementById('rechercher-menu');
        const filtrer_menu = document.getElementById('filtrer-menu');

        //// Tri par entête ////
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

        //// Tri par recherches et filtres ////
        let candidatures_selection = Array.from(candidatures);
        let filtrerIsVisible = false;
        let rechercherIsVisible = false;

        const champs_action = {
            champs: Array.from(document.querySelectorAll('.action_statut input')),
            index: 0
        };
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

        filtrer.addEventListener('click', () => {
            listManipulation.hideMenu(rechercher_menu);
            rechercherIsVisible = false;

            if(filtrerIsVisible) 
                listManipulation.hideMenu(filtrer_menu);
            else 
                listManipulation.showMenu(filtrer_menu);
            filtrerIsVisible = !filtrerIsVisible;
        });
        rechercher.addEventListener('click', () => {
            listManipulation.hideMenu(filtrer_menu);
            filtrerIsVisible = false;

            if(rechercherIsVisible) 
                listManipulation.hideMenu(rechercher_menu);
            else
                listManipulation.showMenu(rechercher_menu);
            rechercherIsVisible = !rechercherIsVisible;
        });

        //// Application des filtres ////
        function filter() {
            let criteres = [];
            listManipulation.recoverFields(champs_infos, criteres);
            listManipulation.recoverCheckbox(champs_action, criteres);
            listManipulation.recoverFieldsDate(champs_date, criteres);

            // If empty, reset the list
            if(criteres.length === 0) {
                listManipulation.resetLines(candidatures);
                candidatures_selection = Array.from(candidatures);
                listManipulation.displayCountItems(candidatures !== null ? candidatures.length : 0);
            
            } else {
                candidatures_selection = listManipulation.multiFilter(candidatures, criteres);
                listManipulation.deleteLines(candidatures);
                listManipulation.resetLines(candidatures_selection);
                listManipulation.displayCountItems(document.querySelector('.liste_items .entete h3'), candidatures_selection !== null ? candidatures_selection.length : 0);
            
                filtrerIsVisible = !filtrerIsVisible;
                rechercherIsVisible = !rechercherIsVisible;  
            }
            listManipulation.hideMenu(filtrer_menu);
            listManipulation.hideMenu(rechercher_menu);
        }
        appliquer_filtre.addEventListener('click', filter);
        appliquer_recherche.addEventListener('click', filter);

        //// Réinitialisation des filtres ////
        function reinitFields() {
            listManipulation.clearFields(champs_infos);
            listManipulation.clearFieldsCheckbox(champs_action);
            listManipulation.clearFieldsDate(champs_date);
        }
        reinit_filtre.addEventListener('click', reinitFields);
        reinit_recherche.addEventListener('click', reinitFields);
    });
</script>