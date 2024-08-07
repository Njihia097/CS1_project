<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Artist;
use App\Models\User;
use App\Models\Order;
use Carbon\Carbon;
use App\Models\CategoryContent;
use App\Models\Content;
use Barryvdh\DomPDF\Facade\PDF;


class AdminController extends Controller
{
    public function adminHome(Request $request)
    {
        $total_art=artist::all()->count();
        $total_users=user::all()->count();
        $total_orders=order::all()->count();

        $artistCount = Artist::count();
        $contentCount = Content::count();

        $order=order::all();

       $total_revenue = 0;

foreach($order as $orders)
{
    $total_revenue = $total_revenue + $orders->price;
}


return view('admin.adminHome', compact('total_art', 'total_users', 'total_orders', 'total_revenue', 'artistCount', 'contentCount'));

    }

    public function charts()
    {

        $users = User::selectRaw('COUNT(id) as count, MONTHNAME(created_at) as month')
        ->whereYear('created_at', Carbon::now()->year)
        ->groupBy('month')
        ->orderByRaw('MONTH(created_at)')
        ->get();

$months = $users->pluck('month');
$counts = $users->pluck('count');

        return view('admin.chart', compact('months','counts'));
    }

    public function category_Chart()
    {
        $contentData = Content::selectRaw('COUNT(ContentID) as count, CategoryID')
                        ->groupBy('CategoryID')
                        ->get();
    
        $categories = CategoryContent::whereIn('CategoryID', $contentData->pluck('CategoryID'))->get()->keyBy('CategoryID');
    
        $categoryNames = [];
        $counts = [];
    
        foreach ($contentData as $data) {
            $categoryNames[] = $categories[$data->CategoryID]->name; // Adjust field 'name' if different
            $counts[] = $data->count;
        }

    
        return view('admin.categorychart', compact('categoryNames', 'counts'));
    }
    
    
    public function order()
    {
        $orders = Order::all();
        return view('admin.order',compact('orders'));
    }
    public function manageContentView()
    {
        $flaggedContents = Content::where('status', 'flagged')->get();
        return view('admin.adminManageContent', compact('flaggedContents'));
    }

    public function updateContentStatus(Request $request, $contentId)
    {
        $content = Content::findOrFail($contentId);
        $content->status = $request->status;
        $content->save();

        return response()->json(['success' => true, 'content' => $content]);
    }
    public function contentDetailsView ($id)
    {
        $content = Content::with(['author', 'chapters' => function ($query) {
            $query->where('IsPublished', 1);
        }])->findOrFail($id);

        return view('admin.detailedContentView', compact('content'));
    }


    public function print_pdf($id)
    {

        $orderdet=order::find($id);

        $pdf=PDF::loadView('admin.pdf', compact('orderdet'));

        return $pdf->download('order_details');
    }


    public function delivered($id)
    {
        $order=order::find($id);

        $order->delivery_status="delivered";

        $order->save();

        return redirect()->back();


    }
    
}
