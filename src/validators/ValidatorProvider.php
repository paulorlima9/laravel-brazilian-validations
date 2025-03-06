<?php

namespace PauloRLima\BrazilianValidations;

use Illuminate\Support\ServiceProvider;
use PauloRLima\BrazilianValidations\Rules\Cnh;
use PauloRLima\BrazilianValidations\Rules\Cns;
use PauloRLima\BrazilianValidations\Rules\Cpf;
use PauloRLima\BrazilianValidations\Rules\Pis;
use PauloRLima\BrazilianValidations\Rules\Cnpj;
use PauloRLima\BrazilianValidations\Rules\Celular;
use PauloRLima\BrazilianValidations\Rules\Telefone;
use PauloRLima\BrazilianValidations\Rules\CpfOuCnpj;
use PauloRLima\BrazilianValidations\Rules\FormatoCep;
use PauloRLima\BrazilianValidations\Rules\FormatoCpf;
use PauloRLima\BrazilianValidations\Rules\FormatoPis;
use PauloRLima\BrazilianValidations\Rules\FormatoCnpj;
use PauloRLima\BrazilianValidations\Rules\CelularComDdd;
use PauloRLima\BrazilianValidations\Rules\TelefoneComDdd;
use PauloRLima\BrazilianValidations\Rules\CelularComCodigo;
use PauloRLima\BrazilianValidations\Rules\FormatoCpfOuCnpj;
use PauloRLima\BrazilianValidations\Rules\TelefoneComCodigo;
use PauloRLima\BrazilianValidations\Rules\FormatoPlacaDeVeiculo;
use PauloRLima\BrazilianValidations\Rules\CelularComCodigoSemMascara;
use PauloRLima\BrazilianValidations\Rules\Uf;

class ValidatorProvider extends ServiceProvider
{

    /**
     * Indicates if loading of the provider is deferred.
     *
     * @var bool
     */
    protected $defer = false;


    /**
     * Bootstrap the application events.
     *
     * @return void
     */

    public function boot()
    {
        $rules = [
            'celular'                        => Celular::class,
            'celular_com_ddd'                => CelularComDdd::class,
            'celular_com_codigo'             => CelularComCodigo::class,
            'celular_com_codigo_sem_mascara' => CelularComCodigoSemMascara::class,
            'cnh'                            => Cnh::class,
            'cnpj'                           => Cnpj::class,
            'cns'                            => Cns::class,
            'cpf'                            => Cpf::class,
            'formato_cnpj'                   => FormatoCnpj::class,
            'formato_cpf'                    => FormatoCpf::class,
            'telefone'                       => Telefone::class,
            'telefone_com_ddd'               => TelefoneComDdd::class,
            'telefone_com_codigo'            => TelefoneComCodigo::class,
            'formato_cep'                    => FormatoCep::class,
            'formato_placa_de_veiculo'       => FormatoPlacaDeVeiculo::class,
            'formato_pis'                    => FormatoPis::class,
            'pis'                            => Pis::class,
            'cpf_ou_cnpj'                    => CpfOuCnpj::class,
            'formato_cpf_ou_cnpj'            => FormatoCpfOuCnpj::class,
            'uf'                             => Uf::class,
        ];

        foreach ($rules as $name => $class) {
            $rule = new $class;

            $extension = static function ($attribute, $value) use ($rule) {
                return $rule->passes($attribute, $value);
            };

            $this->app['validator']->extend($name, $extension, $rule->message());
        }
    }


    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register() {}

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return [];
    }
}
