import { Users } from "../classes/Users.js"

window.addEventListener('load', () => {

    const _user = new Users();
    _user.initPage()
    _user.initPaginationSeparator()

    document.querySelector('.refresh-database').addEventListener('click', () => {
        alert('Cette fonctionnalité est désactivée pour le moment.')
        return;
        _user.refreshDatabase()
    })

    if (document.querySelector('.user-searchbar-input')) {
        document.querySelector('.user-searchbar-input').addEventListener('keyup', (e) => {
            _user.search(e)
        })
    }
})