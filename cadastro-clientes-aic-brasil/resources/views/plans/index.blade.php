@extends('templates.index')
@section('title', 'Planos')

@section('content')
    <main class="container">
        <h1>Planos</h1>


        @if (isset($plans) && count($plans) > 0)
            <div class="table-responsive">
                <table class="table table-striped table-bordered" id="table-planos" class="display">
                    <thead>
                    <tr class="table-info">
                        <th>Id</th>
                        <th>Nome</th>
                        <th>Ativo</th>
                        <th>Ações</th>
                    </tr>
                    </thead>
                    <tbody>
                        @foreach ($plans as $plan)
                            <tr>
                                <td>{{$plan['id']}}</td>
                                <td>{{$plan['nome']}}</td>
                                <td>
                                    @if($plan['ativo'])
                                        <span style="color: blue;">Ativo</span>
                                    @else
                                        <span style="color: red;">Inativo</span>
                                    @endif
                                </td>
                                <td>
                                    @if(!$plan['ativo'])
                                        <form action="{{route('plans.activate')}}" method="POST" class="form-inline">
                                            @csrf
                                            <input type="hidden" name="galaxPayId" value="{{$plan['id_galaxpay']}}" />

                                            <button type="submit" class="btn btn-sm btn-outline-success ml-2">Ativar</a>
                                        </form>
                                    @else
                                        <form action="{{route('plans.deactivate')}}" method="POST" class="form-inline">
                                            @csrf
                                            <input type="hidden" name="galaxPayId" value="{{$plan['id_galaxpay']}}" />

                                            <button type="submit" class="btn btn-sm btn-outline-danger ml-2">Desativar</a>
                                        </form>
                                    @endif
                                </td>

                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

        @endif
        {{-- <h3>Adicionar Plano GalaxPay</h3>
        <form action="{{route('plans.add')}}" method="POST">
            @csrf
            <select name="galaxPayId" class="form-control ml-1" value="">
                @isset($galaxPayPlans)
                    @foreach($galaxPayPlans as $plan)
                        @if(!in_array($plan['galaxPayId'], $addedPlans))
                            <option value="{{$plan['galaxPayId']}}">{{$plan['galaxPayId']}} - {{$plan['name']}}</option>
                        @endif
                    @endforeach
                @endisset
            </select>
            <button type="submit" class="btn btn-sm btn-outline-primary ml-2">Adicionar à base</button>
        </form> --}}
    </main>
    <script>
        $(document).ready( function () {
            $('#table-planos').DataTable();
        } );
    </script>
@endsection
