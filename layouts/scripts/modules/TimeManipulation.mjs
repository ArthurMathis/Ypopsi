/**
 * @module Time
 * @description Time module
 * @author Arthur MATHIS - arthur.mathis@diaconat-mulhouse.fr
 */
export default class Time {
    constructor(str_time) {
        [this._hour, this._minute] = str_time.split(':').map(Number);
        console.log(this);
    }

    /**
     * @function hour
     * @description Public method returning the hour attribute
     * @return {Integer}
     */
    get hour() { return this._hour; }
    /**
     * @function minute
     * @description Public metthod returning the minte attribute
     * @return {Integer}
     */
    get minute() { return this._minute; }

    /**
     * @function hour
     * @description Public method setting the hour attribute
     * @param {Integer} hour The hour
     * @return {void}
     */
    set hour(hour) { 
        if(isNaN(hour)) {
            throw Error(`L'heure : ${hour} est invalide.`);
        }

        this._hour = hour;
    }
    /**
     * @function minute
     * @description Public metthod setting the minte attribute
     * @param {Integer} minute The minute
     * @return {void}
     */
    set minute(minute) { 
        if(isNaN(minute)) {
            throw Error(`Les minutes : ${minute} sont invalides.`);
        }

        this._minute = minute;
    }

    /**
     * @fucntion isEarlyer
     * @description Public static method returing if this time is earlyer than an another time
     * @param {Time} time The another Time
     * @returns 
     */
    isEarlyer(time) {
        return this.hour < time.hour || (this.hour == time.hour && this.minute <= time.minute);
    }
}