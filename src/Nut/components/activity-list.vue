<template>
    <div v-if='team'>
        <div class='paper'>
            <div class='fluid fluid-vcenter content-spacing'>
                <h2>Activities ({{ activities.resources.length }})</h2>
                <div class='fill'></div>
                <div><button class='btn  btn-primary'>New</button></div>
            </div>
        </div>

        <div class='paper'>
            <table cellpadding='0' cellspacing='0'>
                <tbody>
                    <tr>
                        <th></th>
                        <th class='col'>Description</th>
                        <th class='col'>Started At</th>
                        <th class='col'>Ended At</th>
                        <th class='col  col-actions'>Actions</th>
                    </tr>

                    <tr v-for='activity in activities.resources' class='row'>
                        
                        <td class='col'><span>{{ activity.description }}</span></td>
                        <td class='col'><span>{{ activity.started_at }}</span></td>
                        <td class='col'><span>{{ activity.ended_at }}</span></td>
                        <td class='col col-actions'>
                            <button class='btn btn-primary'><i class='fa fa-pencil'></i></button>
                            <button class='btn btn-danger'><i class='fa fa-trash'></i></button>
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
        props: ['team'],
        watch: {
            'team': 'all'
        },
        data: function() {
            return { 
                user: container.get('user'),
                activities: { resources: [], pagination : {}},
                form: {
                    update: {},
                    insert: {}
                },
            }
        },
        methods: {
            all () {

                var self = this;

                container.get('services.activity').all({
                    params: {
                        "search[team_id]": self.team.id
                    },
                    success: function(response) {

                        self.activities.resources = response.data.resources;

                    },
                    error: function(response) {
                        
                        container.get('router').push({ name: 'index'});
                    }
                });
            }
        },
        mounted() {
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
</style>
