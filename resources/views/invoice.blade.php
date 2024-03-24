<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-4bw+/aepP/YC94hEpVNVgiZdgIC5+VKNBQNGCHeKRQN+PtmoHDEXuppvnDJzQIu9" crossorigin="anonymous">

    <title>Document</title>
    <style>
        hr {
            border-top: 3px solid grey;
            width: 100%;
        }

        /* Dashed red border */

    </style>
</head>
<body>
    <div class="col-sm-12">
        <table class="table" style="width:100%;">
            <tbody>
                <tr>
                    <td>
                        {{-- <h1>fdgdfgdfg</h1> --}}
                        {{-- @dd(public_path('assets/logos/logo.png')) --}}

                        <img style="width:180px;" src="{{ public_path('assets/logos/itec.png')}}" />


                    </td>
                    <td style="align-items:end; float:right;">

                        <h1 style="align-items:end; float:right;">INVOICE</h1><br><br>

                        <p style="align-items:end; float:right;"><b>Queleads

                            </b></p><br>

                        <p style="align-items:end; float:right;">Level 1, 7</p><br>
                        <p style="align-items:end; float:right;">Greenfield Pde Bankstown

                        </p><br>
                        <p style="align-items:end; float:right;">New South Wales 2200
                        </p><br>
                        <p style="align-items:end; float:right;">Australia

                        </p><br>
                        <p style="align-items:end; float:right;">1300 535 922
                        </p><br>
                        {{-- <p style="align-items:end; float:right;">www.itecounsel.com
                        </p> --}}
                        <br>

                    </td>
                </tr>
            </tbody>
        </table>
        <hr>
        <div class="container-fluid">
            <div class="col-md-12">
                <div class="row">
                    <table class="table" style="width:100%;">
                        <tbody>
                            <tr style="">
                                <td style=" width:50%;">

                                    <p style="color:grey;">BILL TO</p>
                                    <p style="line-height:0.1%"><B>Queleads</B></p>
                                    <p style="line-height:19px"><B></B></p>

                                </td>
                                <td style="align-items:center; margin:auto;">


                                    <table style="align-items:center; margin:auto; justify-content:center;width:80%;">
                                        <tbody style="align-items:center; margin:auto; justify-content:center;">
                                            <tr>
                                                <td><b>Invoice Number</b></td>
                                                <td>:</td>
                                                <td style="padding-left:6%;">{{ $inv_no }}</td>

                                            </tr>
                                            <tr>
                                                <td><b>Company Name</b></td>
                                                <td>:</td>
                                                <td style="padding-left:6%;">{{$company_name}}</td>

                                            </tr>
                                            {{-- <tr>
                                                <td><b>Payment Due</b></td>
                                                <td>:</td>
                                                <td style="padding-left:6%;">July 3, 2023</td>

                                            </tr> --}}
                                            <tr style="background:#F3F3F3;">

                                                <td><b>Amount (AUD)</b></td>
                                                <td>:</td>
                                                <td style="padding-left:6%;"><b>${{$price}}</b></td>
                                            </tr>

                                        </tbody>
                                    </table>

                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

    </div>
    <table class="table" style="width:100%;">
        <thead style="background:#BD0000 ;">

            <tr style="color:white;">

                <td style="padding:6px;width: 40%;">Items</td>

                <td style="padding:6px;width: 25%;">Quantity</td>

                <td style="padding:6px;width: 34%;">Price</td>

                <td style="padding:6px;">Amount</td>
            </tr>
        </thead>
        <br>

        <tbody>
            <tr style="">
                <td style=" width:50%;">

                    <p><B>RPL</B></p>
                    {{-- <p style="">{{$course_name}}</p> --}}

                </td>
                <td style="align-items:center; margin:auto;width: 25%;">


                    <p>1</p>
                </td>
                <td style="align-items:center; margin:auto;width: 34%;">

                    <p>${{$price}}</p>
                </td>
                <td style="align-items:center; margin:auto;">
                    <p>${{$price}}</p>
                </td>

            </tr>
            <hr style="width:250%;">

            <tr style="">
                <td style=" width:50%;width: 40%;">

                </td>
                <td style="align-items:center; margin:auto;width: 25%;">


                </td>
                <td style="align-items:center; margin:auto;width: 34%;">

                    <p><b>Total:</b></p>

                </td>
                <td style="align-items:center; margin:auto;">
                    <p>${{$price}}</p>
                </td>

            </tr>
            {{-- <hr style="width:101%;margin-left:150%;">
            <tr style="">
                <td style=" width:50%;width: 40%;">

                </td>
                <td style="align-items:center; margin:auto;width: 25%;">


                </td>
                <td style="width: 34%;">

                    <p><b>Amount Due (AUD):</b></p>

                </td>
                <td style="align-items:center; margin:auto;">
                    <p><b>${{$price}}</b></p>


                </td>

            </tr> --}}


        </tbody>
    </table>
    <div>
        <p style="line-height:0.9px"><b>Notes / Terms</b></p>
        <p style="line-height:0.9px">Banking Details:</p>
        <p style="line-height:0.9px">Account Name: Education Group Australia</p>
        <p style="line-height:0.9px">BSB: 062339</p>
        <p style="line-height:0.9px">Account number: 11059035</p>
    </div> <br>
    {{-- <div style="align-items:center;width:100%;margin:auto; justify-content:center; display:flex; margin-top:60%; margin-bottom:0%">


        <p style="margin-left:45%; margin-right:40%;align-items:center;">GST included</p>

    </div> --}}

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-HwwvtgBNo3bZJJLYd8oVXjrBZt8cqVSpeBNS5n7C8IVInixGAoxmnlMuBnhbgrkm" crossorigin="anonymous"></script>

</body>
</html>

