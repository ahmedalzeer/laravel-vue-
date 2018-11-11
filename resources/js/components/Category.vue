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
                            <h3 class="">Category Table</h3>
                        </div>
                        <div class="col-md-3"></div>
                        <div class="col-md-3 ">
                            <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#UserModal">
                                <i class="fa fa-user"></i> Add Category </button>
                        </div>
                    </div>



                </div>
                <!-- /.card-header -->
                <div class="card-body table-responsive p-0">
                    <table class="table table-hover">
                        <tbody><tr>
                            <th>ID</th>
                            <th>Category</th>
                            <th>Description</th>
                            <th>Created At</th>
                            <th>Modify</th>
                        </tr>
                        <tr v-for="cat in cats.data" :key="cat.id">
                            <td>{{cat.id}}</td>
                            <td>{{cat.cat_name | uptext}}</td>
                            <td>{{cat.cat_desc}}</td>
                            <td>{{cat.created_at | mydate}}</td>
                            <td>
                                <a href="#" @click="editmodal(cat)"><i class="fa fa-edit blue"></i></a>
                                <a href="#" @click="deletecat(cat.id)"><i class="fa fa-trash red"></i></a>
                            </td>
                        </tr>

                        </tbody>
                    </table>
                </div>
                <!-- /.card-body -->
                <div class="card-footer">
                    <pagination :data="cats" @pagination-change-page="getResults"></pagination>
                </div>
            </div>
            <!-- /.card -->

            <!-- Modal -->
            <div class="modal fade" id="UserModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" v-show="!editmode" id="UserModalLabel">Add New Category</h5>
                            <h5 class="modal-title" v-show="editmode" id="UserModalLabel">Update Category's Info </h5>
                            <button type="button" @click="newmodal" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <form @submit.prevent="editmode ? updatecat() : createcat()">
                            <div class="modal-body">
                                <div class="form-group">
                                    <input v-model="form.cat_name" type="text" name="cat_name" placeholder="Category Name"
                                           class="form-control" :class="{ 'is-invalid': form.errors.has('cat_name') }">
                                    <has-error :form="form" field="cat_name"></has-error>
                                </div>
                                <div class="form-group">
                                <textarea v-model="form.cat_desc"  name="cat_desc" placeholder="Description"
                                          class="form-control" :class="{ 'is-invalid': form.errors.has('cat_desc') }"></textarea>
                                    <has-error :form="form" field="cat_desc"></has-error>
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
                cats:{},
                form : new Form({
                    id:      '',
                    cat_name:    '',
                    cat_desc:    '',

                })
            }
        },
        methods:{
            getResults(page = 1) {
                axios.get('api/category?page=' + page)
                    .then(response => {
                        this.cats = response.data
                    });
            },
            updatecat(){
                this.$Progress.start()
                this.form.put('api/category/'+this.form.id)
                    .then(()=>{
                        $('#UserModal').modal('hide')
                        toast({
                            type: 'success',
                            title: 'Category Updated successfully'
                        })
                        this.$Progress.finish()
                        fire.$emit('getnew')
                    })
                    .catch(()=>{
                        this.$Progress.fail()
                    })
            },
            editmodal(cat){
                this.editmode = true;
                this.form.reset()
                $('#UserModal').modal('show')
                this.form.fill(cat)
            },
            newmodal(){
                this.editmode = false;
                this.form.reset()
                $('#UserModal').modal('show')
            },
            deletecat(id){
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
                        console.log(id)
                        this.form.delete('api/category/'+id)
                            .then(()=>{
                                swal(
                                    'Deleted!',
                                    'Your Category has been deleted.',
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
            loadcat(){
                if (this.$gate.isadmin())
                {axios.get('api/category').then(({data})=>this.cats = data)}
            },
            createcat(){
                this.$Progress.start()
                this.form.post('api/category')
                    .then(()=>{
                        fire.$emit('getnew')
                        $('#UserModal').modal('hide')
                        toast({
                            type: 'success',
                            title: 'Category Created successfully'
                        })
                        this.$Progress.finish()
                    })
                    .catch(()=>{
                        swal('Failed','oops someting goes wronge','warning')
                    })

            }
        },
        created(){
            this.loadcat()
            fire.$on('getnew',()=>{
                this.loadcat()
            })
        }
    }
</script>

<style scoped>

</style>
