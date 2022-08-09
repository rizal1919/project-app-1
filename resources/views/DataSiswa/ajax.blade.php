<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>

    <title>Document</title>
    
</head>
<body>
    <div class="form-group my-5 col-5 d-flex justify-content-center">
        <form action="">
            @csrf
            <input type="text" class="form-control" autocomplete="off" name="nama_siswa" id="nama_siswa" placeholder="nama" autofocus>
            <div id="nama"></div>
            <input type="text" class="form-control mt-3" autocomplete="off" name="ktp" id="ktp" placeholder="ktp" autofocus>
            <div id="noktp"></div>
        </form>
    </div>
    
    <script>
        $(document).ready(function(){
    
        
            $('#nama_siswa').on('keyup', function(){
                var value = $(this).val();
                $.ajax({
                    url:"{{ route('search') }}",
                    type:"GET",
                    data:{'nama_siswa':value},
                    success:function(data){

                        $('#nama').html(data);
                        
                    }
                });
            });


            $(document).on('click', '#n', function(){
                var value = $(this).text();
                $("#nama_siswa").val(value);
                $('#nama').html('');
            });

            $('#ktp').on('keyup', function(){
                var value = $(this).val();
                $.ajax({
                    url:"{{ route('ktp') }}",
                    type:"GET",
                    data:{'ktp':value},
                    success:function(data){

                        $('#noktp').html(data);
                        
                    }
                });
            });


            $(document).on('click', '#k', function(){
                var value = $(this).text();
                $("#ktp").val(value);
                $('#noktp').html('');
            });



        });
    </script>
</body>
</html>