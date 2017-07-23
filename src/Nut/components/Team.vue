<template>
    <div v-if='user'>
        <component-header></component-header>
            
        <div class='fluid main'>
            <div class='container-teams'>
                <component-team-list></component-team-list>
            </div>
            <div class='container-content' v-if='team'>
                <component-team-view></component-team-view>
            </div>
        </div>
    </div>
</template>

<script>
    import { container } from '../services/container';

    export default {

        data: function() {
            return { 
                user: null,
                team: null,
                logout: function() {

                    container.get('services.oauth').logout();
                    window.location.href = "/login";
                }
            }
        },
        mounted() {
            var self = this;
            container.get('services.oauth').loadUser({
                success: function(response) {
                    container.set('user', response.data.resource);
                    self.user = container.get('user');
                },
                error: function() {
                    window.location.href = "/login";
                }
            });
            
            var team_id = this.$route.params.team;

            container.get('services.team').get(team_id, {
                params: {},
                success: function(response) {
                    self.team = response.data.resources;
                    container.set('team', self.team);
                },
                error: function(response) {
                    console.log(response);
                }
            });
        }
    }


    require('./layout.css');
</script>

<style>

</style>