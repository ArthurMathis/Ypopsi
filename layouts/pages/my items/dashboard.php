<section class="onglet">
    <div class="dashboard_bubble">
        <h2>Qualifications</h2>
        <?php foreach($item['candidate']['qualifications'] as $obj): ?>
            <article>
                <p><?= $obj['titled']; ?></p>
                <i><?= $obj['year']; ?></i>
            </article>
        <?php endforeach ?>    
    </div>
    <div class="number_bubble">
        <p>Contrats</p>
        <p class="number">
            <?php
                $compt = 0; 
                $size = empty($contracts) ? 0 :count($contracts);
                for($i = 0; $i < $size; $i++) {
                    if(!empty($contracts[$i]['signature'])){
                        $compt++;
                    }
                }

                echo $compt;
            ?>        
        </p>
    </div>
    <div class="number_bubble">
        <p>Offres d'emplois</p>
        <p class="number"><?= empty($item['contracts']) ? 0 : count($item['contracts'])?></p>
    </div>
    <div class="number_bubble">
        <p>Candidatures</p>
        <p class="number"><?= empty($item['applications']) ? 0 : count($item['applications'])?></p>
    </div>
    <div class="number_bubble">
        <p>Rendez-vous</p>
        <p class="number"><?= empty($item['meeting']) ? 0 : count($item['meeting'])?></p>
    </div>
    <div class="dashboard_bubble">
        <h2>Aides au recrutement</h2>
        <?php foreach($item['candidate']['qualifications'] as $obj): ?>
            <article>
                <p><?= $obj['titled']; ?></p>
                <i><?= $obj['year']; ?></i>
            </article>
        <?php endforeach ?>    
    </div>
    <?php if($_SESSION['user_role'] != INVITE): ?>
    <a class="action_button reverse_color add_button" href="index.php?candidates=edit-ratings&key_candidate=<?=$candidate['Id'] ?>">
        <p>Noter</p>
        <img src="layouts\assets\img\logo\white-edit.svg" alt="Logo de modification du candidat, représenté par un carnet et un stylo">
    </a>
<?php endif ?>
</section>