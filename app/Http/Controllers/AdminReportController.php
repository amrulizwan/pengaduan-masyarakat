<?php

namespace App\Http\Controllers;

use App\Models\Report;
use App\Models\ResponseNote;
use App\Http\Requests\UpdateReportRequest;
use Illuminate\Http\Request;

class AdminReportController extends Controller
{
    public function index(Request $request)
    {
        $query = Report::withUser();

        if ($request->has('status')) {
            $query->where('status', $request->status);
        }

        if ($request->has('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%")
                  ->orWhereHas('user', function($userQuery) use ($search) {
                      $userQuery->where('name', 'like', "%{$search}%")
                               ->orWhere('email', 'like', "%{$search}%");
                  });
            });
        }

        $reports = $query->orderBy('created_at', 'desc')->paginate(15);

        return response()->json([
            'success' => true,
            'data' => $reports
        ]);
    }

    public function update(UpdateReportRequest $request, Report $report)
    {
        $previousStatus = $report->status;

        $report->update([
            'status' => $request->status,
            'response_note' => $request->response_note,
        ]);

        if ($request->response_note && $previousStatus !== $request->status) {
            $report->responseNotes()->create([
                'admin_id' => auth()->id(),
                'note' => $request->response_note,
                'previous_status' => $previousStatus,
                'new_status' => $request->status,
            ]);
        }

        $report->load(['user:id,name,email', 'responseNotes']);

        return response()->json([
            'success' => true,
            'message' => 'Report updated successfully',
            'data' => $report
        ]);
    }

    public function show(Report $report)
    {
        $report->load(['user:id,name,email', 'responseNotes']);

        return response()->json([
            'success' => true,
            'data' => $report
        ]);
    }

    public function statistics()
    {
        $stats = [
            'total_reports' => Report::count(),
            'menunggu' => Report::where('status', 'menunggu')->count(),
            'diproses' => Report::where('status', 'diproses')->count(),
            'selesai' => Report::where('status', 'selesai')->count(),
            'ditolak' => Report::where('status', 'ditolak')->count(),
        ];

        return response()->json([
            'success' => true,
            'data' => $stats
        ]);
    }
}
