<template>
    <div class="row">
        <div class="col-md-12 mt-5">
            <div class="card card-dark">
                <div class="card-header">
                    <div class="row">
                        <div class="col-md-6">
                            <h3 class="">Items Table</h3>
                        </div>
                        <div class="col-md-4"></div>
                        <div class="col-md-2 ">
                            <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#UserModal">
                                <i class="fa fa-user"></i> Add Item </button>
                        </div>
                    </div>



                </div>
                <!-- /.card-header -->
                <div class="card-body table-responsive p-0">
                    <table class="table table-hover">
                        <tbody><tr>
                            <th>ID</th>
                            <th>Item</th>
                            <th>Description</th>
                            <th>Category</th>
                            <th>Add by</th>
                            <th>buy price</th>
                            <th>sell price</th>
                            <th>Add At</th>
                            <th>Modify</th>
                        </tr>
                        <tr v-for="item in items.data" :key="item.id">
                            <td>{{item.id}}</td>
                            <td>{{item.item_name | uptext}}</td>
                            <td>{{item.item_desc}}</td>
                            <td>{{item.category.cat_name}}</td>
                            <td>{{item.user.name}}</td>
                            <td>{{item.buy_price}}</td>
                            <td>{{item.sell_price}}</td>
                            <td>{{item.created_at | mydate}}</td>
                            <td>
                                <a href="#" @click="editmodal(item)"><i class="fa fa-edit blue"></i></a>
                                <a href="#" data-toggle="modal" data-target="#myModal" @click="showitem(item.id)"><i class="fa fa-eye green"></i></a>
                                <a href="#" @click="deleteitem(item.id)"><i class="fa fa-trash red"></i></a>
                            </td>
                        </tr>

                        </tbody>
                    </table>
                </div>
                <!-- /.card-body -->
                <div class="card-footer">
                    <pagination :data="items" @pagination-change-page="getResults"></pagination>
                </div>
            </div>
            <!-- /.card -->

            <!-- Modal -->
            <div class="modal fade" id="UserModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" v-show="!editmode" id="UserModalLabel">Add New Item</h5>
                            <h5 class="modal-title" v-show="editmode" id="UserModalLabel">Update Item's Info </h5>
                            <button type="button" @click="newmodal" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <form @submit.prevent="editmode ? updateitem() : createitem()">
                            <div class="modal-body">
                                <div class="form-group">
                                    <input v-model="form.item_name" type="text" name="item_name" placeholder="Item Name"
                                           class="form-control" :class="{ 'is-invalid': form.errors.has('item_name') }">
                                    <has-error :form="form" field="item_name"></has-error>
                                </div>
                                <div class="form-group">
                                <textarea v-model="form.item_desc"  name="item_desc" placeholder="Description"
                                          class="form-control" :class="{ 'is-invalid': form.errors.has('item_desc') }"></textarea>
                                    <has-error :form="form" field="item_desc"></has-error>
                                </div>
                                <div class="form-group">
                                    <select v-model="form.cat_id" name="cat_id" class="form-control" :class="{ 'is-invalid': form.errors.has('cat_id') }">
                                        <option value="">Select Category</option>
                                        <option v-for="cat in cats.data" :key="cat.id" v-bind:value="cat.id">{{cat.cat_name}}</option>

                                    </select>
                                    <has-error :form="form" field="cat_id"></has-error>
                                </div>
                                <div class="form-group">
                                    <input v-model="form.buy_price" type="text" name="buy_price" placeholder="Buy Price"
                                           class="form-control" :class="{ 'is-invalid': form.errors.has('buy_price') }">
                                    <has-error :form="form" field="buy_price"></has-error>
                                </div>
                                <div class="form-group">
                                    <input v-model="form.sell_price" type="text" name="sell_price" placeholder="Sell Price"
                                           class="form-control" :class="{ 'is-invalid': form.errors.has('sell_price') }">
                                    <has-error :form="form" field="sell_price"></has-error>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-2 d-inline">Item Photo</label>
                                    <div class="col-sm-12">
                                            <span class="btn btn-primary btn-file btn-sm">
                                                Browse...<input type="file" @change="uploadphoto" name="item_photo" :class="{ 'is-invalid': form.errors.has('item_photo') }">
                                            </span>
                                        <has-error :form="form" field="item_photo"></has-error>
                                    </div>
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
        <div id="myModal" class="modal fade" role="dialog">
            <div class="modal-dialog ">

                <!-- Modal content-->
                <div class="modal-content">
                    <div class="modal-header ">
                        <center>
                            <h4 class="modal-title">Name : {{it.item_name}}</h4>
                            <img :src="getitemphoto()">
                        </center>
                    </div>
                    <div class="modal-body">
                        <label>Description</label>
                        <p>{{it.item_desc}}</p>
                        <label>Buy Price</label>
                        <p>{{it.buy_price}}</p>
                        <label>Sell Price</label>
                        <p>{{it.sell_price}}</p>
                        <label>Category</label>
                        <p>{{itemcat}}</p>
                        <label>Add By</label>
                        <p>{{itemuser}}</p>
                        <label>Add At</label>
                        <p>{{it.created_at | mydate}}</p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
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
                items:{},
                cats:{},
                it:{},
                itemuser:'',
                itemcat:'',
                form : new Form({
                    id:            '',
                    item_name:     '',
                    item_desc:     '',
                    item_user:     '',
                    cat_id:        '',
                    sell_price:    '',
                    buy_price:     '',
                    item_photo:    ''
                })
            }
        },
        methods:{
            getitemphoto(){
                return '/img/item/'+this.it.item_photo

            },
            showitem(id){
                axios.get('api/item/'+id)
                    .then(response => {
                        this.it = response.data;
                        this.itemuser = response.data.user.name
                        this.itemcat = response.data.category.cat_name
                    });
            },
            loadcat(){
                axios.get('api/category').then(({data})=>this.cats = data)
            },
            getResults(page = 1) {
                axios.get('api/item?page=' + page)
                    .then(response => {
                        this.item = response.data;
                    });
            },
            updateitem(){
                this.$Progress.start()
                this.form.item_user = $('#userid').val()
                this.form.put('api/item/'+this.form.id)
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
            editmodal(item){
                this.editmode = true;
                this.form.reset()
                $('#UserModal').modal('show')
                this.form.fill(item)
            },
            newmodal(){
                this.editmode = false;
                this.form.reset()
                $('#UserModal').modal('show')
            },
            deleteitem(id){
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
                        this.form.delete('api/item/'+id)
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
            loaditem(){
                axios.get('api/item').then(({data})=>this.items = data)
            },
            createitem(){
                this.$Progress.start()
                this.form.item_user = $('#userid').val()
                this.form.post('api/item')
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

            },
            uploadphoto(e){
                let file = e.target.files[0]
                let r = new FileReader()
                if(file['size'] < 2111775)
                {
                    r.onloadend = (file)=>{
                        this.form.item_photo = r.result
                    }
                    r.readAsDataURL(file)
                }else
                {
                    swal({
                        type: 'error',
                        title: 'oops...',
                        text:'Your file is too large...max 2m'
                    })
                }
            }
        },
        created(){
            this.loadcat()
            this.loaditem()
            fire.$on('searching',()=>{
                let query = this.$parent.search
                axios.get('api/finditem?q='+query)
                    .then((data)=>{
                        this.users = data.data
                    })
                    .catch(()=>{

                    })
            })
            fire.$on('getnew',()=>{
                this.loaditem()
            })
        }
    }
</script>

<style scoped>
    .modal-dialog{
        margin-left: 50%;
    }
</style>
