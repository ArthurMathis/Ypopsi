<form method="post" action="index.php?candidates=update-ratings&key_candidate=<?= $candidate['Id']; ?>">
    <h3>Saisissez les modifications à enregistrer</h3>
    <section>
        <p>Notation</p>
        <div class="etoile-container">
            <input type="checkbox" name="notation[]" id="notation1" value="1" <?php if(0 < $candidate['Rating']) echo 'checked'; ?>>
            <input type="checkbox" name="notation[]" id="notation2" value="2" <?php if(1 < $candidate['Rating']) echo 'checked'; ?>>
            <input type="checkbox" name="notation[]" id="notation3" value="3" <?php if(2 < $candidate['Rating']) echo 'checked'; ?>>
            <input type="checkbox" name="notation[]" id="notation4" value="4" <?php if(3 < $candidate['Rating']) echo 'checked'; ?>>
            <input type="checkbox" name="notation[]" id="notation5" value="5" <?php if(4 < $candidate['Rating']) echo 'checked'; ?>>
        </div>
        <p>Caractéristiques</p>
        <div class="double-items">
            <p>A</p>
            <input type="checkbox" id="a" name="a" <?php if($candidate['A']) echo 'checked'; ?>></input>
        </div>
        <div class="double-items">
            <p>B</p>
            <input type="checkbox" id="b" name="b" <?php if($candidate['B']) echo 'checked'; ?>></input>
        </div>
        <div class="double-items">
            <p>C</p>
            <input type="checkbox" id="c" name="c" <?php if($candidate['C']) echo 'checked'; ?>></input>
        </div>
        <p>Remarque</p>
        <textarea name="description" id="description"><?= $candidate['Description']; ?></textarea>
    </section>
    <button type="submit">Mettre à jour</button>
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