<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Http\Requests\Backend\AdminInfoRequest;
use App\Models\Document;
use App\Models\Menu;
use App\Models\Page;
use App\Models\Post;
use App\Models\Slider;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;

use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;

class BackendController extends Controller
{
    public function login()
    {
        return view('backend.admin-login');
    }

    public function register()
    {
        return view('backend.admin-register');
    }

    public function lock_screen()
    {
        return view('backend.admin-lock-screen');
    }

    public function recover_password()
    {
        return view('backend.admin-recoverpw');
    }

    // public function index()
    // {

    //     $numberOfDocumentsToday = Document::whereDate('created_at', today())->count(); //filter the created_at to today 

    //     if (Auth::check()) {
    //         return view('backend.index', compact('numberOfDocumentsToday'));
    //     }

    //     return view('backend.admin-login');
    // }

    public function index()
    {
        // Number of documents added today
        $numberOfDocumentsToday = Document::whereDate('created_at', today())->count();

        // Fetch document counts for the last 30 days
        $documentCounts = Document::selectRaw('DATE(created_at) as date, COUNT(*) as count')
            ->where('created_at', '>=', Carbon::now()->subDays(30)) // Last 30 days
            ->groupBy('date')
            ->orderBy('date')
            ->get();

        $numberOfCompletedDocuments = Document::where('doc_status', 1)->count();
        $numberOfCompletedDocuments = Document::where('doc_status', 0)->count();


        // Prepare data for the chart
        $dates = $documentCounts->pluck('date')->map(function ($date) {
            return Carbon::parse($date)->format('M d Y'); // Format dates for the chart
        });

        $counts = $documentCounts->pluck('count');

        // Calculate total documents and percentage increase
        $totalDocuments = $documentCounts->sum('count');
        $previousPeriodCount = Document::where('created_at', '<', Carbon::now()->subDays(30))->count();
        $percentageIncrease = $previousPeriodCount > 0 ? round((($totalDocuments - $previousPeriodCount) / $previousPeriodCount) * 100, 2) : 100;


        // =================== start monthly salys =================//
        // Fetch monthly sales data (e.g., number of documents created per month)
        $monthlySalesData = Document::selectRaw('YEAR(created_at) as year, MONTH(created_at) as month, COUNT(*) as count')
            ->where('created_at', '>=', Carbon::now()->subMonths(12)) // Last 12 months
            ->groupBy('year', 'month')
            ->orderBy('year')
            ->orderBy('month')
            ->get();

        // Prepare data for the chart
        $monthlySalesCategories = $monthlySalesData->map(function ($item) {
            return Carbon::create($item->year, $item->month)->format('M Y'); // Format as "Jan 2022"
        });

        $monthlySalesCounts = $monthlySalesData->pluck('count');

        // =================== end monthly salys =================//


        if (Auth::check()) {
            return view('backend.index', compact(
                'numberOfDocumentsToday',
                'dates',
                'counts',
                'totalDocuments',
                'percentageIncrease',
                'numberOfCompletedDocuments',

                'monthlySalesCategories',
                'monthlySalesCounts'

            ));
        }

        return view('backend.admin-login');
    }

    public function account_settings()
    {
        return view('backend.account_settings');
    }

    public function update_account_settings(AdminInfoRequest $request)
    {

        $user = auth()->user();
        $data['first_name'] =   $request->first_name;
        $data['last_name']  =   $request->last_name;
        $data['username']   =   $request->username;
        $data['email']      =   $request->email;
        $data['mobile']     =   $request->mobile;

        if (!empty($request->password) && !Hash::check($request->password, $user->password)) {
            $data['password'] = bcrypt($request->password);
        }

        if ($image = $request->file('user_image')) {

            if ($user->user_image != '') {
                if (File::exists('assets/users/' . $user->user_image)) {
                    unlink('assets/users/' . $user->user_image);
                }
            }

            $manager = new ImageManager(new Driver());
            $file_name = $user->username . '.' . $image->extension();
            $img = $manager->read($request->file('user_image'));
            $img->toJpeg(80)->save(base_path('public/assets/users/' . $file_name));
            $data['user_image'] = $file_name;
        }

        $user->update($data);

        // toast('Profile updated' , 'success');
        return back();
    }

    public function remove_image(Request $request)
    {

        $user = auth()->user();

        if ($user->user_image != '') {
            if (File::exists('assets/users/' . $user->user_image)) {
                unlink('assets/users/' . $user->user_image);
            }

            $user->user_image = null;
            $user->save();

            return true;
        }
    }


    public function create_update_theme(Request $request)
    {
        $theme = $request->input('theme_choice');

        if ($theme && in_array($theme, ['light', 'dark'])) {

            $cookie = cookie('theme', $theme, 60 * 25 * 365, "/"); // just one year
        }

        return back()->withCookie($cookie);
    }
}
