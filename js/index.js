import { debug } from './functions.js';
import { Navbar } from './classes/Navbar.js';

window.addEventListener('load', () => {
    debug(true);
    new Navbar().init();
});
