<template>
    <div class='container-content fill' v-if='data'>
        <div class='paper content-spacing'>
            <h1>Dashboard</h1>
        </div>

        <div class='paper content-spacing paper-primary '>
            <span class='text-big'>{{ hours }} hours</span>
        </div>

        <div class='paper content-spacing fluid fluid-center'>
            <select class='form-control' v-model='filter.data'>
                <option value='week_current'>Current Week</option>
                <option value='month_current'>Current Month</option>
                <option value='month_last'>Last Month</option>
            </select>
        </div>

        <div class='paper'>
            <canvas id="chart_1" width="400" height="200"></canvas>
        </div>
    </div>
</template>

<script>
    import { container } from '../services/container';

    export default {

        watch: {
            '$route': 'fetchData',
            'filter.data': 'fetchData'
        },
        data: function() {
            return { 
                user: container.get('user'),
                hours: 0,
                filter: {
                    data: "week_current",
                    values: {
                        "today": function() {
                            return {
                                from: container.get('date')().format('YYYY-MM-DD 00:00:00'),
                                to: container.get('date')().format('YYYY-MM-DD 23:59:59')
                            }
                        },
                        "week_current": function() {
                            return {
                                from: container.get('date')().startOf('week').isoWeekday(1).format('YYYY-MM-DD HH:mm:ss'),
                                to: container.get('date')().startOf('week').add(6, 'day').add(1, 'day').subtract(1, 'second').format('YYYY-MM-DD HH:mm:ss')
                            }
                        },
                        "month_current": function() {
                            return {
                                from: container.get('date')().startOf('month').format('YYYY-MM-DD HH:mm:ss'),
                                to: container.get('date')().endOf('month').format('YYYY-MM-DD 23:59:59')
                            }
                        },
                        "month_last": function() {
                            return {
                                from: container.get('date')().subtract(1, "month").startOf('month').format('YYYY-MM-DD HH:mm:ss'),
                                to: container.get('date')().subtract(1, "month").endOf('month').format('YYYY-MM-DD 23:59:59')
                            }
                        }
                    }
                },
                data: null,
                charts: {
                    hoursPerDay: {
                        data: null
                    },

                }
            };
        },
        methods:  {

            fetchData () {


                var self = this;

                
                var act = this.filter.values[this.filter.data]();

                container.get('services.report').activities({
                    params: {
                        activities_from: act.from,
                        activities_to: act.to,
                    },
                    success: function(response) {

                        self.data = response.data.resources;

                        self.charts.data = self.data;


                        setTimeout(function() {

                            self.drawCharts();

                        }, 1);
                    },
                    error: function(response) {
                        
                        container.get('router').push({ name: 'index'});
                    }
                });
            },


            drawCharts() {

                if (!$("#chart_1").length)
                    return;

                if (!this.charts.hoursPerDay.el) {
                    this.charts.hoursPerDay.el = new Chart($("#chart_1"), {
                        type: 'bar',
                        data: {
                            labels: [],
                            datasets: []
                        },
                        options: {
                            scales: {
                                xAxes: [{
                                    stacked: true
                                }],
                                yAxes: [{
                                    ticks: {
                                        beginAtZero:true
                                    },
                                    stacked: true
                                }]
                            }
                        }
                    });
                }

                this.charts.hoursPerDay.el.data.datasets = [];

                var c;
                var l = 0;
                var colors = [
                    'rgba(255, 99, 132, 0.8)',
                    'rgba(54, 162, 235, 0.8)',
                ];
                        

                this.hours = 0;


                for (var i in this.charts.data) {
                    
                    c = this.charts.data[i];

                    this.charts.hoursPerDay.el.data.labels = c.reports.hoursPerDay.labels;


                    this.hours += c.info.hours;


                    this.charts.hoursPerDay.el.data.datasets.push({
                        label: c.label,
                        data: c.reports.hoursPerDay.data,
                        backgroundColor: colors[l],
                        borderWidth: 1
                    });
                    l++;
                }

                this.charts.hoursPerDay.el.update();
            }
        },
        mounted() {
            this.fetchData();
        }
    }

</script>

<style>

</style>