import { consoleLog } from "../functions.js";

export class Navbar {

    constructor() {
        this.option = new URLSearchParams(window.location.search).get("nav");
        this.AuthorizedPage = ['c-users', 'c-article', 'c-ccout', 'c-famille', 's-entry', 's-checkout', 'visu', 'alerts', 'settings', 'mvmt'];
        this.down = 'menu-burger-transition-element-down'
        this.up = 'menu-burger-transition-element-up'
    };

    init() {
        const selection = document.querySelector(`.${this.option}`);
        consoleLog(`Onglet actif : ${this.option}`, 's');
        selection.classList += ' nav-active';
        if (this.option === 'alerts' || this.option === 'settings') {
            consoleLog('Onglet actif : ' + this.option + ' => Scroll nécessaire', 'e');
            const Navbar = document.querySelector('.features-navigation');
            Navbar.scroll({
                top: '300',
                behavior: 'smooth'
            }) // Envoi l'utilisateur (si l'écran n'est pas grand) en scrollant sur ce qui est en bas du menu si coché.
        }
    }
}