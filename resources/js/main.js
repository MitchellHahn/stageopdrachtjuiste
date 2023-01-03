import {down, up} from 'slide-element';

const mobileNav = document.querySelector('#navbarSupportedContent');
const navBtn = document.querySelector('.nav-btn');

if(navBtn) {
    navBtn.addEventListener('click', function() {
        if(this.classList.contains('is-active')) {
            this.classList.remove('is-active');
            up(mobileNav);
        } else {
            this.classList.add('is-active');
            down(mobileNav);
        }
    });
}
