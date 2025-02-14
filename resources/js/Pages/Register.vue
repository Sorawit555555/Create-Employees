<template>
    <div>
        <h2>Register</h2>
        <form @submit.prevent="register">
            <label for="name">Name:</label>
            <input type="text" v-model="form.name" required><br><br>
            <label for="email">Email:</label>
            <input type="email" v-model="form.email" required><br><br>
            <label for="password">Password:</label>
            <input type="password" v-model="form.password" required><br><br>
            <button type="submit">Register</button>
        </form>
    </div>
</template>

<script>
import { ref } from 'vue';
import { useForm } from '@inertiajs/inertia-vue3';

export default {
    setup() {
        const form = useForm({
            name: '',
            email: '',
            password: ''
        });

        function register() {
            form.post('/api/register');
        }

        return { form, register };
    }
}
</script>
