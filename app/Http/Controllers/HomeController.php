<?php

namespace App\Http\Controllers;
use App\Models\customers;
use App\Models\Project;
use App\Models\produk;  
use App\Models\User;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $totalCustomers = Customers::count();
        $totalProjects = Project::count();
        $totalServices = produk::count();
        $totalUsers = User::count();
        return view('adminHome', compact('totalCustomers', 'totalProjects', 'totalServices', 'totalUsers'));
    }


    public function adminHome()
    {
        $totalCustomers = Customers::count();
        $totalProjects = Project::count();
        $totalServices = produk::count();
        $totalUsers = User::count();
        return view('adminHome', compact('totalCustomers', 'totalProjects', 'totalServices', 'totalUsers'));
    }
    public function adminProject()
    {
        return view('adminProject');
    }
}
