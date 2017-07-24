<template>
    <div v-if='user'>
        <component-header></component-header>
            
        <div class='fluid main'>
            <div class='container-teams'>
                <component-team-list></component-team-list>
            </div>
            <div class='container-content'>
                Dashboard
            </div>
        </div>
    </div>
</template>

<script>
    import { container } from '../services/container';
    export default {

        data: function() {
            return { 
                user: null
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
                    container.get('router').push({ name: 'login'});
                }
            });
           
        }
    }

    require('./layout.css');
</script>


<style>

</style>