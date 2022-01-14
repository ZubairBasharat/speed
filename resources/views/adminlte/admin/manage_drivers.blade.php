@extends('adminlte.layouts.app')
@section('htmlheader_title')
@endsection

@section('main-content')

	  <div class="box">
      <div class="box-header">
      </div>
      <div class="box-body">
        <div class="row">
          @if (session('status'))
            <div class="alert alert-success">
              {{ session('status') }}
            </div>
          @endif
          @if (count($errors) > 0)
            <div class="alert alert-danger">
              <ul>
                @foreach ($errors->all() as $error)
                  <li>{{ $error }}</li>
                @endforeach
              </ul>
            </div>
          @endif
        </div>
        <div class="row">
          <div class="col-md-12">
            <a style="margin: 15px 5px;" href="{{ route('add_driver') }}" class="pull-right btn btn-success"><i title="@lang('adminlte.add_driver')" class=" fa fa-plus"></i> &nbsp; @lang('adminlte.add_driver') </a>
          </div>
        </div>
        <div class="row">
          <div class="col-md-12">
            <div class="table-responsive">
              <table id="mydatatable" class="table table-bordered table-striped">

                <thead>

                  <tr>

                    <th>@lang('adminlte.name') </th>

                    <th>@lang('adminlte.username')</th>

                    <th>@lang('adminlte.email')</th>

                    <th>Wallet</th>

                    <th>@lang('adminlte.email_status')</th>

                    <th>@lang('adminlte.account_status')</th>

                    <th>@lang('adminlte.actions')</th>

                  </tr>

                </thead>

                <tbody>

                  @if(count($users) > 0)

                    @foreach($users as $u)

                      <tr>

                        <td>
                          <a href="{{ route('driver_details', encrypt($u->id)) }}" target="_blank"> {{ $u->name }} </a>
                        </td>

                        <td>{{ $u->username }}</td>

                        <td>{{ $u->email }}</td>

                        <td>{{ $u->wallet }}</td>

                        <td>

                          @if($u->verified == 1)

                            <span class="label label-success">

                              Verified

                            </span>

                          @else

                            <span class="label label-danger">

                              Unverified

                            </span>

                          @endif

                        </td>

                        <td>

                          @if($u->active == 1)

                            <span class="label label-success">

                              Active

                            </span>

                          @else

                            <span class="label label-danger">

                              Disabled

                            </span>

                          @endif

                        </td>

                        <td>
                          @if(auth()->user()->user_type == 1)
                            <a href="{{ route('edit_driver', encrypt($u->id)) }}"> <span class="label label-info"> @lang('adminlte.update') </span></a>
                            &nbsp;
                            <a href="#" onclick='LinksModal( {{ $u->id }} )'> <span class="label label-warning"> @lang('adminlte.account_setting') </span></a>
                          @else
                            &nbsp;
                          @endif
                        </td>

                      </tr>

                    @endforeach

                  @else

                    <tr>

                      <td colspan="5">No driver exists in db.</td>

                    </tr>

                  @endif
                </tbody>
              </table>
            </div>
          </div>
        </div>
      </div>
    </div>

    <div class="modal fade" id="updateModal">
      <div class="modal-dialog">

        <div class="modal-content">

          <div class="modal-header">

            <button type="button" class="close" data-dismiss="modal" aria-label="Close">

              <span aria-hidden="true">&times;</span></button>

            <h4 class="modal-title">Manage Driver</h4>

          </div>

          <div class="modal-body" id="model_body">
          </div>

        </div>
        <!-- /.modal-content -->
      </div>
      <!-- /.modal-dialog -->
    </div>
@endsection

@push('plugin-scripts')
  <script type="text/javascript">
    function LinksModal(user_id)
    {
      var data= {'user_id':user_id, '_token':'{{csrf_token()}}' };

      $.post('{{ route('edit_account_status_modal') }}', data , function(response) {

          $("#model_body").html(response);
          $('#updateModal').modal('show');
      });
    }
  </script>
@endpush
