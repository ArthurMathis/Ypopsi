<aside>
    <header>
        <div>
            <h2><?= $item['candidate']['Gender'] ? 'M' : 'Mme'; ?>. <?= $item['candidate']['Name']; ?> <?= $item['candidate']['Firstname']; ?></h2>
            <article>
                <?php if(!empty($item['candidate']['Rating'])) : ?>
                    <li class="notation">
                        <ul class="bille_notation <?php if(0 < $item['candidate']['Rating']) echo "active"; ?>"><img src="<?= ETOILE; ?>"></ul>
                        <ul class="bille_notation <?php if(1 < $item['candidate']['Rating']) echo "active"; ?>"><img src="<?= ETOILE; ?>"></ul>
                        <ul class="bille_notation <?php if(2 < $item['candidate']['Rating']) echo "active"; ?>"><img src="<?= ETOILE; ?>"></ul>
                        <ul class="bille_notation <?php if(3 < $item['candidate']['Rating']) echo "active"; ?>"><img src="<?= ETOILE; ?>"></ul>
                        <ul class="bille_notation <?php if(4 < $item['candidate']['Rating']) echo "active"; ?>"><img src="<?= ETOILE; ?>"></ul>
                    </li>
                <?php endif ?> 
                <?php if($item['candidate']['A'] || $item['candidate']['B'] || $item['candidate']['C']): ?>
                    <p>Alerte notation !</p>
                <?php endif ?>
            </article>
        </div>
        <h3><?= $item['applications'][0]['type_de_contrat']; ?></h3>
        <p><?php 
            if($item['applications'][0]['acceptee'])
                echo ACCEPTED;
            elseif($item['applications'][0]['refusee']) 
                echo REFUSED;  
            else 
                echo UNTREATED;   
        ?></p>  
    </header>
    <section>
        <div>
            <p>Diplômes</p>
            <div>
                <?php if(isset($item['candidate'][0]['diplomes']) && 0 < count($item['candidate'][0]['diplomes'])): ?>
                    <?php foreach($item['candidate'][0]['diplomes'] as $obj): ?>
                        <p><?= $obj['Intitule_Diplomes']; ?></p>
                    <?php endforeach ?>   
                <?php else : ?>
                    <p>Aucun diplôme saisie</p>     
                <?php endif ?>    
            </div>
        </div>
        <div>
            <p>Disponibilité</p>
            <p><?= $item['candidate']['Availability']; ?></p>
        </div>
        <div>
            <p>Service demandé</p>
            <?php if(empty($item['candidatures'][0]['service'])): ?>
                <p>Aucun service renseigné</p>
            <?php else: ?>
                <p><?= $item['candidatures'][0]['service']; ?></p>
            <?php endif ?>
        </div>
        <div>
            <p>Etablissement demandé</p>
            <?php if(empty($item['candidatures'][0]['etablissement'])): ?>
                <p>Aucun établissement renseigné</p>
            <?php else: ?>
                <p><?= $item['candidatures'][0]['etablissement']; ?></p>
            <?php endif ?>
        </div>
        <div>
        <p>Aide au recrutement</p> 
            <?php if($item['helps'] == null): ?>
                <p>Aucune aide au recrutement</p>
            <?php else: ?>
                <div>
                    <?php foreach($item['helps'] as $obj): ?>
                        <p><?= $obj['intitule']?><?php if($obj['intitule'] === COOPTATION): ?> - <?= $item['helps']['intitule']?><?php endif ?></p>
                    <?php endforeach ?>
                </div>
            <?php endif ?> 
        </div>
        <!--
        <div>
            <p>Aide au recrutement</p>   
            <?php if($item['helps'] == null): ?>
                <p>Aucune aide au recrutement</p>
            <?php else: ?>
                <p><?= $item['helps']['intitule']?></p>    
            <?php endif ?>  
        </div>
        <?php if(isset($item['employee'])): ?>
            <div>
                <p>Coopteur</p>
                <p><?= $item['employee']; ?></p>
            </div>
        <?php endif ?>
        -->
    </section>
    <section>
        <div>
            <p>Numéro de téléphone</p>
            <p><?= $item['candidate']['Phone']; ?></p>
        </div>
        <div>
            <p>Adresse email</p>
            <p><?= $item['candidate']['Email']; ?></p>
        </div>
        <div>
            <p>Adresse</p>
            <div>
                <p><?= $item['candidate']['Address']; ?></p>
                <p><?= $item['candidate']['City']; ?></p>
                <p><?= $item['candidate']['PostCode']; ?></p>
            </div>
        </div>
    </section>
    <footer>
        <?php if($_SESSION['user_role'] != INVITE): ?>
            <a class="circle_button reverse_color" href="mailto:<?= $item['candidate']['Email']; ?>">
                <img src="layouts\assets\img\logo\white-paperplane.svg" alt="Logo d'envoi d'un courrier, représenté par un avion en papier">
            </a>
            <a class="circle_button reverse_color" href="index.php?candidates=edit-candidate&key_candidate=<?= $item['candidate']['Id']; ?>">
                <img src="layouts\assets\img\logo\white-edit.svg" alt="Logo de modification du candidat, représenté par un carnet et un stylo">
            </a>  
        <?php endif ?>    
    </footer>
</aside>