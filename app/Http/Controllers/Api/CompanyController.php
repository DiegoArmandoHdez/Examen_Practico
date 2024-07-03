<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Resources\CompanyResource;
use App\Models\Company;

class CompanyController extends Controller
{
    //

    public function companies(){

        if(isset($_GET["id"])){
            return new CompanyResource(Company::with(["tasks", "tasks.user"])->where("id", $_GET["id"])->first());
        }

        return CompanyResource::collection(
            Company::with(["tasks", "tasks.user"])->get()
        );
    }
}
