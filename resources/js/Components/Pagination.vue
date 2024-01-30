<script setup>

import { router } from '@inertiajs/vue3'
import { watchEffect, reactive } from 'vue';

/**
 * @typede {Object} PageLink
 * @property {boolean} active
 * @property {string} label
 * @property {?string} url
 */

const props = defineProps({
    links: Object,

    meta: Object,

    /** @type {int[]} */
    pageChunks: {
        type: Array,
        default: () => [
            5,
            10,
            15,
            30,
            50,
            100
        ]
    }
})

const pageMeta = reactive({
    currentPage: props.meta.current_page,
    currentPageChunk: props.meta.per_page,
})

/**
 * @returns {void}
 */
function previousPage() {
    if (pageMeta.currentPage > 1) {
        navigateToPage(props.meta.current_page - 1)
    }
}

/**
 * @returns {void}
 */
function nextPage() {
    if (pageMeta.currentPage < props.meta.last_page) {
        navigateToPage(props.meta.current_page + 1)
    }
}

/**
 * @param {int} pageNumber
 * @return {void}
 */
function navigateToPage(pageNumber) {
    props.meta.current_page = pageNumber

    router.visit(window.location.href, {
        data: {
            page: pageNumber,
        },
        preserveScroll: true,
        preserveState: true
    })
}

/**
 * @param {int} pageNumber
 * @return {void}
 */
function changePageChunk(chunk) {
    pageMeta.currentPage = 1

    router.visit(window.location.href, {
        replace: true,
        data: {
            per_page: chunk,
            page: 1
        },
        preserveScroll: true,
        preserveState: true
    })

}

// Watch for changes in props.meta
watchEffect(() => {
    pageMeta.currentPage = props.meta.current_page
    pageMeta.currentPageChunk = props.meta.per_page
})

</script>

<template>
    <div class="flex items-center">
        <slot>
            <div class="flex w-full justify-center md:justify-end">
                <button class="cursor-pointer w-[38px] h-[38px] flex justify-center rounded-md bg-[#4B465C14] mx-2"
                        @click="previousPage" :disabled="pageMeta.currentPage <= 1">
                    <div class="self-center">
                        <img class="w-2 inline-block" src="images/svg/icons/left-arrow.svg" />
                    </div>
                </button>

                <div class="flex gap-2 gap-y-2">
                    <div v-for="page in meta.last_page" :key="page.id">
                        <button class="cursor-pointer min-w-[38px] h-[38px] p-2 flex justify-center rounded-md"
                                @click="navigateToPage(page)" :disabled="pageMeta.currentPage == page"
                                :class="{
                 'bg-[#05164D] text-white' : pageMeta.currentPage == page,
                 'bg-[#4B465C14] text-[#4B465C]' : pageMeta.currentPage !== page
              }"
                        >
                            <div class="self-center">
                                <a v-text="page"></a>
                            </div>
                        </button>
                    </div>
                </div>

                <button class="cursor-pointer w-[38px] h-[38px] flex justify-center rounded-md bg-[#4B465C14] mx-2"
                        @click="nextPage" :disabled="pageMeta.currentPage >= meta.last_page">
                    <div class="self-center">
                        <img class="w-2 inline-block" src="images/svg/icons/right-arrow.svg" />
                    </div>
                </button>
            </div>
        </slot>
    </div>
</template>

