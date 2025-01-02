<form class="big-form" method="post" action="index.php?candidates=inscript-contracts&key_candidate=<?= $key_candidate; ?>">
    <div class="form-container">
        <h3>Saisissez les informations du contrat</h3>
        <section>
            <div class="input-container">
                <p>Poste *</p>
                <div class="autocomplete">
                    <input type="text" id="poste" name="poste" placeholder="Poste" autocomplete="off" required>
                    <article></article>
                </div>
            </div>
            <div class="input-container">
                <p>Service *</p>
                <div class="autocomplete">
                    <input type="text" id="service" name="service" placeholder="Services" autocomplete="off" required>
                    <article></article>
                </div>
            </div>
            <div class="input-container">
                <p>Etablissement *</p>
                <div class="autocomplete">
                    <input type="text" id="etablissement" name="etablissement" placeholder="Etablissements" autocomplete="off" required>
                    <article></article>
                </div>
            </div>
            <div class="input-container">
                <p>Type de contrat *</p>
                <div class="autocomplete">
                    <input type="text" id="type_contrat" name="type_contrat" placeholder="Type de contrats" autocomplete="off" required>
                    <article></article>
                </div>
            </div>
        </section>
        <section class="double-items">
            <div class="input-container">
                <label for="date_debut">Date de début *</label>
                <input type="date" name="date_debut" id="date_debut" min="<?php echo Moment::currentMoment()->getDate(); ?>" required>
            </div>
            <div class="input-container">
                <label for="date_fin">Date de fin *</label>
                <input type="date" name="date_fin" id="date_fin">
            </div>  
        </section>
        <section>
            <p>Horaires et rémunérations</p>
            <input type="number" id="salaire_mensuel" name="salaire_mensuel" placeholder="salaire mensuel">
            <input type="number" id="taux_horaire_hebdomadaire" name="taux_horaire_hebdomadaire" placeholder="taux horaire hebdomadaire">
            <div class="checkbox-liste">
                <div class="checkbox-item">
                    <label for="travail_nuit">Travail de nuit</label>
                    <input type="checkbox" id="travail_nuit" name="travail_nuit">
                </div>
                <div class="checkbox-item">
                    <input type="checkbox" id="travail_wk" name="travail_wk"/>
                    <label for="travail_wk">Travail le week-end</label>
                </div>
            </div>
        </section>
        <section class="buttons_actions">
            <button type="submit" class="submit_button" value="new_user">Inscrire</button>
        </section>
    </div>
</form>
<script type="module">
    import { AutoComplete } from "./layouts/assets/scripts/modules/AutoComplete.mjs";
    import { formManipulation } from "./layouts/assets/scripts/modules/FormManipulation.mjs";

    new AutoComplete(document.getElementById('poste'), <?php echo json_encode(array_map(function($c) { return $c['titled']; }, $jobs)); ?>);
    new AutoComplete(document.getElementById('service'), <?php echo json_encode(array_map(function($c) {  return $c['titled'];  }, $services)); ?>);
    new AutoComplete(document.getElementById('etablissement'), <?php echo json_encode(array_map(function($c) {  return $c['titled'];  }, $establishments)); ?>);
    new AutoComplete(document.getElementById('type_contrat'), <?php echo json_encode(array_map(function($c) { return $c['titled']; }, $types_of_contrats)); ?>);

    formManipulation.setMinEndDate('date_debut', 'date_fin');

    const inputTypeContrat = document.getElementById('type_contrat');
    const inputDateFin = document.getElementById('date_fin').parentElement;
    const checkContratType = () => {
        if (inputTypeContrat.value.trim().toUpperCase() === 'CDI') 
            inputDateFin.style.display = 'none';
        else 
            inputDateFin.style.display = 'flex';  
    };

    inputTypeContrat.addEventListener('input', checkContratType);
    inputTypeContrat.addEventListener('AutoCompleteSelect', checkContratType);
    checkContratType();
</script>