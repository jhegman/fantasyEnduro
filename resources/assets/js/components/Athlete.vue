<template>
    <tr v-if="athleteName.toLowerCase().indexOf(athleteSearch.toLowerCase()) > -1">
        <slot name="athlete-name">

        </slot>

        <slot name="gender">

        </slot>
    </tr>
</template>
<script>
    export default {
        props: ['athleteName', 'athleteSearch']
    }
</script>