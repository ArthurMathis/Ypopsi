<nav class="options_barre">
    <article>
        <?php if($_SESSION['user']->getRole() == OWNER || $_SESSION['user']->getRole() == ADMIN): ?>
            <a class="action_button reverse_color" href="index.php?preferences=input-services">Nouveau service</a>
        <?php endif?>
    </article>
    <article>
        <p class="action_button" id="rechercher-button">Rechercher</p>
    </article>
</nav>
<div class="candidatures-menu" id="rechercher-menu">
    <h2>Rechercher selon</h2>
    <main>
        <content>
            <section>
                <p>Secteur</p>
                <input type="text" id="recherche-service"  placeholder="Service">
            </section>
            <section>
                <p>Localisation</p>
                <input type="text" id="recherche-etablissement"  placeholder="Etablissement">
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
    import { List } from "./layouts/scripts/modules/List.mjs"; 
    import { listManipulation } from "./layouts/scripts/modules/ListManipulation.mjs";

    document.addEventListener('DOMContentLoaded', () => {
        // * LISTE DYNAMIQUE * //
        const list = new List("main-liste");

        // * REPONSIVE * //
        let candidatures = document.querySelector('.liste_items .table-wrapper table tbody').rows
        const entete = Array.from(document.querySelector('.liste_items .table-wrapper table thead tr').cells);

        // * MANIPULATION DE LA LISTE * //
        const rechercher = document.getElementById('rechercher-button');
        const appliquer_recherche = document.getElementById('valider-recherche');
        const reinit_recherche = document.getElementById('reinint-recherche');
        const rechercher_menu = document.getElementById('rechercher-menu');

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
        let rechercherIsVisible = false;

        const champs_infos = [
            {
                champs: document.getElementById('recherche-service'),
                index: 0
            },
            {
                champs: document.getElementById('recherche-etablissement'),
                index: 1
            }
        ];
        rechercher.addEventListener('click', () => {
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
            }
            listManipulation.hideMenu(rechercher_menu);
        }
        appliquer_recherche.addEventListener('click', filter);

        //// Réinitialisation des filtres ////
        function reinitFields() { listManipulation.clearFields(champs_infos); }
        reinit_recherche.addEventListener('click', reinitFields);
    });
</script>