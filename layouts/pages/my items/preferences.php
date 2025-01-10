<aside>
    <article>
        <header>
            <h2>Votre compte</h2>
            <img src="layouts\assets\img\logo\white-profil.svg" alt="Logo de la section profil représentant une personne">
        </header>
        <content>
            <a <?php if($_GET['preferences'] == "home") echo 'class="selected"'; ?> href="index.php?preferences=home">Consulter vos informations</a>
            <a <?php if($_GET['preferences'] == "edit-password") echo 'class="selected"'; ?> href="index.php?preferences=edit-password">Modifier votre mot de passe</a>
        </content>
    </article>
    <?php if($_SESSION['user_role'] == OWNER || $_SESSION['user_role'] == ADMIN): ?>
    <article>
        <header>
            <h2>Utilisateurs</h2>
            <img src="layouts\assets\img\logo\white-utilisateurs.svg" alt="Logo de la section utilisateurs représentant un groupe de personne">
        </header>
        <content>
            <a <?php if($_GET['preferences'] == "list-users") echo 'class="selected"'; ?> href="index.php?preferences=list-users">Liste des utilisateurs</a>
            <a <?php if($_GET['preferences'] == "list-new-users") echo 'class="selected"'; ?> href="index.php?preferences=list-new-users">Nouveaux utilisateurs</a>
            <a <?php if($_GET['preferences'] == "logs-history") echo 'class="selected"'; ?> href="index.php?preferences=logs-history">Historique de connexions</a>
            <a <?php if($_GET['preferences'] == "actions-history") echo 'class="selected"'; ?> href="index.php?preferences=actions-history">Historique d'actions</a>
        </content>
    </article>
    <?php endif ?>
    <?php if($_SESSION['user_role'] != INVITE): ?>
    <article>
        <header>
            <h2>Données</h2>
            <img src="layouts\assets\img\logo\white-data.svg" alt="Logo de la section données représentant un nuage">
        </header>
        <content>
            <a <?php if($_GET['preferences'] == "list-services") echo 'class="selected"'; ?> href="index.php?preferences=list-services">Services</a>
            <a <?php if($_GET['preferences'] == "list-establishments") echo 'class="selected"'; ?> href="index.php?preferences=list-establishments">Etablissements</a>
            <a <?php if($_GET['preferences'] == "list-poles") echo 'class="selected"'; ?> href="index.php?preferences=list-poles">Pôles</a>
            <a <?php if($_GET['preferences'] == "list-jobs") echo 'class="selected"'; ?> href="index.php?preferences=list-jobs">Postes</a>
            <a <?php if($_GET['preferences'] == "list-qualifications") echo 'class="selected"'; ?> href="index.php?preferences=list-qualifications">Qualifications</a>
            <!--<a <?php if($_GET['preferences'] == "autres") echo 'class="selected"'; ?> href="index.php?preferences=autres">Autres</a>-->
        </content>
    </article>
    <?php endif ?>
    <footer class="versionning">version <?= getenv('APP_VERSION'); ?></footer>
</aside>