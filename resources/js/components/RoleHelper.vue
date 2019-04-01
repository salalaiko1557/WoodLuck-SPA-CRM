<template>
    <div>
    </div>
</template>
<script>
export default {
    props: ['role'],
    created(){
        this.setRoleUserToLocalStorage()
    },
    methods: {
        setRoleUserToLocalStorage(){
            localStorage.role = this.role
        }
    }
}
</script>
