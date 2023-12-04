import { Article } from "../classes/Article.js"

window.addEventListener('load', () => {

    const _article = new Article();

    _article.init()

    document.querySelector('.new').addEventListener('click', (e) => {
        _article.newToExist(e);
    })

    document.querySelector('.exist').addEventListener('click', (e) => {
        _article.existToNew(e);
    })

    document.querySelector('.article-name-select').addEventListener('change', (e) => {
        _article.toggleArticleChange(e);
    })

    document.querySelector('.card-form-article-submit').addEventListener('click', () => {
        _article.confirm();
    })

    document.querySelector('.exit-article-focus').addEventListener('click', () => {
        _article.clear();
    })

    document.querySelector('.exist-article-deleted').addEventListener('click', (e) => {
        _article.delete(e);
    })

    document.querySelector('.article-alert-state').addEventListener('click', (e) => {
        _article.disableAlerts(e);
    })

})