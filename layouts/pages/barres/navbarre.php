<nav class="nav-barre" id="barre-de-navigation">           
<h1>Ypopsi</h1>
<div class="section-logo">
    <a class="LignesHover" href="index.php" <?php if($home == false) :?>style="display: none"<?php endif; ?>>
        <img  src="layouts\assets\img\logo\home.svg" alt="Logo de la page d'accueil, représenté par une maison">
    </a>
    <div id="bouton-menu" class="LignesHover">
        <img  class="LignesHover"src="layouts\assets\img\logo\menu.svg" alt="Logo du menu, représenté par un burger">
    </div>
</div>
</nav>
<section id="menu">
    <main>
        <header>
            <h1>Ypopsi</h1>
            <div id="bouton-close-menu" class="LignesHover"><img src="layouts\assets\img\logo\white-close.svg" alt="Logo de fermeture du menu, représenté par une croix"></div>
        </header>
        <content>
            <?php foreach($liste_menu as $item): ?>
                <article>
                    <a href="<?=$item["action"] ?>"><?=$item["intitule"] ?></a>
                    <img src="<?= $item["logo"] ?>">
                </article>
            <?php endforeach ?>
        </content>
        <img src="layouts/assets/img/coeur.png" alt="Illustration de coeur">
        <img src="layouts/assets/img/main.png" alt="Illustration de main">
    </main>
</section>
<script>
    const button_menu = document.getElementById('bouton-menu');
    const menu = document.getElementById('menu');
    const button_fermer = document.getElementById('bouton-close-menu');
    const link = menu.querySelectorAll('main content a');

    button_menu.addEventListener('click', () => { menu.classList.add('active') });
    button_fermer.addEventListener('click', () => { menu.classList.remove('active'); });
</script>