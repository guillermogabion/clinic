 <template>
    <div>
        <v-card
        >
        
            <v-data-table
                :headers="headers"
                :items="participants"
                class="elevation-1"
                :items-per-page="itemsPerPage"
                :loading="loading"
                :page.sync="page"
                @page-count="pageCount = $event"
                :server-items-length="total_participants"
                @pagination="fetchParticipantsData"
                hide-default-footer
            >
                <template v-slot:top>
                <v-toolbar
                    flat
                >
                    <v-toolbar-title>Patients</v-toolbar-title>
                    <v-divider
                    class="mx-4"
                    inset
                    vertical
                    ></v-divider>
                    <v-spacer></v-spacer>
                    <v-text-field
                        label="Search"
                        filled
                        rounded
                        dense
                        class="pt-8"
                        append-icon="mdi-magnify"
                        :items="participants"
                        v-model="search"
                    ></v-text-field>
                    
                
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
                <template v-slot:item.actions ="{ item }">
                  <v-icon
                  @click="show(item)"
                  >
                    mdi mdi-file-document-box-multiple
                  </v-icon>
                </template>
            </v-data-table>
            <div class="text-center pt-2">
              <v-pagination
              v-model="page"
              :total-visible="7"
              :length="pageCount"
              
            ></v-pagination>
            </div>
            <v-dialog
            v-model="dialog_record"
            width="700px"
            >
              <v-card
              width="700px"
              >
               <!-- {{ this.record.service }} -->

               <table>
                <thead>
                  <tr>
                    <th>Name</th>
                  </tr>
                </thead>
                <tbody>
                  <tr v-for="items in record" :key="items.id">
                    <td>{{ items.fullname }}</td>
                  </tr>
                </tbody>
              </table>
                
              </v-card>
            </v-dialog>


        </v-card>
    </div>
 </template>
 <script>
// import Axios from 'axios';
import Axios from '../../../plugins/axios';
 import { PatientPagination } from '../../../repositories/user.api';
 export default {
   data: () => ({
     dialog: false,
     dialog_record: false,
     dialogDelete: false,
     headers: [
       { text: 'Fullname', align: 'start', sortable: false, value: 'fullname',},
       { text: 'Age', value: 'age' },
       { text: 'Address', value: 'address' },
       { text: 'Contact', value: 'contact' },
       { text: 'Records', align: 'start', sortable: false, value: 'actions'},
     ],
     headersRecord: [
       { text: 'Service', align: 'start', sortable: false, value: 'service.service_rend'},
       { text: 'Age', value: 'age' },
       { text: 'Address', value: 'address' },
       { text: 'Contact', value: 'contact' },
       { text: 'Records', align: 'start', sortable: false, value: 'actions'},
     ],
     loading: false,
     participants: [],
      search : '',
      pageCount: 0,
      itemsPerPage:null,
      total_participants:0,
      page:1,
      current_page:0,
      record: [],
   }),
  
   watch: {
     dialog (val) {
       val || this.close()
     },
     dialogDelete (val) {
       val || this.closeDelete()
     },
     "search": {
        handler(val) {
          this.indexParticipants(val)
        },
        deep: true,
      },

   },
   mounted(){
    this.initialize()
   }, 
 

   methods: {
    initialize(){
      // Axios.get('get').then((response) => {
      //   console.log(response.data)
      //   this.participants = response.data
      // })

    },
    set_data_fromServer(data) {
      this.participants = data.data
      this.total_participants = data.total
      this.itemsPerPage = data.per_page
      this.pageCount = data.last_page
    },
    fetchParticipantsData(page){
        this.current_page = page.page
        this.indexParticipants()
    },
    indexParticipants() {
      this.url = 'user/pagination?page='+this.current_page+ '&keyword=' +this.search
      this.loading = true
      if (this.timer) {
        clearTimeout(this.timer);
        this.timer = null;
      }
      this.timer = setTimeout(() => { 
        PatientPagination(this.url).then(({data}) => {
          this.set_data_fromServer(data)
          this.loading = false
        })
      }, 800);
    },
    add(){
      this.$router.push('/attendee/add')
    },
    show(item){
      Axios.get('get-record/' + item.id).then((response) => {
        this.dialog_record = true
        this.record = response.data
        console.log(response.data)
      })
    }
   },
 }
</script>
