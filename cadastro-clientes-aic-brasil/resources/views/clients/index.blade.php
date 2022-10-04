<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Laravel</title>

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@200;600&display=swap" rel="stylesheet">
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css">
    </head>
    <body>
        <main class="container">
            <h1>Clientes</h1>
            <h3>Filtro</h3>
            <form method="GET" class="form-inline">
                <label class="ml-2">Documento:</label>
                <input type="text" name="documents" class="form-control ml-1"/>

                <label class="ml-2">Status:</label>
                <select name="status" class="form-control ml-1">
                    <option value="">Selecione...</option>
                    <option value="active">Ativo</option>
                    <option value="inactive">Inativo</option>
                    <option value="delayed">Pagamento Atrasado</option>
                    <option value="withoutSubscriptionOrCharge">Não possui assinatura</option>
                </select>

                <label class="ml-2">Data Criação:</label>
                <input type="date" name="createdAtFrom" class="form-control ml-1" />

                <button type="submit" class="btn btn-outline-info ml-2">Filtrar</button>
            </form><br/>
            @if (count($clients) > 0)
                <table class="table table-responsive table-striped table-bordered">
                    <tr>
                        <th>Nome</th>
                        <th>Documento</th>
                        <th>Criado em</th>
                        <th>Status</th>
                        <th>Emails</th>
                        <th>Contatos</th>
                    </tr>
                    @foreach ($clients as $client)
                        <tr>
                            <td>{{$client['name']}}</td>
                            <td>{{$client['document']}}</td>
                            <td>{{$client['createdAt']}}</td>
                            <td>{{$client['status']}}</td>
                            <td>{{implode(', ', $client['emails'])}}</td>
                            <td>{{implode(', ', $client['phones'])}}</td>
                        </tr>
                    @endforeach
                </table>
            @else

            @endif
        </main>
    </body>
</html>
