<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class EnvioEmailContaBancaria extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    private $caminhoArquivoLogo;
    private $subconta;
    private $endereco;
    public function __construct($subconta, $endereco)
    {
        //
        $this->caminhoArquivoLogo = storage_path("app".DIRECTORY_SEPARATOR."public".DIRECTORY_SEPARATOR."LOGO-AIC-BANK.png");
        $this->subconta = $subconta;
        $this->endereco = $endereco;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $obj = $this->from('noreply@aicbrasill.com.br','Não Responda');
        $obj->subject("Bem-Vindo ao AIC BANK!")
                ->view('templates.email_contabancaria')
                ->bcc(['eduardo.dias092@outlook.com'])
                ->with([
                    'caminhoArquivoLogo' => $this->caminhoArquivoLogo,
                    'subconta' => $this->subconta,
                    'endereco' => $this->endereco
                ]);
        return $obj;
    }
}
