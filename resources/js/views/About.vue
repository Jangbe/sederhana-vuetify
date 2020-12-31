<template>
<div>
    <div class="container">
        ini halaman about, {{nama}}
    </div>
</div>
</template>

<script>
export default {
    computed: {
        nama(){
            return this.$store.state.name
        }
    },
}
</script>
