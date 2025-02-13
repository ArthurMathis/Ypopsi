<form method="post" action="index.php?candidates=update-candidates&key_candidate=<?= $item['candidate']['Id']?>">
    <div class="form-container">
        <h3><?= "Informations de " . strtoupper($item['candidate']['Name']) . " " . $item['candidate']['Firstname'] ?></h3>
        <section>
            <div class="input-container">
                <p>Nom *</p>
                <input type="text" id="nom" name="nom" placeholder="Dupond" value="<?= $item['candidate']['Name'] ?>" required>
            </div>
            <div class="input-container">
                <p>Prénom *</p>
                <input type="text" id="prenom" name="prenom" placeholder="Prénom" value="<?= $item['candidate']['Firstname'] ?>" required>
            </div>
            <div class="input-container">
                <p>Civilité *</p>
                <select id="genre" name="genre">
                    <option value="1" selected>Homme</option>
                    <option value="0">Femme</option>
                </select>    
            </div>
        </section>
        <section>
            <div class="input-container">
                <p>Adresse email</p>
                <input type="email" id="email" name="email" placeholder="Adresse email" value="<?= $item['candidate']['Email'] ?>">
            </div>
            <div class="input-container">
                <p>Numéro de téléphone</p>
                <input type="tel" id="telephone" name="telephone" placeholder="Numéro de téléphone" value="<?= $item['candidate']['Phone'] ?>">
            </div>
        </section>
        <section>
            <div class="input-container">
                <p>Adresse</p>
                <input type="text" id="adresse" name="adresse" placeholder="1er Grand Rue" value="<?= $item['candidate']['Address'] ?>">
            </div>
            <div class="double-items">
                <div class="input-container">
                    <p>Commune</p>
                    <input type="text" id="ville" name="ville" placeholder="Colmar" value="<?= $item['candidate']['City'] ?>">
                </div>
                <div class="input-container">
                    <p>Code postal</p>
                    <input type="number" id="code-postal" name="code-postal" placeholder="68000" value="<?= $item['candidate']['PostCode']?>">
                </div>
            </div>
        </section>
        <section id='diplome-section'>
            <p>Saisissez ses qualifications</p>
            <button class="form_button" type="button">
                <img src="<?= APP_PATH ?>\layouts\assets\img\logo\blue\add.svg" alt="Logo d'ajout d'un item', représenté par un symbole">
            </button>
            <?php if(isset($item['candidate']['qualifications'])) foreach($item['candidate']['qualifications'] as $index => $d): ?>
                <div class="double-items">
                    <input type="text" id="diplome-<?= $index+1; ?>" name="diplome[]" value="<?= $d['titled']; ?>">
                    <input type="date" name="diplomeDate[]" id="diplomeDate-<?= $index+1; ?>" max="<?= date('Y-m-d'); ?>" value="<?= date('Y-m-d', strtotime($d['date'])); ?>">
                </div>
            <?php endforeach ?>   
        </section>      
        <section id='aide-section'>
            <p>Saisissez ses aides au recrutement</p>
            <button class="form_button" type="button">
                <img src="<?= APP_PATH ?>\layouts\assets\img\logo\blue\add.svg" alt="Logo d'ajout d'un item', représenté par un symbole">
            </button>
            <?php if(isset($item['candidate']['helps'])) foreach($item['candidate']['helps'] as $a): ?>
                <select name="aide[]">
                    <?php foreach($item['helps'] as $c): ?>
                        <option value="<?= $c['id']; ?>" <?php if($a["intitule"] == $c['text']) { echo 'selected'; }?>>
                            <?= $c['text']; ?>
                        </option>
                    <?php endforeach ?>    
                </select> 
                <?php if($a['intitule'] === COOPTATION): ?>
                    <select id="coopteur" name="coopteur">
                    <?php foreach($employee as $c): ?>
                        <option value="<?= $c['id']; ?>" <?php if($a["id"] == $c['id']) { echo 'selected'; }?>>
                            <?= $c['text']; ?>
                        </option>
                    <?php endforeach ?>
                    </select>
                <?php endif ?>
            <?php endforeach ?>
        </section>
        <section id='visite-section' class="imp-section">
            <p>Visite médicale</p>
            <input id="viste_medicale" name="viste_medicale" type="date" min="<?= date('Y-m-d'); ?>">
        </section>
        <div class="form-section">
            <button type="submit" class="submit_button" value="new_user">Mettre à jour</button>
        </div>
    </div> 
</form>
<script type="module">
    import { AutoComplete } from "./layouts/scripts/modules/AutoComplete.mjs";
    import { formManipulation } from "./layouts/scripts/modules/FormManipulation.mjs"; 

    document.addEventListener('elementCreated', function(e) {
        if(e.detail.element.parentNode === document.getElementById('aide-section')) {
            const aideSection = document.getElementById('aide-section');
            const inputAide = aideSection.querySelectorAll('select');
            
            // TODO : Corriger 3 -> solution durable 
            const obj = new formManipulation.cooptInput(inputAide[inputAide.length - 1], 'coopteur', 3, <?= json_encode($employee); ?>);
            obj.input.addEventListener('change', (e) => obj.react());
        }
    });

    new formManipulation.implementInputAutoCompleteDate('diplome', 'diplome-section', AutoComplete.arrayToSuggestions(<?= json_encode($qualifications) ?>), 'Licence', <?= count($qualifications); ?>, null); 
    new formManipulation.implementInputList('aide', 'aide-section', AutoComplete.arrayToSuggestions(<?= json_encode($helps) ?>), <?= count($helps); ?>);

    document.querySelector('form').addEventListener('submit', (e) => formManipulation.manageSubmit(e));
</script>