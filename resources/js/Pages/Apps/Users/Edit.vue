<template>
    <Head>
        <title>Edit User | E-Monev BBP Mektan</title>
    </Head>
    <main class="c-main">
        <div class="container-fluid">
            <div class="fade-in">
                <div class="row">
                    <div class="col-md-12">
                        <div class="card border-0 rounded-3 shadow border-top-purple">
                            <div class="card-header">
                                <span class="font-weight-bold"><i class="fa fa-user"></i> Edit User</span>
                            </div>
                            <div class="card-body">

                                <form @submit.prevent="submit">

                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label class="fw-bold">Full Name</label>
                                                <input class="form-control" v-model="form.name"
                                                    :class="{ 'is-invalid': errors.name }" type="text"
                                                    placeholder="Full Name">
                                            </div>
                                            <div v-if="errors.name" class="alert alert-danger">
                                                {{ errors.name }}
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label class="fw-bold">Email Address</label>
                                                <input class="form-control" v-model="form.email"
                                                    :class="{ 'is-invalid': errors.email }" type="email"
                                                    placeholder="Email Address">
                                            </div>
                                            <div v-if="errors.email" class="alert alert-danger">
                                                {{ errors.email }}
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label class="fw-bold">Password</label>
                                                <input class="form-control" v-model="form.password"
                                                    :class="{ 'is-invalid': errors.password }" type="password"
                                                    placeholder="Password">
                                            </div>
                                            <div v-if="errors.password" class="alert alert-danger">
                                                {{ errors.password }}
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label class="fw-bold">Password Confirmation</label>
                                                <input class="form-control" v-model="form.password_confirmation"
                                                    type="password" placeholder="Password Confirmation">
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="mb-3">
                                                <label class="fw-bold">Roles</label>
                                                <br>
                                                <div class="form-check form-check-inline" v-for="(role, index) in roles"
                                                    :key="index">
                                                    <input class="form-check-input" type="radio" v-model="form.roles"
                                                        :value="role.name" :id="`check-${role.id}`">
                                                    <label class="form-check-label" :for="`check-${role.id}`">{{ role.name
                                                    }}</label>
                                                </div>
                                            </div>
                                            <div v-if="errors.roles" class="alert alert-danger">
                                                {{ errors.roles }}
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="mb-3">
                                                <label class="fw-bold">Field</label>
                                                <br>
                                                <select v-model="form.field_id">
                                                    <option disabled value="">Please select one</option>
                                                    <option v-for="field in fields" :value="field.id">{{ field.name }}
                                                    </option>
                                                </select>
                                            </div>
                                            <div v-if="errors.field_id" class="alert alert-danger">
                                                {{ errors.field_id }}
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="mb-3">
                                                <label class="fw-bold">Group</label>
                                                <br>
                                                <select v-model="form.group_id">
                                                    <option disabled value="">Please select one</option>
                                                    <option v-for="group in groups" :value="group.id">{{ group.name }}
                                                    </option>
                                                </select>
                                            </div>
                                            <div v-if="errors.group_id" class="alert alert-danger">
                                                {{ errors.group_id }}
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-12">
                                            <button class="btn btn-primary shadow-sm rounded-sm" type="submit">Save</button>
                                            <Link class="btn btn-warning shadow-sm rounded-sm ms-3" href="/apps/users">Back
                                            </Link>
                                        </div>
                                    </div>
                                </form>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
</template>

<script>
//import layout
import LayoutApp from '../../../Layouts/App.vue';

//import Head and useForm from Inertia
import { Head, Link, router, useForm } from '@inertiajs/vue3';

//import reactive from vue
import { reactive } from 'vue';

//import sweet alert2
import Swal from 'sweetalert2';

export default {
    //layout
    layout: LayoutApp,

    //register component
    components: {
        Head,
        Link
    },

    //props
    props: {
        errors: Object,
        user: Object,
        roles: Object,
        groups: Object,
        fields: Object,
    },

    //composition API
    setup(props) {

        //define form with reactive
        const form = useForm({
            name: props.user.name,
            email: props.user.email,
            password: '',
            password_confirmation: '',
            roles: props.user.roles.name,
            group_id: props.user.group_id,
            field_id: props.user.field_id,
        });

        //method "submit"
        const submit = () => {

            //send data to server
            form.put(`/apps/users/${props.user.id}`, {
                //data
                name: form.name,
                email: form.email,
                password: form.password,
                password_confirmation: form.password_confirmation,
                roles: form.roles,
                fields: form.fields
            }, {
                onSuccess: () => {
                    //show success alert
                    Swal.fire({
                        title: 'Success!',
                        text: 'User saved successfully.',
                        icon: 'success',
                        showConfirmButton: false,
                        timer: 2000
                    });
                },
            });

        }

        return {
            form,
            submit,
        };

    }
}
</script>

<style></style>