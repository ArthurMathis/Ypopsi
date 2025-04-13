<?php

use App\Core\Moment;

?>

<form 
    class="big-form" 
    method="post" 
    action="<?= APP_PATH.$action.DS.$candidate->getId() ?><?php if(!empty($key_application)): ?><?= DS.$key_application ?><?php endif ?>"
>
    <div class="form-container">
        <h3>
            <?= $titled ?>
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

                        <?php if(!empty($application_job)): ?>
                            value="<?= $candidate->getGender() ? $application_job->getTitled() : $application_job->getTitledFeminin(); ?>"
                        <?php endif ?>

                        required
                    >

                    <article></article>
                </div>
            </div>

            <div class="input-container">
                <label for="service">
                    Service *
                </label>

                <div class="autocomplete">
                    <input 
                        type="text" 
                        id="service" 
                        name="service" 
                        placeholder="ACCUEIL-STANDARD" 
                        autocomplete="off" 

                        <?php if(!empty($application_service)): ?>
                            value="<?= $application_service->getTitled() ?>"
                        <?php endif ?>

                        required
                    >

                    <article></article>
                </div>
            </div>

            <div class="input-container">
                <babel for="establishment">
                    Etablissement *
                </babel>

                <div class="autocomplete">
                    <input 
                        type="text" 
                        id="establishment" 
                        name="establishment" 
                        placeholder="Clinique du Diaconat Roosevelt" 
                        autocomplete="off" 

                        <?php if(!empty($application_establishment)): ?>
                            value="<?= $application_establishment->getTitled() ?>"
                        <?php endif ?>
                        
                        required
                    >
                    <article></article>
                </div>
            </div>

            <div class="input-container">
                <label for="type_of_contrat">
                    Type de contrat *
                </label>

                <div class="autocomplete">
                    <input 
                        type="text" 
                        id="type_of_contrat" 
                        name="type_of_contrat" 
                        placeholder="CDI" 
                        autocomplete="off" 

                        <?php if(!empty($application_type)): ?>
                            value="<?= $application_type->getTitled() ?>"
                        <?php endif ?>

                        required
                    >

                    <article></article>
                </div>

            </div>
        </section>

        <section class="double-items">
            <div class="input-container">
                <label for="start_date">
                    Date de début *
                </label>

                <input 
                    type="date" 
                    name="start_date" 
                    id="start_date" 
                    min="<?= Moment::dayFromDate(Moment::currentMoment()->getDate()) ?>"
                    required
                >
            </div>

            <div class="input-container">
                <label for="end_date">
                    Date de fin
                </label>

                <input 
                    type="date" 
                    name="end_date" 
                    id="end_date"
                >
            </div>
        </section>

        <section>
            <div class="input-container">
                <label for="salary">
                    Rémunération
                </label>
                
                <input 
                    id="salary" 
                    name="salary" 
                    type="number" 
                    placeholder="1500"
                >
            </div>

            <div class="input-container">
                <label for="hourly_rate">
                    Taux horaire
                </label>
                <input 
                    id="hourly_rate" 
                    name="hourly_rate" 
                    type="number" 
                    placeholder="35"
                >
            </div>

            <div class="checkbox-liste">
                <div class="checkbox-item">
                    <label for="night_work">
                        Travail de nuit
                    </label>

                    <input 
                        type="checkbox" 
                        id="night_work" 
                        name="night_work"
                    >
                </div>

                <div class="checkbox-item">
                    <input 
                        type="checkbox" 
                        id="wk_work" 
                        name="wk_work"
                    >

                    <label for="wk_work">
                        Travail le week-end
                    </label>
                </div>
            </div> 
        </section>

        <div class="form-section">
            <button 
                class="action_button grey_color"
                type="button"
                onclick="window.history.back()"
            >
                <p>Annuler</p>

                <img
                    src="<?= APP_PATH ?>\layouts\assets\img\arrow\left\black.svg"
                    alt="Annuler"
                >
            </button>
            
            <button 
                class="action_button reverse_color"
                type="submit" 
                value="<?= $value ?>"
            >
                <p>Enregistrer</p>

                <img
                    src="<?= APP_PATH ?>\layouts\assets\img\save\white.svg"
                    alt="Enregistrer"
                >
            </button>
        </div>
    </div>
</form>

<script type="module">
    import AutoComplete from "<?= APP_PATH  ?>\\layouts\\scripts\\modules\\AutoComplete.mjs"; 
    import { formManipulation } from "<?= APP_PATH ?>\\layouts\\scripts\\modules\\FormManipulation.mjs";

    new AutoComplete(document.getElementById('job'), AutoComplete.arrayToSuggestions(<?= json_encode($jobs_list) ?>));
    new AutoComplete(document.getElementById('service'), AutoComplete.arrayToSuggestions(<?= json_encode($services_list) ?>));
    new AutoComplete(document.getElementById('establishment'), AutoComplete.arrayToSuggestions(<?= json_encode($establishments_list) ?>));
    new AutoComplete(document.getElementById('type_of_contrat'), AutoComplete.arrayToSuggestions(<?= json_encode($types_of_contracts_list) ?>));

    formManipulation.setMinEndDate('start_date', 'end_date');

    const inputTypeContrat = document.getElementById('type_of_contrat');
    const inputDateFin = document.getElementById('end_date');
    const checkContratType = (input) => {
        if (inputTypeContrat.value.trim().toUpperCase() === 'CDI') {
            inputDateFin.value = '';
            inputDateFin.parentElement.style.display = 'none';
        } else { 
            inputDateFin.parentElement.style.display = 'flex'
        };  
    };

    inputTypeContrat.addEventListener('input', checkContratType);
    inputTypeContrat.addEventListener('AutoCompleteSelect', checkContratType);
    checkContratType();

    document.querySelector('form')
            .addEventListener('submit', (e) => formManipulation.manageSubmit(e));
</script>