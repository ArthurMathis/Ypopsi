<?php 

use App\Core\Middleware\AuthMiddleware;

?>

<aside>
    <div class="aside-wrapper">
        <header>
            <h2><?= $candidate->getGender() ? 'M' : 'Mme'; ?>. <?= $candidate->getName(); ?> <?= $candidate->getFirstname(); ?></h2>    
            <h3><?= $applications[0]['type_de_contrat']; ?></h3>
            <p><?php 
                if($applications[0]['acceptee'])
                    echo ACCEPTED;
                elseif($applications[0]['refusee']) 
                    echo REFUSED;  
                else 
                    echo UNTREATED;   
            ?></p>  
        </header>
        <section>
            <div>
                <p>Disponibilité</p>
                <p><?= $candidate->getAvailability(); ?></p>
            </div>
            <div>
                <p>Service demandé</p>
                <?php if(!empty($item['candidatures'][0]['service'])): ?>
                    <p><?= $item['candidatures'][0]['service']; ?></p>
                <?php endif ?>
            </div>
            <div>
                <p>Etablissement demandé</p>
                <?php if(!empty($item['candidatures'][0]['etablissement'])): ?>
                    <p><?= $item['candidatures'][0]['etablissement']; ?></p>
                <?php endif ?>
            </div>
        </section>
        <section>
            <div>
                <p>Numéro de téléphone</p>
                <p><?= $candidate->getPhone(); ?></p>
            </div>
            <div>
                <p>Adresse email</p>
                <p><?= $candidate->getEmail(); ?></p>
            </div>
            <div>
                <p>Adresse</p>
                <div>
                    <p><?= $candidate->getAddress(); ?></p>
                    <p><?= $candidate->getCity(); ?></p>
                    <p><?= $candidate->getPostcode(); ?></p>
                </div>
            </div>
        </section>
    </div>
    <footer>
        <?php if(AuthMiddleware::isUserOrMore()): ?>
            <?php if(!empty($candidate->getEmail())): ?>
                <a class="action_button reverse_color" href="mailto:<?= $candidate->getEmail(); ?>">
                    <p>Contacter</p>
                    <img src="<?= APP_PATH ?>\layouts\assets\img\logo\white-paperplane.svg" alt="">
                </a>
            <?php endif ?>
            <a class="action_button form_button" href="<?= APP_PATH ?>/candidates/edit/<?= $candidate->getId(); ?>">
                <p>Modifier</p>
                <img src="<?= APP_PATH ?>\layouts\assets\img\logo\blue\edit.svg" alt="">
            </a>  
        <?php endif ?>    
    </footer>
</aside>