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
                        <input type='hidden' name='id' value='{team.id}'>
                        <button type="submit" class="btn btn-primary" data-dismiss="modal" v-on:click="remove()">Yes, remove</button>
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">No, Close</button>
                        
                    </div>
                </div>
            </div>
        </div>

        <div class='paper'>
            <div class='fluid'>
                <span>{{ team.name }}</span>
                <div class='fluid fluid-stretch dropdown'>
                    <div class='nav-project-action-icon-a fluid fluid-vcenter fill' data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" id="nav-team-actions">
                 
                        <i class='fa fa-gear nav-project-action-icon'></i>
                    </div>
                    <div class="dropdown-menu" aria-labelledby="nav-team-actions">

                        <!--<a class="dropdown-item" href="#" data-toggle="modal" data-team-id='{team.id}' data-target="#project-create">Create project</a>-->

                        <a class="dropdown-item" href="#" data-toggle="modal" data-target="#team-update" data-id="{id}">Edit</a>
                        <a class="dropdown-item" href="#" data-toggle="modal" data-target="#team-change-avatar" data-id="{id}">Change avatar</a>
                        <div class="dropdown-divider"></div>
                        <a class="dropdown-item" href="#" data-toggle="modal" data-target="#team-remove" data-id="{id}">Remove</a>
                        <!--
                        <form method='POST' class='projects-delete'>
                            <input type='hidden' name='id' value='{id}'>
                            <button class="dropdown-item" type='submit'>Leave project</button>
                        </form>-->
                    </div>
                </div>

            </div>
        </div>

        <div class='fluid'>
            <div class='paper'>
                Last month
            </div>
            <div class='paper'>
                Current month
            </div>
        </div>
    </div>
</template>

<script>
    import { container } from '../services/container';
    export default {

        watch: {
            '$route': 'fetchData'
        },
        data: function() {
            return { 
                team: null,
                user: container.get('team'),
                form: {
                    update: {}
                },
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

                container.get('services.team').get(team_id, {
                    params: {},
                    success: function(response) {

                        self.team = response.data.resources;
                        self.form.update = self.team;

                    },
                    error: function(response) {
                        
                        container.get('router').push({ name: 'index'});
                    }
                });
            }
        },
        mounted() {
            this.fetchData();
        }
    }
</script>
