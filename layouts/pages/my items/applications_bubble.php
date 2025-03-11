<?php

use App\Core\Middleware\AuthMiddleware;

?>

<div class="candidatures_bulle">
    <header>
        <h2><?= $item['poste']; ?></h2>
        <?php if(empty($item['service'])): ?>
            <p>Aucun service spécifié</p>
        <?php else : ?>
            <p><?= $item['service']; ?></p>
        <?php endif ?>    
        <?php if(empty($item['etablissement'])): ?>
            <p>Aucun étalissement spécifié</p>
        <?php else : ?>
            <p><?= $item['etablissement']; ?></p>
        <?php endif ?>
    </header>
    <article>
        <h3><?= $item['type_de_contrat']; ?></h3>
        <?php 
            if($item['acceptee'])
                echo '<p class="acceptee">' . ACCEPTED . '</p>';
            elseif($item['refusee']) 
                echo '<p class="refusee">' . REFUSED . '</p>';  
            else 
                echo '<p class="non-traitee">' . UNTREATED . '</p>';   
        ?>
    </article>
    <content>
        <div>
            <p>Effectuée le</p>
            <p><?= substr($item['date'], 0, 10); ?></p>
        </div>
        <div>
            <p>Effectuée via</p>
            <p><?= $item['source']; ?></p>
        </div>
    </content>
    <?php if(!$item['acceptee'] && !$item['refusee']): ?>
        <footer>
        <?php if(AuthMiddleware::isUserOrMore()): ?>
            <a class="action_button grey_color" href="<?= APP_PATH ?>/candidates/applications/reject/<?= $key_candidate ?>/<?= $item['cle'] ?>">
                <p>Refuser</p>
                <img src="<?= APP_PATH ?>\layouts\assets\img\logo\close.svg" alt="">
            </a>
            <a class="action_button reverse_color" href="<?= APP_PATH ?>/candidates/offers/input/<?= $key_candidate ?>/<?= $item['cle'] ?>">
                <p>Valider</p>
                <img src="<?= APP_PATH ?>\layouts\assets\img\logo\white-valider.svg" alt="">
            </a> 
        <?php endif ?>     
        </footer>
    <?php endif ?>    
</div>