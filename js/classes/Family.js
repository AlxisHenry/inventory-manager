import { consoleLog, popUp } from "../functions.js";

export class Family {

    constructor() {
        this.UrlParamId = new URLSearchParams(window.location.search).get("id");
        this.UrlParamState = new URLSearchParams(window.location.search).get('st');
        this._NewFamily = document.querySelector('.new');
        this._ExistFamily = document.querySelector('.exist')
    }

    init() {

        const _GetExistArticle = this.UrlParamId ? this.UrlParamId : false

        if (!isNaN(parseInt(_GetExistArticle))) {
            this._NewFamily.classList.remove('config-active-action')
            this._ExistFamily.classList.add('config-active-action')
            document.querySelector('.exit-article-focus').classList.remove('invisible')
            document.querySelector('.delete-family').classList.remove('hidden')
            document.querySelector('.family-name-select').children[0].removeAttribute('selected')
            document.querySelector('.opt-family-' + _GetExistArticle).setAttribute('selected', true)
            document.querySelector('.card-form-family-submit').dataset.target = 'update'
        } else if (this.UrlParamState) {
            this._NewFamily.classList.remove('config-active-action')
            this._ExistFamily.classList.add('config-active-action')
            document.querySelector('.form-edit-family').classList.remove('hidden')
            document.querySelector('.new-family-name').classList.add('hidden')
            document.querySelector('.new-family-name').parentNode.classList.add('hidden')
            document.querySelector('.card-form-family-submit').dataset.target = 'update'
        } else {
            document.querySelector('.form-edit-family').classList.add('hidden')
            document.querySelector('.new-family-name').classList.remove('hidden')
            document.querySelector('.new-family-name').parentNode.classList.remove('hidden')
            document.querySelector('.card-form-family-submit').dataset.target = 'insert'
        }
    }

    newToExist(e) {

        if (this.UrlParamId || this.UrlParamState) {
            document.location.replace('config-familles.php?nav=c-famille')
        } else if (this._NewFamily.classList.contains('config-active-action')) {
            e.preventDefault()
            return false;
        }

        document.querySelector('.card-form-family-submit').dataset.target = 'insert'

        this._NewFamily.classList.add('config-active-action')
        this._ExistFamily.classList.remove('config-active-action')

    }

    existToNew(e) {

        if (this._ExistFamily.classList.contains('config-active-action')) {
            e.preventDefault();
            return false;
        }

        document.location.replace('config-familles.php?nav=c-famille&st=true');
        document.querySelector('.card-form-family-submit').dataset.target = 'update'

        this._NewFamily.classList.remove('config-active-action')
        this._ExistFamily.classList.add('config-active-action')

        document.querySelector('.form-edit-family').classList.remove('hidden')
        document.querySelector('.new-family-name').classList.add('hidden')
        document.querySelector('.new-family-name').parentNode.classList.add('hidden')

    }

    toggleFamilyChange(e) {
        document.location.replace('config-familles.php?nav=c-famille&id=' + e.target.value)
    }

    clear() {
        console.log('Clear');
        document.location.replace('config-familles.php?nav=c-famille&st=true');
    }

    confirm() {

        const TargetAction = document.querySelector('.card-form-family-submit').dataset.target ?? false;

        if (!TargetAction) {
            popUp('uncompleted-data')
            return false
        }

        const data = {
            id: document.querySelector('.family-name-select').value ?? 0,
            nom: document.querySelector('.new-family-name').value,
            comment: document.querySelector('.new-family-comment').value,
            type: TargetAction,
        }

        if (data.nom.length < 1) {
            popUp('uncompleted-data')
            return false
        }

        popUp('clean')

        $.ajax({
            type: "POST",
            url: `../tools/ajax/config-famille.php`,
            data: { ...data },
            success: function (state) {
                popUp('success')
            },
            error: function () {
                popUp('contact-admin');
            },
        });

    }

    delete(e) {
        const Confirm = confirm("Vous êtes sur le point de supprimer la famille ! Les articles n'auront plus de famille... ")
        if (Confirm) {
            const TargetAction = document.querySelector('.exist-family-deleted').dataset.target
            const data = {
                id: document.querySelector('.family-name-select').dataset.family ?? null,
                nom: null,
                comment: null,
                type: TargetAction,
            }
            $.ajax({
                type: "POST",
                url: `../tools/ajax/config-famille.php`,
                data: { ...data },
                success: function (rep) {
                    consoleLog('Mise à jour effectuée.', 's');
                    console.table(rep)
                    popUp('success')
                    document.location.replace('config-familles.php?nav=c-famille&st=true');
                },
                error: function () {
                    popUp('contact-admin');
                },
            });
        } else {
            e.preventDefault()
        }

    }

}
