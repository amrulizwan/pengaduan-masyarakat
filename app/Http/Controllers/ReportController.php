<?php

namespace App\Http\Controllers;

use App\Models\Report;
use App\Http\Requests\StoreReportRequest;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    public function index(Request $request)
    {
        $query = Report::withUser()->where('user_id', auth()->id());

        if ($request->has('status')) {
            $query->where('status', $request->status);
        }

        $reports = $query->orderBy('created_at', 'desc')->paginate(10);

        return response()->json([
            'success' => true,
            'data' => $reports
        ]);
    }

    public function store(StoreReportRequest $request)
    {
        $report = Report::create([
            'user_id' => auth()->id(),
            'title' => $request->title,
            'description' => $request->description,
            'status' => 'menunggu',
        ]);

        $report->load('user:id,name,email');

        return response()->json([
            'success' => true,
            'message' => 'Report created successfully',
            'data' => $report
        ], 201);
    }

    public function show($id)
    {
        $report = Report::withUser()
            ->with('responseNotes')
            ->where('user_id', auth()->id())
            ->find($id);

        if (!$report) {
            return response()->json([
                'success' => false,
                'message' => 'Report not found'
            ], 404);
        }

        return response()->json([
            'success' => true,
            'data' => $report
        ]);
    }

    public function update(Request $request, Report $report)
    {
        if ($report->status !== 'menunggu') {
            return response()->json([
                'success' => false,
                'message' => 'Only reports with status "menunggu" can be updated'
            ], 403);
        }

        $validatedData = $request->validate([
            'title' => 'string|max:255',
            'description' => 'string|max:1000',
        ]);

        $report->update($validatedData);

        return response()->json([
            'success' => true,
            'message' => 'Report updated successfully',
            'data' => $report
        ]);
    }

    public function delete(Report $report)
    {
        if ($report->status !== 'menunggu') {
            return response()->json([
                'success' => false,
                'message' => 'Only reports with status "menunggu" can be deleted'
            ], 403);
        }

        $report->delete();

        return response()->json([
            'success' => true,
            'message' => 'Report deleted successfully'
        ]);
    }
}
