<template>
    <div>
        {{ team }}
    </div>
</template>

<script>
    import { container } from '../services/container';
    export default {

        watch: {
            // call again the method if the route changes
            '$route': 'fetchData'
        },
        data: function() {
            return { 
                team: null,
                user: container.get('team'),
            }
        },
        methods: {
            fetchData () {

                var team_id = this.$route.params.team;

                var self = this;

                container.get('services.team').get(team_id, {
                    params: {},
                    success: function(response) {
                        console.log(response)
                        self.team = response.data.resources;
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
