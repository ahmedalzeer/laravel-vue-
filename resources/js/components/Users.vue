<template>
    <div class="row">
        <div v-if="!$gate.isadmin()">
            <not-found></not-found>
        </div>
        <div class="col-md-12 mt-5" v-if="$gate.isadmin()">
            <div class="card card-dark">
                <div class="card-header">
                    <div class="row">
                        <div class="col-md-6">
                            <h3 class="">Users Table</h3>
                        </div>
                        <div class="col-md-4"></div>
                        <div class="col-md-2 ">
                            <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#UserModal">
                                <i class="fa fa-user"></i> Add User </button>
                        </div>
                    </div>
                </div>
                <!-- /.card-header -->
                <div class="card-body table-responsive p-0">
                    <table class="table table-hover">
                        <tbody><tr>
                            <th>ID</th>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Role</th>
                            <th>Join At</th>
                            <th>Modify</th>
                        </tr>
                        <tr v-for="user in users.data" :key="user.id">
                            <td>{{user.id}}</td>
                            <td>{{user.name}}</td>
                            <td>{{user.email}}</td>
                            <td>{{user.role | uptext}}</td>
                            <td>{{user.created_at | mydate}}</td>
                            <td>
                                <a href="#" @click="editmodal(user)"><i class="fa fa-edit blue"></i></a>
                                <a href="#" @click="deleteuser(user.id)"><i class="fa fa-trash red"></i></a>
                            </td>
                        </tr>

                        </tbody>
                    </table>
                </div>
                <!-- /.card-body -->
                <div class="card-footer">
                    <pagination :data="users" @pagination-change-page="getResults"></pagination>
                </div>
            </div>
            <!-- /.card -->

            <!-- Modal -->
            <div class="modal fade" id="UserModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" v-show="!editmode" id="UserModalLabel">Add New User</h5>
                            <h5 class="modal-title" v-show="editmode" id="UserModalLabel">Update User's Info </h5>
                            <button type="button" @click="newmodal" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                       <form @submit.prevent="editmode ? updateuser() : createuser()">
                           <div class="modal-body">
                               <div class="form-group">
                                   <input v-model="form.name" type="text" name="name" placeholder="Full Name"
                                          class="form-control" :class="{ 'is-invalid': form.errors.has('name') }">
                                   <has-error :form="form" field="name"></has-error>
                               </div>
                               <div class="form-group">
                                   <input v-model="form.email" type="email" name="email" placeholder="Email"
                                          class="form-control" :class="{ 'is-invalid': form.errors.has('email') }">
                                   <has-error :form="form" field="email"></has-error>
                               </div>
                               <div class="form-group">
                                   <input v-model="form.password" type="password" name="password" placeholder="Password"
                                          class="form-control" :class="{ 'is-invalid': form.errors.has('password') }">
                                   <has-error :form="form" field="password"></has-error>
                               </div>
                               <div class="form-group">
                                   <select v-model="form.role"  name="role" class="form-control" :class="{ 'is-invalid': form.errors.has('role') }">
                                       <option value="admin">Admin</option>
                                       <option value="author">Author</option>
                                       <option value="user">User</option>
                                   </select>
                                   <has-error :form="form" field="role"></has-error>
                               </div>
                               <div class="form-group">
                                <textarea v-model="form.bio"  name="bio" placeholder="Bio"
                                          class="form-control" :class="{ 'is-invalid': form.errors.has('bio') }"></textarea>
                                   <has-error :form="form" field="bio"></has-error>
                               </div>
                           </div>
                           <div class="modal-footer">
                               <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                               <button v-show="!editmode" type="submit" class="btn btn-primary">Create</button>
                               <button v-show="editmode" type="submit" class="btn btn-success">Update</button>
                           </div>
                       </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>

    export default {
        data(){
            return{
                editmode:false,
                users:{},
                form : new Form({
                    id:      '',
                    name:    '',
                    email:   '',
                    password:'',
                    photo:   '',
                    bio:     '',
                    role:    ''
                })
            }
        },
        methods:{
            getResults(page = 1) {
                axios.get('api/user?page=' + page)
                    .then(response => {
                        this.users = response.data;
                    });
            },
            updateuser(){
                this.$Progress.start()
                this.form.put('api/user/'+this.form.id)
                    .then(()=>{
                        $('#UserModal').modal('hide')
                        toast({
                            type: 'success',
                            title: 'User Updated successfully'
                        })
                        this.$Progress.finish()
                        fire.$emit('getnew')
                    })
                    .catch(()=>{
                        this.$Progress.fail()
                    })
            },
            editmodal(user){
                this.editmode = true;
                this.form.reset()
                $('#UserModal').modal('show')
                this.form.fill(user)
            },
            newmodal(){
                this.editmode = false;
                this.form.reset()
                $('#UserModal').modal('show')
            },
            deleteuser(id){
                swal({
                    title: 'Are you sure?',
                    text: "You won't be able to revert this!",
                    type: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes, delete it!'
                }).then((result) => {
                    if (result.value)
                    {
                        this.form.delete('api/user/'+id)
                            .then(()=>{
                                swal(
                                        'Deleted!',
                                        'Your file has been deleted.',
                                        'success'
                                    )
                                fire.$emit('getnew')
                            })
                            .catch(()=>{
                                swal('Failed','oops someting goes wronge','warning')
                            })
                    }
                })
            },
            loaduser(){
                if (this.$gate.isadmin())
                {axios.get('api/user').then(({data})=>this.users = data)}
            },
            createuser(){
                this.$Progress.start()
                this.form.post('api/user')
                    .then(()=>{
                        fire.$emit('getnew')
                        $('#UserModal').modal('hide')
                        toast({
                            type: 'success',
                            title: 'User Created successfully'
                        })
                        this.$Progress.finish()
                    })
                    .catch(()=>{
                        swal('Failed','oops someting goes wronge','warning')
                    })

            }
        },
       created(){
            this.loaduser()
           fire.$on('searching',()=>{
               let query = this.$parent.search
                axios.get('api/finduser?q='+query)
                    .then((data)=>{
                        this.users = data.data
                    })
                    .catch(()=>{

                    })
           })
           fire.$on('getnew',()=>{
               this.loaduser()
           })
       }
    }
</script>

<style scoped>

</style>
