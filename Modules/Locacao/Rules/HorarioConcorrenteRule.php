<?php

namespace Modules\Locacao\Rules;

use Illuminate\Contracts\Validation\Rule;
use Modules\Locacao\Services\HorarioService;

class HorarioConcorrenteRule implements Rule
{

    /**
     * @var HorarioService
     */
    private $horarioService;

    private $locacaoId;
    private $horarios;

    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct($locacaoId, $horarios)
    {
        $this->horarioService = app(HorarioService::class);
        $this->locacaoId = $locacaoId;
        $this->horarios = $horarios;
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        $horario = $this->horarioService->getDefaultRepository()->skipPresenter(true)->scopeQuery(function ($query) use ($attribute, $value){
            $hora = explode(';', $this->horarios);
            return $query
                ->where('locacao_id', $this->locacaoId)
                ->whereBetween($attribute, [
                    $hora[0], $hora[1]
                ])
                ->limit(1);
        })->all();
        return $horario->count() == 0;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'Já possui horários cadastrado nesse intervalo.';
    }

}
