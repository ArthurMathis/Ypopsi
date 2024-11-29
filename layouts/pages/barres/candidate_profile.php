<nav class="tab_barre">
    <?php if(0 < count($buttons)): ?>
        <?php foreach($buttons as $obj): ?>
            <p class="action_button"><?= $obj; ?></p>
        <?php endforeach ?>   
    <?php endif ?>    
</nav>
<script>
    document.addEventListener('DOMContentLoaded', () => {
        const liste_onglets = document.querySelectorAll('.tab_barre p');
        const onglet = document.querySelectorAll('.onglet');

        liste_onglets[0].classList.add('active');
        onglet[0].classList.add('active');

        liste_onglets.forEach((elmt, index) => {
            elmt.addEventListener('click', () => {
                elmt.classList.add('active');
                onglet[index].classList.add('active');

                for(let i = 0; i < index; i++) {
                    liste_onglets[i].classList.remove('active');
                    onglet[i].classList.remove('active');
                } 
                for(let i = index + 1; i < liste_onglets.length; i++) {
                    liste_onglets[i].classList.remove('active');
                    onglet[i].classList.remove('active');
                }     
            });
        });
    });
</script>