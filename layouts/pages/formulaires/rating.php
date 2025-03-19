<form 
    method="post" 
    action="<?= APP_PATH ?>/candidates/rating/update/<?= $candidate->getId() ?>"
>
    <h3>
        Saisissez les modifications à enregistrer
    </h3>

    <section>
        <p>
            Notation
        </p>

        <div class="etoile-container">
            <input 
                type="checkbox" 
                name="rating[]" 
                id="notation1" 
                value="1" 

                <?php if(0 < $candidate->getRating()): ?>
                    checked
                <?php endif ?>
            >

            <input 
                type="checkbox" 
                name="rating[]" 
                id="notation2" 
                value="2" 

                <?php if(1 < $candidate->getRating()) : ?>
                    checked
                <?php endif ?>
            >

            <input 
                type="checkbox" 
                name="rating[]" 
                id="notation3" 
                value="3" 

                <?php if(2 < $candidate->getRating()) : ?>
                    checked
                <?php endif ?>
            >

            <input 
                type="checkbox" 
                name="rating[]" 
                id="notation4" 
                value="4" 

                <?php if(3 < $candidate->getRating()) : ?>
                    checked
                <?php endif ?>
            >

            <input 
                type="checkbox" 
                name="rating[]" 
                id="notation5" 
                value="5" 

                <?php if(4 < $candidate->getRating()) : ?>
                    checked
                <?php endif ?>
            >
        </div>

        <p>
            Caractéristiques
        </p>

        <div class="double-items">
            <p>
                A
            </p>

            <input 
                type="checkbox" 
                id="a" 
                name="a" 
                
                <?php if($candidate->getA()): ?>
                    checked
                <?php endif ?>
            >
        </div>

        <div class="double-items">
            <p>
                B
            </p>

            <input 
                type="checkbox" 
                id="b" 
                name="b" 

                <?php if($candidate->getB()): ?>
                    checked
                <?php endif ?>
            >
        </div>

        <div class="double-items">
            <p>
                C
            </p>

            <input 
                type="checkbox" 
                id="c" 
                name="c" 
                <?php if($candidate->getC()) : ?>
                    checked
                <?php endif ?>
            >
        </div>

        <p>
            Remarque
        </p>

        <textarea 
            name="description" 
            id="description"
        ><?= $candidate->getDescription(); ?></textarea>
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
            value="new_offer"
        >
            <p>Enregistrer</p>

            <img
                src="<?= APP_PATH ?>\layouts\assets\img\save\white.svg"
                alt="Enregistrer"
            >
        </button>
    </div>
</form>

<script>
    const etoiles = document.querySelectorAll('.etoile-container input');
    let currentEtoiles = -1;

    etoiles.forEach((e, index) => {
        e.addEventListener('click', () => {
            for(let i = 0; i <= index; i++)
                etoiles[i].checked = true;
            for(let i = index + 1; i < etoiles.length; i++)
                etoiles[i].checked = false;
        });

        e.addEventListener('mouseenter', () => {
            for(let i = 0; i <= index; i++)
                etoiles[i].classList.add('selected');
        });

        e.addEventListener('mouseleave', () => {
            etoiles.forEach(elmt => {
                elmt.classList.remove('selected');
            });
        });
    });
</script>