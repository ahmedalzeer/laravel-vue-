<template>
    <div>
        <div class="row">
            <div class="col-md-2">
                <div v-for="item in items.data">
                    <div id="itemresult" @click="getitem(item)">{{item.item_name}}</div>
                </div>
            </div>
            <div class="col-md-10">
                <div class="card card-dark">
                    <div class="card-header">
                        <label>Sales</label>
                    </div>
                    <form id="form_sale" action="api/sale" method="post">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <input type="hidden" name="sale_user" id="hiddenuser" value=""/>
                                        <input v-model="form.sale_cus" type="text" name="sale_cus" placeholder="Customer Name"
                                               class="form-control" :class="{ 'is-invalid': form.errors.has('sale_cus') }">
                                        <has-error :form="form" field="sale_cus"></has-error>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <input v-model="form.sale_cusphone" type="text" name="sale_cusphone" placeholder="Customer Phone"
                                               class="form-control" :class="{ 'is-invalid': form.errors.has('sale_cusphone') }">
                                        <has-error :form="form" field="sale_cusphone"></has-error>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <table id="form_item">
                                    </table>
                                </div>
                                <div class="col-md-4">
                                    <input id="totalmoney" class=" btn btn-default btn-sm" value="total">
                                    <div class="form-group">
                                        <input type="text" name="total" id="fullprice"
                                               class="form-control" :class="{ 'is-invalid': form.errors.has('total') }">
                                        <has-error :form="form" field="totaltotal"></has-error>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <label>paid</label>
                                    <div class="form-group">
                                        <input v-model="form.sale_price" type="text" name="sale_price" id="paymount"
                                               class="form-control" :class="{ 'is-invalid': form.errors.has('sale_price') }">
                                        <has-error :form="form" field="sale_price"></has-error>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <label>stay</label>
                                    <div class="form-group">
                                        <input v-model="form.sale_stayprice" type="text" name="sale_stayprice" id="staymount"
                                               class="form-control" :class="{ 'is-invalid': form.errors.has('sale_stayprice') }">
                                        <has-error :form="form" field="sale_stayprice"></has-error>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card-footer">
                            <button type="submit" class="btn btn-primary">Sale</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        data(){
          return{
              items:{},
              newitem:{},
              form:new Form({
                  sale_user:     '',
              })
          }
        },
        methods:{
            getitem(item){
                        $('#form_item').append('<tr id="removerow" class="form" style="margin-bottom: 3px;">'
                            +'<td><div class="form-group">'
                            +'<label>item</label>'
                            +'<input type="text" id="itemname" name="item_name" class="itemname form-control" value="'+item.item_name+'">'
                            +'<input type="hidden" name="item['+item.id+']" value="'+item.id+'">'
                            +'</div></td><td><div class="form-group">'
                            +'<label>mount</label> '+'  '+'<strong id="mountprint"></strong>'
                            +'<input type="text" name="mount['+item.id+']" id="mount'+item.id+'" class="mount form-control" value="1">'
                            +'</div></td><td><div class="form-group">'
                            +'<label>price</label>'
                            +'<input type="text" name="price" id="price'+item.id+'" class="buyprice form-control" value="'+item.sell_price+'">'
                            +'</div></td><td><div class="form-group"><i class="fas fa-window-close red"></i></div></td></tr>');

            },
            createsale(){
                this.$Progress.start()
                this.form.sale_user = $('#userid').val()
                this.form.post('api/sale')
            }
        },
        created(){
            fire.$on('searching',()=>{
                let item = this.$parent.search
                axios.get('api/finditem?q=' + item)
                    .then((data) => {
                        this.items = data.data
                    })
                    .catch(() => {
                    })
            })
        }
    }
    $(document).on('keyup','#form_sale',function () {
        let sss =$('#userid').val();
        $('#hiddenuser').val(sss)
    });
    $(document).on('keyup','#form_sale',function () {
        staymount=$('#paymount').val()-$('#fullprice').val();
        $('#staymount').val(Math.abs(staymount));
    });
    $(document).on("click",'#totalmoney', function(){
        var sum=0;
        $(".buyprice").each(function(){

            sum += parseInt($(this).val());
        });
        $("#fullprice").val(sum);
    });
    $(document).on('dblclick','#removerow',function(){
        $(this).remove();
    })
    $(document).on('keyup','.form',function () {
        var $btn = $(this);
        var dd=$btn.find('.itemname').val();
        $.ajax({
            url: 'api/salemount',
            method: "POST",
            data: {ww : dd},
            dataType: 'json',
            success: function (data) {
                $.each(data,function (key,val) {
                    let hh= $('#mount'+val.id).val();
                    let totalprice = hh*val.sell_price;
                    $('#price'+val.id).val(totalprice);
                });
            }
        });
    });
</script>

<style scoped>
#itemresult{
    background-color: #1b4b72;
    color: white;
    margin: 2px 2px 2px;
    cursor: pointer;
}
</style>
