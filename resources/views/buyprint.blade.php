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
        <label>Supplier Name : {{$buyy->buy_sub}}</label><br><br>
        <label>Supplier phone : {{$buyy->buy_subphone}}</label><br>
        <label>Date : {{$buyy->created_at}}</label><br>
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
        @foreach($buyy->items as $item)
            <tr class="odd gradeX">
                <td><center>{{$item->item_name}}</center></td>
                <td><center>{{$item->pivot->item_mountbuy}}</center></td>
                <td><center>{{$item->pivot->item_mountbuy * $item->sell_price}}</center></td>
            </tr>
        @endforeach
        </tbody>
    </table>
    <div>
        <label>price : {{$buyy->buy_price + $buyy->buy_stayprice}}</label><br>
        <label>paid : {{$buyy->buy_price}}</label><br>
        <label>stay : {{$buyy->buy_stayprice}}</label><br><br>
        <label>employee : {{$buyy->user->name}}</label><br>
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
