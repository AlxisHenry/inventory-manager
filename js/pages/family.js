import { Family } from "../classes/Family.js";

window.addEventListener('load', () => {

    const _family = new Family();

    _family.init()

    document.querySelector('.new').addEventListener('click', (e) => {
        _family.newToExist(e);
    })

    document.querySelector('.exist').addEventListener('click', (e) => {
        _family.existToNew(e);
    })

    document.querySelector('.family-name-select').addEventListener('change', (e) => {
        _family.toggleFamilyChange(e)
    })

    document.querySelector('.exit-article-focus').addEventListener('click', () => {
        _family.clear()
    })

    document.querySelector('.card-form-family-submit').addEventListener('click', (e) => {
        _family.confirm();
    })

    document.querySelector('.exist-family-deleted').addEventListener('click', (e) => {
        _family.delete(e)
    })
})