<?php

use App\Core\Moment;

$editable = time() <= strtotime($meeting->getDate());

?>

<form 
    class="big-form" 
    method="post" 
    action="<?= APP_PATH ?>/candidates/meeting/edit/<?= $key_meeting; ?>"
>
    <div class="form-container">
    <h3>Modifiez les informations du rendez-vous</h3>
        <section>
            <div class="input-container">
                <label>Recruteur *</label>
                <div class="autocomplete">
                    <input 
                        type="text" 
                        id="recruteur" 
                        name="recruteur" 
                        placeholder="Dupond Jean" 
                        autocomplete="off" 
                        value="<?= $meeting['Recruteur']; ?>" 
                        <?php 
                            if(!$editable) {
                                echo "readonly"; 
                            }
                        ?>
                        required
                    >
                    <article></article>
                </div>
            </div>
            <div class="input-container">
                <label>Établissement *</label>
                <div class="autocomplete">
                    <input 
                        type="text" 
                        id="etablissement" 
                        name="etablissement" 
                        placeholder="Clinique du Diaconat Roosevelt" 
                        autocomplete="off" 
                        value="<?= $establishment; ?>"  
                        <?php
                            if(!$editable) {
                                echo "readonly"; 
                            }
                        ?>
                        required
                    >
                    <article></article>
                </div>
            </div>
        </section>
        <section 
            class="double-items" 
            <?php if(!$editable): ?> 
                style="display: none" 
            <?php endif ?>
        >
            <div class="input-container">
                <label for="date">Date</label>
                <input 
                    type="date" 
                    name="date" 
                    id="date" 
                    value="<?= (new DateTime($meeting->getDate()))->format("Y-m-d"); ?>" 
                    <?php if($editable): ?> 
                        min="<?= Moment::currentMoment()->getDate(); ?>" 
                    <?php endif ?>
                >
            </div>
            <div class="input-container">
                <label for="time">Horaire</label>
                <input 
                    type="time" 
                    name="time" 
                    id="time" 
                    value="<?= (new DateTime($meeting->getDate()))->format("h"); ?>"
                >
            </div>
        </section>
        <section>
            <label for="description">Compte rendu</label>
            <textarea name="description" id="description"><?= $meeting['description']; ?></textarea>
        </section>
        <section class="buttons_actions">
            <button type="submit" value="new_user">Enregistrer</button>
        </section>
    </div>  
</form>
<script type="module">
    import { AutoComplete } from "./layouts/scripts/modules/AutoComplete.mjs";
    import { formManipulation } from "./layouts/scripts/modules/FormManipulation.mjs";

    new AutoComplete(document.getElementById('recruteur'), AutoComplete.arrayToSuggestions(<?= json_encode($users) ?>));
    new AutoComplete(document.getElementById('etablissement'), AutoComplete.arrayToSuggestions(<?= json_encode($establisments) ?>));

    document.querySelector('form').addEventListener('submit', (e) => formManipulation.manageSubmit(e));
</script>