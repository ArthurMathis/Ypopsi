// * IMPORTS * //
import { List } from "./modules/List.mjs"; 
import { listManipulation } from "./modules/listManipulation.mjs";

// * LISTE DYNAMIQUE * //
const list = new List("main-liste");

// * REPONSIVE * //
const source = '.liste_items .table-wrapper table tbody';
let candidatures = listManipulation.recupApplications(source);
const entete = Array.from(document.querySelector('.liste_items .table-wrapper table thead tr').cells);
const sizes = [
    {
        width: 1920,
        indexs: [3]
    }, 
    {
        width: 1540,
        indexs: [4]
    },
    {
        width: 1380,
        indexs: [5]
    },
    {
        width: 1240,
        indexs: [0]
    }
];
window.onresize = function() { listManipulation.responsive(window.innerWidth, entete, candidatures, sizes) };
listManipulation.responsive(window.innerWidth, entete, candidatures, sizes);

// * MANIPULATION DE LA LISTE * //
let item_clicked = null;
let method_tri = true;
entete.forEach((item, index) => {
    item.addEventListener('click', () => {
        method_tri = !method_tri;

        if(item_clicked != index)
            method_tri = true;
        const candidatures_triees = listManipulation.sortBy(candidatures, index, method_tri);
        item_clicked = index;

        if(candidatures_triees == null || candidatures_triees.length === 0)
            alert("Alerte : Tri non executé.");
        
        else {
            listManipulation.listManipulation.destroyTable(document.querySelector('.liste_items .table-wrapper table tbody'));
            listManipulation.listManipulation.createTable(document.querySelector('.liste_items .table-wrapper table'), candidatures_triees);

            candidatures = listManipulation.recupApplications(source)

            entete.forEach(items => {
                items.classList.remove('active');
                items.classList.remove('reverse-tri');
            });
            item.classList.add('active');
            if(method_tri)
                item.classList.add('reverse-tri');
            else 
                item.classList.remove('reverse-tri');
        }

    });
});