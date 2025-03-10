<?php

use App\Core\Moment;

$completed = !empty($candidate);

?>

<form 
    class="big-form" 
    method="post" 
    action="<?= APP_PATH ?>/candidates/applications/inscript<?php if($completed) echo DS.$candidate->getId(); ?>"
>
    <div class="form-container">
        <h3>
            Saisissez les informations de la candidature
        </h3>

        <section>
            <div class="input-container">
                <label for="job">
                    Poste *
                </label>

                <div class="autocomplete">
                    <input 
                        type="text" 
                        id="job" 
                        name="job" 
                        placeholder="AGENT ADMINISTRATIF" 
                        autocomplete="off"
                        required
                    >

                    <article></article>
                </div>
            </div>

            <div class="input-container">
                <label for="service">
                    Service
                </label>

                <div class="autocomplete">
                    <input 
                        type="text" 
                        id="service" 
                        name="service" 
                        placeholder="ACCUEIL-STANDARD" 
                        autocomplete="off"
                    >

                    <article></article>
                </div>
            </div>

            <div class="input-container">
                <label for="establishment">
                    Etablissement
                </label>

                <div class="autocomplete">
                    <input 
                        type="text" 
                        id="establishment" 
                        name="establishment" 
                        placeholder="Clinique du Diaconat Roosevelt" 
                        autocomplete="off"
                    >

                    <article></article>
                </div>
            </div>
        </section>

        <section>
            <div class="input-container">
                <label for="type_of_contract">
                    Type de contrat
                </label>

                <div class="autocomplete">
                    <input 
                        type="text" 
                        id="type_of_contract" 
                        name="type_of_contract" 
                        placeholder="CDI" 
                        autocomplete="off"
                    >

                    <article></article>
                </div>
            </div>

            <div class="input-container">
                <label for="availability">
                    Disponibilité
                </label>

                <input 
                    type="Date" 
                    id="availability" 
                    name="availability" 
                    min="<?php echo Moment::currentMoment()->getDate(); ?>"
                >
            </div>

            <div class="input-container">
                <label for="source">
                    Source *
                </label>

                <div class="autocomplete">
                    <input 
                        type="text" 
                        id="source" 
                        name="source" 
                        placeholder="HelloWork" 
                        autocomplete="off"
                        required
                    >

                    <article></article>
                </div>
            </div>
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
                type="submit" 
                class="action_button reverse_color"
                value="new_user"
            >
                Enregistrer
            </button>
        </div>
    </div>
</form>

<script type="module">
    import { AutoComplete } from "<?= APP_PATH  ?>\\layouts\\scripts\\modules/AutoComplete.mjs"; 
    import { formManipulation } from "<?= APP_PATH ?>\\layouts\\scripts\\modules/FormManipulation.mjs";

    new AutoComplete(document.getElementById('job'), AutoComplete.arrayToSuggestions(<?= json_encode($jobs_list) ?>));
    new AutoComplete(document.getElementById('service'), AutoComplete.arrayToSuggestions(<?= json_encode($services_list) ?>));
    new AutoComplete(document.getElementById('establishment'), AutoComplete.arrayToSuggestions(<?= json_encode($establishments_list) ?>));
    new AutoComplete(document.getElementById('type_of_contract'), AutoComplete.arrayToSuggestions(<?= json_encode($type_of_contracts_list) ?>));
    new AutoComplete(document.getElementById('source'), AutoComplete.arrayToSuggestions(<?= json_encode($sources_list) ?>));

    document.querySelector('form')
            .addEventListener('submit', (e) => formManipulation.manageSubmit(e));
</script>