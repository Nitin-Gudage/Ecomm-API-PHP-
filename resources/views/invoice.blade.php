<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Generate PDF in Laravel 10</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">

</head>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <title>Invoice #6</title>

    <style>
        html,
        body {
            margin: 10px;
            padding: 10px;
            font-family: sans-serif;
        }
        h1,h2,h3,h4,h5,h6,p,span,label {
            font-family: sans-serif;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 0px !important;
        }
        table thead th {
            height: 28px;
            text-align: left;
            font-size: 16px;
            font-family: sans-serif;
        }
        table, th, td {
            border: 1px solid #ddd;
            padding: 8px;
            font-size: 14px;
        }

        .heading {
            font-size: 24px;
            margin-top: 12px;
            margin-bottom: 12px;
            font-family: sans-serif;
        }
        .small-heading {
            font-size: 18px;
            font-family: sans-serif;
        }
        .total-heading {
            font-size: 18px;
            font-weight: 700;
            font-family: sans-serif;
        }
        .order-details tbody tr td:nth-child(1) {
            width: 20%;
        }
        .order-details tbody tr td:nth-child(3) {
            width: 20%;
        }

        .text-start {
            text-align: left;
        }
        .text-end {
            text-align: right;
        }
        .text-center {
            text-align: center;
        }
        .company-data span {
            margin-bottom: 4px;
            display: inline-block;
            font-family: sans-serif;
            font-size: 14px;
            font-weight: 400;
        }
        .no-border {
            border: 1px solid #fff !important;
        }
        .bg-blue {
            background-color: #414ab1;
            color: #fff;
        }
    </style>
</head>
<body> 
  <div class="container">
    <table class="order-details">
        <thead>
            <tr>
                <th width="50%" colspan="2">
                    <h2 class="text-start">Funda Ecommerce</h2>
                </th>
                <th width="50%" colspan="2" class="text-end company-data">
                    <span>Invoice Id: #6</span> <br>
                    <span>Date: 24 / 09 / 2022</span> <br>
                    <span>Zip code : 560077</span> <br>
                    <span>Address: #555, Main road, shivaji nagar, Bangalore, India</span> <br>
                </th>
            </tr>
            <tr class="bg-blue">
                <th width="50%" colspan="2">Order Details</th>
                <th width="50%" colspan="2">User Details</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>Order Id:</td>
                <td>6</td>

                <td>Full Name:</td>
                <td>Ved Prakash</td>
            </tr>
            <tr>
                <td>Tracking Id/No.:</td>
                <td>funda-CRheOqspbA</td>

                <td>Email Id:</td>
                <td>ved@gmail.com</td>
            </tr>
            <tr>
                <td>Ordered Date:</td>
                <td>22-09-2022 10:54 AM</td>

                <td>Phone:</td>
                <td>8889997775</td>
            </tr>
            <tr>
                <td>Payment Mode:</td>
                <td>Cash on Delivery</td>

                <td>Address:</td>
                <td>asda asdad asdad adsasd</td>
            </tr>
            <tr>
                <td>Order Status:</td>
                <td>completed</td>

                <td>Pin code:</td>
                <td>566999</td>
            </tr>
        </tbody>
    </table>

    <table>
        <thead>
            <tr>
                <th class="no-border text-start heading" colspan="5">
                    Order Items
                </th>
            </tr>
            <tr class="bg-blue">
                <th>ID</th>
                <th>Product</th>
                <th>Price</th>
                <th>Quantity</th>
                <th>Total</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td width="10%">16</td>
                <td>
                    Mi Note 7
                </td>
                <td width="10%">$14000</td>
                <td width="10%">1</td>
                <td width="15%" class="fw-bold">$14000</td>
            </tr>
            <tr>
                <td width="10%">17</td>
                <td>
                    Vivo V19
                </td>
                <td width="10%">$699</td>
                <td width="10%">1</td>
                <td width="15%" class="fw-bold">$699</td>
            </tr>
            <tr>
                <td colspan="4" class="total-heading">Total Amount - <small>Inc. all vat/tax</small> :</td>
                <td colspan="1" class="total-heading">$14699</td>
            </tr>
        </tbody>
    </table>

    <br>
    <p class="text-center">
        Thank your for shopping with Funda of Web IT
    </p>
  </div>
</body>
</html>


<!-- <style type="text/css">
    body {
        font-family: 'Roboto Condensed', sans-serif;
    }

    .m-0 {
        margin: 0px;
    }

    .p-0 {
        padding: 0px;
    }

    .pt-5 {
        padding-top: 5px;
    }

    .mt-10 {
        margin-top: 10px;
    }

    .text-center {
        text-align: center !important;
    }

    .w-100 {
        width: 100%;
    }

    .w-50 {
        width: 50%;
    }

    .w-85 {
        width: 85%;
    }

    .w-15 {
        width: 15%;
    }

    .logo img {
        width: 200px;
        height: 60px;
    }

    .gray-color {
        color: #5D5D5D;
    }

    .text-bold {
        font-weight: bold;
    }

    .border {
        border: 1px solid black;
    }

    table tr,
    th,
    td {
        border: 1px solid #d2d2d2;
        border-collapse: collapse;
        padding: 7px 8px;
    }

    table tr th {
        background: #F4F4F4;
        font-size: 15px;
    }

    table tr td {
        font-size: 13px;
    }

    table {
        border-collapse: collapse;
    }

    .box-text p {
        line-height: 10px;
    }

    .float-left {
        float: left;
    }

    .total-part {
        font-size: 16px;
        line-height: 12px;
    }

    .total-right p {
        padding-right: 20px;
    }
</style> -->


<!-- <body>
    <div class="container">
    <style type="text/css">
    body{
        font-family: 'Roboto Condensed', sans-serif;
    }
    .m-0{
        margin: 0px;
    }
    .p-0{
        padding: 0px;
    }
    .pt-5{
        padding-top:5px;
    }
    .mt-10{
        margin-top:10px;
    }
    .text-center{
        text-align:center !important;
    }
    .w-100{
        width: 100%;
    }
    .w-50{
        width:50%;   
    }
    .w-85{
        width:85%;   
    }
    .w-15{
        width:15%;   
    }
    .logo img{
        width:180px;
        height:120px;
         
               
    }
    .gray-color{
        color:#5D5D5D;
    }
    .text-bold{
        font-weight: bold;
    }
    .border{
        border:1px solid black;
    }
    table tr,th,td{
        border: 1px solid #d2d2d2;
        border-collapse:collapse;
        padding:7px 8px;
    }
    table tr th{
        background: #F4F4F4;
        font-size:15px;
    }
    table tr td{
        font-size:13px;
    }
    table{
        border-collapse:collapse;
    }
    .box-text p{
        line-height:10px;
    }
    .float-left{
        float:left;
    }
    .total-part{
        font-size:16px;
        line-height:12px;
    }
    .total-right p{
        padding-right:20px;
    }
</style>
<body>
<div class="head-title">
    <h1 class="text-center m-0 p-0">Invoice</h1>
</div>
<div class="add-detail mt-10">
    <div class="w-50 float-left mt-10">
        <p class="m-0 pt-5 text-bold w-100">Invoice Id - <span class="gray-color">#1</span></p>
        <p class="m-0 pt-5 text-bold w-100">Order Id - <span class="gray-color">AB123456A</span></p>
        <p class="m-0 pt-5 text-bold w-100">Order Date - <span class="gray-color">22-01-2023</span></p>
    </div>
    <div class="w-40 float-left logo mt-10">
        <img src="https://static.vecteezy.com/system/resources/thumbnails/011/491/336/small_2x/e-commerce-logo-collection-free-vector.jpg" alt="Logo">
    </div>
    <div style="clear: both;"></div>
</div>
<div class="table-section bill-tbl w-100 mt-10">
    <table class="table w-100 mt-10">
        <tr>
            <th class="w-50">From</th>
            <th class="w-50">To</th>
        </tr>
        <tr>
            <td>
                <div class="box-text">
                    <p>Mountain View,</p>
                    <p>California,</p>
                    <p>United States</p>                    
                    <p>Contact: (650) 253-0000</p>
                </div>
            </td>
            <td>
                <div class="box-text">
                    <p> 410 Terry Ave N,</p>
                    <p>Seattle WA 98109,</p>
                    <p>United States</p>                    
                    <p>Contact: 1-206-266-1000</p>
                </div>
            </td>
        </tr>
    </table>
</div>
<div class="table-section bill-tbl w-100 mt-10">
    <table class="table w-100 mt-10">
        <tr>
            <th class="w-50">Payment Method</th>
            <th class="w-50">Shipping Method</th>
        </tr>
        <tr>
            <td>Cash On Delivery</td>
            <td>Free Shipping - Free Shipping</td>
        </tr>
    </table>
</div>
<div class="table-section bill-tbl w-100 mt-10">
    <table class="table w-100 mt-10">
        <tr>
            <th class="w-50">SKU</th>
            <th class="w-50">Product Name</th>
            <th class="w-50">Price</th>
            <th class="w-50">Qty</th>
            <th class="w-50">Subtotal</th>
            <th class="w-50">Tax Amount</th>
            <th class="w-50">Grand Total</th>
        </tr>
        <tr align="center">
            <td>M101</td>
            <td>Andoid Smart Phone</td>
            <td>$500.2</td>
            <td>3</td>
            <td>$1500</td>
            <td>$50</td>
            <td>$1550.20</td>
        </tr>
        <tr align="center">
            <td>M102</td>
            <td>Andoid Smart Phone</td>
            <td>$250</td>
            <td>2</td>
            <td>$500</td>
            <td>$50</td>
            <td>$550.00</td>
        </tr>
        <tr align="center">
            <td>T1010</td>
            <td>Andoid Smart Phone</td>
            <td>$1000</td>
            <td>5</td>
            <td>$5000</td>
            <td>$500</td>
            <td>$5500.00</td>
        </tr>
        <tr>
            <td colspan="7">
                <div class="total-part">
                    <div class="total-left w-85 float-left" align="right">
                        <p>Sub Total</p>
                        <p>Tax (18%)</p>
                        <p>Total Payable</p>
                    </div>
                    <div class="total-right w-15 float-left text-bold" align="right">
                        <p>$7600</p>
                        <p>$400</p>
                        <p>$8000.00</p>
                    </div>
                    <div style="clear: both;"></div>
                </div> 
            </td>
        </tr>
    </table>
   
</body> -->

</html>