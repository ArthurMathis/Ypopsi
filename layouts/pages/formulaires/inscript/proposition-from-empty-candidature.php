<form class="small-form" method="post" action="index.php?candidats=inscript-propositions-from-empty-candidatures&cle_candidature=<?= $cle_candidature; ?>">
    <h3>Saissisez les informations de la proposition</h3>
    <section>
            <p>Service et établissement</p>
            <div class="autocomplete">
            <input type="text" id="service" name="service" placeholder="Services" autocomplete="off">
                <article></article>
            </div>
        </section>
    <section class="double-items">
        <div class="input-container">
            <label for="date debut">Date de début</label>
            <input type="date" name="date debut" id="date debut" min="<?php echo Instants::currentInstants()->getDate(); ?>">
        </div>
        <div class="input-container">
            <label for="date fin">Date de fin</label>
            <input type="date" name="date fin" id="date fin">
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
</form>

<script>
    // On récupère les données depuis PHP
    const services = <?php echo json_encode(array_map(function($c) { return $c['Intitule_Services'];  }, $service)); ?>;
    // On prépare l'AutoComplete
    new AutoComplete(document.getElementById('service'), services);

    // On ajuste la sélection de date
    setMinDateFin('date debut', 'date fin');
</script>