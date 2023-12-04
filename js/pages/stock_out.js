import { StockOut } from "../classes/StockOut.js";

window.addEventListener('load', () => {

    const stockOut = new StockOut();

    let isValid = stockOut.validator();
    
    if (isValid) {
        document.querySelector('.card-form-article-submit').addEventListener('click', stockOut.submit)
    }

    document.querySelector('.article-name-select').addEventListener('change', (e) => {
        stockOut.toggleArticleChange(e)
    })

    document.querySelector('.exit-article-focus').addEventListener('click', () => {
        stockOut.clear()
    })

    document.querySelectorAll('.subinfo-toggle').forEach((el) => {
        el.addEventListener('click', () => {
            stockOut.toggleUserInput(el);
        })
    })

})