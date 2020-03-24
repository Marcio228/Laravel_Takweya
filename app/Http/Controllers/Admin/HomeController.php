<?php

namespace App\Http\Controllers\Admin;

use App\User;
use DateTime;
use App\Http\Controllers\Controller;
use Sentinel;

class HomeController extends Controller
{
    const NUMBER_OF_MONTHS = 6;

    public function index()
    {
        $currentUser = User::where('id', Sentinel::getUser()->id)->firstOrFail();

        $usersCount = User::where('id', '!=', $currentUser->id)->count();
        $studentsCount = 0;
        $teachersCount = 0;

        $users = User::get();
        foreach ($users as $user) {
            if ($user->inRole('student')) {
                $studentsCount++;
            }
            if ($user->inRole('teacher')) {
                $teachersCount++;
            }
        }

        $recentlyUsers = User::where('id', '!=', $currentUser->id)->limit(4)->orderByDesc('id')->get();
        $chartMessages = $this->getChartMessages($currentUser);

        return view('admin.home.index', compact('usersCount', 'studentsCount', 'teachersCount', 'recentlyUsers', 'chartMessages'));
    }

    /**
     * Generate chart statistics
     * @return array
     */
    private function getChartMessages($currentUser)
    {
        $chartMessages = [];
        for ($i = 0; $i <= self::NUMBER_OF_MONTHS; $i++) {
            $chartMessages[$i]['month'] = date("m", mktime(0, 0, 0, date("m") - $i, 1, date("Y")));
            $dateObj = DateTime::createFromFormat('!m', $chartMessages[$i]['month']);
            $chartMessages[$i]['monthName'] = $dateObj->format('F');
            $chartMessages[$i]['year'] = date('Y', strtotime(date('Y-m-d') . " -$i month"));
            $chartMessages[$i]['count'] = User::where('id', '!=', $currentUser->id)->whereMonth('created_at', $chartMessages[$i]['month'])
                ->whereYear('created_at', $chartMessages[$i]['year'])->count();
        }
        $chartMessages = array_reverse($chartMessages);

        return $chartMessages;
    }
}