<template>
    <Head>
        <title>Subkelompok | E-Monev BBPSI Mektan</title>
    </Head>
    <main class="c-main">
        <div class="container-fluid">
            <div class="fade-in">
                <div class="row">
                    <div class="col-md-12">
                        <div class="card border-0 rounded-3 shadow border-top-purple">
                            <div class="card-header">
                                <span class="font-weight-bold"><i class="fa fa-shield"></i> Subkelompok</span>
                            </div>
                            <div class="card-body">
                                <form @submit.prevent="handleSearch">
                                    <div class="input-group mb-3">

                                        <Link href="/apps/groups/create" v-if="hasAnyPermission(['groups.create'])"
                                            class="btn btn-primary input-group-text"> <i class="fa fa-plus-circle me-2"></i>
                                        Tambah</Link>

                                        <input type="text" v-model="search" class="form-control"
                                            placeholder="Cari berdasarkan nama subkelompok...">

                                        <button class="btn btn-primary input-group-text" type="submit"> <i
                                                class="fa fa-search me-2"></i> Cari</button>

                                    </div>
                                </form>
                                <table class="table table-striped table-bordered table-hover">
                                    <thead>
                                        <tr>
                                            <th scope="col">Group Name</th>
                                            <th scope="col">Svp</th>
                                            <th scope="col">Field Name</th>
                                            <th scope="col" v-if="hasAnyPermission(['users.index'])">Users</th>
                                            <th scope="col" style="width:20%" v-if="hasAnyPermission(['users.delete'])">
                                                Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr v-for="(group, index) in groups.data" :key="index">
                                            <td>{{ group.name }}</td>
                                            <td>{{ group.spv }}</td>
                                            <td>
                                                <span class="badge badge-primary shadow border-0 ms-2 mb-2">
                                                    {{ group.field.name }}
                                                </span>
                                            </td>
                                            <td v-if="hasAnyPermission(['users.index'])">
                                                <span v-for="(user, index) in group.users" :key="index"
                                                    class="badge badge-primary shadow border-0 ms-2 mb-2">
                                                    {{ user.name }}
                                                </span>
                                            </td>
                                            <td class="text-center" v-if="hasAnyPermission(['users.delete'])">
                                                <Link :href="`/apps/groups/${group.id}/edit`"
                                                    v-if="hasAnyPermission(['groups.edit'])"
                                                    class="btn btn-success btn-sm me-2"><i
                                                    class="fa fa-pencil-alt me-1"></i> Edit</Link>
                                                <button @click.prevent="destroy(group.id)"
                                                    v-if="hasAnyPermission(['groups.delete'])"
                                                    class="btn btn-danger btn-sm"><i class="fa fa-trash"></i>
                                                    Delete</button>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                                <Pagination :links="groups.links" align="end" />
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

//import component pagination
import Pagination from '../../../Components/Pagination.vue';

//import Heade and Link from Inertia
import { Head, Link, router } from '@inertiajs/vue3';

// import ref
import { ref } from 'vue';
import Swal from 'sweetalert2';

export default {
    //layout
    layout: LayoutApp,

    //register component
    components: {
        Head,
        Link,
        Pagination
    },

    //props
    props: {
        groups: Object,
    },
    setup() {
        const search = ref('' || (new URL(document.location)).searchParams.get('q'));

        const handleSearch = () => {
            router.get('/apps/groups', {
                q: search.value,
            });
        }

        const destroy = (id) => {
            Swal.fire({
                title: 'Are you sure?',
                text: "You won't be able to revert this action!",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    router.delete(`/apps/groups/${id}`);

                    Swal.fire({
                        title: 'Deleted!',
                        text: 'User deleted successfully.',
                        icon: 'success',
                        timer: 2000,
                        showConfirmButton: false,
                    });
                }
            });
        }

        return {
            search,
            handleSearch,
            destroy,
        };
    },
}
</script>

<style></style>