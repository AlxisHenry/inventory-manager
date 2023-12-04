import { consoleLog, popUp } from "../functions.js";

export class Article {

    constructor() {
        this.UrlParamId = new URLSearchParams(window.location.search).get("id");
        this.UrlParamState = new URLSearchParams(window.location.search).get('st');
        this._NewArticle = document.querySelector('.new');
        this._ExistArticle = document.querySelector('.exist')
    }

    init() {

        const _GetExistArticle = this.UrlParamId ? this.UrlParamId : false
        localStorage.removeItem('value')

        console.log(_GetExistArticle)

        if (!isNaN(parseInt(_GetExistArticle))) {
            console.log(_GetExistArticle)

            document.querySelector('.exit-article-focus').classList.remove('invisible')

            this._NewArticle.classList.remove('config-active-action')
            this._ExistArticle.classList.add('config-active-action')

            const Family = document.querySelector('.article-family-select').dataset.family
            const FamilySelect = document.querySelector('.opt-family-' + Family)
            if (FamilySelect) {
                FamilySelect.setAttribute('selected', true)
            }

            const Name = document.querySelector('.article-name-select').dataset.art
            const NameSelect = document.querySelector('.opt-name-' + Name)
            if (NameSelect) {
                NameSelect.setAttribute('selected', true)
            } else {
                document.location.replace('config-articles.php?nav=c-article')
            }

            document.querySelector('.exist-article-deleted').classList.remove('hidden')
            document.querySelector('.card-form-article-submit').dataset.target = "update";

            return false;
        } else if (this.UrlParamState) {

            document.querySelector('.exit-article-focus').classList.add('invisible')

            this._NewArticle.classList.remove('config-active-action')
            this._ExistArticle.classList.add('config-active-action')

            document.querySelector('.article-new-name').classList.add('hidden')
            document.querySelector('.article-name-select').classList.remove('hidden')
            document.querySelector('.article-quantity').setAttribute('disabled', true)

            document.querySelector('.card-form-article-submit').dataset.target = "update";

        } else {
            document.querySelector('.exit-article-focus').classList.add('invisible')

            this._NewArticle.classList.add('config-active-action')
            this._ExistArticle.classList.remove('config-active-action')

            document.querySelector('.card-form-article-submit').dataset.target = "insert";
        }

    }

    newToExist(e) {

        if (this.UrlParamId || this.UrlParamState) {
            document.location.replace('config-articles.php?nav=c-article')
        } else if (this._NewArticle.classList.contains('config-active-action')) {
            e.preventDefault()
            return false;
        }

        this._NewArticle.classList.add('config-active-action')
        this._ExistArticle.classList.remove('config-active-action')

        document.querySelector('.exit-article-focus').classList.add('invisible')
        document.querySelector('.article-new-name').classList.remove('hidden')
        document.querySelector('.article-name-select').classList.add('hidden')
        document.querySelector('.article-quantity').removeAttribute('disabled')

    }

    existToNew(e) {

        if (this._ExistArticle.classList.contains('config-active-action')) {
            e.preventDefault();
            return false;
        }

        document.location.replace('config-articles.php?nav=c-article&st=true');

        document.querySelector('.exit-article-focus').classList.add('invisible')
        this._NewArticle.classList.remove('config-active-action')
        this._ExistArticle.classList.add('config-active-action')

        document.querySelector('.article-new-name').classList.add('hidden')
        document.querySelector('.article-name-select').classList.remove('hidden')
        document.querySelector('.article-quantity').setAttribute('disabled', true)

    }

    toggleArticleChange(e) {
        document.location.replace('config-articles.php?nav=c-article&id=' + e.target.value)
    }

    confirm() {
        const TargetAction = document.querySelector('.card-form-article-submit').dataset.target;
        const quantityStatus = document.querySelector('.article-alert-state').checked;
        const quantityMin = quantityStatus ? -1 : document.querySelector('.article-quantity-minimal').value

        const data = {
            nom: document.querySelector('.article-new-name').value,
            id: document.querySelector('.article-name-select').value,
            quantity: document.querySelector('.article-quantity').value,
            quantityMin: quantityMin,
            comment: document.querySelector('.article-commentary').value,
            family: document.querySelector('.article-family-select').value,
            code: document.querySelector('.article-code').value,
            localisation: document.querySelector('.article-localisation').value,
            type: TargetAction,
        }

        if (data.nom < 1) {
            popUp('uncompleted-data')
            document.querySelector('.article-new-name').style.backgroundColor = '#ffa4a4';
            setTimeout(() => { document.querySelector('.article-new-name').style.backgroundColor = 'white' }, 1250)
            return false
        }

        document.querySelector('.article-new-name').style.backgroundColor = 'white'
        popUp('clean')

        $.ajax({
            type: "POST",
            url: `../tools/ajax/config-article.php`,
            data: { ...data },
            success: function (state) {
                console.log(state)
                consoleLog('Mise à jour effectuée.', 's');
                const Result = JSON.parse(state)
                if (Result[0] === 'insert') {
                    popUp('new-article')
                } else {
                    popUp('success')
                }
            },
            error: function () {
                popUp('contact-admin');
            },
        });

    }

    clear() {
        console.log('Clear');
        document.location.replace('config-articles.php?nav=c-article&st=true');
    }

    delete(e) {
        const confirm = confirm("Vous êtes sur le point de supprimer l'article ")
        if (confirm) {
            const TargetAction = document.querySelector('.exist-article-deleted').dataset.target
            console.log(document.querySelector('.article-name-select').value)
            const data = {
                nom: null,
                id: document.querySelector('.article-name-select').value,
                quantity: null,
                quantityMin: null,
                comment: null,
                family: null,
                code: null,
                localisation: null,
                type: TargetAction,
            }
            $.ajax({
                type: "POST",
                url: `../tools/ajax/config-article.php`,
                data: { ...data },
                success: function (rep) {
                    consoleLog('Mise à jour effectuée.', 's');
                    console.table(rep)
                    popUp('success')
                    localStorage.removeItem('value')
                    document.location.replace('config-articles.php?nav=c-article&st=true');

                },
                error: function () {
                    popUp('contact-admin');
                },
            });
        } else {
            e.preventDefault()
        }
    }

    disableAlerts(e) {
        const Status = e.target.checked
        const saveQuantityMin = (value) => {
            if (value) {
                localStorage.setItem('value', value)
                console.log(localStorage.getItem('value'))
            }
        }
        saveQuantityMin(document.querySelector('.article-quantity-minimal').value)
        document.querySelector('.article-quantity-minimal').toggleAttribute('disabled')
        if (!Status) {
            document.querySelector('.article-quantity-minimal').value = localStorage.getItem('value')
        } else {
            document.querySelector('.article-quantity-minimal').value = ''
        }
    }

}
