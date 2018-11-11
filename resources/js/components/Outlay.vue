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
                            <h3 class="">Outlay Table</h3>
                        </div>
                        <div class="col-md-3"></div>
                        <div class="col-md-3 ">
                            <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#UserModal">
                                <i class="fa fa-user"></i>Add Outlay</button>
                        </div>
                    </div>
                </div>
                <!-- /.card-header -->
                <div class="card-body table-responsive p-0">
                    <table class="table table-hover">
                        <tbody><tr>
                            <th>ID</th>
                            <th>Outlay Name</th>
                            <th>Outlay Mount</th>
                            <th>Date</th>
                            <th>Modfiy</th>
                        </tr>
                        <tr v-for="out in outs.data" :key="out.id">
                            <td>{{out.id}}</td>
                            <td>{{out.outlay_name | uptext}}</td>
                            <td>{{out.outlay_mount}}</td>
                            <td>{{out.created_at | mydate}}</td>
                            <td>
                                <a href="#" @click="editmodal(out)"><i class="fa fa-edit blue"></i></a>
                                <a href="#" @click="deleteout(out.id)"><i class="fa fa-trash red"></i></a>
                            </td>
                        </tr>

                        </tbody>
                    </table>
                </div>
                <!-- /.card-body -->
                <div class="card-footer">
                    <pagination :data="outs" @pagination-change-page="getResults"></pagination>
                </div>
            </div>
            <!-- /.card -->

            <!-- Modal -->
            <div class="modal fade" id="UserModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" v-show="!editmode" id="UserModalLabel">Add Outlay User</h5>
                            <h5 class="modal-title" v-show="editmode" id="UserModalLabel">Update Outlay's Info </h5>
                            <button type="button" @click="newmodal" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <form @submit.prevent="editmode ? updateout() : createout()">
                            <div class="modal-body">
                                <div class="form-group">
                                    <input v-model="form.outlay_name" type="text" name="outlay_name" placeholder="Outlay Nmae"
                                           class="form-control" :class="{ 'is-invalid': form.errors.has('outlay_name') }">
                                    <has-error :form="form" field="outlay_name"></has-error>
                                </div>
                                <div class="form-group">
                                    <input v-model="form.outlay_mount" type="text" name="outlay_mount" placeholder="Outlay Mount"
                                           class="form-control" :class="{ 'is-invalid': form.errors.has('outlay_mount') }">
                                    <has-error :form="form" field="outlay_mount"></has-error>
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
                outs:{},
                form : new Form({
                    id:      '',
                    outlay_name:    '',
                    outlay_mount:   '',
                })
            }
        },
        methods:{
            getResults(page = 1) {
                axios.get('api/outlay?page=' + page)
                    .then(response => {
                        this.outs = response.data;
                    });
            },
            updateout(){
                this.$Progress.start()
                this.form.put('api/outlay/'+this.form.id)
                    .then(()=>{
                        $('#UserModal').modal('hide')
                        toast({
                            type: 'success',
                            title: 'Outlay Updated successfully'
                        })
                        this.$Progress.finish()
                        fire.$emit('getnew')
                    })
                    .catch(()=>{
                        this.$Progress.fail()
                    })
            },
            editmodal(out){
                this.editmode = true;
                this.form.reset()
                $('#UserModal').modal('show')
                this.form.fill(out)
            },
            newmodal(){
                this.editmode = false;
                this.form.reset()
                $('#UserModal').modal('show')
            },
            deleteout(id){
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
                        this.form.delete('api/outlay/'+id)
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
            loadout(){
                if (this.$gate.isadmin())
                {axios.get('api/outlay').then(({data})=>this.outs = data)}
            },
            createout(){
                this.$Progress.start()
                this.form.post('api/outlay')
                    .then(()=>{
                        fire.$emit('getnew')
                        $('#UserModal').modal('hide')
                        toast({
                            type: 'success',
                            title: 'Outlay Created successfully'
                        })
                        this.$Progress.finish()
                    })
                    .catch(()=>{
                        swal('Failed','oops someting goes wronge','warning')
                    })

            }
        },
        created(){
            this.loadout()
            fire.$on('searching',()=>{
                let query = this.$parent.search
                axios.get('api/findoutlay?q='+query)
                    .then((data)=>{
                        this.outs = data.data
                    })
                    .catch(()=>{

                    })
            })
            fire.$on('getnew',()=>{
                this.loadout()
            })
        }
    }
</script>

<style scoped>

</style>
