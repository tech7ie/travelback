<template>
    <select id="currency_select" class="">
        <option
            :selected="currentcurrency === key"
            v-for="(currency, key) in JSON.parse(currencylist)"
                :value="key">{{ currency }}
        </option>
    </select>
</template>
<script>
import Vue from "vue/dist/vue.esm.browser.min";
import SlimSelect from "slim-select";
//
// let selectElements = [].slice.call(document.querySelectorAll(".js-select"));
// selectElements.forEach(function (selectElement) {
//     new SlimSelect({
//         select: selectElement,
//         showSearch: false,
//     });
// });


export default Vue.component("v-currency-select", {
    props: {
        currencylist: [],
        currentcurrency: 'eur'
    },
    data(){
        return {
            currencyList: [
                {
                    title: 'Australian Dollar',
                    code: 'cad',
                },
                {
                    title: 'Euro',
                    code: 'eur',
                },
                {
                    title: 'U.S. Dollar',
                    code: 'usd',
                },
            ]
        }
    },
    mounted() {
        new SlimSelect({
            select: document.getElementById('currency_select'),
            showSearch: false,
            onChange: (info) => {
                window.location.href = '/setcurrency/' + info.value
                //console.log(info)
            }
        });
    }
});
</script>
