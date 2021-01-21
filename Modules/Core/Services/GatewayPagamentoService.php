<?php

namespace Modules\Core\Services;

use Modules\Core\Enuns\TipoGatewayPagamento;
use Modules\Core\Repositories\GatewayPagamentoRepository;
use Modules\Core\Models\GatewayPagamento;
use Modules\Financeiro\Services\TransacaoService;
use App\Interfaces\IService;
use App\Services\BaseService;
use App\Traits\ResponseActions;

class GatewayPagamentoService extends BaseService implements IService
{
    use ResponseActions;

    /**
     * @var  GatewayPagamentoRepository
     */
    private $gatewaypagamentoRepository;

    private $defaultGateWayConfig;
    /**
     * @var TransacaoService
     */
    private $transacaoService;

    public function __construct(
        GatewayPagamentoRepository $gatewaypagamentoRepository,
        TransacaoService $transacaoService)
    {
        $this->gatewaypagamentoRepository = $gatewaypagamentoRepository;
        $this->defaultGateWayConfig = $this->gatewaypagamentoRepository->skipPresenter(true)->findWhere([
            'ativo'=> true,
            'producao' => env_pagamento()
        ]);
        $this->defaultGateWayConfig = $this->defaultGateWayConfig->count() == 0 ? null : $this->defaultGateWayConfig->first();
        $this->transacaoService = $transacaoService;
    }

    public function getDefaultRepository()
    {
        return $this->gatewaypagamentoRepository;
    }

    public function get(int $id = null, bool $presenter = false)
    {
        if (is_null($id))
            return $this->getDefaultRepository()->skipPresenter($presenter)->first();

        return $this->getDefaultRepository()->skipPresenter($presenter)->find($id);

    }

    private function getDefaultPagamentoGateway()
    {
        switch ($this->defaultGateWayConfig->tipo_gate) {
            case TipoGatewayPagamento::REDE:
                // Configuração da loja
                return new \Rede\Store($this->defaultGateWayConfig->client_code, $this->defaultGateWayConfig->token, $this->getEvironment());
                break;
        }
    }


    /**
     * @return \Rede\Environment
     */
    private function getEvironment()
    {

        if(env_pagamento())
            $environment = \Rede\Environment::production();
        else
            $environment = \Rede\Environment::sandbox();


        //$environment->setIp('127.0.0.1');
        //$environment->setSessionId('NomeEstabelecimento-WebSessionID');
        return $environment;
    }


    public function capturaTranzacaoComAntifraude($data , $assossiacaoModel = null, $mensagem = "Transação autorizada com sucesso;", $disableFraude = false)
    {

        $transaction = (new \Rede\Transaction((double) $data['valor'], 'pedido' . time()))->creditCard(
            $data['numero_cc'],
            $data['ccv'],
            $data['mes_cc'],
            $data['ano_cc'],
            $data['nome_titular']
        );


        //Dados do antifraude
        $antifraud = $transaction->antifraud($this->getEvironment());

        if (!$disableFraude) {
            $antifraud
                ->consumer($data['nome_titular'], AuthService::getUser()->email, $data['cpf']);

            $antifraud
                ->address()
                ->setAddresseeName($data['nome_titular'])
                ->setAddress($data['endereco'])
                ->setNumber($data['numero'])
                ->setZipCode($data['cep'])
                ->setNeighbourhood($data['bairro'])
                ->setCity($data['cidade'])
                ->setState($data['estado'])
                ->setType(\Rede\Address::OTHER);

            /*$antifraud
                ->addItem(
                    (new \Rede\Item('123123', 1, \Rede\Item::PHYSICAL))
                    ->setAmount(200000)
                    ->setDescription('Televisão')
                    ->setFreight(199)
                    ->setDiscount(199)
                    ->setShippingType('Sedex')
                );*/
        }


        // Autoriza a transação
        $transaction = (new \Rede\eRede($this->getDefaultPagamentoGateway()))->create($transaction);

        if ($transaction->getReturnCode() == '00') {
            $antifraud = $transaction->getAntifraud();

            /*printf("Transação autorizada com sucesso; tid=%s\n", $transaction->getTid());

            printf("\tAntifraude: %s\n", $antifraud->isSuccess() ? 'Sucesso' : 'Falha');
            printf("\tScore: %s\n", $antifraud->getScore());
            printf("\tNível de Risco: %s\n", $antifraud->getRiskLevel());
            printf("\tRecomendação: %s\n", $antifraud->getRecommendation());*/

            $transacao = $this->transacaoService->getDefaultRepository()->skipPresenter(true)->create([
                'tid' => $transaction->getTid(),
                'mensagem'=> $mensagem,
                'status' => true,
                'body'=>json_encode([
                    'tid'=>$transaction->getTid(),
                    'score'=>$antifraud->getScore(),
                    'risk_level'=>$antifraud->getRiskLevel(),
                    'recomendation'=>$antifraud->getRecommendation(),
                    'antifraude'=>$antifraud->isSuccess() ? 'Sucesso' : 'Falha',
                    'transation' => serialize($transaction)
                ])
            ]);

            if($assossiacaoModel){
                $assossiacaoModel->transacao()->save($transacao);
            }

            return true;
        }
        return false;
    }


}
