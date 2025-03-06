# brazilian-validations: Brazilian Validations for Laravel

This library adds Brazilian validations to Laravel, such as CPF, CNPJ, Car License Plate, ZIP Code, Phone, Cellphone, and similar.

:brazil::brazil::brazil:

## Versions

<table>
    <tr>    
        <th>Laravel</th>
        <th>Library</th>
    </tr>
    <tr>
        <td>^11.0</td>
        <td>^11.0</td>
    </tr>
     <tr>
        <td>^12.0</td>
        <td>^12.0</td>
    </tr>
</table>

## Installation

Navigate to your project folder, for example:

```bash
cd /etc/www/project
```

Then run:

```bash
composer require paulorlima9/brazilian-validations
```

If you are using a version of this library prior to `5.2`, you must add the provider in `config/app.php`:

```php
'providers' => [
    // ... other packages
    PauloRLima\BrazilianValidations\ValidatorProvider::class
]
```

Now, to use the validation, simply follow Laravel's standard procedure.

The difference is that you can use the following validation methods:

|             RULE             |                                                                       Description                                                                       |
|:-----------------------------|----------------------------------------------------------------------------------------------------------------------------------------------------------:|
| Cellphone                    | Validates if the field is in the format (**`99999-9999`** or **`9999-9999`**)                                                                               |
| celular_com_ddd            | Validates if the field is in the format (**`(99)99999-9999`** or **`(99)9999-9999`** or **`(99) 99999-9999`** or **`(99) 9999-9999`**)             |
| celular_com_codigo         | Validates if the field is in the format `+99(99)99999-9999` or `+99(99)9999-9999`.                                                                          |
| cnpj                         | Validates if the field is a valid CNPJ. You can generate a valid CNPJ for your tests using the website [geradorcnpj.com](http://www.geradorcnpj.com/)      |
| cpf                          | Validates if the field is a valid CPF. You can generate a valid CPF for your tests using the website [geradordecpf.org](http://geradordecpf.org)          |
| cns                          | Validates if the field is a valid CNS. Use the website [geradornv.com.br](https://geradornv.com.br/gerador-cns/) to test                                  |
| formato_cnpj                 | Validates if the field has the correct CNPJ mask (**`99.999.999/9999-99`**).                                                                                |
| formato_cpf                  | Validates if the field has the correct CPF mask (**`999.999.999-99`**).                                                                                     |
| formato_cep                  | Validates if the field has the correct mask (**`99999-999`** or **`99.999-999`**).                                                                          |
| telefone                     | Validates if the field has a telephone mask (**`9999-9999`**).                                                                                              |
| telefone_com_ddd             | Validates if the field has a telephone mask with area code (**`(99)9999-9999`**).                                                                            |
| telefone_com_codigo          | Validates if the field has a telephone mask with country code (**`+55(99)9999-9999`**).                                                                       |
| formato_placa_de_veiculo     | Validates if the field has a valid vehicle plate format (including the MERCOSUL standard).                                                                  |
| formato_pis                  | Validates if the field has the PIS format.                                                                                                                  |
| pis                          | Validates if the PIS is valid.                                                                                                                              |
| cpf_ou_cnpj                  | Validates if the field is either a CPF or CNPJ.                                                                                                             |
| formato_cpf_ou_cnpj          | Validates if the field contains a CPF or CNPJ format.                                                                                                       |
| uf                           | Validates if the field contains a valid state abbreviation (UF).                                                                                            |

## Testing Brazilian Validations

With this, you can perform a simple test:

```php
$validator = \Validator::make(
    ['telefone' => '(77)9999-3333'],
    ['telefone' => 'required|telefone_com_ddd']
);

dd($validator->fails());
```

You can also use it with the `Illuminate\Http\Request` instance, using the `validate` method.

For example:

```php
use Illuminate\Http\Request;

// URL: /testando?telefone=3455-1222

Route::get('testando', function (Request $request) {

    try {

        $dados = $request->validate([
            'telefone' => 'required|telefone',
            // other validations here
        ]);

    } catch (\Illuminate\Validation\ValidationException $e) {
        dd($e->errors());
    }

});
```

### Customizing the Messages

All the validations mentioned above already have default validation messages; however, it is possible to change them using the third parameter of `Validator::make`. This parameter must be an array where the keys are the validation names and the values are the respective messages.

For example:

```php
Validator::make($valor, $regras, ['celular_com_ddd' => 'The field :attribute is not a celular'])
```

Or through the `messages` method of your Request created with the command `php artisan make:request`:

```php
public function messages() {
    return [
        'campo.telefone' => 'Invalid telephone!'
    ];
}
```

### Accessing the Rules Separately

If you need to access any rule separately, you can use the following classes:

```
\PauloRLima\BrazilianValidations\Rules\Celular::class
\PauloRLima\BrazilianValidations\Rules\CelularComDdd::class
\PauloRLima\BrazilianValidations\Rules\CelularComCodigo::class
\PauloRLima\BrazilianValidations\Rules\Cnh::class
\PauloRLima\BrazilianValidations\Rules\Cnpj::class
\PauloRLima\BrazilianValidations\Rules\Cpf::class
\PauloRLima\BrazilianValidations\Rules\Cns::class
\PauloRLima\BrazilianValidations\Rules\FormatoCnpj::class
\PauloRLima\BrazilianValidations\Rules\FormatoCpf::class
\PauloRLima\BrazilianValidations\Rules\Telefone::class
\PauloRLima\BrazilianValidations\Rules\TelefoneComDdd::class
\PauloRLima\BrazilianValidations\Rules\TelefoneComCodigo::class
\PauloRLima\BrazilianValidations\Rules\FormatoCep::class
\PauloRLima\BrazilianValidations\Rules\FormatoPlacaDeVeiculo::class
\PauloRLima\BrazilianValidations\Rules\FormatoPis::class
\PauloRLima\BrazilianValidations\Rules\Pis::class
\PauloRLima\BrazilianValidations\Rules\CpfOuCnpj::class
\PauloRLima\BrazilianValidations\Rules\FormatoCpfOuCnpj::class
\PauloRLima\BrazilianValidations\Rules\Uf::class
```

For example, if you want to validate the format of a CPF field, you can use the class `PauloRLima\BrazilianValidations\Rules\FormatoCpf` as follows:

```php
use Illuminate\Http\Request;
use PauloRLima\BrazilianValidations\Rules\FormatoCpf;

// testing?cpf=invalid_value

Route::get('testando', function (Request $request) {

    try {

        $dados = $request->validate([
            'cpf'  => ['required', new FormatoCpf]
            // other validations here
        ]);

    } catch (\Illuminate\Validation\ValidationException $e) {
        dd($e->errors());
    }

});
```
