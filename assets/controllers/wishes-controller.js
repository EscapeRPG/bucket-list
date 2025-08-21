import {Controller} from '@hotwired/stimulus';

/*
 * This is an example Stimulus controller!
 *
 * Any element with a data-controller="hello" attribute will cause
 * this controller to be executed. The name "hello" comes from the filename:
 * hello_controller.js -> "hello"
 *
 * Delete this file or adapt it for your use!
 */
export default class extends Controller {
    connect() {
        const body = document.body,
            darkButton = document.getElementById("darkbutton");

        body.classList.add('no-transition');
        this.checkValidWishes();
    }

    rayer() {
        const button = event.currentTarget;
        const wishDiv = button.closest('.wish-container').querySelector('.wish');

        let validWishes = new Set();
        let actualWishes = JSON.parse(localStorage.getItem("valid-wishes"));

        if (actualWishes) {
            actualWishes.forEach((wish) => {
                validWishes.add(wish);
            })
        }

        wishDiv.classList.toggle('raye');

        if (wishDiv.classList.contains('raye')) {
            button.innerText = '✗';
            button.classList.add('validated');

            validWishes.add(wishDiv.id);

            localStorage.setItem("valid-wishes", JSON.stringify(Array.from(validWishes)));
        } else {
            button.innerText = '✓';
            button.classList.remove('validated');

            validWishes.delete(wishDiv.id);

            localStorage.setItem("valid-wishes", JSON.stringify(Array.from(validWishes)));
        }
    }

    checkValidWishes() {
        let actualWishes = JSON.parse(localStorage.getItem("valid-wishes"));

        if (actualWishes) {
            actualWishes.forEach((wish) => {
                let validWish =document.getElementById(wish);
                validWish.classList.add('raye');
                let button = validWish.closest('.wish-container').querySelector('.validate-wish');
                button.innerText = '✓';
                button.classList.add('validated');
            })
        }
    }

    checkWishState() {
        const button = event.currentTarget;
            if (button.innerText === '✓') {
                button.innerText = '✗';
            } else {
                button.innerText = '✓';
            }
    }

    changeInnerText() {
        const button = event.currentTarget;
        if (button.innerText === '✓') {
            button.innerText = '';
        } else {
            button.innerText = '✓';
        }
    }
}
