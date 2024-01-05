<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class EmailBoasVindas extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    private $caminhoArquivo;
    private $pacote;
    private $caminhoArquivoLogo;
    public function __construct($pacote)
    {
        //
        $this->pacote = $pacote;
        $this->caminhoArquivoLogo = storage_path('app/public/LOGO-AIC-BRASIL.ico');
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $obj = $this->from('noreply@aicbrasill.com.br','Não Responda')
                ->subject("Bem-Vindo à AIC BRASIL!")
                ->view('templates.boasvindas')
                ->with([
                    'pacote' => $this->pacote,
                    'caminhoArquivoLogo' => $this->caminhoArquivoLogo
                ]);


        return $obj;
    }
}
