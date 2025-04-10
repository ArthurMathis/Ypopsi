/**
 * @class
 * @classdesc Class representing an HTML table allowing the dynamic appearance and disappearance of its lines
 * @author Arthur MATHIS
 */
export default class List {
    /**
     * @constructor
     * @param {String} id The list's identifier
     */
    constructor(id) {
        this.parent = document.querySelector('#' + id + ' .table-wrapper');
        this.items = Array.from(document.querySelectorAll('#' + id + ' .table-wrapper table tbody tr'));
        this.observer = new IntersectionObserver(
            this.callback.bind(this), 
            {
                root      : this.parent,
                rootMargin: '-60px 0px 0px 0px',
                threshold : 1
            }
        );
        this.int();
    }

    /**
     * @function init
     * @description Method starting the visibility detection
     */
    int() { this.items.forEach(item => { this.observer.observe(item); }); }
    /**
     * @function callback
     * @description Methode showing/hiding a an array's line
     * @param entries The line
     */
    callback(entries) {
        entries.forEach(entry => {
            if (entry.isIntersecting) 
                entry.target.style.visibility = "visible";
            else 
                entry.target.style.visibility = "hidden";
        });
    }
}