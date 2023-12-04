import { consoleLog, popUp, popUpCustom } from "../functions.js";
import { Stock } from "./Stock.js";

export class StockEntry extends Stock {

    constructor() {
        super()
        this.view = "stock_entry";
        this.nav = "s-entry";
    }

    submit() {
        const values = {
            article: document.querySelector('.article-name-select').dataset.art,
            cc: document.querySelector('.ccout-target').value,
            qty: document.querySelector('.article-quantity-to-add').value,
            order: document.querySelector('.command-order').value,
            commentary: document.querySelector('.about-entry').value
        }

        let CheckNegative = values.qty.toLocaleString()

        if (!values.article || !values.qty) {
            popUp('uncompleted-data')
            return false
        } else if (!values.cc) {
            popUp('no-user-to-checkout')
            return false
        } else if (isNaN(values.qty) || parseInt(values.qty) === 0) {
            popUp('invalid-quantity')
            return false
        } else if (CheckNegative.includes('-')) {
            popUpCustom('error-signe', `Ne pas insérer de signe -  dans la quantité`, 's', 'rgb(203,78,105)')
            return false
        }

        console.log(values)

        $.ajax({
            type: "POST",
            url: `../tools/ajax/stock-action.php`,
            data: { values: values, type: 'in' },
            success: (re) => {
                popUp('in/out-done')
                console.log(re)
                location.replace('movements.php?nav=mvmt');
            },
            error: (err) => {
                popUp('contact-admin')
                consoleLog("Une erreur est survenue durant l'entrée de stock (Ajax request failed).", 'e')
            },
        });

    }

    fromEntryToNew() {
        document.querySelector('.new').addEventListener('click', () => {
            location.replace('config-articles.php?nav=c-article')
        })
    }

}