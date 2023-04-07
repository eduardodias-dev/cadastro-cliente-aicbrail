<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class EnvioEmailApolice extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    private $caminhoArquivo;
    private $assinatura;
    private $adicionais;
    private $caminhoArquivoLogo;
    public function __construct($assinatura, $caminhoArquivo, $adicionais)
    {
        //
        $this->assinatura = $assinatura;
        $this->caminhoArquivo = $caminhoArquivo;
        $this->adicionais = $adicionais;
        $this->caminhoArquivoLogo = storage_path('app\public\LOGO-AIC-BRASIL.ico');
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->from('noreply@aicbrasill.com.br','Não Responda')
                    ->subject("Bem-Vindo à AIC BRASIL!")
                    ->view('templates.email')
                    ->with([
                        'assinatura' => $this->assinatura,
                        'adicionais' => $this->adicionais,
                        'caminhoArquivoLogo' => $this->caminhoArquivoLogo
                    ])
                    ->attach($this->caminhoArquivo);
    }
}
