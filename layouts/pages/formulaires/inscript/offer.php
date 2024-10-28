<form class="big-form" method="post" action="index.php?candidates=inscript-offers&key_candidate=<?= $key_candidate; ?>&key_application=<?= empty($offer['Id']) ? NULL : $offer['Id']; ?>">
    <div class="form-container">
    <h3>Saissisez les informations de la proposition</h3>
        <section>
                <p>Emploi</p>
                <div class="autocomplete">
                    <input type="text" id="poste" name="poste" placeholder="Poste" autocomplete="off" value="<?= !empty($offer['Key_Jobs']) ? $offer['Key_Jobs'] : NULL; ?>">
                    <article></article>
                </div>
                <div class="autocomplete">
                    <input type="text" id="service" name="service" placeholder="Services" autocomplete="off" value="<?= !empty($offer['Key_Services']) ? $offer['Key_Services'] : NULL; ?>">
                    <article></article>
                </div>
                <div class="autocomplete">
                    <input type="text" id="etablissement" name="etablissement" placeholder="Etablissements" autocomplete="off" value="<?= !empty($offer['Key_Establishments']) ? $offer['Key_Establishments'] : NULL; ?>">
                    <article></article>
                </div>
                <div class="autocomplete">
                    <input type="text" id="type_contrat" name="type_contrat" placeholder="Type de contrat" autocomplete="off" value="<?= !empty($offer['Key_Types_of_contracts']) ? $offer['Key_Types_of_contracts'] : NULL; ?>">
                    <article></article>
                </div>
            </section>
        <section class="double-items">
            <div class="input-container">
                <label for="date_debut">Date de début</label>
                <input type="date" name="date_debut" id="date_debut" min="<?php echo Moment::currentMoment()->getDate(); ?>">
            </div>
            <div class="input-container">
                <label for="date_fin">Date de fin</label>
                <input type="date" name="date_fin" id="date_fin">
            </div>
        </section>
        <section>
            <p>Horaires et rémunérations</p>
            <input id="salaire_mensuel" name="salaire_mensuel" type="number" placeholder="Salaire mensuel">
            <input id="taux_horaire_hebdomadaire" name="taux_horaire_hebdomadaire" type="number" placeholder="taux horaire hebdomadaire">
            <div class="checkbox-liste">
                <div class="checkbox-item">
                    <label for="travail nuit">Travail de nuit</label>
                    <input type="checkbox" id="travail nuit" name="travail nuit">
                </div>
                <div class="checkbox-item">
                    <input type="checkbox" id="travail wk" name="travail wk"/>
                    <label for="travail wk">Travail le week-end</label>
                </div>
            </div> 
        </section>
        <section class="buttons_actions">
            <button type="submit" class="submit_button" value="new_user">Inscrire</button>
        </section>
    </div>
</form>

<script>
    new AutoComplete(document.getElementById('poste'), <?= json_encode(array_map(function($c) { return $c['titled']; }, $jobs)); ?>);
    new AutoComplete(document.getElementById('service'), <?= json_encode(array_map(function($c) {  return $c['titled'];  }, $services)); ?>);
    new AutoComplete(document.getElementById('etablissement'), <?= json_encode(array_map(function($c) {  return $c['titled'];  }, $establishments)); ?>);
    new AutoComplete(document.getElementById('type_contrat'), <?= json_encode(array_map(function($c) { return $c['titled']; }, $types_of_contracts)); ?>);

    setMinDateFin('date_debut', 'date_fin');

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