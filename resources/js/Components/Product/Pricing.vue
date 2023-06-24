<template>
    <v-sheet rounded="lg" class="mb-3">
        <v-card title="Pricing">
            <v-card-item>
                <v-row>
                    <v-col cols="12" sm="4">
                        <Input type="number" label="Price" :prefix="currencyPrefix"
                               @update:modelValue="handleProfitAndMarginChange"
                               v-model="form.sales_price"
                               :errorMessage="errors.sales_price"
                               required/>
                    </v-col>

                    <v-col cols="12" sm="4">
                        <Input type="number" label="Compare-at Price" :prefix="currencyPrefix"
                               v-model="form.compare_price" :errorMessage="errors.compare_price"
                               required/>
                    </v-col>
                    <v-col cols="12" sm="4">
                        <Select :items="taxes" label="Tax" v-model="form.tax"
                                itemKey="titleWithPercentage"/>
                    </v-col>

                </v-row>
                <Switch label="Charge tax on this product"/>
            </v-card-item>
        </v-card>
        <v-divider class="border-opacity-25"></v-divider>
        <v-card>
            <v-card-item>
                <v-row>
                    <v-col cols="12" sm="4">
                        <Input type="number" label="Cost per item" v-model="form.cost_price"
                               :errorMessage="errors.cost_price"
                               @update:modelValue="handleProfitAndMarginChange" required/>
                    </v-col>
                    <v-col cols="12" sm="4">
                        <Input type="number" label="Profit" readonly v-model="form.profit"
                               :errorMessage="errors.profit" required/>
                    </v-col>
                    <v-col cols="12" sm="4">
                        <Input type="number" label="Margin" readonly v-model="form.profit_margin"
                               suffix="%" required :errorMessage="errors.profit_margin"/>
                    </v-col>
                </v-row>
            </v-card-item>
        </v-card>
    </v-sheet>
</template>

<script setup>
import Input from "@/Components/Form/BaseInput.vue";
import Select from "@/Components/Form/Select.vue";

const props = defineProps({
    form: {
        required: true,
    },
    errors: {
        required: true,
    },
    currencyPrefix:{

    },
    taxes:{
        type: Object
    },
})

function handleProfitAndMarginChange() {
    let form = props.form
    form.profit_margin = (((form.sales_price - form.cost_price) / form.sales_price) * 100).toFixed(2)
    form.profit = (form.sales_price - form.cost_price).toFixed(2)
}
</script>

<style scoped>

</style>
