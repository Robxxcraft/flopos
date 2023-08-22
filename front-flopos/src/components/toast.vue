<template>
    <div class="fixed z-20 w-full flex justify-center top-8">
        <div class="bg-white shadow-lg font-medium mx-6 lg:mx-auto rounded p-2 flex items-center space-x-3">
            <div :class="`h-full w-1 ${bgToast} rounded`"></div>
            <div :class="`${toastColor}`">
                <template v-if="type == 'success'">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"><path d="M10.0007 15.1709L19.1931 5.97852L20.6073 7.39273L10.0007 17.9993L3.63672 11.6354L5.05093 10.2212L10.0007 15.1709Z"></path></svg>
                </template>
                <template v-else="type == 'error'">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"><path d="M12.0007 10.5865L16.9504 5.63672L18.3646 7.05093L13.4149 12.0007L18.3646 16.9504L16.9504 18.3646L12.0007 13.4149L7.05093 18.3646L5.63672 16.9504L10.5865 12.0007L5.63672 7.05093L7.05093 5.63672L12.0007 10.5865Z"></path></svg>
                </template>
            </div>
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