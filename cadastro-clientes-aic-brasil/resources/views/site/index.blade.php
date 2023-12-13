@extends('templates.site')
@section('title', 'Bem-vindo à AIC Brasil!')
@section('content')



<!-- ======= Hero Section ======= -->
  <section id="hero" class="d-flex align-items-center">
    <div class="container position-relative" data-aos="fade-up" data-aos-delay="100">
      <div class="row justify-content-center">
        <div class="col-xl-7 col-lg-9 text-center">
          <h1>AiC BRASIL - ASSISTÊNCIA 24h</h1>
          <p>SEJA(M) BEM VINDO(A) AO GROUP AiC
            BRASIL!!!</p>
        </div>
      </div>
      <div class="text-center">
        <a href="#about" class="btn-get-started scrollto">Adquira já</a>
      </div>
    </div>
  </section><!-- End Hero -->

  <!-- Modal -->
  <div class="modal fade" id="myModal">
    <div class="modal-dialog">
      <div class="modal-content">

        <!-- Modal Body -->
        <div class="modal-body">
            <!-- Centered Icon -->
            <div class="center-icon">
              <!-- You can replace the below with your desired icon or use an icon library -->
              <img src="/site/img/logo_nova.png" height="80"></a>
            </div>
          <!-- Title -->
          <div class="modal-title-container">
          </div>

          <div class="clickable-boxes text-center">
              <!-- Clickable Boxes -->
              <!-- Box 1 -->
              <a href="{{route('create.bank.account', ['type' => 'pf'])}}" class="box-link-modal box-primary" target="_blank">
                Abertura de Conta PF 100% Digital
              </a>
              <!-- Box 2 -->
              <a href="{{route('create.bank.account', ['type' => 'pj'])}}" class="box-link-modal box-success"  target="_blank">
                Abertura de Conta PJ 100% Digital
              </a>
          </div>

          <div class="bottom-box mt-3">
              <!-- Subtitle -->
              <h5 class="modal-title text-center">Garantidora</h5>
              <!-- Smaller Subtitle with Arrow Icon -->
              <p class="small-text text-center">
                <span class="arrow-icon">&#8594;</span>
                Cota / Taxa de Condomínio / Consórcio
              </p>
          </div>

          <!-- Subtitle 2 -->
            <h5 class="subtitle">Crédito P/ Condomínio</h5>

            <!-- Unordered List -->
            <ul class="credit-list">
                <li>Fundo Reserva</li>
                <li>Fundo Obra</li>
                <li>Fundo Manutenção</li>
                <li>Fundo Investimento</li>
            </ul>

            <!-- Bottom Box -->
            <div class="bottom-box text-left">
                <p>
                    <span class="arrow-icon">&#8594;</span>
                    Consulte as Condições e Regulamento
                </p>
                <p>
                    <span class="arrow-icon">&#8594;</span>
                    Programa válido até 01/04/2024
                </p>
            </div>
        </div>
      </div>
    </div>
  </div>

  <main id="main">

    <!-- ======= About Section ======= -->
    <section id="about" class="about">
      <div class="container" data-aos="fade-up">

        <div class="section-title">
          <h2>Sobre nós</h2>
        </div>

        <div class="row content">
          <div class="col-lg-6">
            <p>
                A <b>AIC BRASIL</b> NASCEU JUNTAMENTE COM O SÉCULO XXI, OU SEJA,
                DESDE 01 DE JANEIRO DO ANO 2001, ESTAMOS PRESENTES NO
                MERCADO E, COM A DEVIDA CONSTITUIÇÃO LEGAL EMPRESARIAL. NA
                DATA DE 30/09/2014 DECIDIMOS, ENTÃO, EXPANDIR O(S) NEGÓCIO(S)
                E, ASSIM POR DIANTE, ATENDER A TODO ESTADO BRASILEIRO.
            </p>
            <p>
                CONTE COM UMA EMPRESA SÉRIA, IDÔNEA E ÉTICA, ATUANTE NO MERCADO. Ei psiu, <b>#VEM SER, AiC BANK | AiC BRASIL!</b>
            </p>
          </div>
          <div class="col-lg-6 pt-4 pt-lg-0">
            <p>
                AQUI ESTÁ ALGUMAS DAS VANTAGENS <b>AiC BRASIL GROUP</b>:
            </p>
            <ul>
              <li><i class="ri-check-double-line"></i> ASSISTÊNCIA 24h, 365 DIAS</li>
              <li><i class="ri-check-double-line"></i> CONTROLE TOTAL DA OPERAÇÃO</li>
              <li><i class="ri-check-double-line"></i> SISTEMA TOTALMENTE INTEGRADO VIA <b>APP</b></li>
              <li><i class="ri-check-double-line"></i> MONITIRAMENTO VIA, <b>SATÉLITE | GPS BLOCK</b></li>
              <li><i class="ri-check-double-line"></i> RELATÓRIO(S) MAPS, PERIÓDICO(S)</li>
            </ul>
            <a href="#" class="btn-learn-more">Saiba Mais</a>
          </div>
        </div>

      </div>
    </section><!-- End About Section -->

    <!-- ======= About Video Section ======= -->
    <section id="about-video" class="about-video">
      <div class="container" data-aos="fade-up">

        <div class="row">
            <div class="section-title">
                <h2>Uma empresa para a sua necessidade.</h2>
              </div>
        </div>

        <div class="row">
          <div class="col-lg-12 video-box align-self-baseline text-center" data-aos="fade-right" data-aos-delay="100">
            <img src="site/img/logo-video.jpeg" class="img-fluid" alt="">
            <a href="https://www.youtube.com/watch?v=-3BMZse2q6s" class="glightbox play-btn mb-4" data-vbtype="video" data-autoplay="true"></a>
          </div>
        </div>

      </div>
    </section><!-- End About Video Section -->
    <!-- ======= Cta Section ======= -->
    <section id="cta" class="cta">
      <div class="container" data-aos="zoom-in">
        <div class="text-center">
          <h3>Fale conosco, será um prazer te atender!</h3>
          <a class="cta-btn" href="https://wa.me/5508003482342?text=Quero%20saber%20mais%20sobre%20a%20AIC%20Brasil%20Assistência%2024h">Quero falar com um consultor</a>
        </div>
      </div>
    </section><!-- End Cta Section -->

    <!-- ======= Pricing Section ======= -->
    <section id="pricing" class="pricing">
      <div class="container" data-aos="fade-up">

        <div class="section-title">
          <h2>Planos</h2>
        </div>

        <div class="row">

          <div class="col-lg-4 col-md-6" data-aos="zoom-im" data-aos-delay="100">
            <div class="box">
              <div class="box-image mb-3">
                <img src="site/img/logo_veicular.jpeg" height="150" />
              </div>
              <h3>PROTEÇÃO VEICULAR</h3>
              <h4><sup>R$</sup>99,99<span> / mês</span></h4>
              <ul>
                <li>GPS Block</li>
                <li>GUINCHO - REBOQUE.24h</li>
              </ul>
              <div class="btn-wrap">
                <a href="{{route('site.comprar_plano', ['id_plano' => 18])}}" class="btn-buy">Quero esse</a>
              </div>
            </div>
          </div>

          <div class="col-lg-4 col-md-6 mt-4 mt-md-0" data-aos="zoom-in" data-aos-delay="100">
            <div class="box featured">
              <div class="box-beneficios">
                <a href="https://www.facebook.com/aicbrasil2009" class="box-link" target="_blank">
                    <div class="box-beneficio-quadrado">
                        <p class="titulo-box">
                            AIC BANK & IMOB.
                        </p>
                        <div class="conteudo-box">
                            <ul class="text-start mb-0">
                                <li>ADM. CONDOMÍNIOS</li>
                                <li>IMOBILIÁRIA</li>
                                <li>GARANTIDORA E SEGURADORA</li>
                            </ul>
                        </div>
                    </div>
                </a>
                <a href="https://www.facebook.com/AiCBRASILSAUDE" class="box-link" target="_blank">
                    <div class="box-beneficio-redondo mx-auto d-flex justify-content align-items-center">
                        <p class="titulo-box text-center my-auto flex-grow-1">
                            SAÚDE <br>
                             & <br>
                            CIA
                        </p>
                    </div>
                </a>
                <a href="http://www.companyhero.com/afiliados/JADSONLINC25" class="box-link" target="_blank">
                    <div class="box-beneficio-quadrado box-beneficio-ultimo">
                        <p class="titulo-box">
                            COWORKING
                        </p>
                        <div class="conteudo-box">
                            <ul class="text-start">
                                <li>ESCRITÓRIO VIRTUAL</li>
                                <li>ANTI-MULTAS (RECURSO)</li>
                                <li>REGISTRO DE MARCAS</li>
                            </ul>
                        </div>
                    </div>
                </a>
              </div>
            </div>
          </div>

          <div class="col-lg-4 col-md-6 mt-4 mt-lg-0" data-aos="zoom-in" data-aos-delay="100">
            <div class="box">
                <div class="box-image mb-3">
                    <img src="site/img/logo_juridico.png" height="150" />
                </div>
              <h3>ASSISTÊNCIA JURÍDICA 24h!</h3>
              <p class="text-center">A partir de:</p>
              <h4><sup>R$</sup>99,00<span> / mês</span></h4>
              <ul>
              </ul>
              <div class="btn-wrap">
                <a href="{{route('planos')."#planos_juridico"}}" class="btn-buy">Ver planos</a>
              </div>
            </div>
          </div>

        </div>

      </div>
    </section><!-- End Pricing Section -->

    <!-- ======= Propagandas ======= -->
    <div class="container" data-aos="fade-up">
      <div class="section-title">
        <h2>Mais Produtos</h2>
      </div>
      <div class="Images text-center">
        <div class="siema mySiema">
            <div class="image-siema img-responsive">
                <a href="https://www.facebook.com/AiCBRASIL.IES" target="_blank">
                    <img src="site/img/ad1.jpeg" height="650">
                </a>
            </div>
            <div class="image-siema img-responsive"><img src="site/img/ad2.jpeg"></div>
            <div class="image-siema img-responsive"><img src="site/img/ad4.jpeg"></div>
            <div class="image-siema img-responsive">
                <a href="https://www.facebook.com/aicbrasil2009" target="_blank">
                    <img src="site/img/ad5.jpeg">
                </a>
            </div>
            <div class="image-siema img-responsive"><img src="site/img/ad8.jpeg"></div>
            <div class="image-siema img-responsive"><img src="site/img/ad9.jpeg"></div>
            <div class="image-siema img-responsive"><img src="site/img/ad10.jpeg"></div>
            <div class="image-siema img-responsive"><img src="site/img/ad11.jpeg"></div>
            <div class="image-siema img-responsive"><img src="site/img/ad12.jpeg"></div>
            </div>
            <a href="#!" class="carousel-control-prev" control="true">‹</a>
            <a href="#!" class="carousel-control-next" control="true">›</a>
        </div>
    </div>
    <!-- ======= End Propagandas ======= -->


    <!-- ======= Frequently Asked Questions Section ======= -->
    <section id="faq" class="faq section-bg">
      <div class="container" data-aos="fade-up">

        <div class="section-title">
          <h2>Perguntas Frequentes</h2>
        </div>

        <div class="faq-list">
          <ul>
            <li data-aos="fade-up">
              <i class="bx bx-help-circle icon-help"></i> <a data-bs-toggle="collapse" class="collapse" data-bs-target="#faq-list-1">COMO ACIONO A ASSISTÊNCIA 24h <b>AiC BRASIL</b>?<i class="bx bx-chevron-down icon-show"></i><i class="bx bx-chevron-up icon-close"></i></a>
              <div id="faq-list-1" class="collapse show" data-bs-parent=".faq-list">
                <p>
                    0800 348 2342
                </p>
              </div>
            </li>

            <li data-aos="fade-up" data-aos-delay="100">
              <i class="bx bx-help-circle icon-help"></i> <a data-bs-toggle="collapse" data-bs-target="#faq-list-2" class="collapsed">EM QUAIS CIDADES A ASSISTÊNCIA 24h DA <b>AiC BRASIL</b> ESTÁ PRESENTE?<i class="bx bx-chevron-down icon-show"></i><i class="bx bx-chevron-up icon-close"></i></a>
              <div id="faq-list-2" class="collapse" data-bs-parent=".faq-list">
                <p>
                    99% DO BRASIL
                </p>
              </div>
            </li>

            <li data-aos="fade-up" data-aos-delay="200">
              <i class="bx bx-help-circle icon-help"></i> <a data-bs-toggle="collapse" data-bs-target="#faq-list-3" class="collapsed">QUANTOS GUINCHOS REBOQUE TENHO DIREITO, POR MÊS?<i class="bx bx-chevron-down icon-show"></i><i class="bx bx-chevron-up icon-close"></i></a>
              <div id="faq-list-3" class="collapse" data-bs-parent=".faq-list">
                <p>
                    ILIMITADO, EM CASO DE EVENTO-SINISTRO
                </p>
              </div>
            </li>

            <li data-aos="fade-up" data-aos-delay="300">
              <i class="bx bx-help-circle icon-help"></i> <a data-bs-toggle="collapse" data-bs-target="#faq-list-4" class="collapsed">QUANTAS BASES (PONTO DE APOIO) A ASSISTÊNCIA 24h <b>AiC BRASIL</b> TEM?<i class="bx bx-chevron-down icon-show"></i><i class="bx bx-chevron-up icon-close"></i></a>
              <div id="faq-list-4" class="collapse" data-bs-parent=".faq-list">
                <p>
                    5570 BASES E 27850 PONTO(S) DE APOIO
                </p>
              </div>
            </li>

            <li data-aos="fade-up" data-aos-delay="400">
                <i class="bx bx-help-circle icon-help"></i> <a data-bs-toggle="collapse" data-bs-target="#faq-list-5" class="collapsed">A AIC BRASIL, TEM APP?<i class="bx bx-chevron-down icon-show"></i><i class="bx bx-chevron-up icon-close"></i></a>
                <div id="faq-list-5" class="collapse" data-bs-parent=".faq-list">
                  <p>
                    SIM, É SÓ BAIXÁ-LO NO TEU Pc, TABLET OU TELEFONE.
                  </p>
                </div>
            </li>

            <li data-aos="fade-up" data-aos-delay="400">
              <i class="bx bx-help-circle icon-help"></i> <a data-bs-toggle="collapse" data-bs-target="#faq-list-6" class="collapsed">QUAL É O HORÁRIO DE FUNCIONAMENTO DA AiC BRASIL?<i class="bx bx-chevron-down icon-show"></i><i class="bx bx-chevron-up icon-close"></i></a>
              <div id="faq-list-6" class="collapse" data-bs-parent=".faq-list">
                <ul class="ul-resposta">
                    ✓ <b>COMERCIAL:</b> DAS 09h AS 21h<br>
                    ✓ <b>CRYPTO iMoB:</b> DAS 09h AS 17h<br>
                    ✓ <b>JURÍDICO:</b> DAS 09h AS 12h E, DAS 14h AS 17h<br>
                    ✓ <b>GUINCHO REBOQUE:</b> 24h/365 DIAS
                </ul>
              </div>
            </li>
          </ul>
        </div>

      </div>
    </section><!-- End Frequently Asked Questions Section -->

    <!-- ======= Contact Section ======= -->
    <section id="contact" class="contact">
      <div class="container" data-aos="fade-up">

        <div class="section-title">
          <h2>Contato</h2>
        </div>
        <div class="row mt-5">

          <div class="col-lg-4">
            <div class="info">
              <div class="address">
                <i class="bi bi-geo-alt"></i>
                <h4>Endereço:</h4>
                <p>AV. RAJA GABAGLIA, nº.1617 5º andar, LUXEMBURGO, B.HORIZONTE/MG, CEP nº.30380-435, BRASIL|BR.</p>
              </div>

              <div class="email">
                <i class="bi bi-envelope"></i>
                <h4>Email:</h4>
                <p>aicbrasill@gmail.com</p>
                <p>contato@aicbrasil-ies.com.br</p>
              </div>

              <div class="phone">
                <i class="bi bi-phone"></i>
                <h4>Tel.:</h4>
                <p>(31) 97348-2342</p>
                <p>0800.348.2342</p>
              </div>

            </div>

          </div>

          <div class="col-lg-8 mt-5 mt-lg-0">
            <iframe style="border:0; width: 100%; height: 300px;"src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3750.4299254177445!2d-43.96274068453904!3d-19.94841394403505!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0xa69798ff3f22ad%3A0x5d77e1965cf1c94d!2sAv.%20Raja%20Gab%C3%A1glia%2C%201617%20-%20Luxemburgo%2C%20Belo%20Horizonte%20-%20MG%2C%2030380-435!5e0!3m2!1spt-BR!2sbr!4v1675301377532!5m2!1spt-BR!2sbr" allowfullscreen loading="lazy" frameborder=0></iframe>
          </div>

        </div>

      </div>
    </section><!-- End Contact Section -->
    <a href="https://wa.me/5508003482342?text=Quero%20saber%20mais%20sobre%20a%20AIC%20Brasil%20Assistência%2024h" data-bs-toggle="tooltip" data-bs-placement="top" id="botao_whatsapp" title="Contato no Whatsapp" target="_blank" >
        <i style="margin-top:10px; font-size: 40px;" class="bx bxl-whatsapp"></i>
    </a>
    <button id="botao_doacao" data-bs-toggle="tooltip" data-bs-placement="top" title="Faça uma doação">
        <i style="margin-top:10px; font-size: 40px;" class="bx bx-donate-heart"></i>
    </button>
  </main><!-- End #main -->

@endsection
