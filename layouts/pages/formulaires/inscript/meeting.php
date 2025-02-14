<?php

use App\Core\Moment;

?>

<form 
    method="post" 
    action="<?= APP_PATH ?>/candidates/meeting/inscript/<?= $key_candidate ?>"
>
    <h3>Saissisez les informations du rendez-vous</h3>
    <section>
        <div class="input-container">
            <label>Recuteur *</label>
            <div class="autocomplete">
                <input 
                    type="text" 
                    id="recruteur" 
                    name="recruteur" 
                    placeholder="Dupond Jean" 
                    autocomplete="off" 
                    value="<?= $_SESSION['user']->getName() . " " . $_SESSION['user']->getFirstname(); ?>"
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
                    value="<?= $user_establishment ?>"
                    required
                >
                <article></article>
            </div>
        </div>
    </section>
    <section class="double-items">
        <div class="input-container">
            <label for="date">Date *</label>
            <input 
                type="date" 
                name="date" 
                id="date" 
                min="<?= Moment::currentMoment()->getDate(); ?>"
                required
            >
        </div>
        <div class="input-container">
            <label for="time">Horaire *</label>
            <input 
                type="time" 
                name="time" 
                id="time"
                required
            >
        </div>
    </section>
    <button type="submit" value="new_user">Enregistrer</button>
</form>

<script type="module">
    import { AutoComplete } from "<?= APP_PATH ?>/layouts/scripts/modules/AutoComplete.mjs"; 
    import { formManipulation } from "<?= APP_PATH ?>/layouts/scripts/modules/FormManipulation.mjs";

    console.table(<?= json_encode($users) ?>);
    
    new AutoComplete(document.getElementById('recruteur'), AutoComplete.arrayToSuggestions(<?= json_encode($users) ?>));                                                                                                                                                                                                                                                  
    new AutoComplete(document.getElementById('etablissement'), AutoComplete.arrayToSuggestions(<?= json_encode($establisments) ?>));

    document.querySelector('form').addEventListener('submit', (e) => formManipulation.manageSubmit(e));
</script>