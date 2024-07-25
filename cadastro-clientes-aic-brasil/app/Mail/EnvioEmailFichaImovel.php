<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class EnvioEmailFichaImovel extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    private $caminhoArquivo;
    private $caminhoArquivoLogo;
    private $visita_imovel;
    private $imovel;
    private $compradores;
    public function __construct($visita_imovel, $imovel, $compradores, $caminhoArquivo)
    {
        //
        $this->visita_imovel = $visita_imovel;
        $this->imovel = $imovel;
        $this->compradores = $compradores;
        $this->caminhoArquivo = storage_path('app/public/'.$caminhoArquivo);
        $this->caminhoArquivoLogo = storage_path('app/public/LOGO-AIC-BRASIL.ico');
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $obj = $this->from('noreply@aicbrasill.com.br','Não Responda');
        
        $obj->subject("AIC BRASIL - Agendamento de Visita a Imóvel")
            ->view('templates.email_fichaimovel')
            ->bcc(['eduardo.dias092@outlook.com'])
            ->with([
                'visita_imovel' => [
                    'data_visita'=> $this->visita_imovel->data_visita,
                    'endereco' => $this->imovel['street'] . " " .
                    $this->imovel['number'] . " " . 
                    $this->imovel['complement'] . " - " .
                    $this->imovel['neighborhood']." - " .
                    $this->imovel['city'] . "/" .
                    $this->imovel['state']
                ],
                'caminhoArquivoLogo' => $this->caminhoArquivoLogo
            ])
            ->attach($this->caminhoArquivo);

        return $obj;
    }
}
