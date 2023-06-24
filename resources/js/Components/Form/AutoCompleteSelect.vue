<template>
    <v-autocomplete
        :model-value="modelValue"
        :label="label"
        :prefix="prefix"
        chips
        closable-chips
        density="compact"
        :disabled="disabled"
        :required="required"
        :error-messages="errorMessage"
        :items="items"
        :multiple="multiple"
    ></v-autocomplete>
</template>

<script>
import {commonProps} from "@/Components/Form/commonProps";

let propObject = {
    items: {
        type: Array,
        required: false,
    },
    multiple: {
        type: Boolean,
        required: false,
        default: false
    },
};
let mergedPropObject = {...commonProps,...propObject}
</script>

<script setup>
const props = defineProps(mergedPropObject)
</script>
