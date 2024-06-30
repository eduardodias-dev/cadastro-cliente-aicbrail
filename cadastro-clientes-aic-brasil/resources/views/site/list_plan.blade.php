@extends('templates.site')
@section('title', 'AIC Brasil - Planos')
@section('content')

<main id="main mt-5">
      <section id="pricing" class="pricing">
        <div class="container" data-aos="fade-up">

          <div class="section-title">
            <h2>Planos Assistência 24h</h2>
          </div>

          <div class="row justify-content-center">
            @foreach($planos as $plano)
              <div class="col-lg-4 col-md-6 " data-aos="zoom-im" data-aos-delay="100">
                <div class="box">
                  <h3>{{$plano->nome}}</h3>
                  <h4><sup>R$</sup>{{getValorEmReal($plano->preco)}}<span> / mês</span></h4>
                  <div class="btn-wrap">
                    <a href="{{route('site.comprar_plano', ['id_plano' => $plano->id])}}" class="btn-buy">Quero esse</a>
                  </div>
                </div>
              </div>
            @endforeach
          </div>

          <div class="section-title mt-5" id="planos_juridico">
            <h2>Planos Assistência Jurídica 24h</h2>
          </div>

          <div class="row justify-content-center">
            @foreach($planosJuridicos as $planoJuridico)
              <div class="col-lg-4 col-md-6" data-aos="zoom-im" data-aos-delay="100">
                <div class="box">
                  <h3>{{$planoJuridico->nome}}</h3>
                  <h4><sup>R$</sup>{{getValorEmReal($planoJuridico->preco)}}<span> / mês</span></h4>
                  <div class="btn-wrap">
                    <a href="{{route('site.comprar_plano', ['id_plano' => $planoJuridico->id])}}" class="btn-buy">Quero esse</a>
                  </div>
                </div>
              </div>
            @endforeach
          </div>

        </div>
      </section>
      <a href="https://wa.me/5508003482342?text=Quero%20saber%20mais%20sobre%20a%20AIC%20Brasil%20Assistência%2024h" data-bs-toggle="tooltip" data-bs-placement="top" id="botao_whatsapp" title="Contato no Whatsapp" target="_blank" >
          <i style="margin-top:10px; font-size: 40px;" class="bx bxl-whatsapp"></i>
      </a>
      <button id="botao_doacao" data-bs-toggle="tooltip" data-bs-placement="top" title="Faça uma doação">
          <i style="margin-top:10px; font-size: 40px;" class="bx bx-donate-heart"></i>
      </button>
</main><!-- End #main -->

@endsection
