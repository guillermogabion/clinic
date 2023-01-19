<template>
    <div>
        <v-card>
        
            <v-data-table
                :headers="headers"
                :items="service"
                class="elevation-1"
                hide-default-footer
            >
                <template v-slot:top>
                <v-toolbar
                    flat
                >
                    <v-toolbar-title>Services</v-toolbar-title>
                    <v-divider
                    class="mx-4"
                    inset
                    vertical
                    ></v-divider>
                    <v-spacer></v-spacer>
                    <!-- <div
                    class="pt-1"
                    >
                        <v-btn
                        color="green"
                        dark
                        class="ma-4"
                        fab
                        @click="add()"
                        >
                          <v-icon 
                          pa-8
                          ma-2
                          size="30"
                        
                          dark>
                              mdi-plus
                            </v-icon>
                          </v-btn>
                              
                        </div> -->
                </v-toolbar>
                </template>
                
            </v-data-table>
        </v-card>
    </div>
 </template>
 <script>
// import Axios from 'axios';
import { Services } from '../../../repositories/service.api';
 export default {
   data: () => ({
     dialog: false,
     dialogDelete: false,
     headers: [
       { text: 'Service', align: 'start', sortable: false, value: 'name',},
    //    { text: 'Title', align: 'start', sortable: false, value: 'name',},yyttt
      
     ],
     loading: false,
      service: [],
      search : '',
   }),
  
   watch: {
   },
   mounted(){
    this.services()
   }, 
 

   methods: {
      services(){
        Services().then(response => {
          console.log = response.data
          this.service = response.data
        })
      }
   },
 }
</script>
