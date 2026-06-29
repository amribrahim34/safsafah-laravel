<?php

namespace App\Http\Controllers\App;

use App\Http\Controllers\Controller;
use App\Http\Resources\App\BeautyQuestionnaireResource;
use App\Services\Website\BeautyProfileService;
use Illuminate\Http\Request;

class BeautyQuestionnaireController extends Controller
{
    protected $beautyProfileService;

    public function __construct(BeautyProfileService $beautyProfileService)
    {
        $this->beautyProfileService = $beautyProfileService;
    }

    public function index()
    {
        $options = $this->beautyProfileService->getQuestionnaireOptions();
        return new BeautyQuestionnaireResource($options);
    }
}
