<template>
<v-slide-x-transition>
    
    <div v-if="$is_admin()">
        <v-row>
            <v-col>
                <v-card color="green">
                    <span style="font-size:larger"> Total Number of Appointments</span>
                    <span style="font-size:larger"> {{ this.appointment }}</span>
                </v-card>
            </v-col>
            <v-col>
                <v-card color="red">
                    <span style="font-size:larger"> Total Number of Items </span>
                    <span style="font-size:larger"> {{ this.items }} </span>
                </v-card>
            </v-col>
            <v-col>
                <v-card color="blue">
                    <span style="font-size:larger">Number of Today's Schedule</span>
                    <span style="font-size:larger"> {{ this.app_today }} </span>

                </v-card>
            </v-col>
        </v-row>
        <v-row>
            <v-col>
                <div id="chart">
                    <apexchart  ref="realtimeChart" type="bar" height="350" :options="barChartOptions" :series="chartData"></apexchart>
                </div>
            </v-col>
            <v-col>
                <div id="chart2">
                    <apexchart type="pie" width="380" :options="pieChartOptions" :series="pieSeries"></apexchart>
                </div>
            </v-col>
        </v-row> 
    </div>

</v-slide-x-transition>
</template>

<script>
import Axios from '../../plugins/axios';
import PureVueChart from 'pure-vue-chart';
export default {
    data() {
        return {
            chartOptions: {
                chart: {
                    type: 'bar'
                },
                xaxis: {
                    categories: []
                },
                series: [{
                    name: 'Sales',
                    data: []
                }]
                },
              
            appointment : '',
            app_today : '',
            items: '',
            service: [],
            chartData: [],
            chartData2: [],
            
           
   
        }
    },
    components: {
        PureVueChart,
    },
    methods: {
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
        }
    },
    async mounted(){
        this.count_appointment()
        this.count_today()
        this.count_item()
        this.get_services()
        this.get_chartData()
     
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
        pieChartOptions () {
            let labels = ['Team A', 'Team B', 'Team C', 'Team D', 'Team E'];
            return {
                chart: {
                width: 380,
                type: 'pie',
                },
                responsive: [{
                breakpoint: 480,
                options: {
                    chart: {
                    width: 200
                    },
                    legend: {
                    position: 'bottom'
                    }
                },
                labels : labels
                }]
            }

        },
        pieSeries() {
            let series = [44, 55, 13, 43, 22];
            return series
        }
        
    }
}
</script>