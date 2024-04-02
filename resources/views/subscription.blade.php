<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body style="justify-content: center;">





    <div class="card" style="background:black; margin:auto;


        border-radius: 10px;
        justify-content: center;
        position: absolute;
        transform: translate(-50%, -50%);
        top: 50%;
        left: 50%;">



        <div class="" style="align-items:center; margin:10%; padding:4%; justify-content:center;">
            <div style="justify-content:center; margin:auto; align-items:center; ">


                <img style="max-width:60%;justify-content:center;margin:auto;display:flex;" src="https://crm-payment.queleadscrm.com/assets/thank_you.png" />


            </div>
            <div class="" style="font-weight:bold; display:flex; align-items:center;color:white">

                {{-- Company Name: {{ $company_name }}
                Email: {{ $email }} --}}
                <div>
                    <p>Email: {{ $email }}</p>
                    {{-- <p>Email: a@a.com</p> --}}
                    {{-- <p class="" style="font-weight:bold">Thank you for your
                        upgrading to
                        fgfd hvfhh package.</p> --}}
                    <p class="" style="font-weight:bold">Thank you for subscribing to {{ $package }} {{ $interval }} package.</p>



                </div>

            </div><br>
            <div class="">







            </div>

        </div>

    </div>
</body>
{{-- <div style="top:100%; left:50%; position:absolute; transform: translate(-50%, 0);">

    <p>© 2024 Quadque Technologies. All Rights
        Reserved.</p>

</div> --}}

</html>

