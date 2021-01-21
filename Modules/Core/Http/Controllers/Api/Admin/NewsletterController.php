<?php

namespace Modules\Core\Http\Controllers\Api\Admin;

use Modules\Core\Criteria\NewsletterCriteria;
use Modules\Core\Http\Requests\NewsletterResquest;
use Modules\Core\Repositories\NewsletterRepository;
use App\Http\Controllers\BaseController;

class NewsletterController extends BaseController
{
    private $newsletterRepository;

    public function __construct(NewsletterRepository $newsletterRepository)
    {
        parent::__construct($newsletterRepository, NewsletterCriteria::class);
        $this->newsletterRepository = $newsletterRepository;
    }

    public function getValidator($id = null)
    {
        return new NewsletterResquest();
    }
}
