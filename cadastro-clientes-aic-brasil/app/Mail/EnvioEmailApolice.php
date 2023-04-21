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
    private $enviarApolice;
    public function __construct($assinatura, $caminhoArquivo, $adicionais, $enviarApolice = 0)
    {
        //
        $this->assinatura = $assinatura;
        $this->caminhoArquivo = $caminhoArquivo;
        $this->adicionais = $adicionais;
        $this->caminhoArquivoLogo = storage_path('app\public\LOGO-AIC-BRASIL.ico');
        $this->enviarApolice = $enviarApolice;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $obj = $this->from('noreply@aicbrasill.com.br','Não Responda');
        if($this->enviarApolice == 0){
            $obj->subject("Bem-Vindo à AIC BRASIL!")
                ->view('templates.email')
                ->with([
                    'assinatura' => $this->assinatura,
                    'adicionais' => $this->adicionais,
                    'caminhoArquivoLogo' => $this->caminhoArquivoLogo
                ]);
        }
        else
        {
            $obj->subject("Pagamento Recebido - AIC BRASIL")
                ->view('templates.email_anexo')
                ->with([
                    'assinatura' => $this->assinatura,
                    'adicionais' => $this->adicionais,
                    'caminhoArquivoLogo' => $this->caminhoArquivoLogo
                ])
                ->attach($this->caminhoArquivo);
        }

        return $obj;
    }
}
