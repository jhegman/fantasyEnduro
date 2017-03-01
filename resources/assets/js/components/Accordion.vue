<template>
    <div>
        <span class="dropdown" v-if="seen" v-on:click="seen = !seen" v-cloak>
            <i class="fa fa-minus-square-o" aria-hidden="true"></i>
        </span>
        <span class="dropdown" v-if="!seen" v-on:click="seen = !seen" v-cloak>
            <i class="fa fa-plus-square-o" aria-hidden="true"></i>
        </span>
        <span v-on:click="seen = !seen" style="cursor: pointer;">
            <slot name="title"></slot>
        </span>
        <slot v-if="seen" name="form"></slot>
    </div>
</template>
<script>
    export default {
        data: function() {
            return {
                seen: false
            }
        },
        props: {
            errors: {
                type: Boolean,
                required: false
            }
        },
        mounted: function() {
            this.seen = this.errors;
        }
    }
</script>