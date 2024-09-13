<nav class="options_barre">
    <article>
            <?php if($_SESSION['user_role'] == OWNER || $_SESSION['user_role'] == ADMIN): ?>
            <a class="action_button reverse_color" href="index.php?preferences=saisie-pole">Nouveau pôle</a>
        <?php endif ?>
    </article>
    <article>
        <p class="action_button" id="rechercher-button">Rechercher</p>
    </article>
</nav>
<div class="candidatures-menu" id="rechercher-menu">
    <h2>Rechercher par</h2>
    <content>
        <section>
            <input type="text" id="recherche-intitule"  placeholder="Intitulé">
        </section>
    </content>
    <button id="lancer-recherche" class="circle_button">
        <img src="layouts\assets\img\logo\white-recherche.svg" alt="">
    </button>
</div>