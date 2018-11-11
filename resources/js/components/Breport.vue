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
                            <h3 class="">Buys Report Table</h3>
                        </div>
                    </div>
                </div>
                <!-- /.card-header -->
                <div class="card-body table-responsive p-0">
                    <table class="table table-hover">
                        <tbody><tr>
                            <th>ID</th>
                            <th>Supplier Name</th>
                            <th>Supplier Phone</th>
                            <th>Paid</th>
                            <th>Stay</th>
                            <th>Time</th>
                            <th>Full Info</th>
                        </tr>
                        <tr v-for="buy in buys.data" :key="buy.id">
                            <td>{{buy.id}}</td>
                            <td>{{buy.buy_sub | uptext}}</td>
                            <td>{{buy.buy_subphone}}</td>
                            <td>{{buy.buy_price}}</td>
                            <td>{{buy.buy_stayprice}}</td>
                            <td>{{buy.created_at | mydate}}</td>
                            <td><button data-toggle="modal" data-target="#myModal" @click="viewreport(buy.id)"><i class="fas fa-eye fa-1x blue"></i></button></td>
                        </tr>

                        </tbody>
                    </table>
                </div>
                <!-- /.card-body -->
                <div class="card-footer">
                    <pagination :data="buys" @pagination-change-page="getResults"></pagination>
                </div>
            </div>
            <!-- /.card -->
            <div class="modal fade" id="myModal" role="dialog">
                <div class="modal-dialog">

                    <!-- Modal content-->
                    <div class="modal-content">
                        <div class="modal-header">
                            <label>Customer Name : {{report.buy_sub}}</label>
                            <label>Customer phone : {{report.buy_subphone}}</label>
                        </div>
                        <div class="modal-body">
                            <table cellpadding="0" cellspacing="0" border="1" class="display">
                                <thead>
                                <tr>
                                    <th>item</th>
                                    <th>mount</th>
                                    <th>price</th>
                                </tr>
                                </thead>
                                <tbody v-for="repor in report.items">
                                <tr class="odd gradeX">
                                    <td><center>{{repor.item_name}}</center></td>
                                    <td><center>{{repor.pivot.item_mountbuy}}</center></td>
                                    <td><center>{{repor.pivot.item_mountbuy * repor.buy_price}}</center></td>
                                </tr>
                                </tbody>
                            </table>
                        </div>
                        <div class="modal-footer">
                            <label>Total : {{parseInt(report.buy_price)+parseInt(report.buy_stayprice)}}</label><br>
                            <label>paid : {{report.buy_price}}</label><br>
                            <label>stay : {{report.buy_stayprice}}</label><br><br>
                            <label>employee : {{reportuser.name}}</label><br>
                        </div>
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
                buys:{},
                report:{},
                reportuser:{},
            }
        },
        methods:{
            getResults(page = 1) {
                axios.get('api/buy?page=' + page)
                    .then(response => {
                        this.buys = response.data;
                    });
            },
            viewreport(id){
                this.$Progress.start()
                axios.get('api/buy/'+id)
                    .then(response => {
                        this.report = response.data;
                        this.reportuser =response.data.user
                        this.$Progress.finish()
                    })
                    .catch(()=>{
                        this.$Progress.fail()
                    });
            },

            loadbuy(){
                if (this.$gate.isadmin())
                {axios.get('api/buy').then(({data})=>this.buys = data)}
            }
        },
        created(){
            this.loadbuy()
        }
    }
</script>

<style scoped>
    .display{
        width: 100%;
    }
</style>
