<nav class="options_barre">
    <article></article>

    <article>
        <p 
            class="action_button" 
            id="filtrer-button"
        >
        Filtrer
        </p>

        <p 
            class="action_button" 
            id="rechercher-button"
        >
            Rechercher
        </p>
    </article>
</nav>

<div 
    class="candidatures-menu" 
    id="filtrer-menu"
>
    <h2>
        Filtrer par
    </h2>

    <main>
        <content>
            <section 
                id="action_input" 
                class="small-section"
            >
                <p>
                    Actions
                </p>

                <div class="container-statut">
                    <input 
                        type="checkbox" 
                        name="connexion" 
                        checked
                    >

                    <p>
                        Connexion
                    </p>
                </div>

                <div class="container-statut">
                    <input 
                        type="checkbox" 
                        name="moderateur" 
                        checked
                    >

                    <p>
                        Deconnexion
                    </p>
                </div>
            </section>

            <!--
            <section 
                id="role_input" 
                class="small-section"
            >
                <p>
                    Rôles
                </p>

                <div class="container-statut">
                    <input 
                        type="checkbox" 
                        name="Propriétaire" 
                        checked
                    >

                    <p>
                        Propriétaire
                    </p>
                </div>

                <div class="container-statut">
                    <input 
                        type="checkbox" 
                        name="Administrateur" 
                        checked
                    >

                    <p>
                        Administrateur
                    </p>
                </div>
                <div class="container-statut">
                    <input 
                        type="checkbox" 
                        name="Modérateur" 
                        checked
                    >

                    <p>
                        Modérateur
                    </p>
                </div>
                <div class="container-statut">
                    <input 
                        type="checkbox" 
                        name="Utilisateur" 
                        checked
                    >

                    <p>
                        Utilisateur
                    </p>
                </div>
                <div class="container-statut">
                    <input 
                        type="checkbox" 
                        name="Invité" 
                        checked
                    >

                    <p>
                        Invité
                    </p>
                </div>
            </section>
-->

            <section>
                <p>
                    Date
                </p>
                
                <label for="filtre-date-min">
                    Minimale
                </label>

                <input 
                    type="date" 
                    id="filtre-date-min" 
                    name="filre-date-min"
                >

                <label for="filre-data-max">
                    Maximale
                </label>

                <input 
                    type="date" 
                    id="filtre-date-max" 
                    name="filre-date-max"
                >
            </section>

            <section>
                <p>
                    Date
                </p>
                
                <label for="filtre-heure-min">
                    Minimale
                </label>

                <input 
                    type="time" 
                    id="filtre-heure-min" 
                    name="filre-heure-min"
                >

                <label for="filre-heure-max">
                    Maximale
                </label>

                <input 
                    type="time" 
                    id="filtre-heure-max" 
                    name="filre-heure-max"
                >
            </section>
        </content> 

        <aside>
            <button 
                id="reinint-filtre" 
                class="reinint_button LignesHover"
            >
                <p>
                    Réinitialiser les filtres
                </p>

                <img 
                    src="<?= APP_PATH ?>\layouts\assets\img\close\black.svg"
                    alt=""
                >
            </button>

            <button 
                id="valider-filtre" 
                class="reverse_color"
            >
                <p>
                    Appliquer
                </p>

                <img 
                    src="<?= APP_PATH ?>\layouts\assets\img\filter\white.svg" 
                    alt=""
                >
            </button>
        </aside>
    </main>
</div>

<div 
    class="candidatures-menu" 
    id="rechercher-menu"
>
    <h2>
        Rechercher selon
    </h2>

    <main>
        <content>
        <section>
                <p>
                    Role
                </p>

                <input 
                    type="text" 
                    id="recherche-role"  
                    placeholder="Utilisateur"
                >
            </section>

            <section>
                <p>
                    Utilisateur
                </p>

                <input 
                    type="text" 
                    id="recherche-user"  
                    placeholder="DUPOND Jean"
                >
            </section>
        </content>

        <aside>
            <button 
                id="reinint-recherche" 
                class="reinint_button LignesHover"
            >
                <p>
                    Réinitialiser les filtres
                </p>

                <img 
                    src="<?= APP_PATH ?>\layouts\assets\img\close\black.svg" 
                    alt=""
                >
            </button>

            <button 
                id="valider-recherche" 
                class="reverse_color"
            >
                <p>
                    Appliquer
                </p>

                <img 
                    src="<?= APP_PATH ?>\layouts\assets\img\search\white.svg" 
                    alt=""
                >
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
                content: 'Connexion', 
                class: 'connexion'
            },{
                content: 'Déconnexion', 
                class: 'deconnexion'
            }
        ], 0);
        listManipulation.setColor(candidatures, [
            {
                content: 'Propriétaire',
                class: 'proprietaire'
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
            },{
                content: 'Invité', 
                class: 'invite'
            }
        ], 1);

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
            champs: Array.from(document.getElementById('action_input').querySelectorAll('input')),
            index: 0
        };
        // const champs_role = {
        //     champs: Array.from(document.getElementById('role_input').querySelectorAll('input')),
        //     index: 1
        // };
        const champs_role = [
            {
                champs : document.getElementById('recherche-role'),
                index: 1
            }
        ]
        const champs_infos = [
            {
                champs: document.getElementById('recherche-user'),
                index: 2
            }
        ];
        const champs_date = {
            index: 4,
            champs : [
                document.getElementById('filtre-date-max'),
                document.getElementById('filtre-date-min')
            ]
        };
        const champs_heure = {
            index: 5,
            champs : [
                document.getElementById('filtre-heure-max'),
                document.getElementById('filtre-heure-min')
            ]
        }

        filtrer.addEventListener('click', () => {
            listManipulation.hideMenu(rechercher_menu);
            rechercherIsVisible = false;

            if(filtrerIsVisible) {
                listManipulation.hideMenu(filtrer_menu);
            } else {
                listManipulation.showMenu(filtrer_menu);
            } 

            filtrerIsVisible = !filtrerIsVisible;
        });
        rechercher.addEventListener('click', () => {
            listManipulation.hideMenu(filtrer_menu);
            filtrerIsVisible = false;

            if(filtrerIsVisible) {
                listManipulation.hideMenu(rechercher_menu);
            } else {
                listManipulation.showMenu(rechercher_menu);
            }

            rechercherIsVisible = !rechercherIsVisible;
        });

        //// Application des filtres ////
        function filter() {
            let criteres = [];
            listManipulation.recoverCheckbox(champs_action, criteres);
            listManipulation.recoverFields(champs_role, criteres);
            listManipulation.recoverFields(champs_infos, criteres);
            listManipulation.recoverFieldsDate(champs_date, criteres);
            listManipulation.recoverFieldsDate(champs_heure, criteres);

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
            listManipulation.clearFieldsCheckbox(champs_role);
            listManipulation.clearFieldsDate(champs_date);
        }
        reinit_filtre.addEventListener('click', reinitFields);
        reinit_recherche.addEventListener('click', reinitFields);
    });
</script>