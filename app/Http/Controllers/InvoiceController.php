<?php

namespace App\Http\Controllers;

use App\Models\invoice;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;

class InvoiceController extends Controller
{
    public function index()
    {
        $payslips = invoice::orderBy('id','Desc')->get();
        $data['invoce']=$payslips;
        return view('invoice', $data);
    }
     
    public function downloadpdf()
    {
             $payslips = invoice::orderBy('id','Desc')->get();
             $data['invoices']=$payslips;
             $pdf = Pdf::loadView('pdf.pdfslip', $data);
             // return $pdf->stream();
             return $pdf->download('pdfslip.pdf');
    }
}
