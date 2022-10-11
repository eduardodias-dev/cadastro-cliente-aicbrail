<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Laravel</title>

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@200;600&display=swap" rel="stylesheet">
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css">
        <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.12.1/css/jquery.dataTables.css">
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.1/jquery.min.js" integrity="sha512-aVKKRRi/Q/YV+4mjoKBsE4x3H+BkegoM/em46NNlCqNTmUYADjBbeNefNxYV7giUp0VxICtqdrbqU7iVaeZNXA==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
        <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.12.1/js/jquery.dataTables.js"></script>

    </head>
    <body>
        <main class="container">
            <h1>Planos</h1>

            @if (isset($plans) && count($plans) > 0)
                <div class="table-responsive">
                    <table class="table table-striped table-bordered" id="table-planos" class="display">
                        <thead>
                        <tr class="table-info">
                            <th>Id</th>
                            <th>Id GalaxPay</th>
                            <th>Nome</th>
                            <th>Ações</th>
                        </tr>
                        </thead>
                        <tbody>
                            @foreach ($plans as $plan)
                                <tr>
                                    <td>{{$plan['myId']}}</td>
                                    <td>{{$plan['galaxPayId']}}</td>
                                    <td>{{$plan['name']}}</td>

                                    <td>
                                        <form action="{{route('plans.add')}}" method="POST">
                                            @csrf
                                            <input type="hidden" name="galaxPayId" value="{{$plan['galaxPayId']}}" />
                                            <input type="hidden" name="name" value="{{$plan['name']}}" />

                                            <button type="submit" class="btn btn-sm btn-outline-primary ml-2">Adicionar à base</button>
                                        </form>
                                        <form action="{{route('plans.activate')}}" method="POST">
                                            @csrf
                                            <input type="hidden" name="galaxPayId" value="{{$plan['galaxPayId']}}" />

                                            <button type="submit" class="btn btn-sm btn-outline-success ml-2">Ativar</a>
                                        </form>
                                    </td>

                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

            @endif
        </main>
        <script>
            $(document).ready( function () {
                $('#table-planos').DataTable();
            } );
        </script>
    </body>
</html>
