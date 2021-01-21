<?php

namespace Modules\Core\Repositories;

use Prettus\Repository\Contracts\RepositoryInterface;

/**
 * Interface GrupoRepository
 * @package namespace App\Repositories;
 */
interface GrupoRepository extends RepositoryInterface
{
    public function ativarDesativar(int $id);
}
