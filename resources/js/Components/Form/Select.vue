<template>
    <v-select
        :model-value="modelValue"
        class="pa-2"
        :label="label"
        :prefix="prefix"
        :disabled="disabled"
        :required="required"
        :item-title="itemKey"
        item-value="id"
        variant="outlined"
        density="compact"
        :error-messages="errorMessage"
        :items="items"
        :multiple="multiple"
    ></v-select>
</template>

<script>
import {commonProps} from "@/Components/Form/commonProps";
</script>

<script setup>

const props = defineProps({
    commonProps,
    multiple: {
        type: Boolean,
        required: false,
        default: false
    },
    items: {
        type: Array,
        required: false,
    },
    itemKey: {
        type: [String, Number],
        required: false,
    },
})

</script>
