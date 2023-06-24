<template>
    <v-text-field
        class="py-2"
        density="compact"
        :model-value="modelValue"
        :label="label"
        :type="type"
        :prefix="prefix"
        :disabled="disabled"
        @input="$emit('update:modelValue', $event.target.value)"
        :required="required"
        variant="outlined"
        :error-messages="errorMessage"
    ></v-text-field>
</template>

<script>
import {commonProps} from "@/Components/Form/commonProps";

let propObject = {};
propObject = {...commonProps, ...propObject}
</script>
<script setup>
const props = defineProps(propObject)
</script>

<style scoped>

</style>
