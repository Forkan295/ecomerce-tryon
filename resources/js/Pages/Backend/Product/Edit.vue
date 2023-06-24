<template>
    <AuthenticatedLayout>
        <Head title="Create Product"/>

        <form @submit.prevent="handleForm">
            <v-row no-gutters>
                <v-col cols="12" class="my-3">
                    <CardTitle
                        title="Edit Product"
                        icon="mdi-arrow-left-bold"
                        :router="{title:'Back', route:'backend.product.index', queryParam: $page.props.auth.tenant}"
                    />
                </v-col>
                <v-col cols="12" sm="8" class="pr-2 mb-3">
                    <v-sheet rounded="lg" class="mb-3">
                        <v-card>
                            <v-card-item>
                                <v-tabs
                                    v-model="data.tab"
                                    bg-color="white"
                                >
                                    <v-tab value="en">English</v-tab>
                                    <v-tab value="bn">Bangla</v-tab>
                                </v-tabs>
                                <v-window v-model="data.tab">
                                    <v-window-item value="en">
                                        <Input type="text" label="Title En" v-model="form.title_en" required
                                               :errorMessage="errors.title_en"/>
                                        <TextArea label="Content En" v-model="form.content_en"
                                                  :errorMessage="errors.content_en"></TextArea>
                                    </v-window-item>

                                    <v-window-item value="bn">
                                        <Input type="text" label="Title Bn" v-model="form.title_bn" required/>
                                        <TextArea label="Content Bn" v-model="form.content_bn"></TextArea>
                                    </v-window-item>
                                </v-window>
                            </v-card-item>
                        </v-card>
                    </v-sheet>
                    <v-sheet rounded="lg" class="mb-3">
                        <v-card title="Media">
                            <v-divider/>
                            <v-card-item class="mb-3">
                                <v-row class="ma-2">
                                    <v-col cols="12" sm="2" class="d-flex child-flex border mr-1 mb-1">
                                        <v-icon
                                            class="mx-auto my-auto ma-2"
                                            color="primary"
                                            size="80"
                                            @click="openImageInput"
                                            icon="mdi-plus-circle-outline"></v-icon>
                                    </v-col>
                                    <v-col cols="12" sm="2" v-for="(image,index) in form.images"
                                           class="d-flex child-flex border mr-1 mb-1">
                                        <v-img aspect-ratio="1"
                                               v-if="!image.isStored"
                                               cover
                                               class="bg-grey-lighten-2" :src="handleImagePath(image)">
                                            <v-btn
                                                size="small"
                                                density="compact"
                                                class="float-end"
                                                color="red"
                                                icon="mdi-close-circle"
                                                @click="handleImageRemove(index,image)"></v-btn>
                                        </v-img>

                                        <v-img aspect-ratio="1"
                                               v-else
                                               cover
                                               class="bg-grey-lighten-2" :src="image.url">
                                            <v-btn
                                                size="small"
                                                density="compact"
                                                class="float-end"
                                                color="red"
                                                icon="mdi-close-circle"
                                                @click="handleImageRemove(index,image)"></v-btn>
                                        </v-img>

                                    </v-col>
                                </v-row>
                            </v-card-item>
                            <v-card-item>
                                <v-file-input
                                    label="3d file"
                                    density="compact"
                                    counter
                                    accept=".glb"
                                    variant="outlined"
                                    v-model="form.files"
                                    :error-messages="errors.files"
                                    multiple
                                ></v-file-input>
                            </v-card-item>
                            <v-file-input
                                label="Image"
                                density="compact"
                                ref="imageInput"
                                class="d-none"
                                counter
                                variant="outlined"
                                accept="image/png, image/jpeg, image/bmp"
                                prepend-icon="mdi-camera"
                                @update:modelValue="handleImage($event)"
                                :error-messages="errors.images"
                            ></v-file-input>
                        </v-card>
                    </v-sheet>

                    <Pricing :form="form" :errors="errors" :currencyPrefix="currencyPrefix" :taxes="taxes"/>

                    <v-sheet rounded="lg" class="mb-3">
                        <v-card title="Inventory">
                            <v-divider/>
                            <v-card-item>
                                <Switch label="This product has a SKU or barcode"/>
                                <v-row>
                                    <v-col cols="12" sm="6">
                                        <Input type="text" label="SKU (Stock Keeping Unit)" v-model="form.sku"
                                               :errorMessage="errors.sku"
                                        />
                                    </v-col>
                                    <v-col cols="12" sm="6">
                                        <Input type="text" label="Barcode (ISBN, UPC, GTIN)" v-model="form.barcode"
                                               :errorMessage="errors.barcode"
                                        />
                                    </v-col>
                                </v-row>
                            </v-card-item>
                        </v-card>
                    </v-sheet>

                    <v-sheet rounded="lg">
                        <v-card title="Variants">
                            <v-divider/>
                            <v-card-item>
                                <Variant :edit="true" :optionGeneratorPanel="true" :form="form"
                                         :currencyPrefix="currencyPrefix" :attrs="attrs"/>
                            </v-card-item>
                        </v-card>
                    </v-sheet>
                </v-col>

                <v-col cols="12" sm="4">
                    <v-sheet rounded="lg" class="mb-3">
                        <v-card title="Product Organization">
                            <v-divider/>
                            <v-card-item>
                                <v-select
                                    v-model="form.category"
                                    class="mt-4"
                                    density="compact"
                                    label="Category"
                                    item-title="title_en"
                                    item-value="id"
                                    variant="outlined"
                                    :error-messages="errors.category"
                                    :items="categories"
                                ></v-select>
                            </v-card-item>
                            <v-card-item>
                                <Select
                                    multiple label="Tags"
                                    :items="allTags"
                                    v-model="form.tags"
                                    item-title="title_en"
                                    item-value="id"/>
                            </v-card-item>
                        </v-card>
                    </v-sheet>

                    <v-sheet rounded="lg">
                        <v-card>
                            <v-card-item title="Status">
                                <Switch v-model="form.status" :label="form.status?'On':'Off'" @click="form.status = !form.status"/>
                            </v-card-item>
                        </v-card>
                    </v-sheet>
                </v-col>
            </v-row>
            <v-divider></v-divider>
            <v-card-actions>
                <v-btn
                    type="submit"
                    class="text-none mb-4 mx-auto"
                    color="indigo-darken-3"
                    variant="flat"
                >
                    Save
                </v-btn>
            </v-card-actions>
        </form>
    </AuthenticatedLayout>
</template>

<script setup>
    import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue'
    import Input from "@/Components/Form/BaseInput.vue";
    import Variant from "@/Components/Product/Variant.vue";
    import TextArea from "@/Components/Form/TextArea.vue";
    import CardTitle from "@/Components/Common/CardTitle.vue";
    import Pricing from "@/Components/Product/Pricing.vue";
    import Switch from "@/Components/Form/Switch.vue";
    import Select from "@/Components/Form/Select.vue";
    import {useForm, router, usePage} from '@inertiajs/vue3'
    import {reactive, ref, computed} from "vue";

    const page = usePage();

    const tenantData = computed(() => page.props.auth.tenant)

    const tenant = tenantData ? tenantData.value : '';

    const props = defineProps({
        categories: {
            type: Object
        },
        attrs: {
            type: Object
        },
        taxes: {
            type: Object
        },
        errors: {
            type: Object
        },
        product: {
            type: Object
        },
        productTags: {
            type: Object
        },
        optionCombination: {
            type: Object
        },
        images: {
            type: Object
        },
        allTags: {
            type: Object
        },
    })

    const imageInput = ref(null)
    const currencyPrefix = ""
    const data = reactive({
        files: [],
        fechedCategories: [],
        tab: null
    })

    const form = useForm({
        title_en: props.product.title_en,
        title_bn: props.product.title_bn,
        content_en: props.product.content_en,
        content_bn: props.product.content_bn,
        tag: '',
        tags: props.productTags,
        category: props.product.categories[0].id,
        tax: props.product.tax_id,
        sales_price: props.product.sales_price,
        compare_price: props.product.compare_price,
        cost_price: props.product.cost_price,
        profit: props.product.sales_price - props.product.cost_price,
        profit_margin: props.product.profit_margin,
        images: props.images,
        files: [],
        sku: props.product.sku,
        barcode: props.product.barcode,
        variant: [{
            value: "",
            optionValue: [{}]
        }],
        optionCombinations: props.optionCombination,
        status: !!props.product.status,
        putMethod: true,
        newOptionCombinations:[]
    });

    function handleImagePath(image) {
        return URL.createObjectURL(image);
    }

    function openImageInput() {
        imageInput.value.click()
    }

    function handleImage(event) {
        if (event[0] !== undefined) {
            form.images.push(event[0])
        }
    }

    function handleImageRemove(index, image) {
        if (image.isStored === true) {
            if (window.confirm("Do you want to delete this image ?")) {

                axios.post(route('backend.single-product-media.delete', [tenant, {
                    data: {
                        mediaId: image.id
                    }
                }])).then(response => {
                    data.attrs = response;

                })
            } else {
                return false;
            }
        }
        form.images.splice(index, 1)
    }

    function handleTagClose(index) {
        form.tags.splice(index, 1);
    }

    function handleChange(event) {

        form.category = event

        axios.get(route('backend.category.children', [tenant, {id: form.category}]))
            .then(response => {
                if (response.data.data.length) {
                    if (response.data.isParent) {
                        data.fechedCategories = []
                        data.fechedCategories.push(response.data.data)
                        this.$forceUpdate();
                    } else {
                        data.fechedCategories.push(response.data.data)
                    }

                } else {
                    if (response.data.isParent) {
                        console.log(response.data.isParent)
                        data.fechedCategories = []
                    }
                }
            })
    }

    function handleProfitAndMarginChange() {
        form.profit_margin = (((form.sales_price - form.cost_price) / form.sales_price) * 100).toFixed(2)
        form.profit = (form.sales_price - form.cost_price).toFixed(2)
    }

    function handleForm() {
        form.submit('post', route('backend.product.update', [tenant, props.product.id]))
    }
</script>
