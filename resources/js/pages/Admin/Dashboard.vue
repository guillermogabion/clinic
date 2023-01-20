<template>
<v-slide-x-transition>
    
    <div v-if="$is_admin()">
        <v-row>
            <v-col>
                <v-card color="green" height="100px">
                    <span style="font-size:larger"> Total Number of Appointments</span><br>
                    <div align="right" class="pa-2">
                        <span style="font-size:50px; font-weight: bold;" > {{ this.appointment }}</span>
                    </div>
                </v-card>
            </v-col>
            <v-col>
                <v-card color="red" height="100px">
                    <span style="font-size:larger"> Total Number of Items </span><br>
                    <div align="right" class="pa-2">
                        <span style="font-size:50px; font-weight: bold;"> {{ this.items }} </span>
                    </div>
                </v-card>
            </v-col>
            
        </v-row>
        <v-row>
            <v-col>
                <!-- <div id="chart">
                    <apexchart  ref="realtimeChart" type="bar" height="400" :options="barChartOptions" :series="chartData2"></apexchart>
                </div> -->
            </v-col>
            <v-col>
                <div id="chart2">
                    <!-- <apexchart type="pie" width="380" :options="pieChartOptions" :series="pieSeries"></apexchart> -->
                    <!-- <apexchart  ref="realtimeChart" type="bar" height="250" :options="barChartOptionsmonth" :series="chartData2"></apexchart> -->
                </div>
            </v-col>
        </v-row> 
        <v-row>
            <v-col>
                <v-card>
                    <v-card-title>Bar Graph</v-card-title>
                     <div id="chart">
                        <apexchart  ref="realtimeChart" type="bar" height="400" :options="barChartOptions" :series="chartData2"></apexchart>
                    </div>
                </v-card>

            </v-col>
            <v-col>
                <v-card>
                    <v-card-title>Pie Graph</v-card-title>
                </v-card>
            </v-col>
        </v-row>
    </div>
    <div
    v-if="$is_user()"
    >
    <div class="text-center">

            <v-card
                width="1000"
                class="mx-auto"
                elevation="3"
                color="white"
            >
                    <v-card>
                        <!-- <div
                         style="padding-top: 4%"
                        >
                        <v-img 
                        contain
                        :src="logocard"
                        max-height="30%"
                        width="50%"
                        class="mx-auto"
                        />
                    </div> -->
                    <span class="login_title">Dental Clinic</span>
                    <v-col>
                        <span style="font-weight:bold; ">Set an Appointment</span>
                        <v-select
                            filled
                            rounded
                            dense
                            :items="service"
                            v-model="payload.service"
                            label="Select Service"
                            item-text="name"
                            item-value="id"
                        ></v-select>
                        <v-text-field 
                            v-model="payload.picker"
                            filled
                            rounded
                            dense
                            readonly
                        ></v-text-field>
                        <v-text-field 
                            v-model="payload.time"
                            filled
                            rounded
                            dense
                            readonly
                        ></v-text-field>
                      
                        <v-row>
                            <v-col>
                                <v-date-picker 
                                v-model="payload.picker" 
                                :allowed-dates="isNotWeekend"></v-date-picker>
                            </v-col>
                            <v-col>
                                <v-time-picker
                                v-model="payload.time"
                                no-title
                                format="ampm"
                                ></v-time-picker>
                            </v-col>
                        </v-row>
                        <span>Service Cost : {{ services.price }}</span><br>
                        <span>Appointment Fee : 100Php</span><br>
                        <v-text-field 
                            :value="totalCost()"
                            type="number"
                            filled
                            rounded
                            dense
                            label="Total Cost"
                        ></v-text-field>
                       
                        <v-card-actions>
                        <v-spacer></v-spacer>
                          <v-btn
                          @click="addAppointment()"
                          @click.prevent="alert=true"
                          color="primary"
                          >Submit</v-btn>
                        <v-spacer></v-spacer>
                        </v-card-actions>
                    </v-col>
                </v-card>
               
            </v-card>
        </div>
    </div>

</v-slide-x-transition>
</template>

<script>
import Axios from '../../plugins/axios';
import PureVueChart from 'pure-vue-chart';
import { addAppointment } from '../../repositories/event.api'
export default {
    data() {
        return {
           
            chartData: [{
                name: 'Statistics',
                data: []
            }],
            date: new Date(),
            appointment : '',
            app_today : '',
            items: '',
            service: [],
            chartData: [],
            chartData2: [],
            chartDatapie: [],
            chartDatapie2: [],
            pie: [],
            payload : {
                service: [],
                picker: (new Date(Date.now() - (new Date()).getTimezoneOffset() * 60000)).toISOString().substr(0, 10),
                time : '',
                cost : ''
            },
            alert: false,
            services: ''
            
           
   
        }
    },
    components: {
        PureVueChart,
    },
    methods: {
        isNotWeekend(date) {
        var d = new Date(date);
        return d.getDay() !== 0 && d.getDay() !== 6;
        },
       count_appointment(){
            Axios.get('count_appointment').then(response => {
                console.log(response.data)
                this.appointment = response.data
            })
       },
       count_today(){
        Axios.get('count_appointment_today').then(response => {
            console.log(response.data)
            this.app_today = response.data
        })
       },
       count_item(){
        Axios.get('count_item').then(response => {
            console.log(response.data)
            this.items = response.data
        })
        },

        get_services(){
            Axios.get('get_all_services').then(response=> {
                this.service = response.data
            })
        },
        get_reserve(){
            Axios.get('get_all_reserve').then(response=> {
                this.reserve = response.data
            })
        },
        get_chartData(){
            Axios.get('get_all_reserve').then(response=> {
                console.log(response.data, 'get_chart')

                this.chartData = response.data

                let list = this.chartData   
                let singleArray = [].concat.apply([], list.map(x => x));
                let filteredArray = singleArray.map(item => {
                let value = item.reserve_count;
                delete item.id;
                delete item.name;
                delete item.created_at;
                delete item.updated_at;
                return value;
            });
            console.log(filteredArray, 'filtered')  
            this.chartData2 = filteredArray
            })
        },
        pie_labels(){
            Axios.get('get_all_reserve').then(response => {
                console.log(response.data, 'pie_labels')

                let pie = response.data
                let singleArray = [].concat.apply([], pie.map(x=> x));
                let filteredArray = singleArray.map(item=> {
                    let value = item.name
                    delete item.id;
                    delete item.reserve_count;
                    delete item.created_at;
                    delete item.updated_at;
                    return value;
                });
                console.log(filteredArray, 'labels_pie')
                this.pie = filteredArray

            })
        },

        addAppointment(){
            this.payload.cost = this.totalCost()
            addAppointment(this.payload).then(response => {
                console.log(response.data)
                alert('Appointment request Submitted');
            })
        },
       searchService(key){
            Axios.post('search-service', {searchkey:key}).then(response => {
                this.services = response.data
                console.log(response.data)
            })
        },
        totalCost(){
           return Number(this.services.price) + Number(100);
        }
       
    },
    async mounted(){
        this.count_appointment()
        this.count_today()
        this.count_item()
        this.get_services()
        this.get_chartData()
        this.pie_labels()
    },
    created(){
     
    },
    watch : {
        "payload.service" : {
            handler(val) {
            this.searchService(val)
            },
            deep: true,
        }
    },  
    computed :{

       
    //     chartData() {
    // Axios.get('get_all_services')
    //   .then(response => {
    //     this.xaxis.categories = response.data.name
    //     this.series[0].data = response.data.reserve_count
    //             })
    //             return {
    //             xaxis: {
    //                 categories: this.xaxis.categories
    //             },
    //             series: this.series
    //             }
    //         },
        barChartOptions(){
            let list = this.service
            let singleArray = [].concat.apply([], list.map(x => x));
            let filteredArray = singleArray.map(item => {
                let value = item.name;
                delete item.id;
                delete item.reserve_count;
                delete item.created_at;
                delete item.updated_at;
                return value;
            });
            console.log(filteredArray)
            return {
                chart: {
                    type: 'bar',
                    height: 350
                },
                plotOptions: {
                    bar: {
                        borderRadius: 4,
                    }
                },
                dataLabels: {
                    enabled: false
                },
                series: [{
                    name: 'Sales',
                    data: this.chartData2
                }],
                xaxis: {
                    categories: filteredArray
                }
            }
        },

    
        barSeries(){
        
      
            let series = []
            if (this.datas){
                this.datas.pie.forEach(data=> {
                    series.push(data)
                })
            }
            return series
            
        },
        barChartOptionsmonth(){
            return {
                chart: {
                    type: 'bar',
                    height: 350
                },
                plotOptions: {
                    bar: {
                        borderRadius: 4,
                    }
                },
                dataLabels: {
                    enabled: false
                },
                series: [{
                    name: 'Sales',
                    data: this.chartData2
                }],
                xaxis: {
                    categories: ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December']
                }
            }
        },
        // pieChartOptions () {
        //     let labels = this.pie;
        //     return {
        //         colors : ['yellow', 'green', 'blue', 'red', 'violet', 'pink', 'orange', 'beige'] ,
        //         chart: {
        //             width: "100%",
        //             type: 'pie',
        //             toolbar: {
        //                 show: false
        //             },
        //             zoom: {
        //                 enabled: false
        //             }
        //         },
        //         labels: labels
        //     }
           
        // },
        // pieSeries(){
        //     let series = []
        //     if (this.chartData2){
        //         this.chartData2.forEach(data=> {
        //             series.push(data)
        //         })
        //     }
        //     return series
        // },
        
    },
    
}
</script>