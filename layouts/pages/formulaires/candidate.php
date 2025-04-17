<?php

use App\Core\Tools\Moment; 

?>

<form 
    class="big-form" 
    method="post" 
    action="<?= APP_PATH ?>/candidates/<?= $action_method ?>"
>
    <div class="form-container">
        <h3>
            <?php if(!$completed): ?>
                Nouveau candidat
            <?php else: ?>
                Mise à jour de <?= $candidate->getCompleteName() ?>
            <?php endif ?>
        </h3>

        <section>
            <div class="input-container">
                <label for="name">
                    Nom *
                </label>

                <input 
                    type="text" 
                    id="name" 
                    name="name" 
                    placeholder="Dupond"
                    required

                    <?php if($completed): ?>
                        value="<?= $candidate->getName() ?>"
                    <?php endif ?>
                >
            </div>

            <div class="input-container">
                <label for="firstname">
                    Prénom *
                </label>

                <input 
                    type="text" 
                    id="firstname" 
                    name="firstname" 
                    placeholder="Jean"
                    required

                    <?php if($completed): ?>
                        value="<?= $candidate->getFirstname() ?>"
                    <?php endif ?>
                >
            </div>

            <div class="input-container">
                <label for="gender">
                    Civilité *
                </label>

                <select 
                    id="gender" 
                    name="gender"
                >
                    <option 
                        value="1" 
                        
                        <?php if(!$completed || (!empty($candidate) && $candidate->getGender())): ?>
                            selected
                        <?php endif ?>
                    >
                        Homme
                    </option>

                    <option 
                        value="0"

                        <?php if(!empty($candidate) && !$candidate->getGender()): ?>
                            selected
                        <?php endif ?>
                    >
                        Femme
                    </option>
                </select>    
            </div>
        </section>

        <section>
            <div class="input-container">
                <label for="email">
                    Adresse email
                </label>

                <input 
                    type="email" 
                    id="email" 
                    name="email" 
                    placeholder="jean.dupond@example.com"

                    <?php if($completed && !empty($candidate->getEmail())): ?>
                        value="<?= $candidate->getEmail() ?>" 
                    <?php endif ?>
                >
            </div>

            <div class="input-container">
                <label for="phone">
                    Numéro de téléphone
                </label>
                
                <input 
                    type="tel" 
                    id="phone" 
                    name="phone" 
                    placeholder="06.12.34.57.89"

                    <?php if($completed && !empty($candidate->getPhone())): ?>
                        value="<?= $candidate->getPhone() ?>" 
                    <?php endif ?>
                >
            </div>
        </section>

        <section>
            <div class="input-container">
                <label for="address">
                    Adresse
                </label>

                <input 
                    type="text" 
                    id="address" 
                    name="address" 
                    placeholder="1er Grand Rue"

                    <?php if($completed && !empty($candidate->getAddress())): ?>
                        value="<?= $candidate->getAddress() ?>" 
                    <?php endif ?>
                >
            </div>

            <div class="double-items">
                <div class="input-container">
                    <label for="city">
                        Commune
                    </label>

                    <input 
                        type="text" 
                        id="city" 
                        name="city" 
                        placeholder="Colmar"

                        <?php if($completed && !empty($candidate->getCity())): ?>
                            value="<?= $candidate->getCity() ?>" 
                        <?php endif ?>
                    >
                </div>

                <div class="input-container">
                    <label for="postcode">
                        Code postal
                    </label>

                    <input 
                        type="number" 
                        id="postcode" 
                        name="postcode" 
                        placeholder="68000"

                        <?php if($completed && !empty($candidate->getPostcode())): ?>
                            value="<?= $candidate->getPostcode() ?>" 
                        <?php endif ?>
                    >
                </div>
            </div>
        </section>

        <section
            id='qualifications-section' 
            class="imp-section"
        >
            <label>
                Diplômes
            </label>

            <button 
                class="form_button" 
                type="button"
            >
                <img 
                    src="<?= APP_PATH ?>\layouts\assets\img\add\blue.svg" 
                    alt=""
                >
            </button>
        </section>

        <section 
            id='helps-section' 
            class="imp-section"
        >
            <label>
                Aides au recrutement
            </label>
            
            <button 
                class="form_button" 
                type="button"
            >
                <img 
                    src="<?= APP_PATH ?>\layouts\assets\img\add\blue.svg" 
                    alt=""
                >
            </button>
        </section>

        <section 
            id='visite-section' 
            class="imp-section"
        >
            <label>
                Visite médicale
            </label>

            <input 
                id="visite_medicale" 
                name="visite_medicale" 
                type="date" 

                <?php if($completed && !empty($candidate->getVisit())): ?>
                    value="<?= $candidate->getVisit() ?>"
                <?php else: ?>
                    min="<?= date('Y-m-d'); ?>"
                <?php endif ?>
            >
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
                type="submit" 
                class="action_button reverse_color" 
                value="<?= $action_value ?>"
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

    // Gestion de la saisie des coopteurs
    document.addEventListener('elementCreated', function(e) {
        const aideSection = document.getElementById('helps-section');

        if(e.detail.element.parentNode === aideSection) {
            const inputAide = aideSection.querySelectorAll('select');
            
            const obj = new formManipulation.cooptInput(
                inputAide[inputAide.length - 1], 
                'employee', 
                3,
                <?= json_encode($employee_list); ?>
            ); 
            obj.input.addEventListener('change', (e) => obj.react());
        }
    });

    // Gestion de la saisie des aides et qualifications
    const qualifications = new formManipulation.implementInputAutoCompleteDate(
        'qualifications', 
        'qualifications-section', 
        AutoComplete.arrayToSuggestions(<?= json_encode($qualifications_list) ?>), 
        'Licence', 
        <?= count($qualifications_list); ?>, 
        "<?= APP_PATH ?>\\layouts\\assets\\img\\trash\\black.svg"
    ); 
    const helps = new formManipulation.implementInputList(
        'helps', 
        'helps-section', 
        AutoComplete.arrayToSuggestions(<?= json_encode($helps_list) ?>), 
        <?= count($helps_list); ?>,
        "<?= APP_PATH ?>\\layouts\\assets\\img\\trash\\black.svg"
    );

    // Ajout des données du candidat
    <?php if(isset($users_qualifications)): ?>
        <?php foreach($users_qualifications as $index => $obj): ?>
            qualifications.addInput();
            qualifications.setValue(<?= $index ?>, <?= $obj["qualification"]->getId() - 1?>, "<?= Moment::dayFromDate($obj["get_qualification"]->getDate()) ?>");
        <?php endforeach ?>
    <?php endif ?>

    // Ajout des données du candidat
    <?php if(isset($users_helps)): ?>
        <?php foreach($users_helps as $index => $obj): ?>
            helps.addInput();
            helps.setValue(<?= $index ?>, <?= $obj->getId() ?>);
        <?php endforeach ?>

        <?php if(!empty($employee)): ?>
            const employee_input = document.getElementById("employee");
            employee_input.value = <?= $employee->getId() ?>;
        <?php endif ?>
    <?php endif ?>

    document.querySelector('form')
            .addEventListener('submit', (e) => formManipulation.manageSubmit(e));
</script>