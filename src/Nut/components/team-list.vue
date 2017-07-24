<template>
    <div class='full-height'>
        <div class='side-left full-height' v-if='user'>

            <div class='full-height fluid'>
                <nav class='full-height nav-teams'>
                    <div class='nav-team' v-for="team in team.resources" v-on:click="to(team)">
                        <img v-bind:src='team.avatar' width='50' height='50' v-if='team.avatar'>
                        <img v-bind:src="'https://api.adorable.io/avatars/50/'+team.uid" v-if='!team.avatar'></i>
                    </div>

                    <div class='nav-team nav-team-add' data-toggle="modal" data-target="#team-create">
                        <i class='fa fa-plus'></i>
                    </div>
                </nav>
            </div>
        </div>

        <div class="modal fade modal-small" id='team-create'>
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header fluid">
                        <h5 class="modal-title">Creating a team</h5>
                        <div class='fill'></div>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="modal-footer">

                            <input type='text' class='form-control' name='name' v-model="form.insert.name">
                            <br>
                            <textarea class='form-control' placeholder='Team description' rows='10' v-model="form.insert.description"></textarea>
                            <br>
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary" v-on:click='insert()'>Create</button>
                            
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>


    
</template>

<script>
    import { container } from '../services/container';
    export default {
        data: function() {
            return { 
                user: container.get('user'),
                team: { resources: [], pagination : {}},
                form: {
                    insert: {},
                    update: {}
                },
                adding: false,
                editing: {},
                to: function(team)
                {
                    container.get('router').push({ name: 'team', params: {team: team.id}});
                },
                add: function(status)
                {
                    this.adding = status;
                },
                all: function() {
                    var self = this;
                    container.get('services.team').all({
                        params: {
                            sort_field: 'id',
                            sort_direction: 'asc'
                        },
                        success: function(response) {
                            self.team.resources = response.data.resources;
                        },
                        error: function(response) {
                            console.log(response);
                        }
                    });
                },
                
                insert: function() {
                    var self = this;

                    this.team.resources.push(self.form.insert);

                    container.get('services.team').insert( {
                        params: self.form.insert,
                        success: function(response) {
                            self.all();
                        },
                        error: function(response) {
                            console.log(response);
                        }
                    });

                },
            }
        },
        mounted() {
            
            this.all();
        
        }
    }
</script>
