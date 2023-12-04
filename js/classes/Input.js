import { consoleLog, popUp } from "../functions.js";

export class Input {

    save(e) {
        const input = e.target.parentNode.children[0].children[0];
        if (input.value.length <= 0) {
            input.classList.add('void-input');
            popUp('uncompleted-data');
            return false;
        }
        input.classList.remove('void-input');
        const data = {
            target: e.target.parentNode.classList[0].split('-')[0],
            action: e.target.parentNode.classList[0].split('-')[1],
            id: e.target.parentNode.attributes[0].value,
            table: e.target.parentNode.attributes[1].value,
            value: e.target.parentNode.children[0].children[0].value
        }
        $.ajax({
            type: "POST",
            url: `../tools/ajax/apply-input-settings.php`,
            data: { ...data },
            success: (save) => {
                const [value, action] = JSON.parse(save);
                switch (value) {
                    case false:
                        consoleLog('Valeur envoyée vide', 'e');
                        popUp('uncompleted-data');
                        break;
                    case null:
                        consoleLog("Valeur identique à l'ancienne.", 'e');
                        switch (action) {
                            case 'minimal':
                                popUp('same-level');
                                break;
                            default:
                                popUp('success')
                                break;
                        }
                        break;
                    case true:
                        consoleLog("Changement effectué", 'e');
                        switch (action) {
                            case 'minimal':
                                popUp('update-level');
                                $.ajax({
                                    type: "GET",
                                    url: `../tools/ajax/init-alerts-count.php`,
                                    data: { format: 'array', return: ['asset', 'date', 'count-alert'] },
                                    success: function (count) {
                                        if (count !== 0) {
                                            if (document.querySelector('.alert-indication')) {
                                                document.querySelector('.alert-indication').children[0].innerHTML = count;
                                            } else {
                                                const Parent = document.querySelector('.alerts');
                                                const Element = `<div class="alert-indication" title="Nombre d'alertes"><span>${count}</span></div>`;
                                                Parent.insertAdjacentHTML('beforeend', Element);
                                            }
                                        } else {
                                            document.querySelector('.alert-indication').remove();
                                        }
                                    },
                                    error: function () {
                                        popUp('contact-admin');
                                    },
                                });
                                break;
                            default:
                                popUp('success');
                                break;
                        }
                        break;
                    case 'none':
                        consoleLog("La valeur entrée ne correspond pas aux critères demandés", 'e');
                        switch (action) {
                            default:
                                popUp('value-not-corresponding');
                                break;
                        }
                        break;
                    default:
                        popUp('contact-admin')
                }
            },
            error: () => {
                popUp('contact-admin');
            },
        });

    }
}