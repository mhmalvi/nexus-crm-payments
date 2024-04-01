<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous">
    </script>
</head>

<body style="background:#e6e6e6;">




    <div class="card" style="">


        <div class="card-body" style="align-items:center; margin:10%; padding:4%; justify-content:center;">
            <div style="justify-content:center; margin:auto; align-items:center; ">


                <img style="width:80%;justify-content:center;margin:auto;display:flex;"


                    src="https://crm-payment.queleadscrm.com/assets/thank_you.jpg" />


            </div>
            <div class="align-items-center d-flex" style="font-weight:bold; display:flex; align-items:center;">

                {{-- Company Name: {{ $company_name }}
            Email: {{ $email }} --}}
                <div class="m-auto">
                    <p>Email: {{ $email }}</p>
                    {{-- <p>Email: a@a.com</p> --}}


                </div>

            </div><br>
            <div class="m-auto">

                <p class="m-auto d-flex justify-content-center" style="font-weight:bold">Thank you for your upgrading to {{ $package }} {{ $interval.'ly' }} subscription.</p>
                {{-- <p class="m-auto d-flex justify-content-center" style="font-weight:bold">Thank you for your upgrading to
                    fgfd hvfhh subscription.</p> --}}




            </div>

        </div>

    </div>
</body>
<div style="top:100%; left:50%; position:absolute; transform: translate(-50%, 0);">

    <p>© 2024 Quadque Technologies. All Rights
        Reserved.</p>

</div>

</html>

<style>
    html {

    }

    .card {
        justify-content: center;
        width: 36%;
        position:absolute;
        transform:translate(-50%,-50%);
        height: 60%;
        top:50%;
        left:50%;

    }
</style>
