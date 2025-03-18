<?php

use App\Core\Middleware\AuthMiddleware; 

?>

<section class="onglet">
    <div class="dashboard_bubble">
        <h2>
            Qualifications
        </h2>

        <?php if(!empty($qualifications)): ?>
            <?php foreach($qualifications as $obj): ?>
                <article>
                    <p>
                        <?= $obj["qualification"]->getTitle(); ?>
                    </p>

                    <i>
                        <?= date('F Y', strtotime($obj['date'])); ?>
                    </i>
                </article>
            <?php endforeach ?>   
        <?php else: ?>
            <i>Aucune qualification renseignée</i>
        <?php endif ?>
    </div>

    <div class="number_bubble">
        <p>
            Contrats
        </p>

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
        <p>
            Offres d'emplois
        </p>
        
        <p class="number">
            <?= empty($contracts) ? 0 : count($contracts)?>
        </p>
    </div>

    <div class="dashboard_bubble">
        <h2>
            Aides au recrutement
        </h2>

        <?php if(!empty($helps)): ?>
            <?php foreach($helps as $obj): ?>
                <article>
                    <p>
                        <?= $obj->getTitled(); ?>
                    </p>

                    <i>
                        <?php if($obj->getTitled() === COOPTATION) echo $coopteur->getCompleteName(); ?>
                    </i>
                </article>
            <?php endforeach ?>  
        <?php else: ?>
            <i>
                Aucune aide renseignée
            </i>
        <?php endif ?>
    </div>

    <div class="number_bubble">
        <p>
            Candidatures
        </p>

        <p class="number">
            <?= empty($applications) ? 0 : count($applications)?>
        </p>
    </div>

    <div class="number_bubble">
        <p>
            Rendez-vous
        </p>

        <p class="number">
            <?= empty($meetings) ? 0 : count($meetings)?>
        </p>
    </div>

    <div 
        class="dashboard_bubble" 
        id="rating_bubble"
    >
        <h2>
            Notation
        </h2>

        <content>
            <article>
                <div>
                    <p for="a">
                        A
                    </p>

                    <input 
                        type="checkbox" 
                        name="a" 
                        id="a" 
                        disabled 
                        onclick="return false;"
                        
                        <?php if($candidate->getA()): ?> 
                            checked
                        <?php endif ?>
                    >
                </div>

                <div>
                    <p for="b">
                        B
                    </p>

                    <input 
                        type="checkbox" 
                        name="b" 
                        id="b" 
                        disabled 
                        
                        <?php if($candidate->getB()): ?>
                            checked
                        <?php endif ?>
                    >
                </div>

                <div>
                    <p for="c">
                        C
                    </p>

                    <input 
                        type="checkbox" 
                        name="c" 
                        id="c" 

                        disabled <?php if($candidate->getC()): ?>
                            checked
                        <?php endif ?>
                    >
                </div>
            </article>

            <p class="number">
                <?php echo !empty($candidate->getRating()) ? $candidate->getRating() : "?"; ?>/5
            </p>
        </content>
    </div>

    <div class="dashboard_bubble">
        <h2>
            Remarque
        </h2>

        <?php if(!empty($candidate->getDescription())): ?>
            <textarea><?= $candidate->getDescription() ?></textarea>
        <?php else: ?>
            <i>
                Aucune remarque saisie
            </i>
        <?php endif ?>
    </div>

    <?php if(AuthMiddleware::isUserOrMore()): ?>
        <a 
            class="action_button reverse_color add_button" 
            href="<?= APP_PATH ?>/candidates/rating/edit/<?= $candidate->getId() ?>"
        >
            <p>
                Noter
            </p>

            <img 
                src="<?= APP_PATH ?>\layouts\assets\img\edit\white.svg" 
                alt=""
            >
        </a>
    <?php endif ?>
</section>