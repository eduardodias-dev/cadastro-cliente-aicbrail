@extends('templates.index')
@section('title', 'Visitas')

@section('content')
    <div class="container-fluid">
        <ul class="nav nav-tabs" id="myTab" role="tablist">
            <li class="nav-item" role="presentation">
              <button class="nav-link active" id="tab-visitas" data-toggle="tab" data-target="#pane-visitas" type="button" role="tab" aria-controls="pane-visitas" aria-selected="true">Visitas</button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link" id="tab-imoveis" data-toggle="tab" data-target="#pane-imoveis" type="button" role="tab" aria-controls="pane-imoveis" aria-selected="true">Imóveis</button>
            </li>
        </ul>
        <div class="tab-content" id="myTabContent">
            <div class="tab-pane fade show active" id="pane-visitas" role="tabpanel" aria-labelledby="home-tab">
                @include("visitas.partials.tab-visitas")
            </div>
            <div class="tab-pane fade" id="pane-imoveis" role="tabpanel" aria-labelledby="profile-tab">
                @include("visitas.partials.tab-imoveis")
            </div>
        </div>
    </div>
@endsection
