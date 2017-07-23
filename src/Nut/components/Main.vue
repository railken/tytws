<template>
    <div v-if='user'>
        <header>
            Welcome back
            {{ user.username }}

            <button class='btn btn-primary' v-on:click="logout()">Logout</button>

        </header>
        <h2>Content: </h2>
        <team-list></team-list>

    </div>
</template>

<script>
    import { container } from '../services/container';
    export default {

        data: function() {
            return { 
                user: null,
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
           
        }
    }
</script>
