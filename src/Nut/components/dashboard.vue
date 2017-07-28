<template>
    <div class='container-content fill' v-if='data'>
        <div class='paper content-spacing'>
            <h1>Dashboard</h1>
        </div>

        <div class='paper content-spacing paper-primary '>
            <span class='text-big'>{{ data.info.hours }} hours</span>
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

        data: function() {
            return { 
                user: container.get('user'),
                filter: {
                    data: "month_current",
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
                                to: container.get('date')().startOf('week').add(1, 'day').subtract(1, 'second').format('YYYY-MM-DD HH:mm:ss')
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
                        labels: ["a", "b", "c"],
                        data: [3, 4, 5]
                    }
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

                        self.charts.hoursPerDay.labels = self.data.reports.hoursPerDay.labels;
                        self.charts.hoursPerDay.data = self.data.reports.hoursPerDay.data;

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
                        type: 'line',
                        data: {
                            labels: [],
                            datasets: [{
                                label: 'Hours X Day',
                                data: [],
                                backgroundColor: [
                                    'rgba(255, 99, 132, 0.2)',
                                    'rgba(54, 162, 235, 0.2)',
                                ],
                                borderColor: [
                                    'rgba(255,99,132,1)',
                                    'rgba(54, 162, 235, 1)',
                                ],
                                borderWidth: 1
                            }]
                        },
                        options: {
                            scales: {
                                yAxes: [{
                                    ticks: {
                                        beginAtZero:true
                                    }
                                }]
                            }
                        }
                    });
                }


                this.charts.hoursPerDay.el.data.labels = this.charts.hoursPerDay.labels;
                this.charts.hoursPerDay.el.data.datasets[0].data = this.charts.hoursPerDay.data;
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