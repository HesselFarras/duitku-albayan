<?php

namespace App\Http\Controllers;

use App\Models\Activity;
use Illuminate\Http\Request;
use Carbon\Carbon;

class ActivityController extends Controller
{
    // Menampilkan daftar kegiatan (Sisi Publik/Admin)
    public function index()
    {
        $activities = Activity::orderBy('date', 'desc')->get();

        $totalUpcoming = $activities->where('status', 'UPCOMING')->count();
        $totalCompleted = $activities->where('status', 'COMPLETED')->count();
        $totalBudgetAllocated = $activities->where('status', '!=', 'COMPLETED')->sum('budget');

        return view('activities.index', compact(
            'activities', 
            'totalUpcoming', 
            'totalCompleted', 
            'totalBudgetAllocated'
        ));
    }

    // Halaman Form Tambah Kegiatan
    public function create()
    {
        return view('activities.create');
    }

    // Proses Simpan ke Database
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'date' => 'required|date',
            'time' => 'required',
            'location' => 'required|string|max:255',
            'funding_source' => 'required|string',
            'budget' => 'required|numeric|min:0',
            'status' => 'required|in:UPCOMING,ONGOING,COMPLETED',
            'description' => 'nullable|string',
        ]);

        Activity::create($validated);

        return redirect()->route('activities.index')->with('success', 'Agenda kegiatan berhasil ditambahkan!');
    }

    // Halaman Form Edit Kegiatan
    public function edit($id)
    {
        $activity = Activity::findOrFail($id);
        return view('activities.edit', compact('activity'));
    }

    // Proses Update ke Database
    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'date' => 'required|date',
            'time' => 'required',
            'location' => 'required|string|max:255',
            'funding_source' => 'required|string',
            'budget' => 'required|numeric|min:0',
            'status' => 'required|in:UPCOMING,ONGOING,COMPLETED',
            'description' => 'nullable|string',
        ]);

        $activity = Activity::findOrFail($id);
        $activity->update($validated);

        return redirect()->route('activities.index')->with('success', 'Agenda kegiatan berhasil diperbarui!');
    }

    // Proses Hapus Kegiatan
    public function destroy($id)
    {
        $activity = Activity::findOrFail($id);
        $activity->delete();

        return redirect()->route('activities.index')->with('success', 'Agenda kegiatan berhasil dihapus!');
    }
}