// import {Fancybox as NativeFancybox} from "@fancyapps/ui/dist/fancybox.esm.js";
import {Fancybox} from "@fancyapps/ui/src/Fancybox/Fancybox.js";
import "@fancyapps/ui/dist/fancybox.css";

const options = {
    closeExisting: true,
    mainClass: 'Test Test Test Test Test Test ',
    closeButton: 'outside'
}

function fancyBox(props) {
    console.log('Fancybox');


    // const delegate = document.get('data-fancybox');
    const delegate = document.querySelectorAll('[data-fancybox]');
    console.log(delegate);
    const opts = options || {};

    // return NativeFancybox.bind(delegate, opts);
    return new Fancybox(delegate, opts);
}

export default fancyBox;
