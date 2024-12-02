import './bootstrap.js';
/*
 * Welcome to your app's main JavaScript file!
 *
 * This file will be included onto the page via the importmap() Twig function,
 * which should already be in your base.html.twig.
 */
import './styles/app.css';

console.log('This log comes from assets/app.js - welcome to AssetMapper! 🎉');

/* --------------- Navbar --------------- */
// Sélectionne la barre de recherche et l'icône
const searchInput = document.querySelector('.search-input');
const searchIcon = document.querySelector('.search-bar-icon');

searchInput.addEventListener('focus', () => {
    searchIcon.style.display = 'none';
});

searchInput.addEventListener('blur', () => {
    searchIcon.style.display = 'block';
});