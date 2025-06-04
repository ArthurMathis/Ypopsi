<?php

use App\Core\Tools\DataFormat\TimeManager;
use App\Core\Middleware\AuthMiddleware;

$date = TimeManager::currentTime()->getDate();

?>

<div class="contrats_bulle">
    <header>
        <h2><?= $item['poste'] ?></h2>
        <p><?= $item['service'] ?></p>
        <p><?= $item['etablissement'] ?></p>
    </header>

    <article>
        <h3><?= $item['type_de_contrat'] ?></h3>
        <?php if($item['demission']): ?>    
            <p class="refusee">Démission</p>
        <?php elseif($date < $item['date_debut']): ?>
            <p class="a_venir">A venir</p>
        <?php elseif($item['date_fin'] < $date): ?>  
            <p class="termine">Terminé</p> 
        <?php else : ?> 
            <p class="en_cours">En cours</p> 
        <?php endif ?>    
    </article>

    <content>
        <div>
            <p>Recruté le</p>

            <p><?= $item['signature'] ?></p>
        </div>

        <div>
            <p>Début du contrat</p>

            <p><?= $item['date_debut'] ?></p>
        </div>

        <div>
            <p>Fin du contrat</p>

            <p><?= $item['date_fin'] ?></p>
        </div>

        <div>
            <p>Horaire</p>

            <?php if(isset($item['heures'])): ?>
                <p><?= $item['heures'] ?> heures</p>
            <?php endif ?>
            <?php if($item['nuit'] == 'true'): ?>
                <p>Emploi de nuit</p>
            <?php endif ?>    
            <?php if($item['week_end'] == 'true'): ?>
                <p>Emploi de week-end</p>
            <?php endif ?>  
        </div>
    </content>
    <?php if($item['demission'] == null && ($item['date_fin'] == null || $date < $item['date_fin'])): ?>
        <footer>
            <?php if(AuthMiddleware::isUserOrMore()): ?>
                <a 
                    class="action_button reverse_color" 
                    href="<?= APP_PATH ?>/candidates/contracts/dismiss/<?= urlencode($item['cle']) ?>"
                >
                    <p>Démissioner</p>

                    <img 
                        src="<?= APP_PATH ?>\layouts\assets\img\close\white.svg" 
                        alt="Démission"
                    >
                </a>
            <?php endif ?>    
        </footer>
    <?php endif ?> 
</div>