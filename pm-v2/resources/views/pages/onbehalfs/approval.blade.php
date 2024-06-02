@extends('layouts_.vertical', ['page_title' => 'On Behalf'])

@section('css')
@endsection

@section('content')
    <!-- Begin Page Content -->
    <div class="container-fluid">
        
    @if ($errors->any())
    <div class="alert alert-danger">
            @foreach ($errors->all() as $error)
                {{ $error }}
            @endforeach
    </div>
    @endif

        <!-- Page Heading -->
        <div class="row">
            <div class="col-12">
                <div class="page-title-box">
                    <div class="page-title-right">
                        <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item"><a href="{{ route('goals') }}">{{ $parentLink }}</a></li>
                            <li class="breadcrumb-item active">{{ $link }}</li>
                        </ol>
                    </div>
                    <h4 class="page-title">{{ $link }}</h4>
                </div>
            </div>
        </div>
        @foreach ($data as $index => $row)
        <form id="goalApprovalAdminForm" action="{{ route('admin.approval.goal') }}" method="post">
            @csrf
            <input type="hidden" name="id" value="{{ $row->request->goal->id }}">
            <input type="hidden" name="employee_id" value="{{ $row->request->employee_id }}">
            <input type="hidden" name="current_approver_id" value="{{ $row->request->current_approval_id }}">
              <div class="d-sm-flex align-items-center mb-4">
                    <h4 class="me-1">{{ $row->request->employee->fullname }}</h4><span class="text-muted h4">{{ $row->request->employee->employee_id }}</span>
              </div>
              <!-- Content Row -->
              <div class="container-card">
                @php
                    $formData = json_decode($row->request->goal['form_data'], true);
                @endphp
                @if ($formData)
                @foreach ($formData as $index => $data)
                    <div class="card col-md-12 mb-4 shadow-sm">
                        <div class="card-header bg-white pb-0">
                            <h4>KPI {{ $index + 1 }}</h4>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="kpi">KPI</label>
                                        <textarea name="kpi[]" class="form-control" readonly>{{ $data['kpi'] }}</textarea>
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="form-group">
                                        <label for="target">Target</label>
                                        <input type="text" name="target[]" value="{{ $data['target'] }}" class="form-control" readonly>
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="form-group">
                                        <label for="uom">UoM</label>
                                        <input type="text" name="uom[]" id="uom" value="{{ $data['uom'] }}" class="form-control" readonly>
                                        <input 
                                            type="text" 
                                            name="custom_uom[]" 
                                            id="custom_uom{{ $index }}" 
                                            class="form-control mt-2" 
                                            value="{{ $data['custom_uom'] }}" 
                                            placeholder=" UoM" 
                                            @if ($data['uom'] !== 'Other') 
                                                style="display: none;" 
                                            @endif 
                                            readonly
                                        >
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="form-group">
                                        <label for="type">Type</label>
                                        <input type="text" oninput="validateDigits(this)" name="type[]" id="type" value="{{ $data['type'] }}" class="form-control" readonly>
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="form-group">
                                        <label for="weightage">Weightage</label>
                                        <div class="input-group">
                                            <input name="weightage[]" class="form-control" value="{{ $data['weightage'] }}" readonly>
                                            <div class="input-group-append">
                                                <span class="input-group-text">%</span>
                                            </div>
                                        </div>
                                        <!-- Tambahkan kode untuk menampilkan error weightage jika ada -->
                                        @if ($errors->has("weightage"))
                                            <span class="text-danger">{{ $errors->first("weightage") }}</span>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
                <div class="row">
                    <div class="col-lg-6">
                        <div class="mb-3">
                            <label class="form-label" for="messages">Messages*</label>
                            <textarea name="messages" id="messages{{ $row->request->id }}" class="form-control" placeholder="Enter messages..">{{ $row->request->messages }}</textarea>
                        </div>
                    </div>
                </div>
                @else
                    <p>No form data available.</p>
                @endif                
            </div>
        </form>
        <form id="goalSendbackForm" action="{{ route('admin.sendback.goal') }}" method="post">
            @csrf
            <input type="hidden" name="request_id" id="request_id">
            <input type="hidden" name="sendto" id="sendto">
            <input type="hidden" name="sendback" id="sendback" value="Sendback">
            <textarea @style('display: none') name="sendback_message" id="sendback_message"></textarea>
            <input type="hidden" name="form_id" value="{{ $row->request->form_id }}">
            
            <input type="hidden" name="approver" id="approver" value="{{ $row->request->manager->fullname.' ('.$row->request->manager->employee_id.')' }}">
            
            <input type="hidden" name="employee_id" value="{{ $row->request->employee_id }}">
            @if ($row->request->sendback_messages)
            <div class="row">
                <div class="col-auto">
                    <div class="mb-3">
                        <label class="form-label">Sendback Messages</label>
                        <textarea class="form-control" @disabled(true)>{{ $row->request->sendback_messages }}</textarea>
                    </div>
                </div>
            </div>
            @endif
            <div class="row">
                <div class="col-lg">
                    <div class="text-center text-lg-end">
                        @can('sendbackonbehalf')
                        <a class="btn btn-info px-2 rounded-pill me-2" href="javascript:void(0)" role="button" data-bs-toggle="dropdown" aria-expanded="false">Send back</a>
                            <div class="dropdown-menu shadow-sm m-2">
                            <h6 class="dropdown-header dark">Select person below :</h6>
                            <a class="dropdown-item" href="javascript:void(0)" onclick="sendBack('{{ $row->request->id }}','{{ $row->request->employee->employee_id }}','{{ $row->request->employee->fullname }}')">{{ $row->request->employee->fullname .' '.$row->request->employee->employee_id }}</a>
                            @foreach ($row->request->approval as $item)
                                <a class="dropdown-item" href="javascript:void(0)" onclick="sendBack('{{ $item->request_id }}','{{ $item->approver_id }}','{{ $item->approverName->fullname }}')">{{ $item->approverName->fullname.' '.$item->approver_id }}</a>
                            @endforeach
                            </div> 
                        @endcan
                        <a href="{{ url()->previous() }}" class="btn btn-danger px-2 me-2 rounded-pill">Cancel</a>
                        <a href="javascript:void(0)" onclick="confirmAprrovalAdmin()" class="btn btn-primary px-2 rounded-pill">Approve</a>
                    </div>
                </div>
            </div>
        </form>
        @endforeach
    </div>
    @endsection

    @push('scripts')
        <script src="{{ asset('js/goal-approval.js') }}"></script>
    @endpush