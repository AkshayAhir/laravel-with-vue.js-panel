<?php

namespace App\Http\Controllers;
use QrCode;
use Milon\Barcode\DNS1D;
use App\Models\Item;
use Illuminate\Http\Request;
use PDF;

class PDFController extends Controller
{
    public function generatePDF(Request $request)
    {

        $selectedUserIds = $request->input('selectedUsers', []);

        $selectedUsers = Item::whereIn('id', $selectedUserIds)->get();
        $pdf = PDF::loadView('pdf.selected_users', ['users' => $selectedUsers]);

        $pdf->save(storage_path('app/public/selected_users.pdf'));
        return response()->json(['message' => 'PDF generated successfully'],200);
    }
}
