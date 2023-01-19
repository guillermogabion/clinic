<template>
    <div>
        <v-data-table
                :headers="headers"
                :items="items"
                class="elevation-1"
                hide-default-footer
            >
                <template v-slot:top>
                <v-toolbar
                    flat
                >
                    <v-toolbar-title>Items</v-toolbar-title>
                    <v-divider
                    class="mx-4"
                    inset
                    vertical
                    ></v-divider>
                    <v-spacer></v-spacer>
                    <v-text-field
                        v-model="form.search"
                        append-icon="mdi-magnify"
                        label="Search"
                        single-line
                        hide-details
                    ></v-text-field>
                    <div
                    class="pt-1"
                    >
                        <v-btn
                        color="green"
                        dark
                        class="ma-4"
                        fab
                        @click="dialog=true"
                        >
                          <v-icon 
                          pa-8
                          ma-2
                          size="30"
                          dark>
                              mdi-plus
                            </v-icon>
                          </v-btn>
                              
                        </div>
                </v-toolbar>
                <v-dialog
                v-model="dialog"
                width="500px"
                >
                    <v-card
                    width="500px"
                    >
                    <v-card-title>
                        Add Item
                    </v-card-title>
                    <v-form
                    ref="form"
                    v-model="valid"
                    lazy-validation
                    >
                    <v-sheet
                    class="ma-2"
                    >
                        <v-text-field
                            outlined
                            label="Item Name"
                            :rules="nameRules"
                            v-model="payload.name"
                        ></v-text-field>
                        <v-text-field
                            outlined
                            label="Item Code"
                            :rules="codeRules"
                            v-model="payload.code"
                        ></v-text-field>
                        <v-text-field
                            outlined
                            label="Item Description"
                            v-model="payload.description"
                        ></v-text-field>
                        <v-text-field
                            outlined
                            label="Item Stock"
                            :rules="stockRules"
                            v-model="payload.stock"
                        ></v-text-field>
                        <v-text-field
                            outlined
                            label="Item Price"
                            v-model="payload.price"
                            :rules="priceRules"
                        ></v-text-field>
                    </v-sheet>
                    <v-card-actions>
                        <v-btn
                            :disabled="!valid"
                            rounded
                            color="primary"
                            class= "mb-2 px-3"
                            @click="save()"
                        >
                            Submit
                        </v-btn>
                    </v-card-actions>
                    
                        
                    </v-form>

                    </v-card>
                </v-dialog>
                </template>
                
            </v-data-table>
    </div>
</template>
<script>
import axios from '../../plugins/axios';
import { store } from '../../repositories/item.api'
    export default {
        data() {
            return {
                valid : true,
                dialog: false,
                search: '',
                items: [],
                headers: [
                { text: 'Name', align: 'start', sortable: false, value: 'name',},
                { text: 'Code', align: 'start', sortable: false, value: 'code',},
                { text: 'Description', align: 'start', sortable: false, value: 'description',},
                { text: 'Stock', align: 'start', sortable: false, value: 'stock',},
                { text: 'Price', align: 'start', sortable: false, value: 'price',},
                
                ],
                form : {
                    search: '',
                },
                nameRules: [
                    v => !!v || 'Item Name is required',
                ],
                codeRules: [
                    v => !!v || 'Code is required',
                ],
                stockRules: [
                    v => !!v || 'Stock is required',
                ],
                priceRules: [
                    v => !!v || 'Price is required',
                ],
                payload : {
                    name : '',
                    code : '',
                    description : '',
                    stock : '',
                    price : ''
                }
            }
        },
        mounted (){
            this.searchItem()
        },
        methods: {
            searchItem(key) {
                this.loading = true
                if (this.timer) {
                clearTimeout(this.timer);
                this.timer = null;
                }
                this.timer = setTimeout(() => {
                axios.post('items-search', {searchkey:key}).then((response) => {
                    this.items = response.data 
                    this.loading = false
                }).catch((errors) => {
                    console.log(errors)
                });
                },800);
            },
            async save(){
            const isValid = await this.$refs.form.validate();
                if (isValid) {

                    store(this.payload).then(({data})=> {
                        console.log(data.data)
                        this.$refs.form.reset()
                        this.$refs.form.resetValidation()
                        this.searchItem()
                        this.dialog = false
                    })
                    this.dialog = true;

                }
        },
        },
        watch: {
            "form.search": {
                handler(val) {
                this.searchItem(val)
                },
                deep: true,
            },
        }
    }
   
</script>
<style>
.selects .v-input__slot {
  padding: 11px !important;
}

</style>