<?php

namespace NFePHP\NFSe\Models\Infisc;

/**
 * Classe para a renderização dos RPS em XML
 * conforme o modelo ISSNET
 *
 * @category  NFePHP
 * @package   NFePHP\NFSe\Models\Infisc\RenderRPS
 * @copyright NFePHP Copyright (c) 2016
 * @license   http://www.gnu.org/licenses/lgpl.txt LGPLv3+
 * @license   https://opensource.org/licenses/MIT MIT
 * @license   http://www.gnu.org/licenses/gpl.txt GPLv3+
 * @author    Roberto L. Machado <linux.rlm at gmail dot com>
 * @link      http://github.com/nfephp-org/sped-nfse for the canonical source repository
 */

use NFePHP\Common\DOMImproved as Dom;
use NFePHP\NFSe\Models\Infisc\Rps;
use NFePHP\Common\Certificate;

class RenderRPS
{

    /**
     * @var DOMImproved
     */
    protected static $dom;

    /**
     * @var Certificate
     */
    protected static $certificate;

    /**
     * @var int
     */
    protected static $algorithm;

    public static function toXml($data, $algorithm = OPENSSL_ALGO_SHA1)
    {
        self::$algorithm = $algorithm;
        $xml = '';
        if (is_object($data)) {
            return self::render($data);
        } elseif (is_array($data)) {
            foreach ($data as $rps) {
                $xml .= self::render($rps);
            }
        }
        return $xml;
    }

    /**
     * Monta o xml com base no objeto Rps
     * @param Rps $rps
     * @return string
     */
    private static function render(Rps $rps)
    {
        self::$dom = new Dom('1.0', 'utf-8');
        $root = self::$dom->createElement('NFS-e');
        $infRPS = self::$dom->createElement('infNFSe');
        $infRPS->setAttribute("versao", "1.1");
        $identificacaoRps = self::$dom->createElement('Id');
        self::$dom->addChild(
            $identificacaoRps,
            'cNFS-e',
            $rps->Id->cNFSe,
            true,
            "Numero Aleatório",
            true
        );
        self::$dom->addChild(
            $identificacaoRps,
            'mod',
            $rps->Id->mod,
            true,
            "Modelo do RPS",
            true
        );
        self::$dom->addChild(
            $identificacaoRps,
            'serie',
            $rps->Id->serie,
            true,
            "Série do RPS",
            true
        );
        self::$dom->addChild(
            $identificacaoRps,
            'nNFS-e',
            $rps->Id->nNFSe,
            true,
            "Número da nota",
            true
        );
        self::$dom->addChild(
            $identificacaoRps,
            'dEmi',
            $rps->Id->dEmi,
            true,
            "Data de emissão",
            true
        );
        self::$dom->addChild(
            $identificacaoRps,
            'hEmi',
            $rps->Id->hEmi,
            true,
            "Hora de emissão",
            true
        );
        self::$dom->addChild(
            $identificacaoRps,
            'tpNF',
            $rps->Id->tpNF,
            true,
            "Tipo de nota",
            true
        );
        self::$dom->addChild(
            $identificacaoRps,
            'refNF',
            $rps->Id->refNF,
            true,
            "Chave",
            true
        );
        self::$dom->addChild(
            $identificacaoRps,
            'tpEmis',
            $rps->Id->tpEmis,
            true,
            "Tipo de emissão",
            true
        );
        self::$dom->addChild(
            $identificacaoRps,
            'ambienteEmi',
            $rps->Id->ambienteEmi,
            true,
            "Ambiente",
            true
        );
        self::$dom->addChild(
            $identificacaoRps,
            'formaEmi',
            $rps->Id->formaEmi,
            true,
            "Forma de emissão",
            true
        );
        self::$dom->addChild(
            $identificacaoRps,
            'empreitadaGlobal',
            $rps->Id->empreitadaGlobal,
            true,
            "Empreitada Global",
            true
        );

        self::$dom->addChild(
            $identificacaoRps,
            'cLocPrestacao',
            $rps->Id->cLocPrestacao,
            true,
            "Local da prestação do serviço",
            true
        );

        self::$dom->addChild(
            $identificacaoRps,
            'cPaisPrestacao',
            $rps->Id->cPaisPrestacao,
            true,
            "Código do país onde ocorreu a prestação do serviço",
            true
        );

        self::$dom->appChild($infRPS, $identificacaoRps, 'Adicionando tag IdentificacaoRPS');

        $prestador = self::$dom->createElement('prest');
        self::$dom->addChild(
            $prestador,
            'CNPJ',
            $rps->prest->CNPJ,
            true,
            "CNPJ",
            true
        );
        self::$dom->addChild(
            $prestador,
            'xNome',
            $rps->prest->xNome,
            true,
            'Razão Social',
            false
        );
        self::$dom->addChild(
            $prestador,
            'IM',
            $rps->prest->IM,
            true,
            'Inscrição Municipal',
            false
        );
        self::$dom->addChild(
            $prestador,
            'xEmail',
            $rps->prest->xEmail,
            false,
            'Email',
            false
        );
        self::$dom->addChild(
            $prestador,
            'xSite',
            $rps->prest->xSite,
            false,
            'Site',
            false
        );

        $endereco = self::$dom->createElement('end');
        self::$dom->addChild(
            $endereco,
            'xLgr',
            $rps->prest->end->xLgr,
            true,
            'Logradouro',
            false
        );
        self::$dom->addChild(
            $endereco,
            'nro',
            $rps->prest->end->nro,
            true,
            'Numero',
            false
        );
        self::$dom->addChild(
            $endereco,
            'xCpl',
            $rps->prest->end->xCpl,
            true,
            'Complemento',
            false
        );
        self::$dom->addChild(
            $endereco,
            'xBairro',
            $rps->prest->end->xBairro,
            true,
            'Bairro',
            false
        );
        self::$dom->addChild(
            $endereco,
            'cMun',
            $rps->prest->end->cMun,
            true,
            'Cidade',
            false
        );
        self::$dom->addChild(
            $endereco,
            'xMun',
            $rps->prest->end->xMun,
            true,
            'Cidade',
            false
        );
        self::$dom->addChild(
            $endereco,
            'UF',
            $rps->prest->end->UF,
            true,
            'Estado',
            false
        );
        self::$dom->addChild(
            $endereco,
            'CEP',
            $rps->prest->end->CEP,
            true,
            'Cep',
            false
        );
        self::$dom->addChild(
            $endereco,
            'cPais',
            $rps->prest->end->cPais,
            true,
            'País',
            false
        );
        self::$dom->addChild(
            $endereco,
            'xPais',
            $rps->prest->end->xPais,
            true,
            'País',
            false
        );

        self::$dom->appChild($prestador, $endereco, 'Adicionando tag Endereco do Prestador');
        //Fim endereço

        self::$dom->addChild(
            $prestador,
            'fone',
            $rps->prest->fone,
            false,
            'Telefone',
            false
        );
        self::$dom->addChild(
            $prestador,
            'fone2',
            $rps->prest->fone2,
            false,
            'Telefone Alternativo',
            false
        );
        self::$dom->addChild(
            $prestador,
            'IE',
            $rps->prest->IE,
            false,
            'Inscrição Estadual',
            false
        );
        self::$dom->addChild(
            $prestador,
            'regimeTrib',
            $rps->prest->regimeTrib,
            true,
            'Regime',
            false
        );
        self::$dom->appChild($infRPS, $prestador, 'Adicionando tag Prestador em infRPS');

        $tomador = self::$dom->createElement('TomS');
        if (!empty($rps->TomS->CNPJ)) {
            self::$dom->addChild(
                $tomador,
                'CNPJ',
                $rps->TomS->CNPJ,
                true,
                'Tomador CNPJ',
                false
            );
        } else {
            self::$dom->addChild(
                $tomador,
                'CPF',
                $rps->TomS->CPF,
                true,
                'Tomador CPF',
                false
            );
        }
        self::$dom->addChild(
            $tomador,
            'xNome',
            $rps->TomS->xNome,
            true,
            'Razao Social',
            false
        );

        $ender = self::$dom->createElement('ender');
        self::$dom->addChild(
            $ender,
            'xLgr',
            $rps->TomS->ender->xLgr,
            true,
            'Logradouro',
            false
        );
        self::$dom->addChild(
            $ender,
            'nro',
            $rps->TomS->ender->nro,
            true,
            'Numero',
            false
        );
        self::$dom->addChild(
            $ender,
            'xCpl',
            $rps->TomS->ender->xCpl,
            true,
            'Complemento',
            false
        );
        self::$dom->addChild(
            $ender,
            'xBairro',
            $rps->TomS->ender->xBairro,
            true,
            'Bairro',
            false
        );
        self::$dom->addChild(
            $ender,
            'cMun',
            $rps->TomS->ender->cMun,
            true,
            'Cidade',
            false
        );
        self::$dom->addChild(
            $ender,
            'xMun',
            $rps->TomS->ender->xMun,
            true,
            'Cidade',
            false
        );
        self::$dom->addChild(
            $ender,
            'UF',
            $rps->TomS->ender->UF,
            true,
            'Estado',
            false
        );
        self::$dom->addChild(
            $ender,
            'CEP',
            $rps->TomS->ender->CEP,
            true,
            'Cep',
            false
        );
        self::$dom->addChild(
            $ender,
            'cPais',
            $rps->TomS->ender->cPais,
            true,
            'País',
            false
        );
        self::$dom->addChild(
            $ender,
            'xPais',
            $rps->TomS->ender->xPais,
            true,
            'País',
            false
        );

        self::$dom->appChild($tomador, $ender, 'Adicionando tag Endereco do Prestador');
        //Fim endereço tomador
        self::$dom->appChild($infRPS, $tomador, 'Adicionando tag Tomador em infRPS');

        //Transportadora
        if (isset($rps->transportadora)) {
            $transportadora = self::$dom->createElement('transportadora');
            self::$dom->addChild(
                $transportadora,
                'xNomeTrans',
                $rps->transportadora->xNomeTrans,
                true,
                'Razao Social',
                false
            );
            self::$dom->addChild(
                $transportadora,
                'xCpfCnpjTrans',
                $rps->transportadora->xCpfCnpjTrans,
                false,
                'CPF ou CNPJ',
                false
            );
            self::$dom->addChild(
                $transportadora,
                'xInscEstTrans',
                $rps->transportadora->xInscEstTrans,
                false,
                'IE',
                false
            );
            self::$dom->addChild(
                $transportadora,
                'xPlacaTrans',
                $rps->transportadora->xPlacaTrans,
                false,
                'Placa',
                false
            );
            self::$dom->addChild(
                $transportadora,
                'xEndTrans',
                $rps->transportadora->xEndTrans,
                false,
                'Endereço',
                false
            );
            self::$dom->addChild(
                $transportadora,
                'cMunTrans',
                $rps->transportadora->cMunTrans,
                false,
                'Código Cidade',
                false
            );
            self::$dom->addChild(
                $transportadora,
                'xMunTrans',
                $rps->transportadora->xMunTrans,
                false,
                'Cidade',
                false
            );
            self::$dom->addChild(
                $transportadora,
                'xUfTrans',
                $rps->transportadora->xUfTrans,
                false,
                'UF',
                false
            );
            self::$dom->addChild(
                $transportadora,
                'cPaisTrans',
                $rps->transportadora->cPaisTrans,
                false,
                'País',
                false
            );
            self::$dom->addChild(
                $transportadora,
                'xPaisTrans',
                $rps->transportadora->xPaisTrans,
                false,
                'País',
                false
            );
            self::$dom->addChild(
                $transportadora,
                'vTipoFreteTrans',
                $rps->transportadora->vTipoFreteTrans,
                false,
                'Tipo frete',
                false
            );
            self::$dom->appChild($infRPS, $transportadora, 'Adicionando tag Transportadora em infRPS');
        }

        //Detalhamento dos serviços
        $rps->totalvISS = 0;
        $rps->totalvBCISS = 0;
        $rps->totalvSTISS = 0;
        $rps->totalvBCSTISS = 0;
        foreach ($rps->det as $d) {
            $det = self::$dom->createElement('det');
            self::$dom->addChild(
                $det,
                'nItem',
                $d->nItem,
                true,
                'Número do Item',
                false
            );

            //Serviço da NFS-e
            $serv = self::$dom->createElement('serv');
            self::$dom->addChild(
                $serv,
                'cServ',
                $rps->serv[$d->nItem]->cServ,
                true,
                'Código Municipal do serviço',
                false
            );
            self::$dom->addChild(
                $serv,
                'cLCServ',
                $rps->serv[$d->nItem]->cLCServ,
                true,
                'Código do Serviço',
                false
            );
            self::$dom->addChild(
                $serv,
                'xServ',
                $rps->serv[$d->nItem]->xServ,
                true,
                'Discriminação do Serviço',
                false
            );
            self::$dom->addChild(
                $serv,
                'localTributacao',
                $rps->serv[$d->nItem]->localTributacao,
                true,
                'Local tributação IBGE',
                false
            );
            self::$dom->addChild(
                $serv,
                'localVerifResServ',
                $rps->serv[$d->nItem]->localVerifResServ,
                true,
                'Local verificação do serviço',
                false
            );
            self::$dom->addChild(
                $serv,
                'uTrib',
                $rps->serv[$d->nItem]->uTrib,
                true,
                'Unidade',
                false
            );
            self::$dom->addChild(
                $serv,
                'qTrib',
                $rps->serv[$d->nItem]->qTrib,
                true,
                'Quantidade',
                false
            );
            self::$dom->addChild(
                $serv,
                'vUnit',
                $rps->serv[$d->nItem]->vUnit,
                true,
                'Valor unitário',
                false
            );
            self::$dom->addChild(
                $serv,
                'vServ',
                $rps->serv[$d->nItem]->vServ,
                true,
                'Valor do Serviço',
                false
            );
            self::$dom->addChild(
                $serv,
                'vDesc',
                $rps->serv[$d->nItem]->vDesc,
                true,
                'Desconto',
                false
            );
            self::$dom->addChild(
                $serv,
                'vBCISS',
                $rps->serv[$d->nItem]->vBCISS,
                false,
                'BaseISSQN',
                false
            );
            $rps->totalvBCISS += $rps->serv[$d->nItem]->vBCISS;
            self::$dom->addChild(
                $serv,
                'pISS',
                $rps->serv[$d->nItem]->pISS,
                false,
                'ISS',
                false
            );
            self::$dom->addChild(
                $serv,
                'vISS',
                $rps->serv[$d->nItem]->vISS,
                false,
                'Valor iss',
                false
            );
            $rps->totalvISS += $rps->serv[$d->nItem]->vISS;
            self::$dom->addChild(
                $serv,
                'vBCINSS',
                $rps->serv[$d->nItem]->vBCINSS,
                false,
                'Base INSS',
                false
            );
            self::$dom->addChild(
                $serv,
                'pRetINSS',
                $rps->serv[$d->nItem]->pRetINSS,
                false,
                'Retenção INSS',
                false
            );
            self::$dom->addChild(
                $serv,
                'vRetINSS',
                $rps->serv[$d->nItem]->vRetINSS,
                false,
                'Retenção INSS',
                false
            );
            self::$dom->addChild(
                $serv,
                'vRed',
                $rps->serv[$d->nItem]->vRed,
                false,
                'Valor redução ISS',
                false
            );
            self::$dom->addChild(
                $serv,
                'vBCRetIR',
                $rps->serv[$d->nItem]->vBCRetIR,
                false,
                'Retenção IR',
                false
            );
            self::$dom->addChild(
                $serv,
                'pRetIR',
                $rps->serv[$d->nItem]->pRetIR,
                false,
                '',
                false
            );
            self::$dom->addChild(
                $serv,
                'vRetIR',
                $rps->serv[$d->nItem]->vRetIR,
                false,
                '',
                false
            );
            self::$dom->addChild(
                $serv,
                'vBCCOFINS',
                $rps->serv[$d->nItem]->vBCCOFINS,
                false,
                'Base Cofins',
                false
            );
            self::$dom->addChild(
                $serv,
                'pRetCOFINS',
                $rps->serv[$d->nItem]->pRetCOFINS,
                false,
                'Retenção Cofins',
                false
            );
            self::$dom->addChild(
                $serv,
                'vRetCOFINS',
                $rps->serv[$d->nItem]->pRetCOFINS,
                false,
                '',
                false
            );
            self::$dom->addChild(
                $serv,
                'vBCCSLL',
                $rps->serv[$d->nItem]->vBCCSLL,
                false,
                'Base CSLL',
                false
            );
            self::$dom->addChild(
                $serv,
                'pRetCSLL',
                $rps->serv[$d->nItem]->pRetCSLL,
                false,
                '',
                false
            );
            self::$dom->addChild(
                $serv,
                'vRetCSLL',
                $rps->serv[$d->nItem]->vRetCSLL,
                false,
                '',
                false
            );
            self::$dom->addChild(
                $serv,
                'vBCPISPASEP',
                $rps->serv[$d->nItem]->vBCPISPASEP,
                false,
                '',
                false
            );
            self::$dom->addChild(
                $serv,
                'pRetPISPASEP',
                $rps->serv[$d->nItem]->pRetPISPASEP,
                false,
                '',
                false
            );
            self::$dom->addChild(
                $serv,
                'vRetPISPASEP',
                $rps->serv[$d->nItem]->vRetPISPASEP,
                false,
                '',
                false
            );

            self::$dom->addChild(
                $serv,
                'totalAproxTribServ',
                $rps->serv[$d->nItem]->totalAproxTribServ,
                false,
                '',
                false
            );

            self::$dom->addChild(
                $serv, // Dom Element
                'CSTPisCofins', // Name
                $rps->serv[$d->nItem]->CSTPisCofins, // Content
                true, // Obrigatorio
                'Código de Situação Tributária do PIS/COFINS (CST)', // Descricao
                true, // Force (se nao preenchido exibe aviso: Preenchimento obrigatorio)
            );

            self::$dom->addChild(
                $serv, // Dom Element
                'cNBS', // Name
                $rps->serv[$d->nItem]->cNBS, // Content
                true, // Obrigatorio
                'Código NBS correspondente ao serviço prestado', // Descricao
                true, // Force (se nao preenchido exibe aviso: Preenchimento obrigatorio)
            );

            self::$dom->appChild($det, $serv, 'Adicionando tag Endereco do Prestador');


            // IBS CBS de Envio:
            if (isset($rps->det[$d->nItem]->IBSCBS)) {

                $IBSCBS = self::$dom->createElement('IBSCBS');
                self::$dom->addChild(
                    $IBSCBS,
                    'finNFSe',
                    $rps->det[$d->nItem]->IBSCBS->finNFSe,
                    true,
                    'Indicador da finalidade da emissão de NFS-e 0 = NFS-e regular',
                    true
                );

                self::$dom->addChild(
                    $IBSCBS,
                    'indFinal',
                    $rps->det[$d->nItem]->IBSCBS->indFinal,
                    true,
                    'Indica operação de uso ou consumo pessoal. (art. 57), 0 = Não, 1 = Sim',
                    true
                );

                self::$dom->addChild(
                    $IBSCBS,
                    'cIndOp',
                    $rps->det[$d->nItem]->IBSCBS->cIndOp,
                    true,
                    'Código indicador da operação de fornecimento, conforme tabela: código indicador de operação',
                    true
                );

                if (isset($rps->det[$d->nItem]->IBSCBS->tpOper)) {
                    self::$dom->addChild(
                        $IBSCBS,
                        'tpOper',
                        $rps->det[$d->nItem]->IBSCBS->tpOper,
                        false,
                        'Tipo de Operação com Entes Governamentais ou outros serviços sobre bens imóveis.',
                        false
                    );
                }

                if (isset($rps->det[$d->nItem]->IBSCBS->gRefNFSe)) {
                    self::$dom->addChild(
                        $IBSCBS,
                        'gRefNFSe',
                        $rps->det[$d->nItem]->IBSCBS->gRefNFSe,
                        false,
                        'Grupo de NFS-e referenciadas.',
                        false
                    );
                }

                if (isset($rps->det[$d->nItem]->IBSCBS->tpEnteGov)) {
                    self::$dom->addChild(
                        $IBSCBS,
                        'tpEnteGov',
                        $rps->det[$d->nItem]->IBSCBS->tpEnteGov,
                        false,
                        'Tipo de ente governamental. Para administração pública direta e suas autarquias e fundações.',
                        false
                    );
                }

                self::$dom->addChild(
                    $IBSCBS,
                    'indDest',
                    $rps->det[$d->nItem]->IBSCBS->indDest,
                    true,
                    'A respeito do Destinatário dos serviços, 0 = destinatario é o proprio tomadar,  = destinatario não é o proprio tomador/adquirinte.',
                    true
                );

                if (isset($rps->det[$d->nItem]->IBSCBS->dest)) {
                    self::$dom->addChild(
                        $IBSCBS,
                        'dest',
                        $rps->det[$d->nItem]->IBSCBS->dest,
                        false,
                        'Informações relativas ao Destinatário, se diferente do tomador.',
                        false
                    );
                }

                if (isset($rps->det[$d->nItem]->IBSCBS->imovel)) {
                    self::$dom->addChild(
                        $IBSCBS,
                        'imovel',
                        $rps->det[$d->nItem]->IBSCBS->imovel,
                        false,
                        'Informações de operações relacionadas a bens imóveis, exceto obras.',
                        false
                    );
                }


                if (isset($rps->det[$d->nItem]->IBSCBS->valores)) {
                    // Informações relativas aos valores do serviço prestado para IBS e CBS
                    $IbsValores = self::$dom->createElement('valores');

                    if (isset($rps->det[$d->nItem]->IBSCBS->valores->gReeRepRes)) {
                        self::$dom->addChild(
                            $IbsValores,
                            'gReeRepRes',
                            $rps->det[$d->nItem]->IBSCBS->valores->gReeRepRes,
                            false,
                            'Informações relativas a valores incluídos neste documento e recebidos por motivo de estarem relacionadas a operações de terceiros, objeto de reembolso, repasse ou ressarcimento pelo recebedor, já tributados e aqui referenciados',
                            false
                        );
                    }

                    // Grupo de informações relacionados aos tributos IBS e CBS
                    $trib = self::$dom->createElement('trib');
                    $gIBSCBS = self::$dom->createElement('gIBSCBS');

                    self::$dom->addChild(
                        $gIBSCBS,
                        'CST',
                        $rps->det[$d->nItem]->IBSCBS->valores->trib->gIBSCBS->CST,
                        true,
                        'Código de Situação Tributária do IBS e da CBS',
                        true
                    );

                    self::$dom->addChild(
                        $gIBSCBS,
                        'cClassTrib',
                        $rps->det[$d->nItem]->IBSCBS->valores->trib->gIBSCBS->cClassTrib,
                        true,
                        'Código de Classificação Tributária do IBS e da CBS',
                        true
                    );

                    self::$dom->appChild($trib, $gIBSCBS, 'Adicionando tag gIBSCBS ao trib do valores do IBSCBS.');
                    self::$dom->appChild($IbsValores, $trib, 'Adicionando tag trib ao Valores do IBSCBS.');
                    self::$dom->appChild($IBSCBS, $IbsValores, 'Adicionando tag valores ao IBSCBS, dentro do det.');
                }

                self::$dom->appChild($det, $IBSCBS, 'Adicionando tag Endereco do Prestador');
            }


            //ISSST
            if (isset($rps->ISSST[$d->nItem])) {
                $ISSST = self::$dom->createElement('ISSST');
                self::$dom->addChild(
                    $ISSST,
                    'vRedBCST',
                    $rps->ISSST[$d->nItem]->vRedBCST,
                    false,
                    'Valor da redução da base de cálculo do ISSQN retido',
                    false
                );
                self::$dom->addChild(
                    $ISSST,
                    'vBCST',
                    $rps->ISSST[$d->nItem]->vBCST,
                    true,
                    'Valor da base de cálculo do ISSQN retido',
                    false
                );
                $rps->totalvBCSTISS += $rps->ISSST[$d->nItem]->vBCST;
                self::$dom->addChild(
                    $ISSST,
                    'pISSST',
                    $rps->ISSST[$d->nItem]->pISSST,
                    true,
                    'Alíquota do ISSQN retido do item de serviço',
                    false
                );
                self::$dom->addChild(
                    $ISSST,
                    'vISSST',
                    $rps->ISSST[$d->nItem]->vISSST,
                    true,
                    'Valor do ISSQN retido do item de serviço',
                    false
                );
                $rps->totalvSTISS += $rps->ISSST[$d->nItem]->vISSST;

                self::$dom->appChild($det, $ISSST, 'Adicionando tag ISSQN retido em um item de serviço da NFS-e');
            }


            //Serviço da NFS-e
            self::$dom->appChild($infRPS, $det, 'Adicionando tag Transportadora em infRPS');
        }

        //Totais
        $total = self::$dom->createElement('total');
        self::$dom->addChild(
            $total,
            'vServ',
            $rps->total->vServ,
            true,
            'Valor Serviço',
            false
        );
        self::$dom->addChild(
            $total,
            'vRedBCCivil',
            $rps->total->vRedBCCivil,
            false,
            'Valor BC construção civil',
            false
        );
        self::$dom->addChild(
            $total,
            'vDesc',
            $rps->total->vDesc,
            false,
            'Valor Desconto',
            false
        );
        self::$dom->addChild(
            $total,
            'vtNF',
            $rps->total->vtNF,
            true,
            'Valor Nota',
            false
        );
        self::$dom->addChild(
            $total,
            'vtLiq',
            $rps->total->vtLiq,
            true,
            'Valor Total Liquido',
            false
        );
        //Serviço da NFS-e
        $ISS = self::$dom->createElement('ISS');
        self::$dom->addChild(
            $ISS,
            'vBCISS',
            number_format($rps->totalvBCISS, 2),
            false,
            'Valor total da base cálculo ISSQN',
            false
        );
        self::$dom->addChild(
            $ISS,
            'vISS',
            number_format($rps->totalvISS, 2),
            false,
            'Valor total ISS',
            false
        );
        self::$dom->addChild(
            $ISS,
            'vBCSTISS',
            number_format($rps->totalvBCSTISS, 2),
            false,
            'Valor total da base cálculo ISSQN ST',
            false
        );
        self::$dom->addChild(
            $ISS,
            'vSTISS',
            number_format($rps->totalvSTISS, 2),
            false,
            'Valor total ISS ST ',
            false
        );

        self::$dom->appChild($total, $ISS, 'Adicionando tag ISS');
        self::$dom->appChild($infRPS, $total, 'Adicionando tag Total em infRPS');

        // TAG <notaNacional>
        $notaNacional = self::$dom->createElement('notaNacional');
        self::$dom->addChild(
            $notaNacional, // Dom Element
            'chaveAcessoNacional', // Tag name
            $rps->notaNacional->chaveAcessoNacional, // Tag content
            true, // Obrigatorio
            'Chave de acesso da nota nacional', // Descricao
            true // Force (se nao preenchido exibe aviso: Preenchimento obrigatorio)
        );

        self::$dom->addChild(
            $notaNacional, // Dom Element
            'numero', // Tag name
            $rps->notaNacional->numero, // Tag content
            true, // Obrigatorio
            'Número da Nota Fiscal Nacional', // Descricao
            true // Force (se nao preenchido exibe aviso: Preenchimento obrigatorio)
        );

        self::$dom->addChild(
            $notaNacional, // Dom Element
            'cTribNac', // Tag name
            $rps->notaNacional->cTribNac, // Tag content
            true, // Obrigatorio
            'Código de tributação nacional do ISSQN', // Descricao
            true // Force (se nao preenchido exibe aviso: Preenchimento obrigatorio)
        );

        self::$dom->addChild(
            $notaNacional, // Dom Element
            'cTribMun', // Tag name
            $rps->notaNacional->cTribMun, // Tag content
            true, // Obrigatorio
            'Código de tributação municipal do ISSQN', // Descricao
            true // Force (se nao preenchido exibe aviso: Preenchimento obrigatorio)
        );

        // TAG <IBSCBS>
        $IBSCBS = self::$dom->createElement('IBSCBS');
        self::$dom->addChild(
            $IBSCBS, // Dom Element
            'cLocalidadeIncid', // Tag name
            $rps->notaNacional->IBSCBS->cLocalidadeIncid, // Tag content
            true, // Obrigatorio
            'Código IBGE da localidade de incidência do IBS/CBS (local da operação)', // Descricao
            true // Force (se nao preenchido exibe aviso: Preenchimento obrigatorio)
        );
        self::$dom->addChild(
            $IBSCBS, // Dom Element
            'xLocalidadeIncid', // Tag name
            $rps->notaNacional->IBSCBS->xLocalidadeIncid, // Tag content
            true, // Obrigatorio
            'Nome da localidade de incidência do IBS/CBS', // Descricao
            true // Force (se nao preenchido exibe aviso: Preenchimento obrigatorio)
        );
        self::$dom->addChild(
            $IBSCBS, // Dom Element
            'pRedutor', // Tag name
            $rps->notaNacional->IBSCBS->pRedutor, // Tag content
            true, // Obrigatorio
            'Percentual de redução de alíquota em compra governamental', // Descricao
            true // Force (se nao preenchido exibe aviso: Preenchimento obrigatorio)
        );

        // TAG <valores>
        $valores = self::$dom->createElement('valores');
        self::$dom->addChild(
            $valores, // Dom Element
            'vBC', // Tag name
            $rps->notaNacional->IBSCBS->valores->vBC, // Tag content
            true, // Obrigatorio
            'Valor da base de cálculo (BC) do IBS/CBS antes das reduções para cálculo do tributo bruto.', // Descricao
            true // Force (se nao preenchido exibe aviso: Preenchimento obrigatorio)
        );

        // TAG <uf>
        $uf = self::$dom->createElement('uf');
        self::$dom->addChild(
            $uf, // Dom Element
            'pIBSUF', // Tag name
            $rps->notaNacional->IBSCBS->valores->uf->pIBSUF, // Tag content
            true, // Obrigatorio
            'Alíquota da UF para IBS da localidade de incidência parametrizada no sistema', // Descricao
            true // Force (se nao preenchido exibe aviso: Preenchimento obrigatorio)
        );
        self::$dom->addChild(
            $uf, // Dom Element
            'pRedAliqUF', // Tag name
            $rps->notaNacional->IBSCBS->valores->uf->pRedAliqUF, // Tag content
            false, // Obrigatorio
            'Percentual de redução de alíquota estadual', // Descricao
            false // Force (se nao preenchido exibe aviso: Preenchimento obrigatorio)
        );
        self::$dom->addChild(
            $uf, // Dom Element
            'pAliqEfetUF', // Tag name
            $rps->notaNacional->IBSCBS->valores->uf->pAliqEfetUF, // Tag content
            true, // Obrigatorio
            'pAliqEfetUF = pIBSUF x (1 - pRedAliqUF) x (1 - pRedutor). Se pRedAliqUF não for informado, então pAliqEfetUF é a própria pIBSUF', // Descricao
            true // Force (se nao preenchido exibe aviso: Preenchimento obrigatorio)
        );
        self::$dom->appChild($valores, $uf, 'Adicionando tag uf em valores');

        // TAG <mun>
        $mun = self::$dom->createElement('mun');
        self::$dom->addChild(
            $mun, // Dom Element
            'pIBSMun', // Tag name
            $rps->notaNacional->IBSCBS->valores->mun->pIBSMun, // Tag content
            true, // Obrigatorio
            'Alíquota do Município para IBS da localidade de incidência parametrizada no sistema', // Descricao
            true // Force (se nao preenchido exibe aviso: Preenchimento obrigatorio)
        );
        self::$dom->addChild(
            $mun, // Dom Element
            'pRedAliqMun', // Tag name
            $rps->notaNacional->IBSCBS->valores->mun->pRedAliqMun, // Tag content
            false, // Obrigatorio
            'Percentual de redução de alíquota municipal', // Descricao
            false // Force (se nao preenchido exibe aviso: Preenchimento obrigatorio)
        );
        self::$dom->addChild(
            $mun, // Dom Element
            'pAliqEfetMun', // Tag name
            $rps->notaNacional->IBSCBS->valores->mun->pAliqEfetMun, // Tag content
            true, // Obrigatorio
            'pAliqEfetMun = pIBSMun x (1 - pRedAliqMun) x (1 - pRedutor). Se pRedAliqMun não for informado, então pAliqEfetMun é a própria pIBSMun', // Descricao
            true // Force (se nao preenchido exibe aviso: Preenchimento obrigatorio)
        );
        self::$dom->appChild($valores, $mun, 'Adicionando tag mun em valores');

        // TAG <fed>
        $fed = self::$dom->createElement('fed');
        self::$dom->addChild(
            $fed, // Dom Element
            'pCBS', // Tag name
            $rps->notaNacional->IBSCBS->valores->fed->pCBS, // Tag content
            true, // Obrigatorio
            'Alíquota da União para CBS parametrizada no sistema', // Descricao
            true // Force (se nao preenchido exibe aviso: Preenchimento obrigatorio)
        );
        self::$dom->addChild(
            $fed, // Dom Element
            'pRedAliqCBS', // Tag name
            $rps->notaNacional->IBSCBS->valores->fed->pRedAliqCBS, // Tag content
            false, // Obrigatorio
            'Percentual da redução de alíquota da CBS', // Descricao
            false // Force (se nao preenchido exibe aviso: Preenchimento obrigatorio)
        );
        self::$dom->addChild(
            $fed, // Dom Element
            'pAliqEfetCBS', // Tag name
            $rps->notaNacional->IBSCBS->valores->fed->pAliqEfetCBS, // Tag content
            true, // Obrigatorio
            'pAliqEfetCBS = pCBS x (1 - pRedAliqCBS) x (1 - pRedutor). Se pRedAliqCBS não for informado, então pAliqEfetCBS é a própria pCBS', // Descricao
            true // Force (se nao preenchido exibe aviso: Preenchimento obrigatorio)
        );
        self::$dom->appChild($valores, $fed, 'Adicionando tag fed em valores');

        self::$dom->appChild($IBSCBS, $valores, 'Adicionando tag valores em IBSCBS');

        // TAG <totCIBS>
        $totCIBS = self::$dom->createElement('totCIBS');
        self::$dom->addChild(
            $totCIBS, // Dom Element
            'vTotNF', // Tag name
            $rps->notaNacional->IBSCBS->totCIBS->vTotNF, // Tag content
            true, // Obrigatorio
            'Valor Total da NF considerando os impostos por fora: IBS e CBS.', // Descricao
            true // Force (se nao preenchido exibe aviso: Preenchimento obrigatorio)
        );

        // TAG <gIBS>
        $gIBS = self::$dom->createElement('gIBS');
        self::$dom->addChild(
            $gIBS, // Dom Element
            'vIBSTot', // Tag name
            $rps->notaNacional->IBSCBS->totCIBS->gIBS->vIBSTot, // Tag content
            true, // Obrigatorio
            'Valor total do IBS, vIBSTot = vIBSUF + vIBSMun', // Descricao
            true // Force (se nao preenchido exibe aviso: Preenchimento obrigatorio)
        );

        // TAG <gIBSUFTot>
        $gIBSUFTot = self::$dom->createElement('gIBSUFTot');
        self::$dom->addChild(
            $gIBSUFTot, // Dom Element
            'vDifUF', // Tag name
            $rps->notaNacional->IBSCBS->totCIBS->gIBS->gIBSUFTot->vDifUF, // Tag content
            true, // Obrigatorio
            'Total do Diferimento do IBS estadual. vDifUF = vIBSUF x pDifUF', // Descricao
            true // Force (se nao preenchido exibe aviso: Preenchimento obrigatorio)
        );
        self::$dom->addChild(
            $gIBSUFTot, // Dom Element
            'vIBSUF', // Tag name
            $rps->notaNacional->IBSCBS->totCIBS->gIBS->gIBSUFTot->vIBSUF, // Tag content
            true, // Obrigatorio
            'Total valor do IBS estadual. vIBSUF = vBC x (pIBSUF ou pAliqEfetUF)', // Descricao
            true // Force (se nao preenchido exibe aviso: Preenchimento obrigatorio)
        );
        self::$dom->appChild($gIBS, $gIBSUFTot, 'Adicionando tag gIBSUFTot em gIBS');

        // TAG <gIBSMunTot>
        $gIBSMunTot = self::$dom->createElement('gIBSMunTot');
        self::$dom->addChild(
            $gIBSMunTot, // Dom Element
            'vDifMun', // Tag name
            $rps->notaNacional->IBSCBS->totCIBS->gIBS->gIBSMunTot->vDifMun, // Tag content
            true, // Obrigatorio
            'Total do Diferimento do IBS municipal. vDifMun = vIBSMun x pDifMun', // Descricao
            true // Force (se nao preenchido exibe aviso: Preenchimento obrigatorio)
        );
        self::$dom->addChild(
            $gIBSMunTot, // Dom Element
            'vIBSMun', // Tag name
            $rps->notaNacional->IBSCBS->totCIBS->gIBS->gIBSMunTot->vIBSMun, // Tag content
            true, // Obrigatorio
            'Total valor do IBS municipal. vIBSMun = vBC x (pIBSMun ou pAliqEfetMun)', // Descricao
            true // Force (se nao preenchido exibe aviso: Preenchimento obrigatorio)
        );
        self::$dom->appChild($gIBS, $gIBSMunTot, 'Adicionando tag gIBSMunTot em gIBS');

        self::$dom->appChild($totCIBS, $gIBS, 'Adicionando tag gIBS em totCIBS');

        // TAG <gCBS>
        $gCBS = self::$dom->createElement('gCBS');
        self::$dom->addChild(
            $gCBS, // Dom Element
            'vDifCBS', // Tag name
            $rps->notaNacional->IBSCBS->totCIBS->gCBS->vDifCBS, // Tag content
            true, // Obrigatorio
            'Total do Diferimento CBS. vDifCBS = vCBS x pDifCBS', // Descricao
            true // Force (se nao preenchido exibe aviso: Preenchimento obrigatorio)
        );
        self::$dom->addChild(
            $gCBS, // Dom Element
            'vCBS', // Tag name
            $rps->notaNacional->IBSCBS->totCIBS->gCBS->vCBS, // Tag content
            true, // Obrigatorio
            'Total valor da CBS da União. vCBS = vBC x (pCBS ou pAliqEfetCBS)', // Descricao
            true // Force (se nao preenchido exibe aviso: Preenchimento obrigatorio)
        );
        self::$dom->appChild($totCIBS, $gCBS, 'Adicionando tag gCBS em totCIBS');

        self::$dom->appChild($IBSCBS, $totCIBS, 'Adicionando tag totCIBS em IBSCBS');
        self::$dom->appChild($notaNacional, $IBSCBS, 'Adicionando tag IBSCBS em notaNacional');
        self::$dom->appChild($infRPS, $notaNacional, 'Adicionando tag notaNacional em infRPS');


        //Faturas
        if (isset($rps->faturas)) {
            $faturas = self::$dom->createElement('faturas');
            foreach ($rps->fat as $fatura) {
                $fat = self::$dom->createElement('fat');
                self::$dom->addChild(
                    $fat,
                    'nItem',
                    $fatura->nItem,
                    true,
                    'Número sequencial para ordenar faturas',
                    false
                );
                self::$dom->addChild(
                    $fat,
                    'nFat',
                    $fatura->nFat,
                    true,
                    'Número da fatura',
                    false
                );
                self::$dom->addChild(
                    $fat,
                    'dVenc',
                    $fatura->dVenc,
                    false,
                    'Data de vencimento da fatura',
                    false
                );
                self::$dom->addChild(
                    $fat,
                    'vFat',
                    $fatura->vFat,
                    true,
                    'Valor da fatura',
                    false
                );
                self::$dom->appChild($faturas, $fat, 'Adicionando tag fat em faturas');
            }
            self::$dom->appChild($infRPS, $faturas, 'Adicionando tag fatura em infRPS');
        }

        //Informações adicionais
        self::$dom->addChild(
            $infRPS,
            'infAdicLT',
            $rps->infAdicLT,
            true,
            'Local da tributação utilizando código do município conforme IBGE',
            false
        );
        foreach ($rps->infAdic as $inf) {
            self::$dom->addChild(
                $infRPS,
                'infAdic',
                $inf,
                true,
                'Informações adicionais',
                false
            );
        }


        self::$dom->appChild($root, $infRPS, 'Adicionando tag infRPS em RPS');
        self::$dom->appendChild($root);
        $xml = str_replace('<?xml version="1.0" encoding="utf-8"?>', '', self::$dom->saveXML());
        return $xml;
    }
}
