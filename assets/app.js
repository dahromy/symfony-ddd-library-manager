import './styles/app.css';
import './bootstrap.js';
import { Turbo } from '@hotwired/turbo-rails';

Turbo.session.drive = false;

document.addEventListener('turbo:load', () => {
    Turbo.session.drive = true;
});

console.log('This log comes from assets/app.js - welcome to AssetMapper! 🎉');
