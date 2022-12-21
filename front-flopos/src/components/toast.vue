<template>
    <div class="fixed z-20 w-full flex justify-center top-8">
        <div :class="`${toastType} shadow-lg font-medium text-white mx-6 lg:mx-auto rounded px-5 py-3`">
            <slot name="text"></slot>
        </div>
    </div>
</template>

<script>
import { ref } from '@vue/reactivity';
export default {
    setup(props) {
        const toastType = ref('')
        switch (props.type) {
            case 'success':
                toastType.value = 'bg-green-400 shadow-green-200'
                break;

            case 'error':
                toastType.value = 'bg-red-400 shadow-red-200'
                break;
        
            default:
                break;
        }

        return { toastType }
    },
    props: ['type']
}
</script>

<style>
.toast-enter-from, 
.toast-leave-to {
    opacity: 0;
    transform: translateY(-60px);
}
/* .toast-enter-to, 
.toast-leave-from {
    opacity: 1;
    transform: translateY(0);
} */
.toast-enter-active,
.toast-leave-active{
    transition: all 0.5s ease-in-out;
}
</style>