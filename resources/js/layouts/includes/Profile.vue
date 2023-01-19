<template>
    <div
  
    >
        <v-menu
          button
          offset-y
          content-class="bubble-menu"
          style="z-index:999"
        >
          <template
            v-slot:activator="{ on }"
          >
            <v-avatar
              color="white"
              v-on="on"
              size="32"
              class="clicker"
            >
              <v-img
                  :src="logo"
                  contain
                  alt="admin"
              />
            </v-avatar>
          </template>
           <v-list
              dense
              class="clicker"
            >
              <v-list-item
                dense
                class="text-capitalize"
                @click="dialog=true"
              >
                History
              </v-list-item>
              <v-list-item
                dense
                class="text-capitalize"
                @click="logout"
              >
                logout
              </v-list-item>
            </v-list>
        </v-menu>
        <v-dialog
        v-model="dialog"
        width="500px"
        >
          <v-card
          width="500px"
          >
            <v-data-table
            :headers="headers"
            :items="history"
            class="elevation-1"
            hide-default-footer
            >
            <template v-slot:item.status="{ item }">
              <span v-if="item.status == 1 ? 'Approved' : 'Not Approved'"></span>
            </template>

            </v-data-table>
          </v-card>
        </v-dialog>
    </div>
  </template>
  <script>
  import logo from '../../assets/logocard.png'
  import axios from '../../plugins/axios'
  export default {
    data(){
      return {
        logo,
        dialog: false,
        history : [],
        headers: [
          
          { text: 'Service', value: 'service_rend.name' },
          { text: 'Date', value: 'created_at' },
          { text: 'Status', value: 'status' },
        ]
      }
    },
    methods:{
      logout(){
        localStorage.setItem('token', '')
        location.reload();
      },
      isHistory(){
        axios.get('get-history').then(response => {
          console.log = response.data
          this.history = response.data
        })
      }
    },
    mounted(){
      this.isHistory()
    }
  }
  </script>
  
  