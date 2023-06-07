<template>
    <Head>
        <title>Forgot Password | E-Monev BBPSI Mektan</title>
    </Head>
    <div class="col-md-4">
        <div class="fade-id">
            <div class="text-center mb-4">
                <a href="" class="text-dark text-decoration-none">
                    <img src="/images/evaluation.png" alt="evaluation-logo" width="70">
                    <h3 class="mt-2 font-weight-bold">APLIKASI E-MONEV BBPSI MEKTAN</h3>
                </a>
            </div>
            <div class="card-group">
                <div class="card border-top-purple border-0 shadow-sm rounded-3">
                    <div class="card-body">
                        <div class="text-start">
                            <h5>Reset Password</h5>
                            <p class="text-muted">Sign in to your account</p>
                        </div>
                        <hr>
                        <div v-if="session.status" class="alert alert-success mt-2">
                            {{ session.status }}
                        </div>
                        <form @submit.prevent="submit">
                            <div class="input-group mb-3">
                                <div class="input-group-prepend">
                                    <span class="input-group-text">
                                        <i class="fa fa-envelope"></i>
                                    </span>
                                </div>
                                <input class="form-control" v-model="form.email" :class="{ 'is-invalid': errors.email }"
                                    type="email" placeholder="Email Address">
                            </div>
                            <div v-if="errors.email" class="alert alert-danger">
                                {{ errors.email }}
                            </div>
                            <div class="row">
                                <div class="col-12 mb-3 text-end fw-bold">
                                    <Link href="/login">Login</Link>
                                </div>
                                <div class="col-12">
                                    <button class="btn btn-primary shadow-sm rounded-sm px-4 w-100" type="submit"
                                        :disabled="form.processing">Send Password Reset Link</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
// Import Layout
import LayoutAuth from "../../Layouts/Auth.vue";

// Import Reactive
// import { reactive } from "vue";

// Import Inertia Adapter, Head and Link
import { router, Head, Link, useForm } from "@inertiajs/vue3";

export default {
    layout: LayoutAuth,

    components: {
        Head,
        Link
    },
    props: {
        errors: Object,
        session: Object,
    },

    // Define Composition API
    setup() {
        // Define Form State
        const form = useForm({
            email: null,
        });

        // Sumbit Method
        const submit = () => {
            // Send Data To Server
            form.post('/forgot-password', {
                // Data
                email: form.email,
            });
        }

        // Return Form State and Submit Method
        return {
            form,
            submit
        };
    }
}

</script>