<!DOCTYPE html>
<html>
<head>
    <meta charset=utf-8 />
    <title>Inventory Print</title>

    <style>
        .display{
            width: 70%;
            margin-right: 10px;
            margin-left: 50px;
            margin-top: 50px;
            margin-bottom: 50px;
            border-style: dashed;
        }
        #container{
            margin-left: 50px;
        }
        .home{
            margin-left: 50px;
        }
    </style>
</head>
<body id="yadcf_">
<div id="container">
    <center><h3>Company(company name)</h3></center>
    <div>
        <label>Customer Name : {{$sal->sale_cus}}</label><br><br>
        <label>Customer phone : {{$sal->sale_cusphone}}</label><br>
        <label>Date : {{$sal->created_at}}</label><br>
        <div ></div>
    </div>
    <table cellpadding="0" cellspacing="0" border="1" class="display">
        <thead>
        <tr>
            <th>item</th>
            <th>mount</th>
            <th>price</th>
        </tr>
        </thead>
        <tbody>
        @foreach($sal->items as $item)
        <tr class="odd gradeX">
            <td><center>{{$item->item_name}}</center></td>
            <td><center>{{$item->pivot->item_mount}}</center></td>
            <td><center>{{$item->pivot->item_mount * $item->sell_price}}</center></td>
        </tr>
            @endforeach
        </tbody>
    </table>
    <div>
        <label>price : {{$sal->sale_price + $sal->sale_stayprice}}</label><br>
        <label>paid : {{$sal->sale_price}}</label><br>
        <label>stay : {{$sal->sale_stayprice}}</label><br><br>
        <label>employee : {{$sal->user->name}}</label><br>
        <div ></div>
    </div><br><br/><br/>
    <a href="#" onclick="printInvoice()">print</a><a class="home" href="/dashboard">home</a>

</div>
<script>
    function printInvoice() {
        window.print();
    }
</script>
</body>
</html>
