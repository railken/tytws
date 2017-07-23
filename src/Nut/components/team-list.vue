<template>
    <div v-if='user'>

        Lista...
    </div>
</template>

<script>
    import { container } from '../services/container';
    export default {

        data: function() {
            return { 
                user: container.get('user'),
                team: { resources: [], pagination : {}}
            }
        },
        mounted() {
            
            var self = this;
            container.get('services.teams').all({
                params: {},
                success: function(response) {
                    self.team.resources = response.data.resources;
                },
                error: function(response) {
                    console.log(response);
                }
            });
            
        }
    }
</script>
