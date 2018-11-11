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
                            <h3 class="">Sales Report Table</h3>
                        </div>
                    </div>
                </div>
                <!-- /.card-header -->
                <div class="card-body table-responsive p-0">
                    <table class="table table-hover">
                        <tbody><tr>
                            <th>ID</th>
                            <th>Customer Name</th>
                            <th>Customer Phone</th>
                            <th>Paid</th>
                            <th>Stay</th>
                            <th>Time</th>
                            <th>Full Info</th>
                        </tr>
                        <tr v-for="sale in sales.data" :key="sale.id">
                            <td>{{sale.id}}</td>
                            <td>{{sale.sale_cus | uptext}}</td>
                            <td>{{sale.sale_cusphone}}</td>
                            <td>{{sale.sale_price}}</td>
                            <td>{{sale.sale_stayprice}}</td>
                            <td>{{sale.created_at | mydate}}</td>
                            <td><button data-toggle="modal" data-target="#myModal" @click="viewreport(sale.id)"><i class="fas fa-eye fa-1x blue"></i></button></td>
                        </tr>

                        </tbody>
                    </table>
                </div>
                <!-- /.card-body -->
                <div class="card-footer">
                    <pagination :data="sales" @pagination-change-page="getResults"></pagination>
                </div>
            </div>
            <!-- /.card -->
            <div class="modal fade" id="myModal" role="dialog">
                <div class="modal-dialog">

                    <!-- Modal content-->
                    <div class="modal-content">
                        <div class="modal-header">
                            <label>Customer Name : {{report.sale_cus}}</label>
                            <label>Customer phone : {{report.sale_cusphone}}</label>
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
                                    <td><center>{{repor.pivot.item_mount}}</center></td>
                                    <td><center>{{repor.pivot.item_mount * repor.sell_price}}</center></td>
                                </tr>
                                </tbody>
                            </table>
                        </div>
                        <div class="modal-footer">
                            <label>Total : {{parseInt(report.sale_price)+parseInt(report.sale_stayprice)}}</label><br>
                            <label>paid : {{report.sale_price}}</label><br>
                            <label>stay : {{report.sale_stayprice}}</label><br><br>
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
                sales:{},
                report:{},
                reportuser:{},
            }
        },
        methods:{
            getResults(page = 1) {
                axios.get('api/sale?page=' + page)
                    .then(response => {
                        this.sales = response.data;
                    });
            },
            viewreport(id){
                this.$Progress.start()
                axios.get('api/sale/'+id)
                    .then(response => {
                        this.report = response.data;
                        this.reportuser =response.data.user
                        this.$Progress.finish()
                    })
                    .catch(()=>{
                        this.$Progress.fail()
                    });
            },

            loadsale(){
                if (this.$gate.isadmin())
                {axios.get('api/sale').then(({data})=>this.sales = data)}
            }
        },
        created(){
            this.loadsale()
        }
    }
</script>

<style scoped>
.display{
    width: 100%;
}
</style>
