<?php

use App\Core\Moment;

?>

<form 
    class="big-form" 
    method="post" 
    action="<?= APP_PATH ?>/candidates/offers/inscript/<?= $candidate->getId() ?>"
>
    <div class="form-container">
        <h3>
            Nouvelle proposition
        </h3>

        <section>
            <div class="input-container">
                <label for="poste">
                    Poste *
                </label>
                <div class="autocomplete">
                    <input 
                        type="text" 
                        id="poste" 
                        name="poste" 
                        placeholder="AGENT ADMINISTRATIF" 
                        autocomplete="off" 

                        <?php if(!empty($application_job)): ?>
                            value="<?= $candidate->getGender() ? $application_job->getTitled() : $application_job->getTitledFeminin(); ?>"
                        <?php endif; ?>

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
                        <?php endif; ?>

                        required
                    >

                    <article></article>
                </div>
            </div>

            <div class="input-container">
                <p>
                    Etablissement *
                </p>
                <div class="autocomplete">
                    <input 
                        type="text" 
                        id="etablissement" 
                        name="etablissement" 
                        placeholder="Clinique du Diaconat Roosevelt" 
                        autocomplete="off" 

                        <?php if(!empty($application_establishment)): ?>
                            value="<?= $application_establishment->getTitled() ?>"
                        <?php endif; ?>
                        
                        required
                    >
                    <article></article>
                </div>
            </div>

            <div class="input-container">
                <p>
                    Type de contrat *
                </p>
                <div class="autocomplete">
                    <input 
                        type="text" 
                        id="type_contrat" 
                        name="type_contrat" 
                        placeholder="CDI" 
                        autocomplete="off" 

                        <?php if(!empty($application_type)): ?>
                            value="<?= $application_type->getTitled() ?>"
                        <?php endif; ?>

                        required
                    >

                    <article></article>
                </div>

            </div>
        </section>

        <section class="double-items">
            <div class="input-container">
                <label for="date_debut">
                    Date de début *
                </label>
                <input 
                    type="date" 
                    name="date_debut" 
                    id="date_debut" 
                    min="<?= Moment::dayFromDate(Moment::currentMoment()->getDate()) ?>"
                    required
                >
            </div>

            <div class="input-container">
                <label for="date_fin">
                    Date de fin
                </label>

                <input 
                    type="date" 
                    name="date_fin" 
                    id="date_fin"
                >
            </div>
        </section>

        <section>
            <div class="input-container">
                <p>
                    Rémunération
                </p>
                <input 
                    id="salaire_mensuel" 
                    name="salaire_mensuel" 
                    type="number" 
                    placeholder="1500"
                >
            </div>

            <div class="input-container">
                <p>
                    Taux horaire
                </p>
                <input 
                    id="taux_horaire_hebdomadaire" 
                    name="taux_horaire_hebdomadaire" 
                    type="number" 
                    placeholder="35"
                >
            </div>

            <div class="checkbox-liste">
                <div class="checkbox-item">
                    <label for="travail_nuit">
                        Travail de nuit
                    </label>
                    <input 
                        type="checkbox" 
                        id="travail_nuit" 
                        name="travail_nuit"
                    >
                </div>

                <div class="checkbox-item">
                    <input 
                        type="checkbox" 
                        id="travail_wk" 
                        name="travail_wk"
                    />
                    <label for="travail_wk">
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
                Annuler
            </button>
            
            <button 
                class="action_button reverse_color"
                type="submit" 
                value="new_offer"
            >
                Enregistrer
            </button>
        </div>
    </div>
</form>

<script type="module">
    import { AutoComplete } from "<?= APP_PATH.DS.SCRIPTS  ?>modules/AutoComplete.mjs";
    import { formManipulation } from "<?= APP_PATH.DS.SCRIPTS  ?>modules/FormManipulation.mjs";

    new AutoComplete(document.getElementById('poste'), AutoComplete.arrayToSuggestions(<?= json_encode($jobs_list) ?>));
    new AutoComplete(document.getElementById('service'), AutoComplete.arrayToSuggestions(<?= json_encode($services_list) ?>));
    new AutoComplete(document.getElementById('etablissement'), AutoComplete.arrayToSuggestions(<?= json_encode($establishments_list) ?>));
    new AutoComplete(document.getElementById('type_contrat'), AutoComplete.arrayToSuggestions(<?= json_encode($types_of_contracts_list) ?>));

    const inputTypeContrat = document.getElementById('type_contrat');
    const inputDateFin = document.getElementById('date_fin');
    const checkContratType = (input) => {
        if (inputTypeContrat.value.trim().toUpperCase() === 'CDI') {
            inputDateFin.value = '';
            inputDateFin.parentElement.style.display = 'none';
        } else inputDateFin.parentElement.style.display = 'flex';  
    };

    inputTypeContrat.addEventListener('input', checkContratType);
    inputTypeContrat.addEventListener('AutoCompleteSelect', checkContratType);
    checkContratType();

    document.querySelector('form').addEventListener('submit', (e) => formManipulation.manageSubmit(e));
</script>