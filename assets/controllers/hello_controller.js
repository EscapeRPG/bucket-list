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

        this.checkDarkMode();
    }
    checkDarkMode() {
        const body = document.body,
            darkButton = document.getElementById("darkbutton");

        if (localStorage.getItem("darkmode") === "on") {
            body.classList.add("darkmode");
            darkButton.innerText = "☼";
        }

        void body.offsetWidth;

        body.classList.remove('no-transition');
    }

    rayer() {
        const button = event.currentTarget;
        const wishDiv = button.closest('.wish-container').querySelector('.wish');
        wishDiv.classList.toggle('raye');

        if (wishDiv.classList.contains('raye')) {
            button.innerText = '✗';
            button.classList.add('validated');
        } else {
            button.innerText = '✓';
            button.classList.remove('validated');
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

    darkmode() {
        const body = document.body,
            darkButton = document.getElementById("darkbutton");

        if (body.className === "darkmode") {
            body.classList.remove("darkmode");
            localStorage.setItem("darkmode", "off");
            darkButton.innerText = "\u263d";
        } else {
            body.classList.toggle("darkmode");
            localStorage.setItem("darkmode", "on");
            darkButton.innerText = "☼";
        }
    }
}
