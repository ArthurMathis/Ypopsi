<nav class="options_barre">
    <article>
        <a class="action_button reverse_color" href="index.php?preferences=input-users">Nouvel utilisateur</a>
    </article>
    <article>
        <p class="action_button" id="filtrer-button">Filtrer</p>
        <p class="action_button" id="rechercher-button">Rechercher</p>
    </article>
</nav>
<div class="candidatures-menu" id="filtrer-menu">
    <h2>Filtrer par</h2>
    <main>
        <content>
            <section id="role_input" class="small-section">
                <p>Rôles</p>
                <div class="container-statut">
                    <input type="checkbox" name="Propriétaire" checked>
                    <p>Propriétaire</p>
                </div>
                <div class="container-statut">
                    <input type="checkbox" name="Administrateur" checked>
                    <p>Administrateur</p>
                </div>
                <div class="container-statut">
                    <input type="checkbox" name="Modérateur" checked>
                    <p>Modérateur</p>
                </div>
                <div class="container-statut">
                    <input type="checkbox" name="Utilisateur" checked>
                    <p>Utilisateur</p>
                </div>
                <div class="container-statut">
                    <input type="checkbox" name="Invité" checked>
                    <p>Invité</p>
                </div>
            </section>
            <section>
                <p>Etablissement</p>
                <input type="text" id="filtre-etablissement" placeholder="Etablissement">
            </section>
        </content>
        <aside>
            <button id="reinint-filtre" class="reinint_button LignesHover">
                <p>Réinitialiser les filtres</p>
                <img src="<?= APP_PATH ?>\layouts\assets\img\close\black.svg"alt="">
            </button>
            <button id="valider-filtre" class="reverse_color">
                <p>Appliquer</p>
                <img src="<?= APP_PATH ?>\layouts\assets\img\filter\white.svg" alt="">
            </button>
        </aside>
    </main>
</div>
<div class="candidatures-menu" id="rechercher-menu">
    <h2>Rechercher par</h2>
    <main>
        <content>
            <section>
                <input type="text" id="recherche-nom"  placeholder="Nom">
                <input type="text" id="recherche-prenom" placeholder="Prenom">
            </section>
            <section>
                <input type="text" id="recherche-email" placeholder="Email">
            </section>
        </content>
        <aside>
            <button id="reinint-recherche" class="reinint_button LignesHover">
                <p>Réinitialiser les filtres</p>
                <img src="<?= APP_PATH ?>\layouts\assets\img\close\black.svg"alt="">
            </button>
            <button id="valider-recherche" class="reverse_color">
                <p>Appliquer</p>
                <img src="<?= APP_PATH ?>\layouts\assets\img\search\white.svg"  alt="">
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

        // * MANIPULATION DE LA LISTE * //
        const rechercher = document.getElementById('rechercher-button');
        const filtrer    = document.getElementById('filtrer-button');

        const appliquer_filtre    = document.getElementById('valider-filtre');
        const appliquer_recherche = document.getElementById('valider-recherche');

        const reinit_filtre    = document.getElementById('reinint-filtre');
        const reinit_recherche = document.getElementById('reinint-recherche');

        const rechercher_menu = document.getElementById('rechercher-menu');
        const filtrer_menu    = document.getElementById('filtrer-menu');

        //// Tri par entête ////
        let item_clicked = null;
        let method_tri = true;
        entete.forEach((item, index) => {
            item.addEventListener('click', () => {
                method_tri = !method_tri;

                if(item_clicked != index) {
                    method_tri = true;
                }
                const candidatures_triees = listManipulation.sortBy(candidatures, index, method_tri);
                item_clicked = index;

                if(candidatures_triees == null || candidatures_triees.length === 0) {
                    alert("Alerte : Tri non executé.");
                } else {
                    listManipulation.destroyTable(document.querySelector('.liste_items .table-wrapper table tbody'));
                    listManipulation.createTable(document.querySelector('.liste_items .table-wrapper table'), candidatures_triees);

                    candidatures = document.querySelector('.liste_items .table-wrapper table tbody').rows
                    
                    entete.forEach(items => {
                        items.classList.remove('active');
                        items.classList.remove('reverse-tri');
                    });
                    item.classList.add('active');
                    method_tri ? item.classList.add('reverse-tri') : item.classList.remove('reverse-tri');
                }
            });
        });

        //// Tri par recherches et filtres ////
        let candidatures_selection = Array.from(candidatures);
        let filtrerIsVisible = false;
        let rechercherIsVisible = false;

        const champs_statut = {
            champs: Array.from(document.getElementById('role_input').querySelectorAll('input')),
            index : 0
        };
        const champs_infos_filtre = [
            {
                champs: document.getElementById('filtre-etablissement'),
                index : 3
            }
        ];
        const champs_infos_recherche = [
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
                index : 3
            }
        ];

        filtrer.addEventListener('click', () => {
            listManipulation.hideMenu(rechercher_menu);
            rechercherIsVisible = false;
            filtrerIsVisible ? listManipulation.hideMenu(filtrer_menu) : listManipulation.showMenu(filtrer_menu);
            filtrerIsVisible = !filtrerIsVisible;
        });
        rechercher.addEventListener('click', () => {
            listManipulation.hideMenu(filtrer_menu);
            filtrerIsVisible = false;

            rechercherIsVisible ? listManipulation.hideMenu(rechercher_menu) : listManipulation.showMenu(rechercher_menu);
            rechercherIsVisible = !rechercherIsVisible;
        });

        //// Application des filtres ////
        function filter() {
            let criteres = [];
            listManipulation.recoverFields(champs_infos_filtre, criteres);
            listManipulation.recoverCheckbox(champs_statut, criteres);
            listManipulation.recoverFields(champs_infos_recherche, criteres);

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
            listManipulation.clearFields(champs_infos_filtre);
            listManipulation.clearFields(champs_infos_recherche);
            listManipulation.clearFieldsCheckbox(champs_statut);
            listManipulation.clearFieldsDate(champs_date);
        }
        reinit_filtre.addEventListener('click', reinitFields);
        reinit_recherche.addEventListener('click', reinitFields);
    });
</script>