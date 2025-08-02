import './bootstrap';

import Alpine from 'alpinejs';
import Choices from 'choices.js';

window.Alpine = Alpine;

Alpine.start();

document.addEventListener('DOMContentLoaded', () => {
    const el = document.querySelector('#category_id');
    if (el) {
        new Choices(el, {
            removeItemButton: false,
            searchEnabled: true,
            itemSelectText: '',
            searchResultLimit: 5,
            position: 'bottom'
        });
    }
});
