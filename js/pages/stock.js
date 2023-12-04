import { Stock } from "../classes/Stock.js";

window.addEventListener('load', () => {

    const stock = new Stock();

    setTimeout( () => {
        stock.removeLastColumnFromTable();
    }, 225);

    document.querySelector('.searchbar').addEventListener('keyup', () => {
        stock.search();
    });

});