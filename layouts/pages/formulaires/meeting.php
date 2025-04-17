<?php 

use App\Core\Tools\Moment; 

?>

<form 
    class="big-form" 
    method="post" 
    action="<?= APP_PATH ?>/candidates/meeting/<?= $action_method ?>"
>
    <div class="form-container">
        <h3>Saissisez les informations du rendez-vous</h3>
        <?php if(!$editable): ?>
            <i>Le rendez-vous a déjà eu lieu, certaines informations ne peuvent-être modifiées.</i>
        <?php endif ?>

        <section>
            <div class="input-container">
                <label for="recruiter">
                    Recuteur *
                </label>
                
                <div class="autocomplete">
                    <input 
                        type="text" 
                        id="recruiter" 
                        name="recruiter" 
                        placeholder="Dupond Jean" 
                        autocomplete="off" 
                        value="<?= $recruiter->getCompleteName() ?>"
                        
                        <?php if(!$editable): ?>
                            readonly
                        <?php endif ?>

                        required
                    >

                    <article></article>
                </div>
            </div>

            <div class="input-container">
                <label for="establishment">
                    Établissement *
                </label>

                <div class="autocomplete">
                    <input 
                        type="text" 
                        id="establishment" 
                        name="establishment" 
                        placeholder="Clinique du Diaconat Roosevelt" 
                        autocomplete="off" 
                        value="<?= $establishment->getTitled() ?>"

                        <?php if(!$editable): ?>
                            readonly
                        <?php endif ?>

                        required
                    >

                    <article></article>
                </div>
            </div>
        </section>

        <section class="double-items">
            <div class="input-container">
                <label for="date">
                    Date *
                </label>

                <input 
                    type="date" 
                    name="date" 
                    id="date" 

                    <?php if(!empty($meeting)): ?>
                        value="<?= Moment::dayFromDate($meeting->getDate()) ?>" 
                    <?php endif ?>

                    <?php if($editable): ?>
                        min="<?= Moment::dayFromDate(Moment::currentMoment()->getDate()) ?>"
                    <?php else: ?>
                        readonly
                    <?php endif ?>

                    required
                >
            </div>

            <div class="input-container">
                <label for="time">Horaire *</label>
                <input 
                    type="time" 
                    name="time" 
                    id="time"

                    <?php if(!empty($meeting)): ?>
                        value="<?= Moment::hourFromDate($meeting->getDate(), "h:m") ?>" 
                    <?php endif ?>

                    <?php if(!$editable): ?>
                        readonly
                    <?php endif ?>

                    required
                >
            </div>
        </section>

        <section>
            <label for="description">
                Compte rendu
            </label>

            <textarea name="description" id="description"><?php if(!empty($meeting)) { echo $meeting->getDescription(); } ?></textarea>
        </section>

        <div class="form-section">
            <button 
                class="action_button grey_color"
                type="button"
                onclick="window.history.back()"
            >
                Annuler
            </button>
            
            <button 
                class="action_button reverse_color"
                type="submit" 
                value="<?= $action_value ?>"
            >
                Enregistrer
            </button>
        </div>
    </div>
</form>

<script type="module">
    import AutoComplete from "<?= APP_PATH  ?>\\layouts\\scripts\\modules/AutoComplete.mjs"; 
    import { formManipulation } from "<?= APP_PATH ?>\\layouts\\scripts\\modules/FormManipulation.mjs";
    
    new AutoComplete(
        document.getElementById('recruiter'), 
        AutoComplete.arrayToSuggestions(<?= json_encode($users_list) ?>)
    );

    new AutoComplete(
        document.getElementById('establishment'), 
        AutoComplete.arrayToSuggestions(<?= json_encode($establishments_list) ?>)
    );

    document.querySelector('form')
            .addEventListener('submit', (e) => formManipulation.manageSubmit(e));
</script>