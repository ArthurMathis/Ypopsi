<?php 

use App\Core\Moment;

?>

<div class="dashboard_bubble bold">
    <header>
        <h2>
            <?= $user->getCompleteName() ?>
        </h2>
        <p>
            <?= $role->getTitled() ?>
        </p>
    </header>

    <content>
        <article>
            <p>
                Email :
            </p>

            <p>
                <?= $user->getEmail() ?>
            </p>
        </article>

        <article>
            <p>
                Etablissement : 
            </p>

            <p>
                <?= $establishment->getTitled() ?>
            </p>
        </article>
        
        <article>
            <p>
                Inscription :
            </p>

            <p>
                <?= Moment::dayFromDate($user->getCreated()) ?> 
            </p>
        </article>
    </content>
</div>

<div class="dashboard_bubble">
    <h2>
        Connexions
    </h2>

    <content>
        <article>
            <p>
                Première connexion : 
            </p>
    
            <i>
                <?= Moment::dayFromDate($first_log->getDate()) ?>
            </i>
        </article>
    
        <article>
            <p>
                Dernière connexion : 
            </p>
    
            <i>
                <?= Moment::dayFromDate($last_log->getDate()) ?>
            </i>
        </article>
    </content>
</div>

<div class="dashboard_bubble">
    <h2>
        Connexions
    </h2>

    <content>
        <article>
            <p>
                Première connexion : 
            </p>
    
            <i>
                <?= Moment::dayFromDate($first_log->getDate()) ?>
            </i>
        </article>
    
        <article>
            <p>
                Dernière connexion : 
            </p>
    
            <i>
                <?= Moment::dayFromDate($last_log->getDate()) ?>
            </i>
        </article>
    </content>
</div>

<div class="dashboard_bubble">
    <h2>
        Connexions
    </h2>

    <content>
        <article>
            <p>
                Première connexion : 
            </p>
    
            <i>
                <?= Moment::dayFromDate($first_log->getDate()) ?>
            </i>
        </article>
    
        <article>
            <p>
                Dernière connexion : 
            </p>
    
            <i>
                <?= Moment::dayFromDate($last_log->getDate()) ?>
            </i>
        </article>
    </content>
</div>

<!-- todo : à compléter -->

<footer class="form-section add_button">
    <a 
        href="<?php if(isset($link)) echo $link; ?>" 
        class="action_button"
    >
        <p>
            Réinitialiser le mot de passe
        </p>

        <img 
            src="<?= APP_PATH ?>\layouts\assets\img\reset\blue.svg" 
            alt=""
        >
    </a>

    <a 
        href="<?php if(isset($link)) echo $link; ?>" 
        class="action_button reverse_color"
    >
        <p>
            Modifier
        </p>

        <img 
            src="<?= APP_PATH ?>\layouts\assets\img\edit\white.svg" 
            alt=""
        >
    </a>
</footer>
