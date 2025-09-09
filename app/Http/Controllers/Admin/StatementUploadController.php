<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Statement; // Import Statement model
use App\Models\User;      // Import User model
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log; // Import Log facade
use Carbon\Carbon; // Import Carbon for date handling

class StatementUploadController extends Controller
{
    /**
     * Display a listing of the uploaded statements.
     */
    public function index(): View
    {
        // Eager load the 'user' relationship to avoid N+1 queries
        // Also order by statement_month if that column exists and is useful for sorting
        $statements = Statement::with('user')
                            // ->orderBy('statement_month', 'desc') // Optional: Sort by statement period
                            ->latest('created_at') // Sort by upload date as primary
                            ->paginate(20);

        // --- Fetch Data for Stats Cards ---
        $usersWithStatementsCount = Statement::distinct('user_id')->count('user_id');
        $latestUpload = Statement::latest('created_at')->first();
        // Format the date nicely, handle case where no statements exist
        $latestUploadDate = $latestUpload ? $latestUpload->created_at->format('M d, Y H:i') : 'Never';
        // --- End Fetch Data ---

        return view('admin.statements.index', compact(
            'statements',
            'usersWithStatementsCount',
            'latestUploadDate'
        ));
    }

    /**
     * Show the form for creating a new statement upload.
     */
    public function create(): View
    {
        // Get only regular users for the dropdown, ordered by name
        $users = User::where('role', User::ROLE_USER) // Use constant if available
                     ->orderBy('last_name')
                     ->orderBy('first_name')
                     ->get();
        return view('admin.statements.create', compact('users')); // Renders the correct view
    }

    /**
     * Store a newly uploaded statement PDF.
     * --- UPDATED TO MATCH THE FORM ---
     */
    public function store(Request $request): RedirectResponse
    {
        // Validate the incoming request data - matching the form fields
        $request->validate([
            'user_id' => 'required|exists:users,id',
            // Validate separate month and year from the form
            'statement_month' => 'required|integer|between:1,12',
            'statement_year' => 'required|integer|digits:4',
            // Validate the file input named 'statement_file'
            'statement_file' => 'required|file|mimes:pdf|max:5120', // PDF only, max 5MB (5 * 1024 KB)
        ]);

        // --- Combine month and year for storage (assuming YYYY-MM format in DB) ---
        // Adjust format if your DB column stores something different (e.g., just month number)
        $statementPeriod = $request->statement_year . '-' . str_pad($request->statement_month, 2, '0', STR_PAD_LEFT);

        // Check if the file was uploaded successfully
        // --- Expect 'statement_file' from the form ---
        if ($request->hasFile('statement_file') && $request->file('statement_file')->isValid()) {
            try {
                // --- Use 'statement_file' ---
                $file = $request->file('statement_file');
                $originalName = $file->getClientOriginalName();

                // Store in a private disk (ensure 'private' disk is configured in config/filesystems.php)
                // Consider including user ID or year/month in path for organization
                // Example: $path = $file->store("statements/{$request->statement_year}/{$request->statement_month}", 'private');
                $path = $file->store('statements', 'private'); // Simple storage path

                if (!$path) {
                     Log::error('Statement PDF storage failed for user: ' . $request->user_id . ' for period ' . $statementPeriod);
                     return back()->with('error', 'Could not store the uploaded file. Please try again.');
                 }

                // Create the database record
                Statement::create([
                    'user_id' => $request->user_id,
                    'file_path' => $path, // Store relative path within the disk
                    'original_filename' => $originalName,
                    // Store the combined period (e.g., YYYY-MM)
                    'statement_month' => $statementPeriod,
                    // Add other fields if your Statement model requires them
                ]);

                return redirect()->route('admin.statements.index')->with('status', 'Statement uploaded successfully!');

             } catch (\Exception $e) {
                 Log::error('Statement upload process failed: ' . $e->getMessage(), ['exception' => $e]);
                 // Attempt to delete partially uploaded file if path was set? Maybe not reliable here.
                 return back()->with('error', 'An unexpected error occurred during upload. Please try again.');
             }
        }

        // Fallback if no valid file was uploaded
        return back()->withInput()->with('error', 'File upload failed or invalid file provided.');
    }

    /**
     * Remove the specified statement resource from storage and database.
     */
    public function destroy(Statement $statement): RedirectResponse // Use Route Model Binding
    {
        try {
            // Attempt to delete file from storage (use the correct 'private' disk)
            if ($statement->file_path && Storage::disk('private')->exists($statement->file_path)) {
                Storage::disk('private')->delete($statement->file_path);
            } else {
                 Log::warning("Statement file not found for deletion: " . ($statement->file_path ?? 'NULL') . " (Statement ID: {$statement->id})");
             }

            // Delete the database record
            $statement->delete();

            return redirect()->route('admin.statements.index')->with('status', 'Statement deleted successfully!');

        } catch (\Exception $e) {
             Log::error('Statement deletion failed: ' . $e->getMessage(), ['exception' => $e]);
             return back()->with('error', 'Could not delete the statement. Please try again.');
        }
    }
}