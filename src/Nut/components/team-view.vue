<template>
    <div>
        {{ team }}
    </div>
</template>

<script>
    import { container } from '../services/container';
    export default {

        data: function() {
            return { 
                team: container.get('team'),
                user: container.get('team'),
            }
        },
        mounted() {
            
        }
    }
</script>
