<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</head>

<body style="background:#e6e6e6; height:100%;" class="m-auto d-flex align-items-center justify-content-center">


<div class="card m-4 d-flex justify-content-center" style="    width: 50%;
    height: 54vh;">


    <div class="card-body align-items-center mx-4 justify-content-center">
        <div class="justify-content-center m-auto align-items-center">

            <img style="width:65%;" class="justify-content-center mx-auto d-flex" src="https://crm-payment.queleadscrm.com/assets/thank_you.jpg" />


        </div>
        <div class="align-items-center d-flex" style="font-weight:bold;">

            {{-- Company Name: {{ $company_name }}
            Email: {{ $email }} --}}
            <div class="m-auto">
                <p>Email: {{ $email }}</p>

            </div>
           
        </div><br>
        <div class="m-auto">

            <p class="m-auto d-flex justify-content-center" style="font-weight:bold">Thank you for your upgrading to {{ $package }} {{ $interval.'ly' }} subscription.</p>



        </div>

    </div>
</div>

    
</body>

</html>

<style>
    html{
        height:100vh;
    }
</style>