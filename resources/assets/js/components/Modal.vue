<template>
    <transition name="modal">
        <div class="modal-mask" @click="closeModal">
            <div class="modal-wrapper">
                <div class="modal-container">
                    <i class="fa fa-times" aria-hidden="true" @click="closeModal"></i>
                        <slot name="body"></slot>
                </div>
            </div>
        </div>
    </transition>
</template>
<script>
    export default {
        props: ['modalClass'],
        methods: {
            closeModal(event) {
                this.$emit('modal-closed', false);
            }
        }
    }
</script>