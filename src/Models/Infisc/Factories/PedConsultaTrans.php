<?php

namespace NFePHP\NFSe\Models\Infisc\Factories;

use NFePHP\NFSe\Models\Infisc\Factories\Factory;

class PedConsultaTrans extends Factory
{
    public function render(
        $versao,
        $CNPJ,
        $chave_nfse
    ) {
        $xsd = 'SchemaCaxias-NFSe';
        $method = "pedConsultaTrans";
        $content = "<$method versao=\"1.0\">";
        $content .= "<CNPJ>$CNPJ</CNPJ>";
        $content .= "<chvAcessoNFS-e>$chave_nfse</chvAcessoNFS-e>";
        $content .= "</$method>";
        
        $body = \NFePHP\Common\Signer::sign(
            $this->certificate,
            $content,
            $method,
            '',
            $this->algorithm,
            [false,false,null,null]
        );
        $this->validar($versao, $body, 'Infisc', $xsd, '');
        
        return $body;
    }
}
