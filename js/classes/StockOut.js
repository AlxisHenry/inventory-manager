import { consoleLog, popUp, popUpCustom } from "../functions.js";
import { Stock } from "./Stock.js";

export class StockOut extends Stock {

    constructor() {
        super()
        this.view = "stock_out";
        this.nav = "s-checkout";
    }


    submit() {
        const values = {
            article: document.querySelector('.article-name-select').dataset.art,
            user: document.querySelector('.checkout-user').value,
            cc: document.querySelector('.centre-cout').value,
            qty: document.querySelector('.article-quantity-to-checkout').value,
            commentary: document.querySelector('.about-checkout').value
        }

        console.log(values.cc)

        let CheckNegative = values.qty.toLocaleString()

        if (!values.article || !values.qty) {
            popUp('uncompleted-data')
            return false
        } else if (!values.user && !values.cc) {
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
            data: { values: values, type: 'out' },
            success: (re) => {
                console.log(re)
                let Status = JSON.parse(re)[3]
                let RestQuantity = JSON.parse(re)[1] === 0 ? "d'articles" : `que ${JSON.parse(re)[1]} article(s)`
                let Name = JSON.parse(re)[0]
                if (Status) {
                    popUp('in/out-done')
                    location.replace('movements.php?nav=mvmt');
                } else {
                    popUpCustom('error-checkout', `${Name}, n'a plus ${RestQuantity} disponible(s).`, 's', 'rgb(255,78,120)')
                }
            },
            error: (err) => {
                console.log(err)
                popUp('contact-admin')
                consoleLog("Une erreur est survenue durant l'entrée de stock (Ajax request failed).", 'e')
            },
        });

    }

    toggleUserInput(el) {
        console.log(el)
        if (el.classList.contains('show-cc-input')) {
            el.parentNode.classList.add('hidden')
            document.querySelector('.show-user-input').parentNode.classList.remove('hidden')
        } else if (el.classList.contains('show-user-input')) {
            el.parentNode.classList.add('hidden')
            document.querySelector('.show-cc-input').parentNode.classList.remove('hidden')
        }
    }

}