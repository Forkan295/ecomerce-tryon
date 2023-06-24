<template>
    <v-textarea
        :model-value="modelValue"
        :label="label"
        :type="type"
        :prefix="prefix"
        :disabled="disabled"
        @input="$emit('update:modelValue', $event.target.value)"
        :required="required"
        density="compact"
        variant="outlined"
        :error-messages="errorMessage"
    ></v-textarea>
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
