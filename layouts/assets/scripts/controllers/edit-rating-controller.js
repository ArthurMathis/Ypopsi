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