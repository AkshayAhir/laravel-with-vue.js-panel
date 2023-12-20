<?php

namespace App\Http\Controllers;

use App\Models\Item;
use Illuminate\Http\Request;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class ExcelController extends Controller
{
    public function generateExcel(Request $request)
    {
        $selectedUserIds = $request->input('selectedUsers', []);
        $selectedUsers = Item::whereIn('id', $selectedUserIds)->get();

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        $sheet->setCellValue('A1', 'ID');
        $sheet->setCellValue('B1', 'First Name');
        $sheet->setCellValue('C1', 'Last Name');
        $sheet->setCellValue('D1', 'Email');
        $sheet->setCellValue('E1', 'Address');
        $sheet->setCellValue('F1', 'Phone');

        $row = 2;
        foreach ($selectedUsers as $user) {
            $sheet->setCellValue('A' . $row, $user->id);
            $sheet->setCellValue('B' . $row, $user->firstname);
            $sheet->setCellValue('C' . $row, $user->lastname);
            $sheet->setCellValue('D' . $row, $user->email);
            $sheet->setCellValue('E' . $row, $user->address);
            $sheet->setCellValue('F' . $row, $user->phone);
            $row++;
        }

        $writer = new Xlsx($spreadsheet);
        $filePath = 'app/public/selected_users.xlsx';
        $writer->save(storage_path($filePath));
        // return response()->json(['message' => 'Excel file generated successfully']);

        return response()->download(storage_path($filePath));

    }
}
