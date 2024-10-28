<?php

namespace App\Http\Controllers;

use App\Models\Appraisal;
use App\Models\Client;
use App\Src\Address\Infrastructure\DatabaseEloquentAppraisalRepository;
use App\Src\Address\Infrastructure\DatabaseEloquentClientRepository;
use App\Src\Appraisal\Application\CreateAppraisalUseCase;
use App\Src\Appraisal\Application\ShowAppraisalLogsUseCase;
use App\Src\Appraisal\Application\ShowAppraisalsUseCase;
use App\Src\Appraisal\Application\UpdateAppraisalLogsUseCase;
use App\Src\Appraisal\Application\UpdateAppraisalUseCase;
use App\Src\Client\Application\ShowClientsUseCase;
use Illuminate\Http\Request;

class AppraisalsController extends Controller
{
    public function showHistoryLog(int $id)
    {
        $appraisalUseCase = new ShowAppraisalLogsUseCase(new DatabaseEloquentAppraisalRepository, new Appraisal());
        $audits = $appraisalUseCase->execute($id);
        return view('appraisals.history', compact('audits'));
    }

    public function getAll(Request $request)
    {
        $filters = [
            'client_name' => $request->input('client_name'),
            'date_from' => $request->input('date_from'),
            'date_to' => $request->input('date_to'),
        ];

        $appraisalUseCase = new ShowAppraisalsUseCase(new DatabaseEloquentAppraisalRepository, new Appraisal());
        $appraisals = $appraisalUseCase->execute($filters);

        $clientUseCase = new ShowClientsUseCase(new DatabaseEloquentClientRepository, new Client());
        $clients = $clientUseCase->execute();

        return view('appraisals.index', compact('appraisals', 'clients'));
    }

    public function updateStatus(Request $request, int $id)
    {
        $appraisalUseCase = new UpdateAppraisalUseCase(new DatabaseEloquentAppraisalRepository, new Appraisal());
        $appraisalUseCase->execute($request->all(),$id); // status => 'Completado';
        return redirect()->route('appraisals.index')->with('success', 'El estado de la tasación ha sido actualizado exitosamente.');
    }

    public function store(Request $request)
    {
        $appraisalUseCase = new CreateAppraisalUseCase(new DatabaseEloquentAppraisalRepository, new Appraisal());
        $appraisalUseCase->execute($request->all());
        return redirect()->route('appraisals.index')->with('success', 'Tasación solicitada con éxito.');
    }
}
