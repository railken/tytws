<template>
    <div v-if='team'>

        <div class="modal fade modal-small" id='team-update'>
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header fluid">
                        <h5 class="modal-title">Updating a team</h5>
                        <div class='fill'></div>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="modal-footer">

                            <input type='text' class='form-control' name='name' placeholder='Team name'  v-model="form.update.name">
                            <br>
                            <textarea class='form-control' placeholder='Team description' rows='10' name='description'  v-model="form.update.description"></textarea>
                            <br>
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary" v-on:click="update();" >Save changes</button>
                            
                        </div>
                    </div>
                    
                </div>
            </div>
        </div>

        <div class="modal fade modal-small" id='team-change-avatar'>
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header fluid">
                        <h5 class="modal-title">Updating a team</h5>
                        <div class='fill'></div>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div><img v-bind:src="team.avatar"></div>
                        <hr>
                        <div class="modal-footer">

                            <div style='display: none;min-height: 100px;' id='team-avatar-container'></div>
                            <input type='file' class='form-control' data-uploader-image data-input='#team-input-avatar' data-preview='#team-avatar-container' >
                            <input type='hidden' name='avatar' id='team-input-avatar'>
                            <br><br>
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary" v-on:click="updateAvatar()">Save changes</button>
                            
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="modal fade modal-small" id='team-remove' >
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header fluid">
                        <h5 class="modal-title">Are you sure?</h5>
                        <div class='fill'></div>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <p>You can't go back.</p>
                    </div>
                    
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary" data-dismiss="modal" v-on:click="remove()">Yes, remove</button>
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">No, Close</button>
                        
                    </div>
                </div>
            </div>
        </div>

        <div class='paper'>
            <div class='fluid content-spacing'>
                <span><h1>{{ team.name }}</h1></span>
                <div class='fill'></div>
                <div class='fluid fluid-stretch dropdown'>
                    <div class='team-icon-settings fluid fluid-vcenter fill' data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" id="nav-team-actions">
                 
                        <i class='fa fa-gear nav-project-action-icon'></i>
                    </div>
                    <div class="dropdown-menu  dropdown-menu-right" aria-labelledby="nav-team-actions">

                        <a class="dropdown-item" href="#" data-toggle="modal" data-target="#team-update" data-id="{id}">Edit</a>
                        <a class="dropdown-item" href="#" data-toggle="modal" data-target="#team-change-avatar" data-id="{id}">Change avatar</a>
                        <div class="dropdown-divider"></div>
                        <a class="dropdown-item" href="#" data-toggle="modal" data-target="#team-remove" data-id="{id}">Remove</a>
                    </div>
                </div>

            </div>
        </div>
        <div class='paper content-spacing paper-primary '>
            <span class='text-big'>{{ team.info.hours }} hours</span>
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

        <!--<div class='paper content-spacing'>
            chart2: how many hours x hour of day 
        </div>-->

        <component-activity-list v-bind:team='team' v-bind:filter='filter.values[filter.data]'></component-activity-list>
    </div>
</template>

<script>
    import { container } from '../services/container';
    import Chart from 'chart.js';
    export default {

        watch: {
            '$route': 'fetchData',
            'filter.data': 'fetchData'
        },
        data: function() {
            return { 
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
                team: null,
                user: container.get('user'),
                form: {
                    update: {}
                },
                charts: {
                    hoursPerDay: {
                        labels: ["a", "b", "c"],
                        data: [3, 4, 5]
                    }
                }
            }
        },
        methods: {
            remove: function() {
                var self = this;
                var team = this.team;

                container.get('services.team').remove(team.id, {
                    params: {},
                    success: function(response) {
                        container.get('router').push({ name: 'index'});
                    },
                    error: function(response) {
                        console.log(response);
                    }
                });

            },

            updateAvatar: function() {

                var self = this;

                File.onLoad('avatar', function(value) {

                    if (value) {
                        self.form.update.avatar = value;
                        self.update();
                        return;
                    }
                    
                    $('.modal').modal('hide');
                });

            },

            update: function() {
                var self = this;
                
                var team = this.team;

                //this.team = self.form.update;

                container.get('services.team').update(team.id, {
                    params: self.form.update,
                    success: function(response) {
                        $('.modal').modal('hide');
                        self.fetchData();
                    },
                    error: function(response) {
                        console.log(response);
                    }
                });

            },

            fetchData () {

                var team_id = this.$route.params.team;

                var self = this;

                
                var act = this.filter.values[this.filter.data]();

                container.get('services.team').get(team_id, {
                    params: {
                        activities_from: act.from,
                        activities_to: act.to,
                    },
                    success: function(response) {

                        self.team = response.data.resources;
                        self.form.update = self.team;

                        self.charts.hoursPerDay.labels = self.team.reports.hoursPerDay.labels;
                        self.charts.hoursPerDay.data = self.team.reports.hoursPerDay.data;

                        setTimeout(function() {

                            self.drawCharts();

                        }, 1000);
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
    .team-icon-settings {
        font-size: 24px;
    }
</style>