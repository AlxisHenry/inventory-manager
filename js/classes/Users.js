import { consoleLog, popUp } from "../functions.js";

export class Users {

    constructor() {
        this.Pages = new URLSearchParams(window.location.search).get('p')
        this.PageIndicator = document.querySelectorAll('.to-page-' + this.Pages)
    }

    refreshDatabase() {
        document.querySelector('.fa-rotate').classList.add('fa-rotate-db-animation');
        document.querySelector('.refresh-database span').style.color = 'black';

        $.ajax({
            type: "POST",
            url: `./tools/ajax/refresh-database-with-csv.php`,
            success: function (refresh) {
                try {
                    let tmp = JSON.parse(refresh)[0];
                    if (tmp) {
                        consoleLog("Utilisateurs temporaires générés.", 'e');
                        document.location.replace("../tools/ajax/users-choices.php");
                    }
                } catch (e) {
                    // :)
                }
                popUp('update-users');
            },
            error: function () {
                popUp('contact-admin')
                consoleLog("Une erreur est survenue durant le rafraîchissement de la base de données (Ajax request failed).", 'e');
            },
        });

        setTimeout(() => {
            document.querySelector('.fa-rotate').classList.remove('fa-rotate-db-animation');
            document.querySelector('.refresh-database span').style.color = 'gray';
            setTimeout(() => {
                document.location.replace('config-users.php?nav=c-users&p=' + this.Pages)
            }, 125)
        }, 3000)
    }

    initPage() {
        if (document.querySelectorAll('.page')) {
            document.querySelectorAll('.page').forEach(removeActive => {
                removeActive.classList.remove('active-page');
            })
            this.PageIndicator.forEach(indicator => {
                indicator.classList.add('active-page')
            })
        }
    }

    search(e) {
        const Value = e.target.value

        if (Value.length < 2) {
            $.ajax({
                type: "POST",
                url: `../tools/ajax/init-users-pagination.php`,
                data: { page: this.Pages },
                success: function (init_this_page) {

                    const UsersElements = init_this_page;

                    const Title = `<div class="main-user-row">
                                    <div class="main-user-title matricule">
                                        <span> Matricule </span>
                                    </div>
                    
                                    <div class="main-user-title identity">
                                        <span>  Identité </span>
                                    </div>
                    
                                    <div class="main-user-title c_cout">
                                        <span>  Centre de coût </span>
                                    </div>
                    
                                    <div class="main-user-title c_affection">
                                        <span>  Lieu d'affection </span>
                                    </div>
                                    </div>`

                    const ResearchElement = document.querySelector('.pages-contain-users');

                    ResearchElement.innerHTML = ''
                    ResearchElement.insertAdjacentHTML('beforeend', Title)
                    ResearchElement.insertAdjacentHTML('beforeend', UsersElements)

                    document.querySelector('.page-separator').classList.remove('invisible')
                    document.querySelectorAll('.move-pages')[0].classList.remove('invisible')
                    document.querySelector('.page-separator-bottom').classList.remove('invisible')
                    document.querySelectorAll('.move-pages')[1].classList.remove('invisible')
                },
                error: function () {
                    popUp('contact-admin')
                    consoleLog("Une erreur est survenue durant le rafraîchissement de la base de données (Ajax request failed).", 'e');
                },
            });
            return false;
        }


        $.ajax({
            type: "POST",
            url: `../tools/ajax/request-user-research.php`,
            data: { Value: Value },
            success: function (users) {

                const UsersElements = users;

                const Title = `<div class="main-user-row">
                <div class="main-user-title matricule">
                    <span> Matricule </span>
                </div>

                <div class="main-user-title identity">
                    <span>  Identité </span>
                </div>

                <div class="main-user-title c_cout">
                    <span>  Centre de coût </span>
                </div>

                <div class="main-user-title c_affection">
                    <span>  Lieu d'affection </span>
                </div>
                </div>`

                const ResearchElement = document.querySelector('.pages-contain-users');

                ResearchElement.innerHTML = ''
                ResearchElement.insertAdjacentHTML('beforeend', Title)
                ResearchElement.insertAdjacentHTML('beforeend', UsersElements)

                document.querySelector('.page-separator').classList.add('invisible')
                document.querySelector('.page-separator-bottom').classList.add('invisible')
                document.querySelectorAll('.move-pages')[0].classList.add('invisible')
                document.querySelectorAll('.move-pages')[1].classList.add('invisible')

            },
            error: function () {
                popUp('contact-admin')
                consoleLog("Une erreur est survenue durant le rafraîchissement de la base de données (Ajax request failed).", 'e');
            },
        });

    }

    initPaginationSeparator() {
        if (document.querySelector('.move-pages .calcul-width')) {
            const Links = document.querySelectorAll('.move-pages .calcul-width')
            const Width = Math.ceil((32.91 + (31.8 * (Links.length - 1)))).toLocaleString() + 'px'
            document.querySelector('.page-separator').style.width = Width
            document.querySelector('.page-separator-bottom').style.width = Width
        }
    }

}
