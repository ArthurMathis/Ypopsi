<?php 

use App\Core\Middleware\AuthMiddleware;

?>

<aside>
    <article>
        <header>
            <h2>
                Votre compte
            </h2>

            <img 
                src="<?= APP_PATH ?>\layouts\assets\img\profile\white.svg" 
                alt="Profil"
            >
        </header>

        <content>
            <a 
                href="<?= APP_PATH ?>/preferences/<?= $_SESSION["user"]->getId() ?>"

                <?php if($tab === "home"): ?>
                    class="selected"
                <?php endif ?>
            >
                Vos informations
            </a>
            
            <a
                href="<?= APP_PATH ?>/preferences/logs/<?= $_SESSION["user"]->getId() ?>"

                <?php if($tab === "user-connexions"): ?>
                    class="selected"
                <?php endif ?>
            >
                Historique de connexions
            </a>

            <a
                href="<?= APP_PATH ?>/preferences/logs/actions/<?= $_SESSION["user"]->getId() ?>"

                <?php if($tab === "user-actions"): ?>
                    class="selected"
                <?php endif ?>
            >
                Historique d'actions
            </a>
        </content>
    </article>

    <?php if(AuthMiddleware::isAdminOrMore()): ?>
        <article>
            <header>
                <h2>Utilisateurs</h2>

                <img 
                    src="<?= APP_PATH ?>\layouts\assets\img\users\white.svg" 
                    alt="Utilisateurs"
                >
            </header>

            <content>
                <a 
                    href="<?= APP_PATH ?>/preferences/users"
                    
                    <?php if($tab === "users"): ?>
                        class="selected"
                    <?php endif ?>
                >
                    Liste des utilisateurs
                </a>

                <a 
                    href="<?= APP_PATH ?>/preferences/users/new"
                    
                    <?php if($tab === "new-users"): ?>
                        class="selected"
                    <?php endif ?>
                >
                    Nouveaux utilisateurs
                </a>

                <a 
                    href="<?= APP_PATH ?>/prefrences/logs"
                    
                    <?php if($tab === "logs"): ?>
                        class="selected"
                    <?php endif ?> 
                >
                    Historique de connexions
                </a>

                <a 
                    href="<?= APP_PATH ?>/prefrences/logs/actions"
                    
                    <?php if($tab === "logs-actions"): ?>
                        class="selected"
                    <?php endif ?>
                >
                    Historique d'actions
                </a>
            </content>
        </article>
    <?php endif ?>

    <?php if(AuthMiddleware::isUserOrMore()): ?>
        <article>
            <header>
                <h2>
                    Recrutement
                </h2>

                <img 
                    src="<?= APP_PATH ?>\layouts\assets\img\folder\white.svg" 
                    alt="Données recruteur"
                >
            </header>
            
            <content>
                <a 
                    href="<?= APP_PATH ?>/prefrences/jobs"
                    
                    <?php if($tab === "jobs"): ?>
                        class="selected"
                    <?php endif ?>
                >
                    Postes
                </a>

                <a 
                    href="<?= APP_PATH ?>/preferences/qualifications"
                    
                    <?php if($tab === "qualifications"): ?>
                        class="selected"
                    <?php endif ?>
                >
                    Qualifications
                </a>

                <a 
                    href="<?= APP_PATH ?>/preferences/sources"
                    
                    <?php if($tab === "sources"): ?>
                        class="selected"
                    <?php endif ?>
                >
                    Sources
                </a>
            </content>
        </article>

        <article>
            <header>
                <h2>
                    Fondation
                </h2>

                <img 
                    src="<?= APP_PATH ?>\layouts\assets\img\data\white.svg" 
                    alt="Données fondation"
                >
            </header>
            
            <content>
                <a 
                    href="<?= APP_PATH ?>/preferences/services"
                    
                    <?php if($tab === "services"): ?>
                        class="selected"
                    <?php endif ?>
                >
                    Services
                </a>
                
                <a 
                    href="<?= APP_PATH ?>/preferences/establishments"
                    
                    <?php if($tab === "establishments"): ?>
                        class="selected"
                    <?php endif ?>
                >
                    Etablissements
                </a>

                <a 
                    href="<?= APP_PATH ?>/preferences/hubs"
                    
                    <?php if($tab === "hubs"): ?>
                        class="selected"
                    <?php endif ?>
                >
                    Pôles
                </a>
            </content>
        </article>
    <?php endif ?>

    <?php if(AuthMiddleware::isOwnerOrMore()): ?>
        <article>
        <header>
                <h2>
                    Autre
                </h2>

                <img 
                    src="<?= APP_PATH ?>\layouts\assets\img\console\white.svg" 
                    alt="Données fondation"
                >
            </header>

            <content>
                <a 
                    href="<?= APP_PATH ?>/preferences/features_toggle"
                    
                    <?php if($tab === "features_toggle"): ?>
                        class="selected"
                    <?php endif ?>
                >
                    Fonctionnalités
                </a>
            </content>
        </article>
    <?php endif ?>

    <footer class="versionning">
        version <?= getenv('APP_VERSION'); ?>
    </footer>
</aside>