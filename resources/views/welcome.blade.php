<!DOCTYPE html>
<html>
<head>
      <title>Weather</title>
      <meta charset="utf-8">
      <meta name="viewport" content="width=device-width, initial-scale=1">
      <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css">
      <link rel="stylesheet" type="text/css" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
      <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.5/css/select2.min.css" />
      <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
      <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js"></script>
      <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js"></script>
    <style type="text/css">

    body{
        /*background-image: url("https://png.pngtree.com/thumb_back/fw800/back_pic/00/02/90/11561bbfa232d68.jpg");*/
    }
        .container {
            width: 65%;
            margin: 100px auto;
        }
        .has-search .form-control-feedback {
            position: absolute;
            padding-left: 60%;
            padding-top: 5px;
            z-index: 2;
            display: block;
            width: 2.375rem;
            height: 2.375rem;
            line-height: 2.375rem;
            text-align: center;
            pointer-events: none;
            
        }
        .cor{
            font-size: 15px !important;
        }

        
    </style>

</head>
<body>
<div class="container">
    <div class="form-group has-search">
        <br>
        <h3 class="text-center" style="font-style:Times New Roman;">Find Your Weather</h3>
        <br>
        <span class="fa fa-search form-control-feedback"></span>
        <input style="height:50px;border-width:2px !important;" id="search" type="text" class="form-control" placeholder="Search City...">

       
        <div class="res border" style="display: none;"></div>
        
    </div>
</div>
<div class="container">
    <div class="row">
        <div class="col-4">
            <h3 id="city_name"></h3>
            <h4 id="city_weather"></h4>
            <span id="long"></span>
            <span id="lat"></sapan>
        </div>
        <div class="col-4">
            <img id="weather_img" style="height:100px; width:auto" class="mx-auto d-block">
            <h5 id="city_desc" class="text-center"></h5>
        </div>
    </div>
</div>
</body>
</html>

<script type="text/javascript">
    $(function(){  
    $("#search").keyup(function(){
        var ajsearch=$(this).val();
        if(ajsearch==''){
            $(".res").hide();
        }
        else{
         $(".res").show();   
        }
        $.ajax({ 
            url:"/api",
            method:'POST',
            dataType:'text',
            data:{
             _token: "{{ csrf_token() }}",
             search:ajsearch
            },
            success:function(data){
                $(".res").html(data);
            }
        });
    
    });
    });
    
    $(document).on('click', '.hov', function () {
        $(".hov").hide();
        var city=$(this).attr('id');
        $("#search").val(city);
        $.ajax({ 
            url:"/city",
            method:'POST',
            dataType:'json',
            data:{
             _token: "{{ csrf_token() }}",
             city:city
            },
            success:function(data){
                $("#city_name").html(data[0].wcity_name);
                $("#city_name").append(" ,"+data[0].country);
                $("#city_desc").html(data[0].wcity_desc);
                $("#city_weather").html(data[0].wcity_temp+'<sup>o</sup>C');
                $("#long").html("<span class='cor'>Long: </span>"+data[0].long);
                $("#lat").html("<span class='cor'>Lat: </span>"+data[0].lat);


                $("#weather_img").attr('src',data[0].wcity_img);
                
            }
        });

    });
    
</script>