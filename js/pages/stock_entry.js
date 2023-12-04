import { StockEntry } from "../classes/StockEntry.js"

window.addEventListener('load', () => {

    const stockEntry = new StockEntry();

    stockEntry.fromEntryToNew();

    let isValid = stockEntry.validator();

    if (isValid) {
        document.querySelector('.card-form-article-submit').addEventListener('click', stockEntry.submit)
    }

    document.querySelector('.article-name-select').addEventListener('change', (e) => {
        stockEntry.toggleArticleChange(e);
    })

    document.querySelector('.exit-article-focus').addEventListener('click', () => {
        stockEntry.clear();
    })
    
})