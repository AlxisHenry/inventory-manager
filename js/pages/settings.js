import { Input } from "../classes/Input.js";

window.addEventListener('load', () => {
    document.querySelectorAll('.save-modification').forEach(el => {
        el.addEventListener('click', (e) => {
            new Input().save(e);
        })
    })
})