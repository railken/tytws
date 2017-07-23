<template>
    <div v-if='user'>
        <div v-for="team in team.resources">

            <div v-if="editing != team">
                <div v-on:click="edit(team)">{{ team.id }} - {{ team.name }}</div>

                <button class='btn btn-danger' v-on:click="remove(team)">Remove</button>
            </div>
            <div v-else>

                <input type='text' class='form-control' v-model="form.update.name" placeholder='name'>
                <textarea class='form-control' v-model="form.update.description" placeholder='description'></textarea>
                <button class='btn btn-primary' v-on:click="update(team); edit(null);">Update</button>
                <button class='btn btn-primary' v-on:click="edit(null)">Annulla</button>
            </div>

        </div>

        <input type='text' class='form-control' v-model="form.insert.name" placeholder='name'>
        <textarea class='form-control' v-model="form.insert.description" placeholder='description'></textarea>
        
        <button class='btn btn-primary' v-on:click="insert()">Add</button>
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
                editing: {},
                edit: function(team)
                {
                    this.form.update = team;
                    this.editing = team;
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
