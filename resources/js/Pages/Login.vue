<!-- filepath: /C:/Users/Asus/Petshop/Petshop/resources/js/Pages/Login.vue -->
<template>
    <div>
        <h2>Login</h2>
        <form @submit.prevent="login">
            <label for="email">Email:</label>
            <input type="email" v-model="form.email" required><br><br>
            <label for="password">Password:</label>
            <input type="password" v-model="form.password" required><br><br>
            <button type="submit">Login</button>
        </form>
    </div>
</template>

<script>
import { ref } from 'vue';
import { useForm } from '@inertiajs/inertia-vue3';

export default {
    setup() {
        const form = useForm({
            email: '',
            password: ''
        });

        function login() {
            form.post('/api/login');
        }

        return { form, login };
    }
}
</script>
