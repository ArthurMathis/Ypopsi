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
        <?php if($_SESSION['user_role'] != INVITE): ?>
            <a class="circle_button" href="index.php?candidates=dismiss-applications&key_applications=<?= $item['cle']; ?>">
                <img src="layouts\assets\img\logo\white-close.svg" alt="Logo de refus de la candidature, représenté par une croix">
            </a>
            <a class="circle_button" href="index.php?candidates=input-offers&key_candidate=<?= $key_candidate; ?>&key_application=<?= $item['cle']; ?>">
                <img src="layouts\assets\img\logo\white-valider.svg" alt="Logo de d'acceptation de la candidature, représenté par une coche">
            </a> 
        <?php endif ?>     
        </footer>
    <?php endif ?>    
</div>