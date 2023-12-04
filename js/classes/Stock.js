import { consoleLog } from "../functions.js";

export class Stock {

    constructor() {
        this.UrlParamId = new URLSearchParams(window.location.search).get("id");
        this.Searchbar = document.querySelector('.searchbar');
        this.view = "";
        this.nav = "";
    };

    /**
     * @param {string} view
     * @param {string} nav 
     * @returns {boolean}
     */
    validator() {
        const id = this.UrlParamId ? this.UrlParamId : false
        if (!isNaN(parseInt(id))) {
            document.querySelector('.exit-article-focus').classList.remove('invisible')
            document.querySelector('.article-name-select').classList.add('hidden')
            document.querySelector('.article-name').classList.remove('hidden')
            return true;
        } else if (id === '') {
            location.replace(`${this.view}.php?nav=${this.nav}`)
        }
    }

    clear() {
        document.location.replace(`${this.view}.php?nav=${this.nav}`);
    }

    toggleArticleChange(e) {
        document.location.replace(`${this.view}.php?nav=${this.nav}&id=${e.target.value}`)
    }

    removeLastColumnFromTable() {
        const AllColumns = document.querySelectorAll('.row-values');
        document.querySelector('.' + AllColumns[AllColumns.length - 1].classList[0]).remove();
    }

    search() {
        $.ajax({
            type: "POST",
            url: `../tools/ajax/request-stock-research.php`,
            data: { value: this.Searchbar.value },
            success: function (article) {
                document.querySelector('.table-body').innerHTML = article;
            },
            error: function () {
                consoleLog("Une erreur est survenue durant la recherche dynamique (Ajax request failed).", 'e');
            },
        });
    }
}