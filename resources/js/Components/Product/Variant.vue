<template>
    <!--    option start-->
    <v-card class="pa-4 my-2">
        <v-row v-for="(option,index) in form.variant">
            <v-card-title>Option Name</v-card-title>
            <v-divider/>
            <v-spacer class="space-y-1"></v-spacer>
            <v-col cols="12" sm="9" class="pa-1">
                <Select
                    v-model="option.value"
                    style="margin-bottom: -30px !important;"
                    label="Option Name"
                    :items="data.attrs"
                    item-title="title_en"
                    @update:modelValue="handleChange($event)"
                    item-value="id"></Select>
            </v-col>

            <v-col cols="12" sm="3" class="mb-0" v-show="index !== 0">
                <v-btn class="my-2" @click="removeOption(index)" density="compact">
                    <v-icon color="red" size="20" icon="mdi-delete-outline"></v-icon>
                </v-btn>
            </v-col>

            <v-col cols="12" sm="12" class="my-0">
                <!--    option value start-->
                <v-card variant="flat">
                    <v-card-title>Option Value</v-card-title>
                    <v-row v-for="(optionVal,optionIndex) in option.optionValue" class="my-0">
                        <v-col cols="12" sm="9">
                            <Input class="option-value" v-model="optionVal.value"/>
                        </v-col>
                        <v-col cols="12" sm="2" v-show="optionIndex !== 0">
                            <v-btn class="my-2" density="compact" @click="removeOptionValue(optionIndex,option)">
                                <v-icon color="red" size="20" icon="mdi-delete-outline"></v-icon>
                            </v-btn>
                        </v-col>
                    </v-row>
                </v-card>
                <!--option value End-->
                <v-row>
                    <v-col cols="12" sm="4">
                        <v-btn class="my-4 text-blue border" density="comfortable" @click="addOptionValue(option)">
                            <v-icon size="20" icon="mdi-plus"></v-icon>
                            <span class="text-variant">Add Another Value</span>
                        </v-btn>
                    </v-col>
                </v-row>
            </v-col>
        </v-row>
        <v-divider/>
        <!--    Button Start-->
        <v-row>
            <v-col col="12" sm="4">
                <v-btn v-show="data.isAttrEmpty !== true" density="comfortable" class="my-4 text-blue border"
                       @click="addOption">
                    <v-icon size="20" icon="mdi-plus"></v-icon>
                    <span class="text-variant">Add Another Option</span>
                </v-btn>
            </v-col>
            <v-col col="12" offset="5" sm="3">
                <v-btn class="my-4 d-inline bg-light-green text-white float-right" @click="generateVariant"> Done
                    <v-tooltip
                        activator="parent"
                        location="top"
                    >Generate Variant
                    </v-tooltip>
                </v-btn>
            </v-col>
        </v-row>
        <!--    Button end-->
    </v-card>
    <!--    option end-->


    <!--    Option combination table start-->
    <v-card v-show="data.optionGeneratorPanel" style="max-width: 1200px;  overflow-x: auto">
        <v-sheet width="1300" overflow-x="auto">
            <v-table density="compact">
                <thead>
                    <tr>
                        <th class="text-center">
                            Variant
                        </th>
                        <th class="text-center">
                            Price
                        </th>
                        <th class="text-center">
                            Available
                        </th>
                        <th class="text-center">
                            On hand
                        </th>
                        <th class="text-center">
                            SKU
                        </th>
                        <th class="text-center">
                            Image
                        </th>
                        <th class="text-center">
                            3D file
                        </th>
                        <th class="text-center">
                            Preview
                        </th>
                        <th class="text-center">
                            Action
                        </th>
                    </tr>
                </thead>
                <tbody>
                <tr v-for="(option,index) in form.optionCombinations">
                    <td>
                        <div v-for="(combinationOptionValues,index) in option.value" class="mb-2">
                            <v-chip size="x-small">
                                {{ option.value[index].value }}
                            </v-chip>
                        </div>
                        <br>
                    </td>
                    <td><Input type="number" :prefix="currencyPrefix" label="Variant Price"
                               v-model="option.price"/>
                    </td>
                    <td><Input type="number" v-model="option.available"/></td>
                    <td><Input type="number" v-model="option.onHand"/></td>
                    <td><Input type="text" v-model="option.sku"/></td>
                    <td>
                        <v-btn class="mb-6" @click="openAttrImageInput(index)" icon="mdi-camera-plus"></v-btn>
                        <v-file-input
                            class="d-none"
                            label="Image"
                            density="compact"
                            ref="attrImageInput"
                            variant="outlined"
                            v-model="option.image"
                        ></v-file-input>
                    </td>
                    <td>
                        <v-btn class="mb-6" @click="openAttrFileInput(index)" icon="mdi-upload"></v-btn>
                        <v-file-input
                            class="d-none"
                            ref="attrFileInput"
                            label="3D file"
                            density="compact"
                            accept=".glb"
                            variant="outlined"
                            v-model="option.file"
                        ></v-file-input>
                    </td>
                    <td>
                        <v-list-item
                            class="mb-6 ml-5"
                            :prepend-avatar="option.imageUrl"
                        ></v-list-item>
                    </td>
                    <td>
                        <Link v-if="form.putMethod !== false" preserve-state
                              :href="route('backend.product.attribute.delete', [$page.props.auth.tenant, option.id])"
                              @success="onDeleteSuccess(index)" method="delete" as="button" type="button">
                            <v-btn class="mb-6" color="red" icon="mdi-delete" size="small"></v-btn>
                        </Link>
                    </td>
                </tr>
                <tr v-for=" (option,index) in form.newOptionCombinations" v-show="edit">
                    <td>
                        <div v-for="(combinationOptionValues,index) in option.value" class="mb-2">
                            <v-chip size="x-small">
                                {{ option.value[index].value }}
                            </v-chip>
                        </div>
                        <br>
                    </td>
                    <td><Input type="number" :prefix="currencyPrefix" label="Variant Price"
                               v-model="option.price"/>
                    </td>
                    <td><Input type="number" v-model="option.available"/></td>
                    <td><Input type="number" v-model="option.onHand"/></td>
                    <td><Input type="text" v-model="option.sku"/></td>
                    <td>
                        <v-btn class="mb-6" @click="openNewAttrImageInput(index)" icon="mdi-camera-plus"
                               size="small"></v-btn>
                        <v-file-input
                            class="d-none"
                            label="Image"
                            density="compact"
                            ref="newAttrImageInput"
                            variant="outlined"
                            v-model="option.image"
                        ></v-file-input>
                    </td>
                    <td>
                        <v-btn class="mb-6" @click="openNewAttrFileInput(index)" icon="mdi-upload"></v-btn>
                        <v-file-input
                            class="d-none"
                            ref="newAttrFileInput"
                            label="3D file"
                            density="compact"
                            accept=".glb"
                            variant="outlined"
                            v-model="option.file"
                        ></v-file-input>
                    </td>
                </tr>
                </tbody>
            </v-table>
        </v-sheet>

    </v-card>
    <!--    Option combination table end-->
</template>

<script setup>
import Input from "@/Components/Form/BaseInput.vue";
import Select from "@/Components/Form/Select.vue";
import {Link} from '@inertiajs/vue3'
import {reactive, ref} from "vue";

const attrFileInput = ref(null)
const attrImageInput = ref(null)
const newAttrFileInput = ref(null)
const newAttrImageInput = ref(null)
const data = reactive({
    optionGeneratorPanel: props.optionGeneratorPanel,
    generatedCombination: null,
    currentAttrs: [],
    attrs: props.attrs,
    isAttrEmpty: false
})

const props = defineProps({
    form: {
        required: true,
    },
    currencyPrefix: {
        type: String,
    },
    attrs: {
        type: Object
    },
    edit: {
        default: false
    }
    , optionGeneratorPanel: {
        default: false
    }
})

function handleChange(event) {
    console.log(event)
    data.currentAttrs.push(event)
}

function openAttrImageInput(index) {
    attrImageInput.value[index].click()
}

function openAttrFileInput(index) {
    attrFileInput.value[index].click()
}

function openNewAttrImageInput(index) {
    newAttrImageInput.value[index].click()
}

function openNewAttrFileInput(index) {
    newAttrFileInput.value[index].click()
}

function onDeleteSuccess(index) {
    props.form.optionCombinations.splice(index, 1)
}

const addOption = function () {
    let variant = props.form.variant;

    if (variant[variant.length - 1].value === '') {
        return false
    }

    variant.push(
        {
            value: "",
            optionValue: [{
                value: ""
            }]
        }
    )

    // axios.get(route('backend.product.attrs', {attrs: data.currentAttrs}))
    //     .then(response => {
    //         console.log(response.data);
    //         data.attrs = response.data;
    //         if (data.attrs.length === 1) {
    //             data.isAttrEmpty = true;
    //         }
    //     })
}

const addOptionValue = function (option) {
    if (option.value !== '') {
        option.optionValue.push(
            {
                value: ""
            }
        )
    }
}

const removeOption = function (index) {
    props.form.variant.splice(index, 1)
}

const removeOptionValue = function (index, option) {
    option.optionValue.splice(index, 1)
}

const generateVariant = function () {
    data.optionGeneratorPanel = true
    let combination = generateCombinations(props.form.variant)
    if (!props.edit) {
        props.form.optionCombinations = []
    }
    for (const combinationElement of combination) {
        let sku = generateSku(combinationElement)
        let combinationElementObj = {
            value: combinationElement,
            price: props.form.sales_price,
            available: '',
            onHand: '',
            sku: sku,
        }

        if (!props.edit) {
            props.form.optionCombinations.push(combinationElementObj)
        } else {
            props.form.newOptionCombinations.push(combinationElementObj)
        }
    }

}

const generateCombinations = function (arrays, current = []) {
    if (current.length === arrays.length) {
        return [current];
    } else {
        const result = [];
        for (let i = 0; i < arrays[current.length].optionValue.length; i++) {
            let concatableObj = arrays[current.length].optionValue[i];
            concatableObj['optionId'] = arrays[current.length].value;
            const combinations = generateCombinations(arrays, current.concat(concatableObj));
            result.push(...combinations);
        }

        return result;
    }
}

function generateSku(combination) {
    let sku = props.form.sku;
    for (const combinationElement of combination) {
        sku += combinationElement.value.charAt(0)
    }
    return sku.toUpperCase();
}

function getAttrs() {
    axios.get(route('backend.product.attrs', {attrs: data.currentAttrs}))
        .then(response => {
            data.attrs = response;

        })
}

</script>

<style scoped>
.option-value {
    padding: 0 !important;
    margin-bottom: -20px !important;
}

.text-variant {
    font-size: 10px;
    font-weight: bold;
    word-spacing: -1px;
    letter-spacing: 1px;
}
</style>
