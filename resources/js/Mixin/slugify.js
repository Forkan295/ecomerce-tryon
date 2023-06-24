import {computed, ref} from 'vue'
export default function useSlugify(initialParam = '') {
    const reuseData = ref(initialParam)
    const reuseMethod = computed(() => {
        return reuseData.value !== '' ? slugify(reuseData.value) : '';
    })
    const slugify = str => str.toLowerCase()
        .trim().replace(/[^\w\s-]/g, '')
        .replace(/[\s_-]+/g, '-')
        .replace(/^-+|-+$/g, '');

    return reuseMethod
}
