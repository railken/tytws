<template>
    <div v-if='team'>

        <div class="modal fade modal-small" id='activity-create'>
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header fluid">
                        <h5 class="modal-title">Creating an activity</h5>
                        <div class='fill'></div>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">

                        <textarea class='form-control' placeholder='Activity description' rows='10' v-model="form.description"></textarea>
                        <br>
                        <date-picker v-model="form.started_at" :config="config.date"></date-picker>
                        <br>
                        <date-picker v-model="form.ended_at" :config="config.date"></date-picker>
                        <br>
                        <label>Breaks: &nbsp;&nbsp;</label>
                        <br>
                        <div class='fluid'>
                            <button class='btn btn-primary' v-on:click="fieldSub('breaks', 5)"><i class='fa fa-minus'></i></button>
                            <input type='text' class='form-control' v-model="form.breaks">
                            <button class='btn btn-primary' v-on:click="fieldInc('breaks', 5)" ><i class='fa fa-plus'></i></button>
                        </div>
                        
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary" v-on:click='insert()'>Create</button>
                            
                        </div>
                    </div>
                </div>
            </div>
        </div>


        <div class="modal fade modal-small" id='activity-update'>
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header fluid">
                        <h5 class="modal-title">Updating an activity</h5>
                        <div class='fill'></div>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">

                        <textarea class='form-control' placeholder='Activity description' rows='10' v-model="form.description"></textarea>
                        <br>

                        <date-picker v-model="form.started_at" :config="config.date"></date-picker>
                        <br>
                        <date-picker v-model="form.ended_at" :config="config.date"></date-picker>
                        <br>
                        <label>Breaks: &nbsp;&nbsp;</label>
                        <br>
                        <div class='fluid'>
                            <button class='btn btn-primary' v-on:click="fieldSub('breaks', 5)"><i class='fa fa-minus'></i></button>
                            <input type='text' class='form-control' v-model="form.breaks">
                            <button class='btn btn-primary' v-on:click="fieldInc('breaks', 5)" ><i class='fa fa-plus'></i></button>
                        </div>

                        <br>

                        <div class="modal-footer">

                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary" v-on:click='update(editing)'>Update</button>
                            
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="modal fade modal-small" id='activity-remove'>
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
                    
                    <div class="modal-footer" v-if='deleting'>
                        <button type="submit" class="btn btn-primary" data-dismiss="modal" v-on:click="remove(deleting)">Yes, remove</button>
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">No, Close</button>
                        
                    </div>
                </div>
            </div>
        </div>

        <div class='paper'>
            <div class='fluid fluid-vcenter content-spacing'>
                <h2>Activities ({{ activities.resources.length }})</h2>
                <div class='fill'></div>
                <div><button class='btn  btn-primary'  v-on:click="showNew()"  data-toggle="modal" data-target="#activity-create">New</button></div>
            </div>
        </div>

        <div class='paper'>
            <table cellpadding='0' cellspacing='0'>
                <tbody>
                    <tr>
                        <th></th>
                        <th class='col'>Time</th>
                        <th class='col'>Description</th>
                        <th class='col  col-actions'>Actions</th>
                    </tr>

                    <tr v-for='activity in activities.resources' class='row'>
                        
                        <td class='col'>
                            <span v-if="activity.started_at.isSame(activity.ended_at, 'day')">
                                {{ activity.started_at.format("DD/MM/YYYY") }} at


                                {{ activity.started_at.format("HH:mm") }} =>
                                {{ activity.ended_at.format("HH:mm") }}
                            </span>
                            <span v-else>
                                {{ activity.started_at.format(config.date.format) }} -
                                {{ activity.ended_at.format(config.date.format) }}
                            </span>
                        </td>
                        <td class='col'><span>{{ activity.description }}</span></td>
                        <td class='col col-actions'>
                            <button class='btn btn-primary' v-on:click="showUpdate(activity)" data-toggle="modal" data-target="#activity-update"><i class='fa fa-pencil'></i></button>
                            <button class='btn btn-danger'  v-on:click="showRemove(activity)" data-toggle="modal" data-target="#activity-remove"><i class='fa fa-trash'></i></button>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>

    </div>
</template>

<script>
    import { container } from '../services/container';

    export default {
        props: ['team', 'filter'],
        watch: {
            'team': 'all',
            'filter': 'all',
        },
        data: function() {
            return { 
                config: {
                    date: {
                        format:'DD/MM/YYYY HH:mm',
                        keyBinds: {
                            left: null,
                            right: null
                        }

                    }
                },
                user: container.get('user'),
                activities: { resources: [], pagination : {}},
                editing: null,
                deleting: null,
                form: {}
            }
        },
        methods: {
            fieldSub(field, value)
            {
                this.form[field] -= value;
                
                if (this.form[field] < 0)
                    this.form[field] = 0;

            },
            fieldInc(field, value)
            {

                this.form[field] += value;
            },
            reload()
            {
                this.form.team_id = this.team.id;

            },
            showNew ()
            {
                this.form = {
                    started_at: new Date(),
                    ended_at: new Date(),
                };
                this.reload();
            },
            showUpdate (activity)
            {
                this.editing = activity;

                this.form = activity;



            },
            showRemove (activity)
            {
                this.deleting = activity;
            },
            all () {
                var self = this;

                this.reload();

                var act = this.filter();

                container.get('services.activity').all({
                    params: {
                        "search[team_id]": self.team.id,
                        activities_from: act.from,
                        activities_to: act.to,
                        show: 999
                    },
                    success: function(response) {

                        self.activities.resources = response.data.resources;
                    },
                    error: function(response) {
                        
                        container.get('router').push({ name: 'index'});
                    }
                });
            },

            insert: function() {
                var self = this;

                this.activities.resources.push(self.form);

                container.get('services.activity').insert( {
                    params: self.form,
                    success: function(response) {
                        self.all();
                        $('.modal').modal('hide');
                    },
                    error: function(response) {
                        console.log(response);
                    }
                });

            },


            update: function(activity) {
                var self = this;
                container.get('services.activity').update(activity.id, {
                    params: self.form,
                    success: function(response) {
                        self.all();
                        $('.modal').modal('hide');
                    },
                    error: function(response) {
                        console.log(response);
                    }
                });

            },

            remove: function(activity) {
                var self = this;

                container.get('services.activity').remove(activity.id, {
                    params: {},
                    success: function(response) {
                        self.all();
                        $('.modal').modal('hide');
                    },
                    error: function(response) {
                        console.log(response);
                    }
                });

            },

        },
        mounted() {
            this.reload();
            this.all();

        }
    }
</script>

<style>
    
    table {
        background: white;
        max-width: 100%;
        width: 100%;
    }

    th {

    }

    .row {

    }

    .col {
        border-bottom: 1px solid #ddd;
        text-align: left;
        padding: 10px 15px;
        flex-grow: 1;
    }

    .col-actions {
        max-width: 90px;
        text-align: right;
    }

    .datepicker {
        padding: 0;
    }

    .datetime-container .input-group-addon{
        width: 35px;
        border-radius: 0;

    }

    .datetime-container .date {
        width: 66%;
    }

    .datetime-container .time {
        width: 33%;
    }

</style>
