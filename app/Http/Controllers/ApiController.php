<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\ApiModel;

class ApiController extends Controller
{
    private $client_type = 'PJ';

    public function index(ApiModel $api)
    {
        $data = $api->index();
        $review_data = [];

        /* echo '<pre>';
        print_r(json_encode($data));
        echo '</pre>'; */

        if (isset($data->protocolo) && isset($data->protocolo->digito) && isset($data->protocolo->numero)) {
            $review_data['query'] = $data->protocolo->digito . ' - ' . $data->protocolo->numero;
        } else {
            $review_data['query'] = 0;
        }

        $review_data['result'] = json_encode($this->getResultSPCBrazil($data, $witc_score = true));

        print_r($review_data['result']);
    }

    private function getResultSPCBrazil($data, $witc_score)
    {
        return [
            'credit_data' => $this->process_credit_data_spc_brazil($data, $this->client_type, $witc_score)
        ];
    }

    private function process_credit_data_spc_brazil($data, $type, $witc_score)
    {
        $review_type = ($witc_score) ? 'ondemand_credit_spc_score_12_months' : 'ondemand_credit_spc';

        $consumer_type =  $type == 'PF' ? 'consumidor-pessoa-fisica' : 'consumidor-pessoa-juridica';

        if (
            ($type == 'PJ' && $data->consumidor->{$consumer_type}->{'razao-social'} == "CADASTRO NAO LOCALIZADO") ||
            ($type == 'PF' && $data->consumidor->{$consumer_type}->nome == "CADASTRO NAO LOCALIZADO")

        ) {
            return ['erro' => ['code' => '1', 'message' => 'CADASTRO NAO LOCALIZADO']];
        } else {

            $emails = [];
            if (isset($data->consumidor->{$consumer_type}->email)) {
                $emails[0] = ['email' => $data->consumidor->{$consumer_type}->email, 'main' => 1];
            } else {
                return 'emails';
            }

            $phones = [];
            if ($type == 'PF') {
                if (isset($data->consumidor->{$consumer_type}->{'telefone-residencial'})) {
                    return ['phones' => 'PF tel'];
                }
            } else {
                if (
                    isset($data->{'ultimo-telefone-informado'}) &&
                    isset($data->{'ultimo-telefone-informado'}->{'detalhe-ultimo-telefone-informado'})
                ) {
                    $phone = $data->{'ultimo-telefone-informado'}->{'detalhe-ultimo-telefone-informado'};
                    foreach ($phone as $key => $value) {
                        $numero[] = $value->telefone->telefone;
                        //$phones['ddd'] = $value->telefone->{'numero-ddd'};
                    }

                    return $phones;
                }
            }

            return 'nao entrou no telefone';
        }
    }
}
