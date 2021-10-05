<template>
</template>
<script>
import Vue from "vue/dist/vue.esm.browser.min";

export default Vue.component("v-init", {
    props: {
        auth: false,
    },
    mounted() {
        if(document.location.hash === '#login'){
            document.getElementById('auth_button').click()
        }
    }
});
</script>
