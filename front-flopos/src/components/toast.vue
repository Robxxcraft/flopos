<template>
    <div class="fixed z-20 w-full flex justify-center top-8">
        <div class="bg-white shadow-lg font-medium mx-6 lg:mx-auto rounded p-2 flex items-center space-x-3">
            <div :class="`h-full w-1 ${bgToast} rounded`"></div>
            <div :class="`${toastColor}`">Icon</div>
            <div>
                <div :class="`font-semibold text-lg ${toastColor}`">{{ type ? type : 'Toast' }}</div>
                <div class="text-gray-500">
                    <slot name="text"></slot>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import { ref } from '@vue/reactivity';
export default {
    setup(props) {
        const bgToast = ref('')
        const toastColor = ref('')
        switch (props.type) {
            case 'success':
                bgToast.value = 'bg-green-500'
                toastColor.value = 'text-green-500'
                break;

            case 'error':
                bgToast.value = 'bg-red-500'
                toastColor.value = 'text-red-500'
                break;
        
            default:
                break;
        }

        return { bgToast, toastColor }
    },
    props: ['type']
}
</script>

<style>
.toast-enter-from, .toast-leave-to {
    opacity: 0;
    transform: translateY(-60px);
}
.toast-enter-active, .toast-leave-active{
    transition: all 0.5s ease-in-out;
}
</style>