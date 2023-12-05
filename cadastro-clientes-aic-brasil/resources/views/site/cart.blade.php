@extends('templates.site')
@section('title', 'AIC Brasil - Carrinho')

@section('content')
    <div class="container">
        @php
            $cart = session('carrinho');
            $total = 0;
            if(isset($cart))
                foreach($cart as $item){
                    $total += $item['valor_calculado'];
                }
            else
                $cart = [];
        @endphp
        <h1>Carrinho</h1>
            <table class="table">
                <thead>
                    <tr>
                        <th>Plano</th>
                        <th>Titular</th>
                        <th>Valor total</th>
                        <th></th>
                    </tr>
                </thead>
                @if(count($cart) > 0)
                    <tbody>
                        @foreach($cart as $item)
                        <tr>
                            <td>{{ $planos[array_search($item['plan_id'], array_column($planos, 'id'))]['nome'] }}</td>
                            <td>{{ $item['nome'] }}</td>
                            <td>{{ getValorEmReal($item['valor_calculado']) }}</td>
                            <td>
                                <form action="{{ route('cart.remove') }}" method="POST">
                                    @csrf
                                    <input type="hidden" name="plan_id" value="{{ $item['plan_id'] }}">
                                    <button type="submit" class="btn btn-danger">Remover</button>
                                </form>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                    <tfoot>
                        <tr class="table-secondary">
                            <td colspan="2"><b>Total</b></td>
                            <td>{{ getValorEmReal($total) }}</td>
                            <td></td>
                        </tr>
                    </tfoot>
                @else
                    <tbody>
                        <tr>
                            <td colspan="4" class="table-secondary"><h4>Não há itens no carrinho</h4></td>
                        </tr>
                    </tbody>
                @endif
            </table>
            @if(count($cart) > 0)
                <a href="{{ route('cart.clear') }}" class="btn btn-secondary">Remover Tudo</a>
                <form action="{{ route('checkout.confirm') }}" method="GET" style="display: inline-block">
                    @csrf
                    <button type="submit" class="btn btn-primary">Prosseguir ao Checkout</button>
                </form>
                <a href="{{ route('planos') }}" class="btn btn-success">Continuar comprando</a>
            @else
                <a href="{{ route('planos') }}" class="btn btn-success">Comprar um plano</a>
            @endif
        </div>

        <a href="https://wa.me/5508003482342?text=Quero%20saber%20mais%20sobre%20a%20AIC%20Brasil%20Assistência%2024h" data-bs-toggle="tooltip" data-bs-placement="top" id="botao_whatsapp" title="Contato no Whatsapp" target="_blank" >
            <i style="margin-top:10px; font-size: 40px;" class="bx bxl-whatsapp"></i>
        </a>
        <button id="botao_doacao" data-bs-toggle="tooltip" data-bs-placement="top" title="Faça uma doação">
            <i style="margin-top:10px; font-size: 40px;" class="bx bx-donate-heart"></i>
        </button>
    </div>
@endsection
