<template>
    <!--<div v-if='user'>
        <div v-for="team in team.resources">

            <div v-if="editing != team" class='fluid fluid-vcenter'>
                <div v-on:click="edit(team)">{{ team.id }} - {{ team.name }}</div>

                <button class='btn btn-danger' v-on:click="remove(team)">Remove</button>
            </div>
            <div v-else>
                <input type='text' class='form-control' v-model="form.update.name" placeholder='name'>
                <textarea class='form-control' v-model="form.update.description" placeholder='description'></textarea>
                <button class='btn btn-primary' v-on:click="update(team); edit(null);">Update</button>
                <button class='btn btn-primary' v-on:click="edit(null)">Back</button>
            </div>

        </div>

        <span v-on:click="add(true)">Add a new team</span>
        <div v-if='adding'>
            <input type='text' class='form-control' v-model="form.insert.name" placeholder='name'>
            <textarea class='form-control' v-model="form.insert.description" placeholder='description'></textarea>
            
            <button class='btn btn-primary' v-on:click="insert()">Add</button>
            <button class='btn btn-primary' v-on:click="add(false)">Back</button>
        </div>
    </div>

    -->
    <div>
        <div class='side-left' v-if='user'>

            <div class='full-height fluid'>
                <nav class='full-height nav-teams'>
                    <div class='nav-team' v-for="team in team.resources" v-on:click="to(team)">
                        <img v-bind:src='team.avatar' width='50' height='50' v-if='team.avatar'>
                        <img v-bind:src="'https://api.adorable.io/avatars/50/'+team.uid" v-if='!team.avatar'></i>
                    </div>

                    <div class='nav-team nav-team-add'  data-toggle="modal" data-target="#team-create">
                        <i class='fa fa-plus'></i>
                    </div>
                </nav>
            </div>
        </div>

        <div class="modal fade modal-small" data-modal-type='team' id='team-create'>
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

                            <input type='text' class='form-control' name='name' placeholder='Team name'  v-model="form.insert.name">
                            <br>
                            <textarea class='form-control' placeholder='Team description' rows='10' name='description'  v-model="form.insert.description"></textarea>
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
                    window.location.href='/team/'+team.id;
                },
                edit: function(team)
                {
                    this.form.update = team;
                    this.editing = team;
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

                remove: function(team) {
                    var self = this;
                    this.team.resources.removeByAttribute('id', team.id);

                    container.get('services.team').remove(team.id, {
                        params: {},
                        success: function(response) {
                            self.all();
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

                update: function(team) {
                    var self = this;
                    this.team.resources.updateByAttribute('id', team.id, this.form.update);
                    container.get('services.team').update(team.id, {
                        params: self.form.update,
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
