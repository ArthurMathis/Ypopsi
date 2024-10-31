<form class="big-form" method="post" action="index.php?candidates=update-candidate&key_candidate=<?= $item['candidate']['Id']?>">
    <div class="form-container">
        <h3>Saisissez les informations du candidat</h3>
        <section>
            <p>Informations personnelles</p>
            <input type="text" id="nom" name="nom" placeholder="Nom" value="<?= $item['candidate']['Name']?>">
            <input type="text" id="prenom" name="prenom" placeholder="Prénom" value="<?= $item['candidate']['Firstname']?>">
            <input type="email" id="email" name="email" placeholder="Adresse email" value="<?= $item['candidate']['Email']?>">
            <input type="tel" id="telephone" name="telephone" placeholder="Numéro de téléphone" value="<?= $item['candidate']['Phone']?>">
        </section>
        <section>
            <p>Informations habitation</p>
            <input type="text" id="adresse" name="adresse" placeholder="Adresse postale" value="<?= $item['candidate']['Address']?>">
            <div class="double-items">
                <input type="text" id="ville" name="ville" placeholder="Commune" value="<?= $item['candidate']['City']?>">
                <input type="number" id="code-postal" name="code-postal" placeholder="Code postal" value="<?= $item['candidate']['PostCode']?>">
            </div>
        </section>
        <section id='diplome-section'>
            <p>Diplômes</p>
            <button class="form_button" type="button" style="margin-left: auto">
                <img src="layouts\assets\img\logo\plus.svg" alt="Logo d'ajout d'un item', représenté par un symbole">
            </button>
            <?php if(isset($item['candidate']['qualifications'])) foreach($item['candidate']['qualifications'] as $index => $d): ?>
                <div class="double-items">
                    <input type="text" id="diplome-<?= $index+1; ?>" name="diplome[]" value="<?= $d['Intitule']; ?>">
                    <input type="number" name="diplomeDate[]" id="diplomeDate-<?= $index+1; ?>" min="1900" max="<?= date('Y'); ?>" value="<?= empty($d['Annee']) ? NULL : $d['Annee']; ?>" placeholder="Année d'obtention">
                </div>
            <?php endforeach ?>   
        </section>      
        <section id='aide-section'>
            <p>Aides au recrutement</p>
            <button class="form_button" type="button" style="margin-left: auto">
                <img src="layouts\assets\img\logo\plus.svg" alt="Logo d'ajout d'un item', représenté par un symbole">
            </button>
            <?php if(isset($item['candidate']['helps'])) foreach($item['candidate']['helps'] as $a): ?>
                <select name="aide[]">
                    <?php foreach($item['helps'] as $c): ?>
                        <option value="<?= $c['id']; ?>" <?php if($a["intitule"] == $c['text']) { $coopt = true; echo 'selected'; }?>>
                            <?= $c['text']; ?>
                        </option>
                    <?php endforeach ?>    
                </select> 
            <?php endforeach ?>
        </section>
        <section id='visite-section'>
            <p>Informations de la visite médicale</p>
            <?php if(isset($item['candidate']['MedicalVisit'])): ?>
                <input type="date" id="visite_medicale" name="visite_medicale[]" value="<?= $item['candidate']['MedicalVisit']; ?>">
            <?php else: ?>
                <button class="form_button" type="button" style="margin-left: auto">
                    <img src="layouts\assets\img\logo\plus.svg" alt="Logo d'ajout d'un item', représenté par un symbole">
                </button>
            <?php endif ?>    
        </section>
        <section class="buttons_actions">
            <button type="submit" class="submit_button" value="new_user">Mettre à jour</button>
        </section>
    </div> 
</form>
<script>console.log(<?= json_encode($item['candidate']); ?>);</script>
<script type="module">
    import { formManipulation } from "./layouts/assets/scripts/modules/FormManipulation.mjs"; 

    const diplome = new formManipulation.implementInput('diplome', 'diplome-section', 'autocomplete/date', <?= count($qualifications); ?>, <?= json_encode($qualifications); ?>);
    const aide = new formManipulation.implementInput('aide', 'aide-section', 'liste', <?= count($helps); ?>, <?= json_encode($helps); ?>);
    const visiteMedicale = new formManipulation.implementInput('visite_medicale', 'visite-section', 'date', 1, []);
</script>